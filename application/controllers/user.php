<?php
	class User extends KK_Controller {
	
		function __construct() {
			parent::__construct();
			$this->load->model('user_profiles_model');
			$this->load->model('group_model');
		}
		
		
		function index() {
			//login_redirect();
			
			
			echo '<img width="50" src="'.  get_user_avatar_url($this->tank_auth->get_user_id() ) . '" />';
		}
		
		
		
		
		// 头像的查看，上传处理
		function avatar() {
			login_redirect();
			
			$data = array();

			kk_show_view('user/avatar_view', $data);
		}
		
		/**
		 *	处理上传头像的，并把头像图片调整大小成640*480以内
		 
		 		并在数据库添加数据，绑定用户头像
		 */
		function avatar_upload() {
			login_redirect();
			
			$data = array();
			
			// 创建当前登录用户的 头像 图片文件夹
			$avatar_path = $this->config->item('avatar_path');
			
			$user_avatar_path = $avatar_path . $this->tank_auth->get_user_id();
			
			
			// 如果未创建用户头像目录，创建
			$this->_createDir($user_avatar_path);
			
		    $config['upload_path'] = $user_avatar_path;
			$config['allowed_types'] = 'gif|jpg|png';
			$config['max_size'] = '2048';   //可以上传2MB
			$config['max_width']  = '2024';
			$config['max_height']  = '1768';
			//$config['overwrite'] = true;  不覆盖，随机重命名文件
			$config['encrypt_name'] = true;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload() ) {
				// 上传失败，失败消息
				$data['page_message'] =  $this->upload->display_errors();
			} else {
				// 上传成功！
				// 已上传文件的信息
				$upload_data = $this->upload->data();
				$data['upload_data'] = $upload_data;
				// 上传头像文件的网址
				$data['avatar_url'] = static_url( 'upload/avatars/' . $this->tank_auth->get_user_id() .'/' . $upload_data['file_name']);
				
				// 直接调整图像的大小 resize, 不创建备份
				
				$img_config = array(
					'image_library' => 'gd2',
					'source_image' => $upload_data['full_path'],
					//'create_thumb' => TRUE,
					'maintain_ratio' => TRUE,
					'width'=> 640,
					'height' => 480,		// 重新调整！
				);
				$this->load->library('image_lib', $img_config);
				$this->image_lib->resize();
			}
			
			kk_show_view('user/avatar_upload_view', $data);
		}
		
		/**
		 *	处理用户的手动裁剪,生成 _thumb用于头像
		 	
		 	将头像裁剪成正方形, 裁剪数据x1...y2来自 avatar_upload界面
		 */
		function avatar_crop() {
			login_redirect();
			
			$x1 = $this->input->post('x1');
			$y1 = $this->input->post('y1');
			$x2 = $this->input->post('x2');
			$y2 = $this->input->post('y2');
			$avatar_file = $this->input->post('avatar_file');
			$avatar_path = $this->config->item('avatar_path');
			
			$width = $x2 - $x1;  // 根据x2, y2确定新图片高度
			$height = $y2 - $y1;
			
			$img_config = array(
				'image_library' => 'gd2',
				'source_image' => $avatar_path . $this->tank_auth->get_user_id() . '/' . $avatar_file,// 用户的头像文件夹所在
				'maintain_ratio' => false,  //要裁剪成正方形～不保持原来比例
				'width' => $width,
				'height' => $height,   
				
				'x_axis'=> $x1,
				'y_axis'=>$y1,
				'create_thumb' => true,
			);
			
			$this->load->library('image_lib', $img_config);
			if ( !$this->image_lib->crop($x1, $y1)) {   // 裁剪！
				echo $this->image_lib->display_errors();
			} else {
				
				
				// 成功裁剪！ 添加头像数据到用户
				$this->load->model('user_avatars_model');
				$avatar_id = $this->user_avatars_model->create_user_avatar($this->tank_auth->get_user_id(), $avatar_file );
				
				// 绑定当前登录用户的头像
				$this->load->model('user_profiles_model');
				$this->user_profiles_model->set_user_avatar( $this->tank_auth->get_user_id(), $avatar_id );
				
				// 设置成功，回到设置页面
				$this->session_message->set('头像设置成功！');
				redirect('user/setting');
			}
			
		}
		
		function avatar_set($avatar_id) {
			login_redirect();
			$user_id = $this->tank_auth->get_user_id();
			
			$this->load->model('user_avatars_model');
			
			// 如果头像数据条目确实属于当前用户~
			if ($this->user_avatars_model->is_user_avatar($user_id, $avatar_id)) {
				// 修改user_profiles
				$this->user_profiles_model->set_user_avatar( $user_id, $avatar_id);
				
				// 设置闪出信息
				$this->session_message->set('您的头像已经成功更改!');
				
				// 重定向到设置页面
				redirect('user/setting');
				
				
			} else {
				echo '出错';
			}
			
		}
		
		
		
		/**
		 *	查看一个用户的资料~  根据权限显示
		 */
		function user_lookup( $user_id_slug, $action='home' ) {
			login_redirect();
			
			$this->load->model('relation_model');
			$this->load->model('user_recommend_model');
			$this->load->model('stream_model');
			
			
			
			if ( is_numeric($user_id_slug) ) {
				// 若传入数字， 判断成ID～～读取该ID的用户
				$user_id = $user_id_slug;
				
				$this->_if_user_404( $user_id );
				
				
				
				
			} else {
				// 获得slug对应的用户
				$user_id = $this->user_profiles_model->get_user_id_by_slug( $user_id_slug );
				$this->_if_user_404( $user_id );
				
				// slug对应用户存在？ 通过ID登录吧！
				
				
				
				

			}
			// 清楚同一页一样的提醒
			clean_notices( get_current_user_id(), 'user', $user_id );
			up_user_page_view( $user_id );
			
			$start = $this->input->get('start');
			
			$user = $this->user_profiles_model->_get_user($user_id);
			$render['user'] = $user;
			$render['page_title'] = sprintf( '%s %s', $user['nickname'] , $user['realname'] );
			$render['start'] = $start;
			
			
			// 传入该用户的"推荐朋友"
			
			$user_recommends = $this->user_recommend_model->get_user_recommends( $user_id );
			$render['user_recommends'] = $user_recommends;
			
			// 获取当前登录用户和查看用户的共群,  当前用户就是查看用户。不显示
			$render['users_common_groups'] = $this->group_model->get_users_common_groups( get_current_user_id(), $user_id , 6, 0, true);

			
			// 获取该用户的群.. 6个吧...
			$render['user_groups'] = $this->group_model->get_user_groups( $user_id , 6, 0, true);
			$render['user_groups_count'] = $this->group_model->get_user_groups_count( $user_id );
			
			// 获取共同好友
			//$render['users_common_friends'] = $this->relation_model->get_users_common_friends( get_current_user_id(), $user_id , 10, 0, true);
			
			// 如果用户查看的是自己的页面~ 菜单聚焦"个人主页"
			if ( $user_id == get_current_user_id() ) {
				$render['current_user_home'] = 'current_menu';
			}
			
			// 哪一项页
			if( $action == 'home' ) {
				
				$render['user_stream'] = $this->stream_model->get_user_stream( $user_id, 20, $start );
				$render['current_user_lookup_home'] = true;
				
				// 首页读取stream
// 				$this->load->library('T_sina');
// 				$weibo = $this->t_sina->getUserWeibo( $user_id );
// 				if ( !empty( $weibo ) ) {
// 					if ( $this->t_sina->is_logined( $weibo ) ) {
// 						$render['stream'] = $weibo->user_timeline();
// 					}
// 				}
				$render['user_events'] = $this->stream_model->get_user_events( $user['id'] );
				$render['user_topics'] = $this->stream_model->get_user_topics( $user['id'] );
				
				kk_show_view('user/user_lookup_view', $render);
			} else if ( $action == 'profile') {
			
				$render['current_user_lookup_profile'] = true;
				kk_show_view('user/user_lookup_profile_view', $render);
				
			} else if ( $action == 'chat' ) {
				// 正在浏览该页面，清楚本用户关于该页面的notices
				clean_notices(get_current_user_id(), 'user', $user['id'] );
			
				$render['current_user_lookup_chat'] = true;
				kk_show_view('user/user_lookup_chat_view', $render);
			}

		}


		
		/**
		 *	获取当前用户加入的群组列表...
		 */
		function user_groups( $user_id ) {
			login_redirect();
			$start = $this->input->get( 'start' );
			
			$render['user'] = $this->group_model->_get_user( $user_id );
			$render['user_groups'] = $this->group_model->get_user_groups( $user_id, 50, $start, false );
			
			kk_show_view('user/user_groups_view', $render);
		}
		
		
		
		/**
		 *	登录的用户个人设置
		 */
		function setting( $action='index') {
			login_redirect();
			
			$user_id = $this->tank_auth->get_user_id();
			
			$this->load->model('user_t_sina_model');
			$this->load->model('user_avatars_model');
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				// 处理提交的用户profile资料
				$this->form_validation->set_rules('realname', '真实姓名', 'trim|required|xss_clean|max_length[14]');
				$this->form_validation->set_rules('nickname', '称呼', 'trim|required|xss_clean|max_length[16]');
				
				$this->form_validation->set_rules('gender', '性别', 'required|trim|xss_clean');
				
				//$this->form_validation->set_rules('birth', '生日', 'trim|xss_clean');
				$this->form_validation->set_rules('birth_year', '生日年', 'trim|xss_clean');
				$this->form_validation->set_rules('birth_month', '生日月', 'trim|xss_clean');
				$this->form_validation->set_rules('birth_day', '生日日', 'trim|xss_clean');
				
				
				$this->form_validation->set_rules('website', '个人网站', 'trim|xss_clean');
				$this->form_validation->set_rules('email_1', '电子邮箱1', 'trim|xss_clean|valid_email');
				$this->form_validation->set_rules('email_2', '电子邮箱2', 'trim|xss_clean|valid_email');
				$this->form_validation->set_rules('email_3', '电子邮箱3', 'trim|xss_clean|valid_email');
				
				$this->form_validation->set_rules('qq', 'QQ', 'trim|xss_clean|integer');
				$this->form_validation->set_rules('msn', 'MSN', 'trim|xss_clean|valid_email');
				$this->form_validation->set_rules('gtalk', '电子邮箱3', 'trim|xss_clean|valid_email');
				
				$this->form_validation->set_rules('link_renren', '人人网ID号', 'trim|xss_clean|numeric');
				$this->form_validation->set_rules('description', '个人简介', 'trim|xss_clean');
				
				$this->form_validation->set_rules('love_status', '恋爱状态', 'trim|xss_clean');
				$this->form_validation->set_rules('lover_id', '恋爱对象果号', 'trim|xss_clean');
				
				
				$this->form_validation->set_rules('city_id', '城市', 'required|trim|xss_clean');
				$this->form_validation->set_rules('province_id', '省份', 'required|trim|xss_clean');
				
				$this->form_validation->set_rules('hometown_province_id', '籍贯省份', 'trim|xss_clean');
				$this->form_validation->set_rules('hometown_city_id', '籍贯城市', 'trim|xss_clean');
				
				$this->form_validation->set_rules('slug', '个人网址', 'trim|xss_clean|alpha_dash'); // 不可以纯数字
				
				//个人页面的隐私设置
				$this->form_validation->set_rules('user_privacy', '个人页面隐私', 'trim|xss_clean|requried');
				
				// 教育信息 Tab
				$this->form_validation->set_rules('school_id[]', '学校', 'xss_clean|trim');
				
				// 工作单位信息
				$this->form_validation->set_rules('job_unit_id[]', '工作单位', 'xss_clean|trim');
				
				
				/*	不采用http新浪微博验证模式
				$this->form_validation->set_rules('t_sina_login', '新浪微博帐号', 'trim|xss_clean');
				$this->form_validation->set_rules('t_sina_password', '城市', 'trim|xss_clean');
				// 微博绑定
				//$this->
				*/
				
				if ( !$this->form_validation->run() ) {
					ajaxReturn(null, validation_errors(), 0);
				} else {
					// Slug Form Validation More
					// 个人网址设置，不可以为纯数字
					$slug = $this->form_validation->set_value('slug');
					if ( is_numeric( $slug ) ) {
						ajaxReturn( null, '个人网址不可以为纯数字', 0);
					}
					// 保证个人网址，没有被别人设置了！
					if ( $this->user_profiles_model->is_user_slug_existed( $slug, get_current_user_id() ) ) { // 需要填入当前用户id， 允许用户重复同样地设置slug
						// 存在了？返回失败吧
						ajaxReturn( null, '你填写的个人网址已经被人抢先一步了!', 0);
					}
				
				
				
					$realname = $this->form_validation->set_value('realname');
					$nickname = $this->form_validation->set_value('nickname');
					
					// 将年月日组合起来
					$birth = sprintf('%s-%s-%s', $this->form_validation->set_value('birth_year'), $this->form_validation->set_value('birth_month'), $this->form_validation->set_value('birth_day')) ;
					
					$website = $this->form_validation->set_value('website');
					$email_1 = $this->form_validation->set_value('email_1');
					$email_2 = $this->form_validation->set_value('email_2');
					$email_3 = $this->form_validation->set_value('email_3');
					$link_renren = $this->form_validation->set_value('link_renren');
					
					// 允许<a>标签出现在自我介绍
					$description = $this->kk_filter->filter( $this->form_validation->set_value('description'), array(
																'without_html' => true, 
																'htmlspecialchars'=> false, 
																));
					
					$province_id = $this->form_validation->set_value('province_id');
					$city_id = $this->form_validation->set_value('city_id');
					$hometown_province_id = $this->form_validation->set_value('hometown_province_id');
					$hometown_city_id = $this->form_validation->set_value('hometown_city_id');
					
					
					// 恋爱对象，恋爱关系
					$love_status = $this->form_validation->set_value('love_status');
					$lover_id = $this->form_validation->set_value('lover_id');
					
					$this->load->model('relation_model');
					if ( $love_status != 'single' ) {
						
						// 非单身，那么设置lover relation
						if ( $lover_id != '' ) {
							// 同时设置 Lover ID， 爱人的ID， 添加爱人关系
							$c = $this->relation_model->create_lover( get_current_user_id(), $lover_id );
						}
					} else {
						// 单身！？删除lover relation
						$this->relation_model->del_lover( get_current_user_id() );
					}
					
					

					
					
					


					

// 
// 					// 教育信息 array , 因为set_value 在 codeigniter 2.0改变规则，只抓一个～所以。。 强制读成数组！函数自循环！
// 					$schools = array();
// 					function get_school_id( $ci, &$target_array ) {
// 						$school = $ci->form_validation->set_value('school_id[]');
// 						if ( !empty($school) ) {
// 							array_push( $target_array, $school );
// 							get_school_id( $ci, &$target_array);
// 						}
// 					}
// 					get_school_id( $this, $schools );
// 					
// 					
// 					
// 					foreach( $schools as $school ) {
// 						if ( !empty( $school ) ) { // 如果值为空，不创建
// 							$this->user_education_model->create_education( get_current_user_id(), array(
// 								'school_id' => $school,							
// 							));
// 						}
// 					}
// 					
// 					
// 					// 工作单位 array, 同样函数自循环读成函数
// 					
// 					$job_units = array();
// 					function get_job_units_id( $ci, &$target_array ) {
// 						$job_unit = $ci->form_validation->set_value('job_unit_id[]');
// 						if ( !empty($job_unit) ) {
// 							array_push( $target_array, $job_unit );
// 							get_school_id( $ci, &$target_array);
// 						}
// 					}
// 					get_job_units_id( $this, $job_units );
// 					
// 					
// 					$this->load->model('user_job_unit_model');
// 					// 删除全部，再添加新的
// 					$this->user_job_unit_model->del_user_job_units( get_current_user_id() );
// 
// 					foreach ( $job_units as $unit ) {
// 						if ( !empty( $unit ) ) {
// 							$this->user_job_unit_model->create_job_unit( get_current_user_id(), array(
// 								'job_unit_id' => $unit,
// 							));
// 						}
// 					}
//					
//					在PHP 5.3 中以上嵌套函数会导致无法进入controller～ 所以修改为do...while

 					// 教育信息 array , 因为set_value 在 codeigniter 2.0改变规则，只抓一个～所以。。 强制读成数组！函数自循环！
					$schools = array();
					do {
						$school = $this->form_validation->set_value('school_id[]');
						if ( $school != '' ) {
							$schools[] = $school;
						}
					} while ( $school != '' );
					
					$this->load->model('user_education_model');
					// 删除全部，再添加新的
					$this->user_education_model->del_user_education( get_current_user_id() );
					
					
					foreach( $schools as $school ) {
						if ( !empty( $school ) ) { // 如果值为空，不创建
							$this->user_education_model->create_education( get_current_user_id(), array(
								'school_id' => $school,							
							));
						}
					}
					
					// 工作单位 array, 同样函数自循环读成函数
					
					$job_units = array();
					do {
						$job_unit = $this->form_validation->set_value('job_unit_id[]');
						if ( $job_unit != '' ) {
							$job_units[] = $job_unit;
						}
					} while ( $job_unit != '' );
					
 					$this->load->model('user_job_unit_model');
// 					// 删除全部，再添加新的
 					$this->user_job_unit_model->del_user_job_units( get_current_user_id() );

					foreach ( $job_units as $unit ) {
						if ( !empty( $unit ) ) {
							$this->user_job_unit_model->create_job_unit( get_current_user_id(), array(
								'job_unit_id' => $unit,
							));
						}
					}
					
					
					// 修改user profiles
					$this->user_profiles_model->update_user_profile( $user_id, array(
						'realname' => $realname,
						'nickname' => $nickname,
						'gender' => $this->form_validation->set_value('gender'),
						
						'birth' => $birth,  // 自动根据生日，获取年龄、星座
						'age' => $this->humanize->age( $birth ),
						'constellation' => $this->humanize->constellation( $birth ),
						
						'website' => $website,
						'email_1' => $email_1,
						'email_2' => $email_2,
						'email_3' => $email_3,
						'qq' => $this->form_validation->set_value('qq'),
						'msn' => $this->form_validation->set_value('msn'),
						'gtalk' => $this->form_validation->set_value('gtalk'),
						
						'link_renren' => $link_renren,
						'description' => $description,
						'love_status' => $love_status,
						
						'city_id' => $city_id,
						'province_id' => $province_id,
						'hometown_province_id' => $hometown_province_id,
						'hometown_city_id' => $hometown_city_id,
						
						
						// 个人网址 tab
						'slug' => $slug,
						'user_privacy' => $this->form_validation->set_value('user_privacy'),
						
					));
					
					

					
					/*  取消新浪微博http绑定功能
					// ──────────微博帐号绑定，  表单验证要检查微博帐号是否合法～（帐号密码正确）
					$t_sina_login = $this->form_validation->set_value('t_sina_login');
					$t_sina_password = $this->form_validation->set_value('t_sina_password');
					
					$this->load->library('fun_crypt');
					$this->load->library('t_sina');
					$this->load->model('user_t_sina_model');
					
					
					// 如果用户有输入帐号密码，检查微博帐号合法性
					if ( $t_sina_login != '' || $t_sina_password != '' ) {
					
						// 微博帐号合法性
						if ( !$this->t_sina->checkUser($t_sina_login, $t_sina_password) ) {
							// 微波帐户不合法！！
							ajaxReturn(null, '新浪微博帐号密码错误！', 0);
						}
						
						// 微博帐号是否用  微博方式登录过奇异果了？
						if ( $this->user_t_sina_model->is_bind_user_t_sina( $t_sina_login ) == 't_sina' ) {
							// 被绑定了！而且是t_sina方式！
							ajaxReturn( null, '新浪微博帐号登录过奇异果！', 0);
						}
						
						
						
						// 判断是否已绑定
						if ( !$this->user_t_sina_model->is_user_t_sina($t_sina_login)) {
							// 未绑定，创建关联
							$this->user_t_sina_model->bind_user_t_sina($user_id, $t_sina_login, $t_sina_password);
						} else {
							// 已绑定,update修改
							$this->user_t_sina_model->bind_user_t_sina($user_id, $t_sina_login, $t_sina_password);
							
						}
					} else {
						//  t_sina login is null, password is null
						// 没填绑定信息，可能是t_sina登录的用户,什么都不做
						
						
						// 没填绑定信息，普通用户，删掉t_sina绑定数据！
						$user_t_sina = $this->user_t_sina_model->get_user_t_sina( get_current_user_profile('id') );
						
						if ( $user_t_sina['type'] == 'user' ) {
							$this->user_t_sina_model->delete_user_t_sina($user_id);
						}
					}  // ──────────────────────结束微博帐号绑定

					*/
					
					ajaxReturn(null, '设置成功', 1);
				}
				
				$this->form_validation->set_rules('description', '个人简介', 'trim|xss_clean');
				
				ajaxReturn(null, $this->input->post('realname'), 0);
				
				
			}
			
			
			$data['page_title'] = '设置 - ' . get_current_user_name() ;
			$data['user_avatars'] = $this->user_avatars_model->get_user_avatars( $user_id );
			$data['current_user_profile'] = get_current_user_profile();
			

			
			// 读取用户新浪微博的绑定资料
			$user_t_sina = $this->user_t_sina_model->get_user_t_sina( get_current_user_profile('id') );
			if ( $user_t_sina ) {
				// 解密
				$this->load->library('fun_crypt');
				//$user_t_sina['t_sina_password'] = $this->fun_crypt->deCrypt($user_t_sina['t_sina_password']);
				
				
				$data['user_t_sina'] = $user_t_sina;
			}
			
			// 获取用户的教育信息
			$this->load->model('user_education_model');
			$data['user_education'] = $this->user_education_model->get_user_education( get_current_user_id() );
			
			// 获得用户的工作单位设置信息
			$this->load->model('user_job_unit_model');
			$data['user_job_units'] = $this->user_job_unit_model->get_user_job_units( get_current_user_id() );
			
			kk_show_view('user/setting_view.php', $data);
		}
		
		
		
		/**
		 *	修改密码...
		 */
		function change_password() {
			$render[] = '';
			
			if ( $_SERVER["REQUEST_METHOD"] == 'POST' ) {
			
				$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean');
				$this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
				$this->form_validation->set_rules('confirm_new_password', 'Confirm new Password', 'trim|required|xss_clean|matches[new_password]');
				
				if ( ! $this->form_validation->run() ) {

					ajaxReturn( null, validation_errors(), 0 );
					
				} else {
				
					if ( $this->tank_auth->change_password(
						$this->form_validation->set_value('old_password'),
						$this->form_validation->set_value('new_password') ) ) {
						
						// 成功修改密码
						//$this->session_message->set('成功修改密码');
						//redirect( '/user/' . get_current_user_id() );
						ajaxReturn( null, '成功修改密码', 1 );
					} else {
						
						//$this->session_message->set( '修改密码失败' );
						ajaxReturn( null, '修改密码失败', 0 );
						
					}
				}
			}
			
			kk_show_view('user/change_password_view', $render);
		}
		
		function test() {
			echo <<<EOT
			<form method='post' action='register'>
				<input name='email' />
				<input name='password' type='password' />
				<input name='username' />
				<input type='submit' />
			</form>
EOT;
			$this->group_model->create_group('TestGroup中文', 1);
		}
		
		/**
		 *	用户自己的详细资料
		 */
		function profile() {
			$profile = $this->user_profiles_model->get_profile();

			
			$this->load->view('user/profile');
			
		}
		
		
// 		/**
// 		 *	用户用t_sina新浪微博帐号登录, ajax
// 		 */
// 		function login_with_t_sina() {
// 		
// 			// TODO 判断，普通用户是否用该帐号绑定过。绑定过，不能登录！
// 			
// 			
// 			$this->load->model('user_t_sina_model');
// 			$this->load->library('t_sina');
// 			
// 			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
// 				if ( $this->tank_auth->is_logged_in() ) {
// 					// 登录过了，转到登录页
// 					redirect( $this->input->get('redirect') );
// 				} else {
// 					// 未登录，用新浪微博帐号登录
// 					
// 					$this->form_validation->set_rules('login','帐号', 'trim|required|xss_clean');
// 					$this->form_validation->set_rules('password','密码', 'trim|required|xss_clean');
// 					$this->form_validation->set_rules('remember', 'Remember me', 'integer');
// 					
// 					if ( $this->form_validation->run() ) {
// 						// 表单验证通过，登录新浪微博用户
// 						$login = $this->form_validation->set_value('login');
// 						$password = $this->form_validation->set_value('password');
// 						$remember = $this->form_validation->set_value('remember');
// 					
// 						// 用户是第一次登录(不存在user_t_sina记录) ?  验证微博帐号合法性, 然后添加user_t_sina记录
// 						if ( !$this->user_t_sina_model->is_user_t_sina( $login ) ) {
// 							$this->load->library('t_sina');
// 							// 验证微博用户合法性， 帐号密码是否通过
// 							if ( $this->t_sina->checkUser($login, $password) ) {
// 								// 通过，创建帐户
// 								$this->user_t_sina_model->create_user_t_sina( $login, $password );
// 								//exit('create it!');
// 							} else {
// 								// 不合法，提示微博帐号错误
// 								ajaxReturn( null, '新浪微博帐号或密码错误！', 0);
// 							}
// 							
// 							
// 							// 创建用户后登录
// 							$this->user_t_sina_model->t_sina_login($login, $password, $remember);
// 							
// 							ajaxReturn( null, '第一次用该新浪微博帐号登录成功！', 1);
// 							
// 						} else {
// 						
// 							// 非第一次登录，是否普通帐号绑定微博
// 								// 该微博帐号已被普通帐号绑定？？被绑定了不能进行登录！
// 							if ( $this->user_t_sina_model->is_bind_user_t_sina( $login ) == 'user' ) {
// 								ajaxReturn( null, '该微博帐号已经被绑定过了！', 0);
// 							}
// 							
// 							// 微博登录帐号？那么登录吧~ t_sina_login
// 							//echo('existed');
// 							
// 							// 验证微博帐号合法性
// 							if ( $this->t_sina->checkUser($login, $password) ) {
// 								
// 								if ( !$this->user_t_sina_model->checkPassword($login, $password ) ) {
// 									// 合法，但数据库密码帐号不匹配,可能微博密码修改了，一切以微博帐号为主  (http auth)
// 									// 那么，修改user_t_sina和users两个表的密码
// 									
// 									
// 									$this->user_t_sina_model->changePassword($login, $password);
// 									
// 									// 修改密码后，登录
// 									$this->user_t_sina_model->t_sina_login($login, $password, $remember);
// 									
// 									ajaxReturn( null,  '数据库密码不匹配，可能微博密码修改了', 0);
// 									
// 								} else {
// 									// 合法，登录
// 									$this->user_t_sina_model->t_sina_login($login, $password, $remember);
// 									
// 									ajaxReturn( null, '成功登录！', 1);
// 									
// 									
// 									
// 								}	
// 							} else {
// 								// 不合法,那么应该微博密码错误
// 								echo 'errror password';
// 							}
// 							
// 							
// 							
// 						}
// 						
// 						
// 					} else {
// 						// 表单验证错误, 可能该填的没填
// 						ajaxReturn(null, validation_errors(), 0);
// 					}
// 				}
// 			}
// 		}
// 		
// 		
		/**
		 *	Ajax，用户登入
		 *  设置redirect_ 两个参数，可以登录后跳转
		 
		 	$type    ajax, general（PHP普通模式)
		 */
		function login( $type="ajax") {
		

			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				
				
				if ($this->tank_auth->is_logged_in()) {
					//已经登录过，提示已登录过了
					//ajaxReturn( null, '您已经登录过了', 0);
					redirect($this->input->get('redirect'));
					
				} else {
					// 未登录，登录
					
					$data['login_by_username'] = ($this->config->item('login_by_username', 'tank_auth') AND
							$this->config->item('use_username', 'tank_auth'));
					$data['login_by_email'] = $this->config->item('login_by_email', 'tank_auth');
		
					$this->form_validation->set_rules('login', '电邮', 'trim|required|xss_clean');
					$this->form_validation->set_rules('password', '密码', 'trim|required|xss_clean');
					$this->form_validation->set_rules('remember', '下次自动登录', 'integer');
		
					// Get login for counting attempts to login
					if ($this->config->item('login_count_attempts', 'tank_auth') AND
							($login = $this->input->post('login'))) {
						$login = $login;
					} else {
						$login = '';
					}
		
					$data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
					if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
						if ($data['use_recaptcha'])
							$this->form_validation->set_rules('recaptcha_response_field', 'Confirmation Code', 'trim|xss_clean|required|callback__check_recaptcha');
						//else
							
							// 验证码
							//$this->form_validation->set_rules('captcha', 'Confirmation Code captcha', 'trim|xss_clean|required|callback__check_captcha');
					}
					$data['errors'] = array();
					
					
					
					// 表单验证，并开始登录
					if ($this->form_validation->run()) {								// validation ok
						if ($this->tank_auth->login(
								$this->form_validation->set_value('login'),
								$this->form_validation->set_value('password'),
								$this->form_validation->set_value('remember'),
								$data['login_by_username'],
								$data['login_by_email'])) {								// success
							//redirect('');
							ajaxReturn(null, '成功登录!', 1);
		
						} else {
							$errors = $this->tank_auth->get_error_message();
							if (isset($errors['banned'])) {								// banned user
								$this->_show_message($this->lang->line('auth_message_banned').' '.$errors['banned']);
								return;
		
							} elseif (isset($errors['not_activated'])) {				// not activated user
								redirect('/auth/send_again/');
		
							} else {													// fail
								foreach ($errors as $k => $v)	$data['errors'][$k] = $this->lang->line($v);
							}
						}
					} else {
						// Form Validation表单验证失败后
						ajaxReturn(null, validation_errors(), 0);
						
					}
					
					
					// 正常浏览...					
					// 如果是IE6。。。 转到首页提示登录 ie6修复
					if(strpos($_SERVER['HTTP_USER_AGENT'],'MSIE 6.0') !== false ) {
						$this->session_message->set('你要登录后才能查看该页面');
						redirect( '/' );
					}
					
					
					$data['show_captcha'] = FALSE;
					if ($this->tank_auth->is_max_login_attempts_exceeded($login)) {
						$data['show_captcha'] = TRUE;
						if ($data['use_recaptcha']) {
							$data['recaptcha_html'] = $this->_create_recaptcha();
						} else {
							// 登录不要验证码
							//$data['captcha_html'] = $this->_create_captcha();
						}
					}
				}
				
				
				// 非表单问题？
				
				ajaxReturn(null,'登录失败！请检查你的电邮、密码是否正确。',0);
			}
			
			
			
			$render = array(
				'form_key_token' => $this->kk_formkey->create_key_token(),
			);
			
			// 非post状态时, 
			if ( $this->tank_auth->is_logged_in() ) {
				redirect( $this->input->get('redirect') );
			}
			
			$this->load->view('user/login_view', $render);
		}
		
		
		/**
		 *	新浪微博OAuth 登录， 第一登录转到电邮绑定页面
		 */
		function login_by_t_sina( $action = 'authorize' ) {
		
			$this->load->library('t_sina');
			
			if ( $action == 'authorize' ) {
				// 授权 。   转到新浪授权页面， 给用户进行授权， 授权成功, 返回oauth token，进行
				//redirect( $this->t_sina->getAuthorizeURL('http://' . $_SERVER["HTTP_HOST"] . site_url('user/login_by_t_sina/callback')) );
				redirect ( $this->t_sina->getAuthorizeURL( site_url('user/login_by_t_sina/callback?redirect=' . $this->input->get('redirect')  )) );
				
			} else if ( $action == 'callback' ) {
				
				$remember = $this->input->get('remember'); // 是否记住登录状态
				
				// 授权callback, 通过oauth verifier 换取access token
				$last_key = $this->t_sina->getAccessToken('user/login_by_t_sina/authorize');  // 
				
				
				$this->session->set_userdata( 'last_key' , $last_key );
				$self = $this->t_sina->getSelf();
				
				// 用户是否第一次登录（ user_t_sina 数据库是否存在绑定条目）
				$this->load->model('user_t_sina_model');
				if ( $this->user_t_sina_model->is_user_t_sina( array( 't_sina_id' => $self['id'] ) )   ) {
					
					// 存在，非第一次登录，协助用户直接登录
					
					// 首先，刷新数据库的 oauth_token !!   TODO
					
					
					// 然后，协助用户登录吧！ 获取t_sina, 再获取用户邮箱、密码
					$user_t_sina = $this->user_t_sina_model->get_user_t_sina_by_t_sina_id( $self['id'] );
					
					$user_id = $user_t_sina['user_id'];
					$user = $this->user_t_sina_model->_get_user( $user_id );

					$this->load->library('Tank_auth');
					
					if ( $this->tank_auth->login_without_password( $user['email'] , $remember ) ) {
						// 用新浪微博帐号，用户成功登录，转到redirect或“开始页”
						redirect( $this->input->get('redirect') );
						//redirect('home/start');
					} else {
						echo 'not logined';
					}
					
					exit( 'exist!' );
					
				} else {
					// 第一次登录， 未绑定，转到微博绑定页
					redirect( 'user/register_by_t_sina?redirect=' . $this->input->get('redirect') );
				}
				
			} else if ( $action == 'test' ) {
				$weibo = $this->t_sina->getWeibo( );
				print_r( $weibo->public_timeline() );
			} else if ( $action == 'bind' ) {
				
				// 普通用户, 未绑定的，在这里进行绑定新浪微博
				
				
			}
		}
		
		
		/**
		 *	豆瓣OAuth登录，第一次登录转到电邮绑定页面
		 */
		function login_by_douban( $action = 'authorize' ) {
			
			$this->load->library('Douban');
			
			if ( $action == 'authorize' ) {
				
				//redirect( $this->douban->get_authorize_url( 'http://' . $_SERVER["HTTP_HOST"] . site_url('user/login_by_douban/callback') ) );
				redirect( $this->douban->get_authorize_url( site_url('user/login_by_douban/callback?redirect=' . $this->input->get('redirect')   ) ) );
				
			} else if ( $action == 'callback' ) {
				
				$remember = $this->input->get('remember');
				
				// Array - access token
				$access_token = $this->douban->get_access_token( $this->input->get('oauth_token') );
				// 将access token存入 session～  令豆瓣oauth成效
				$this->session->set_userdata('douban_access_token', $access_token );
				
				$douban_self = $this->douban->get_self();
				//print_r( $access_token );
				
				// 判断该豆瓣用户是否第一次登录
				$this->load->model('user_douban_model');
				if ( !$this->user_douban_model->is_user_douban( array(
																	'uid' => $douban_self['db:uid']['$t'],
																))) {
					// 第一次登录，转到regsiter_by_douban
					//exit( 'first douban' );
					redirect( 'user/register_by_douban?redirect=' . $this->input->get('redirect') );
					
				} else {
					// 非第一次登录， 通过豆瓣绑定帐户，直接登录
					
					// 通过用户豆瓣uid~ 获取数据库条目～  是对应哪个system user
					$login_user_douban = $this->user_douban_model->get_user_douban( array( 'uid' => $douban_self['db:uid']['$t'], ) );
					$login_user = $this->user_douban_model->_get_user( $login_user_douban['user_id'] );
					
					// 协助登录
					$this->load->library('Tank_auth');
					if ( $this->tank_auth->login_without_password( $login_user['email'] , $remember ) ) {
						// 豆瓣登录成功，转到开始页
						redirect( $this->input->get('redirect') );
						//redirect('home/start');
					} else {
						echo 'not logined';
					}
					
					
					
					
				}
			}

		}
		
		
		function register_by_douban() {
			$this->load->library('Douban');
			
			// 登录过的用户的，不能进入该页面
			if ( $this->tank_auth->is_logged_in() ) {
				exit( 'loggined cannot enter here!' );
			}
			
			$douban_self = $this->douban->get_self();
			
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$this->form_validation->set_rules( 'email',	'电邮', 'trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules( 'password',	'备用密码', 'trim|required|xss_clean');
				$this->form_validation->set_rules( 'realname',	'真实姓名', 'trim|required|xss_clean');
				$this->form_validation->set_rules( 'nickname',	'昵称', 'trim|required|xss_clean');
				$this->form_validation->set_rules( 'gender',	'性别', 'trim|required|xss_clean');
				
				$this->form_validation->set_rules( 'birth_year',	'生日年份', 'trim|required|integer|xss_clean');
				$this->form_validation->set_rules( 'birth_month',	'生日月份', 'trim|required|integer|xss_clean');
				$this->form_validation->set_rules( 'birth_day',	'生日日子', 'trim|required|integer|xss_clean');
				
				$this->form_validation->set_rules( 'province_id',	'所在省份', 'trim|required|integer|xss_clean');
				$this->form_validation->set_rules( 'city_id',	'所在城市', 'trim|required|integer|xss_clean');
				
				if ( ! $this->form_validation->run() ) {
					ajaxReturn(null, validation_errors(), 0 );
				} else {
					// 创建本地用户
					$email = $this->form_validation->set_value('email');
					$password = $this->form_validation->set_value('password');
					
					if ( !$this->tank_auth->create_user( '', $email, $password, FALSE ) ) {
						ajaxReturn( null, '该电邮可能被注册过了', 0 );
					}
					
					// 创建后立即登录
					$this->tank_auth->login($email, $password, FALSE, FALSE, TRUE);
					$current_user_id = $this->tank_auth->get_user_id();
					
					
					// 创建豆瓣关联
					$douban_token = $this->session->userdata('douban_access_token');
					
					$this->load->model('user_douban_model');
					$this->user_douban_model->create_user_douban( array(
						'user_id' => $current_user_id,  // 绑定的用户
						'uid' => $douban_self['db:uid']['$t'],
						'oauth_token' => $douban_token['oauth_token'],
						'oauth_token_secret' => $douban_token['oauth_token_secret'],
						
					));
					
					// 创建 profile~
					$birth = sprintf( '%s-%s-%s', $this->form_validation->set_value('birth_year'), $this->form_validation->set_value('birth_month'), $this->form_validation->set_value('birth_day') );
					
					$profile_data = array();
					$profile_data += array(
						'realname' => $this->form_validation->set_value('realname' ),
						'nickname' => $this->form_validation->set_value('nickname'),
						
						'gender' => $this->form_validation->set_value('gender'),
						
						
						'province_id' => $this->form_validation->set_value('province_id'),
						'city_id' => $this->form_validation->set_value('city_id'),
						
						'birth' => $birth,
						'age' => $this->humanize->age( $birth ),
						'constellation' => $this->humanize->constellation( $birth ),
						
						'description' => $douban_self['db:signature']['$t'],
						'website' => isset( $douban_self['link'][3] ) ? $douban_self['link'][3]['@href'] : '' ,
					);
					
					$this->user_profiles_model->create_user_profile( $current_user_id, $profile_data );
					
					// 成功？
					ajaxReturn( site_url( $this->input->get('redirect') ), '成功通过豆瓣注册', 1 );
					//redirect( $this->input->get('redirect') );
					
					
				}
			}
			
			
			$render = array(
				'douban_self' => $douban_self ,
			);
			kk_show_view('user/register_by_douban_view', $render );
			// 记得头像要截成正方形
			
			
		}
		
		
		
		/**
		 *	用户注册, ajax
		 */
		function register() {
			//$email = $this->input->xss_clean($this->input->post('email'));
			$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email');
//			$this->form_validation->set_rules('username', '姓名', 'trim|required|xss_clean');
			$this->form_validation->set_rules('realname', '真实姓名', 'trim|required|xss_clean');
			$this->form_validation->set_rules('nickname', '昵称', 'trim|required|xss_clean');
			
			$this->form_validation->set_rules('password', '密码', 'trim|required|xss_clean|min_length['.$this->config->item('password_min_length', 'tank_auth').']|max_length['.$this->config->item('password_max_length', 'tank_auth').']|alpha_dash');
			
			$this->form_validation->set_rules('gender', '性别', 'trim|xss_clean|required');
			
			$this->form_validation->set_rules('city_id', '城市', 'required|trim|xss_clean');
			$this->form_validation->set_rules('province_id', '省份', 'required|trim|xss_clean');
			
			$this->form_validation->set_rules('form_key_token', '表单钥匙', 'required');
			
			if ( !$this->form_validation->run() ) {
				//表单验证失败
				ajaxReturn(null, validation_errors(), 0);
			} else {
				//表单验证成功,开始注册
				$email = $this->form_validation->set_value('email');
				$password = $this->form_validation->set_value('password');
				$realname = $this->form_validation->set_value('realname');
				$nickname = $this->form_validation->set_value('nickname');
				$province_id = $this->form_validation->set_value('province_id');
				$city_id = $this->form_validation->set_value('city_id');
				
				$form_key_token = $this->form_validation->set_value('form_key_token');
				
				if ( !$this->kk_formkey->check_key_token( $form_key_token ) ) {
					ajaxReturn( null, '表单钥匙错误', 0 );
				}

				//检查email是否已经注册
				if (!$this->tank_auth->is_email_available($email)) {
					// 被注册了！返回错误！
					ajaxReturn(null, '这个邮箱已经被注册过了！', 0);
				} else {
				
					// 检查邮箱可不可用，是不是乱填
					if ( !$this->_domain_exists ( $email ) ) {
						ajaxReturn( null, '邮箱无效！', 0 );
					}
// 					if ( $this->kk_mailer->send_mail( array(
// 														  'to' => array(
// 														  array( $email, $realname ),
// 													  ))) ) {
// 						ajaxReturn( null, '邮箱无效！', 0 );
// 						return;
// 					}
					
					//没注册，那么添加用户吧    -- 不设username
					$this->tank_auth->create_user( '' , $email, $password, FALSE);
					
					// 注册后立即帮用户登录   TODO EMAIL提醒
					$this->tank_auth->login($email, $password, FALSE, FALSE, TRUE);
					
					
					
					// Depreciatd ...   用户需要填写 真实姓名 & 昵称称谓
					// 根据username, 修改用户profile
					// username 以空格explode成最多2项的数组
					// 数组长度1， [0]那么直接设成nickname,
					// 数组长度2， [0]设成realname, [1]设成nickname
					
// 					$name_array = explode(' ', $username, 2);
// 					if ( sizeof($name_array) == 1 ) {
// 						$realname = '';
// 						$nickname = $name_array[0];
// 					} elseif ( sizeof($name_array) == 2 ) {
// 						$realname = $name_array[0];
// 						$nickname = $name_array[1];
// 					}
					
					$data = array(
						'realname' => $realname,
						'nickname' => $nickname,
						'email_1' => $email,
						'city_id' => $city_id,
						'province_id' => $province_id,
						'gender' => $this->form_validation->set_value('gender'),
					);
					//$this->db->where('id' , $this->tank_auth->get_user_id() );
					//$this->db->update('user_profiles', $data);
					
					$this->user_profiles_model->create_user_profile( $this->tank_auth->get_user_id(), $data);
					
					ajaxReturn(null, '成功注册!', 1);
				}
				
				
			}
			
			ajaxReturn(
				null,
				'Something Error!',
				0
			);
		}
		
		function register_by_t_sina() {
			$this->load->library('t_sina');
			
			// 登录过的用户的，微博未链接登录的用户，不能进入该页面
			if ( $this->tank_auth->is_logged_in() ) {
				exit( 'loggined cannot enter here!' );
			}
			
			if ( !$this->t_sina->is_logined() ) {
				// 微博未登录，不能获取信息进行绑定
				redirect('user/login_by_t_sina');
				
				//exit( 't_sina have not logined!');
			}
			
			
			
			
			
			$data = array();
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$this->form_validation->set_rules( 'email',	'电邮', 'trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules( 'password',	'备用密码', 'trim|required|xss_clean');
				$this->form_validation->set_rules( 'realname',	'真实姓名', 'trim|required|xss_clean');
				$this->form_validation->set_rules( 'nickname',	'昵称', 'trim|required|xss_clean');
				
				$this->form_validation->set_rules( 'birth_year',	'生日年份', 'trim|required|integer|xss_clean');
				$this->form_validation->set_rules( 'birth_month',	'生日月份', 'trim|required|integer|xss_clean');
				$this->form_validation->set_rules( 'birth_day',	'生日日子', 'trim|required|integer|xss_clean');
				
				if ( ! $this->form_validation->run() ) {
					ajaxReturn(null, validation_errors(), 0 );
				} else {
					// 创建本地用户，再绑定新浪微博
					$email = $this->form_validation->set_value('email');
					$password = $this->form_validation->set_value('password');
					
					if ( !$this->tank_auth->create_user( '', $email, $password, FALSE ) ) {
						//exit( 'create user error' );
						ajaxReturn( null, '失败。是不是该电邮地址已被注册?', 0 );
					}
					
					// 立即登录
					$this->tank_auth->login($email, $password, FALSE, FALSE, TRUE);
					$current_user_id = $this->tank_auth->get_user_id();
					
					
					$user_t_sina = $this->t_sina->getSelf();
										
				   // 同步头像 ( 先同步头像， 同步资料时放入头像文件的数据id )
				   if ( isset($user_t_sina['profile_image_url'] ) ) {
				   
																   // 修改默认新浪微博配置的头像大小
					   $avatar = file_get_contents( str_replace( '/50/', '/180/', $user_t_sina['profile_image_url']) );
					   
					   // 写入头像到指定头像上传文件夹
					   $avatar_path = $this->config->item('avatar_path') . '/' . $current_user_id . '/';
					   $this->_createDir($avatar_path);
					   
					   $avatar_file_name = md5(rand(0,9999));
					   $avatar_file_normal_name = $avatar_file_name . '.png';
					   $avatar_file_thumb_name =  $avatar_file_name . '_thumb.png';
					   
					   // 下载成2个头像文件, 一个正常，一个thumb缩略图
					   file_put_contents( $avatar_path . $avatar_file_normal_name , $avatar);  // 写入头像文件,用md5加随机数生成随机文件名
					   file_put_contents( $avatar_path . $avatar_file_thumb_name, $avatar );
					   
					   // 头像下载完了，配置数据库绑定
					   
					   $this->load->model('user_avatars_model');
					   $avatar_id = $this->user_avatars_model->create_user_avatar( $current_user_id, $avatar_file_normal_name );
					   
					   
					   $profile_data['avatar_id'] = $avatar_id;//同步资料的头像
				   }
					


					// 用户profiles    自动抓取微博！
					$this->load->model('user_t_sina_model');
					
					// 资料 - 生日 构成
					$birth = sprintf( '%s-%s-%s', $this->form_validation->set_value('birth_year'), $this->form_validation->set_value('birth_month'), $this->form_validation->set_value('birth_day') );
					
					$profile_data += array(
						'realname' => $this->form_validation->set_value('realname' ),
						'nickname' => $this->form_validation->set_value('nickname'),
						
						'gender' => ( ( $user_t_sina['gender'] == 'm' ) ? 'male' : 'female'),
						
						'description' => $user_t_sina['description'],
						'province_id' => $user_t_sina['province'],
						'city_id' => $this->user_t_sina_model->get_city_id_t_sina_adapter( $user_t_sina['province'], $user_t_sina['city'] ),
						
						'website' => $user_t_sina['url'],
						
						'birth' => $birth,
						'age' => $this->humanize->age( $birth ),
						'constellation' => $this->humanize->constellation( $birth ),
						
					);
					$this->user_profiles_model->create_user_profile( $this->tank_auth->get_user_id(), $profile_data );
					

					
					// 先用户新浪t_sina数据库绑定
					$self =& $user_t_sina; // 这时候，尚未写入数据库
					$t_sina_token = $this->session->userdata('last_key');
					
					$this->user_t_sina_model->create_user_t_sina( $this->tank_auth->get_user_id(), array(
						't_sina_id' => $self['id'],
						'oauth_token' => $t_sina_token['oauth_token'],
						'oauth_token_secret' => $t_sina_token['oauth_token_secret'],
					) );
					
					
					// 通过新浪微博注册成功！！redirect!
					ajaxReturn( site_url( $this->input->get('redirect') ), '通过微博注册成功', 1 );
					//redirect(  );
				}
			}
			
			$this->load->view('user/register_by_t_sina_view', $data );
		}
		
		/**
		 *	登出帐户
		 */
		function logout() {
		
			$this->tank_auth->logout();
			
			//$this->session_message->set('你已经成功退出');
			
			redirect('/');
			return;
			
			$render = array();
			kk_show_view('user/logout_view', $render);
		}
		
		
		/**
		 *	获取当前用户已加入的友群
		 */
		function my_groups() {
			login_redirect();
			
			$start = $this->input->get('start');
			
				$current_user_id = $this->tank_auth->get_user_id();
//				$user_groups = $this->group_model->get_user_groups($current_user_id);
				
				$render['user_admin_groups'] = $this->group_model->get_user_admin_groups( get_current_user_id(), 100 );
				
				$render['user_groups'] = $this->group_model->get_user_groups($current_user_id, 50, $start, false, array( 'role'=>'member',) );
				$render['current_group'] = 'current_menu';
				
				kk_show_view('user/my_groups_view', $render);
		}
		
		/**
		 *	清楚当前用户的所有notices...
		 */
		function clear_notices() {
			login_redirect();
			
			$this->load->model('notice_model');
			$this->notice_model->clear_notices( get_current_user_id() );
			$this->session_message->set('已清空所有提醒');
			redirect( $_SERVER['HTTP_REFERER'] );
		}
		
		/**
		 *	AJAX的登录页面  iframe
		 */
		function iframe_login() {

			kk_show_view('user/login');
		}
		
		function iframe_register() {
			$render['form_key_token'] = $this->kk_formkey->create_key_token();
			kk_show_view('user/register', $render );
		}
		
		
		/**
		 *	Ajax获得指定省份的城市~    传入GET   :  province_id
		 */
		function ajax_get_cities() {
			$cities = $this->dict_model->get_cities( $_GET['province_id'] );
			
			ajaxReturn( $cities, 'City List', 1);
		}
		
		
		
		
		/**
		 *	Ajax返回指定用户的信息 返回名字，头像，ID
		 */
		function ajax_get_user( $user_id ) {
			login_redirect();
			
			$user = $this->user_profiles_model->_get_user( $user_id );
			if ( $user['id'] != 0 ) {
				
				ajaxReturn( array(
								'id' => $user['id'],
								'name' => $user['name'],
								// 自动提供头像全网址
								'avatar_thumb_url' =>  isset( $user['Avatar']) ? static_url('upload/avatars/' . $user['id'] ) . '/' . $user['Avatar']['avatar_thumb'] : static_url('img/default_avatar.jpg'),
								), 'user here', 1 );
				
			} else {
			
				ajaxReturn( $user, '用户不存在', 0 );
			}
		}
		
		/**
		 *	为当前用户添加推荐朋友~
		 */
		function ajax_add_recommend( $user_id ) {
			$this->load->model('user_recommend_model');
			$add_recommend = $this->user_recommend_model->add_user_recommend( get_current_user_id(), $user_id, 'friend');
			
			if ( $add_recommend ) {
				ajaxReturn( null, 'add recommend', 1);
			} else {
				ajaxReturn( null, '无法添加推荐好友！', 0);
			}
		}
		
		
		/**
		 *	获取当前用户的 “推荐用户”， 返回ajax页
		 */
		function ajax_get_recommends() {
			login_redirect();
			
			$this->load->model('user_recommend_model');
			
			$recommend_users = $this->user_recommend_model->get_user_recommends( get_current_user_id() );
			
			
			$render = array(
				'recommend_users' => $recommend_users,
			);
			kk_show_view('user/ajax_get_recommends_view', $render);
		}
		
		
		/**
		 *	为当前用户添加心情, ajax视图
		 */
		function ajax_add_mood() {
			if ( ! is_logged_in() ) {
				ajaxReturn( 'login_redirect', '未登录', 0 );
			}
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$this->form_validation->set_rules('mood_text', '心情', 'requried|xss_clean|trim|max_length[100]');
				
				if ( ! $this->form_validation->run() ) {
					ajaxReturn( null, validation_errors(), 0 );
				} else {
					
					$this->load->model('user_mood_model');
					$mood_text = $this->form_validation->set_value( 'mood_text' );
					if ( $mood_id = $this->user_mood_model->add_mood( get_current_user_id(), $mood_text ) ) {
						ajaxReturn( 'mood added', '添加成功！', 1 );
					} else {
						
						ajaxReturn( 'mood add error', '无法添加心情', 0 );
					
					}
				
				}
			}
			
			kk_show_view('user/ajax_add_mood_view');
			
		}
		
		/**
		 *	调整 （ 重新创建、添加、修改） 当前用户的option～
		 */	
		function ajax_user_option( $key, $value ) {
			if ( !is_logged_in() ) {
				ajaxReturn( null, '未登录', 0 );
			}
			
			$this->load->model('user_option_model');
			
			$current_user_id = get_current_user_id();
			
			if ( $this->user_option_model->user_option(
										$current_user_id,
										$key,
										$value )) {
				
				ajaxReturn( null, 'option修改成功', 1);
			} else {
				ajaxReturn( null, 'option修改失败', 0 );
			}
		}
		
		
		/**
		 *	创建目录函数，用于上传头像是自动生成用户的头像图片存放文件夹
		 */
		function _createDir($path) {
		   if (!file_exists($path)) {
		   	
			$this->_createDir(dirname($path));
		
			mkdir($path, 0777);
		   }
		}
		
		/**
		 *	lookup的用户不存在，404！
		 */
		function _if_user_404( $user_id ) {
			if ( !$this->user_profiles_model->is_user( $user_id ) ) {
				show_404();
			}
		}
		
		
		/**
		 *	检查邮箱地址是否真实可以发邮件..!!
		 */
		function _domain_exists($email,$record = 'MX') {
			list($user,$domain) = split('@',$email);
			return checkdnsrr($domain,$record);
		}
	}
