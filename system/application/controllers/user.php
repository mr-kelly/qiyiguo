<?php
	class User extends KK_Controller {
	
		function __construct() {
			parent::__construct();
			$this->load->model('user_profiles_model');
			$this->load->model('group_model');
		}
		
		function index() {
			login_redirect();
			
			
			echo '<img width="50" src="'.  get_user_avatar_url($this->tank_auth->get_user_id() ) . '" />';
		}
		
		
		// 头像的查看，上传处理
		function avatar() {
			login_redirect();
			
			$data = array();

			$this->load->view('user/avatar_view', $data);
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
				$data['avatar_url'] = static_url() . 'upload/avatars/' . $this->tank_auth->get_user_id() .'/' . $upload_data['file_name'];
				
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
			
			$this->load->view('user/avatar_upload_view', $data);
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
		function user_lookup($user_id) {
			login_redirect();
			
			
			$data = array(
				'user' => $this->user_profiles_model->get_profile($user_id),
			);
			
			// 如果用户查看的是自己的页面~ 菜单聚焦"个人主页"
			if ( $user_id == get_current_user_id() ) {
				$data['current_user_home'] = 'current_menu';
			}
			
			$this->load->view('user/user_lookup_view', $data);
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
				$this->form_validation->set_rules('realname', '真实姓名', 'trim|required|xss_clean');
				$this->form_validation->set_rules('nickname', '称呼', 'trim|required|xss_clean');
				//$this->form_validation->set_rules('birth', '生日', 'trim|xss_clean');
				$this->form_validation->set_rules('birth_year', '生日年', 'trim|xss_clean');
				$this->form_validation->set_rules('birth_month', '生日月', 'trim|xss_clean');
				$this->form_validation->set_rules('birth_day', '生日日', 'trim|xss_clean');
				
				
				$this->form_validation->set_rules('website', '个人网站', 'trim|xss_clean');
				$this->form_validation->set_rules('email_1', '电子邮箱1', 'trim|xss_clean|valid_email');
				$this->form_validation->set_rules('email_2', '电子邮箱2', 'trim|xss_clean|valid_email');
				$this->form_validation->set_rules('email_3', '电子邮箱3', 'trim|xss_clean|valid_email');
				$this->form_validation->set_rules('link_renren', '人人网ID号', 'trim|xss_clean|numeric');
				$this->form_validation->set_rules('description', '个人简介', 'trim|xss_clean');
				
				$this->form_validation->set_rules('city_id', '城市', 'required|trim|xss_clean');
				$this->form_validation->set_rules('province_id', '省份', 'required|trim|xss_clean');
				
				$this->form_validation->set_rules('hometown_province_id', '籍贯省份', 'required|trim|xss_clean');
				$this->form_validation->set_rules('hometown_city_id', '籍贯城市', 'required|trim|xss_clean');
				
				/*	不采用http新浪微博验证模式
				$this->form_validation->set_rules('t_sina_login', '新浪微博帐号', 'trim|xss_clean');
				$this->form_validation->set_rules('t_sina_password', '城市', 'trim|xss_clean');
				// 微博绑定
				//$this->
				*/
				
				if ( !$this->form_validation->run() ) {
					ajaxReturn(null, validation_errors(), 0);
				} else {
					$realname = $this->form_validation->set_value('realname');
					$nickname = $this->form_validation->set_value('nickname');
					
					// 将年月日组合起来
					$birth = sprintf('%s-%s-%s', $this->form_validation->set_value('birth_year'), $this->form_validation->set_value('birth_month'), $this->form_validation->set_value('birth_day')) ;
					
					$website = $this->form_validation->set_value('website');
					$email_1 = $this->form_validation->set_value('email_1');
					$email_2 = $this->form_validation->set_value('email_2');
					$email_3 = $this->form_validation->set_value('email_3');
					$link_renren = $this->form_validation->set_value('link_renren');
					$description = $this->form_validation->set_value('description');
					
					$province_id = $this->form_validation->set_value('province_id');
					$city_id = $this->form_validation->set_value('city_id');
					$hometown_province_id = $this->form_validation->set_value('hometown_province_id');
					$hometown_city_id = $this->form_validation->set_value('hometown_city_id');
					
					
					// 修改user profiles
					$this->user_profiles_model->update_user_profile( $user_id, array(
						'realname' => $realname,
						'nickname' => $nickname,
						'birth' => $birth, 
						'website' => $website,
						'email_1' => $email_1,
						'email_2' => $email_2,
						'email_3' => $email_3,
						'link_renren' => $link_renren,
						'description' => $description,
						
						'city_id' => $city_id,
						'province_id' => $province_id,
						'hometown_province_id' => $hometown_province_id,
						'hometown_city_id' => $hometown_city_id,
						
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
			
			
			
			$data = array(
				'user_avatars' => $this->user_avatars_model->get_user_avatars( $user_id ),
			);
			
			// 读取用户新浪微博的绑定资料
			$user_t_sina = $this->user_t_sina_model->get_user_t_sina( get_current_user_profile('id') );
			if ( $user_t_sina ) {
				// 解密
				$this->load->library('fun_crypt');
				$user_t_sina['t_sina_password'] = $this->fun_crypt->deCrypt($user_t_sina['t_sina_password']);
				
				
				$data['user_t_sina'] = $user_t_sina;
			}
			
			
			$this->load->view('user/setting_view.php', $data);
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
		
		/**
		 *	用户用t_sina新浪微博帐号登录, ajax
		 */
		function login_with_t_sina() {
		
			// TODO 判断，普通用户是否用该帐号绑定过。绑定过，不能登录！
			
			
			$this->load->model('user_t_sina_model');
			$this->load->library('t_sina');
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				if ( $this->tank_auth->is_logged_in() ) {
					// 登录过了，转到登录页
					redirect( $this->input->get('redirect') );
				} else {
					// 未登录，用新浪微博帐号登录
					
					$this->form_validation->set_rules('login','帐号', 'trim|required|xss_clean');
					$this->form_validation->set_rules('password','密码', 'trim|required|xss_clean');
					$this->form_validation->set_rules('remember', 'Remember me', 'integer');
					
					if ( $this->form_validation->run() ) {
						// 表单验证通过，登录新浪微博用户
						$login = $this->form_validation->set_value('login');
						$password = $this->form_validation->set_value('password');
						$remember = $this->form_validation->set_value('remember');
					
						// 用户是第一次登录(不存在user_t_sina记录) ?  验证微博帐号合法性, 然后添加user_t_sina记录
						if ( !$this->user_t_sina_model->is_user_t_sina( $login ) ) {
							$this->load->library('t_sina');
							// 验证微博用户合法性， 帐号密码是否通过
							if ( $this->t_sina->checkUser($login, $password) ) {
								// 通过，创建帐户
								$this->user_t_sina_model->create_user_t_sina( $login, $password );
								//exit('create it!');
							} else {
								// 不合法，提示微博帐号错误
								ajaxReturn( null, '新浪微博帐号或密码错误！', 0);
							}
							
							
							// 创建用户后登录
							$this->user_t_sina_model->t_sina_login($login, $password, $remember);
							
							ajaxReturn( null, '第一次用该新浪微博帐号登录成功！', 1);
							
						} else {
						
							// 非第一次登录，是否普通帐号绑定微博
								// 该微博帐号已被普通帐号绑定？？被绑定了不能进行登录！
							if ( $this->user_t_sina_model->is_bind_user_t_sina( $login ) == 'user' ) {
								ajaxReturn( null, '该微博帐号已经被绑定过了！', 0);
							}
							
							// 微博登录帐号？那么登录吧~ t_sina_login
							//echo('existed');
							
							// 验证微博帐号合法性
							if ( $this->t_sina->checkUser($login, $password) ) {
								
								if ( !$this->user_t_sina_model->checkPassword($login, $password ) ) {
									// 合法，但数据库密码帐号不匹配,可能微博密码修改了，一切以微博帐号为主  (http auth)
									// 那么，修改user_t_sina和users两个表的密码
									
									
									$this->user_t_sina_model->changePassword($login, $password);
									
									// 修改密码后，登录
									$this->user_t_sina_model->t_sina_login($login, $password, $remember);
									
									ajaxReturn( null,  '数据库密码不匹配，可能微博密码修改了', 0);
									
								} else {
									// 合法，登录
									$this->user_t_sina_model->t_sina_login($login, $password, $remember);
									
									ajaxReturn( null, '成功登录！', 1);
									
									
									
								}	
							} else {
								// 不合法,那么应该微博密码错误
								echo 'errror password';
							}
							
							
							
						}
						
						
					} else {
						// 表单验证错误, 可能该填的没填
						ajaxReturn(null, validation_errors(), 0);
					}
				}
			}
		}
		
		
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
		
					$this->form_validation->set_rules('login', 'Login', 'trim|required|xss_clean');
					$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
					$this->form_validation->set_rules('remember', 'Remember me', 'integer');
		
					// Get login for counting attempts to login
					if ($this->config->item('login_count_attempts', 'tank_auth') AND
							($login = $this->input->post('login'))) {
						$login = $this->input->xss_clean($login);
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
				
				ajaxReturn(null,'登录失败！未知原因！',0);
			}
			
			
			
			$data = array(
			);
			// 非post状态时, 
			if ( $this->tank_auth->is_logged_in() ) {
				redirect( $this->input->get('redirect') );
			}
			
			$this->load->view('user/login_view', $data);
		}
		
		
		/**
		 *	新浪微博OAuth 登录， 第一登录转到电邮绑定页面
		 */
		function login_by_t_sina( $action = 'authorize' ) {
		
			$this->load->library('t_sina');
			
			if ( $action == 'authorize' ) {
				// 授权 。   转到新浪授权页面， 给用户进行授权， 授权成功, 返回oauth token，进行
				redirect( $this->t_sina->getAuthorizeURL('http://' . $_SERVER["HTTP_HOST"] . site_url('user/login_by_t_sina/callback')) );
				
			} else if ( $action == 'callback' ) {
				
				
				
				// 授权callback, 通过oauth verifier 换取access token
				$last_key = $this->t_sina->getAccessToken( 'user/login_by_t_sina/authorize' );
				
				
				$this->session->set_userdata( 'last_key' , $last_key );
				$self = $this->t_sina->getSelf();
				
				// 用户是否第一次登录（ user_t_sina 数据库是否存在绑定条目）
				$this->load->model('user_t_sina_model');
				if ( $this->user_t_sina_model->is_user_t_sina( array( 't_sina_id' => $self['id'] ) )   ) {
					
					// 存在，非第一次登录，协助用户直接登录
					exit( 'exist!' );
					
				} else {
					// 第一次登录， 未绑定，转到微博绑定页
					redirect( 'user/register_by_t_sina');
				}
				
			} else if ( $action == 'test' ) {
				$weibo = $this->t_sina->getWeibo( );
				print_r( $weibo->public_timeline() );
			}
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
			
			$this->form_validation->set_rules('city_id', '城市', 'required|trim|xss_clean');
			$this->form_validation->set_rules('province_id', '省份', 'required|trim|xss_clean');
			
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
				
				//检查email是否已经注册
				if (!$this->tank_auth->is_email_available($email)) {
					// 被注册了！返回错误！
					ajaxReturn(null, '这个邮箱已经被注册过了！', 0);
				} else {
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
				exit( 't_sina have not logined!');
			}
			
			
			
			
			
			$data = array();
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$this->form_validation->set_rules( 'email',	'电邮', 'trim|required|xss_clean|valid_email');
				$this->form_validation->set_rules( 'password',	'备用密码', 'trim|required|xss_clean');
				$this->form_validation->set_rules( 'realname',	'真实姓名', 'trim|required|xss_clean');
				$this->form_validation->set_rules( 'nickname',	'昵称', 'trim|required|xss_clean');
				
				if ( ! $this->form_validation->run() ) {
					ajaxReturn(null, validation_errors(), 0 );
				} else {
					// 创建本地用户，再绑定新浪微博
					$email = $this->form_validation->set_value('email');
					$password = $this->form_validation->set_value('password');
					
					if ( !$this->tank_auth->create_user( '', $email, $password, FALSE ) ) {
						exit( 'create user error' );
					}
					
					// 立即登录
					$this->tank_auth->login($email, $password, FALSE, FALSE, TRUE);
					
					
					// 用户profiles
					$data = array(
						'realname' => $this->form_validation->set_value('realname' ),
						'nickname' => $this->form_validation->set_value('nickname'),
					);
					$this->user_profiles_model->create_user_profile( $this->tank_auth->get_user_id(), $data );
					

					
					// 用户新浪t_sina数据库绑定
					$this->load->model('user_t_sina_model');
					$this->load->library('t_sina');
					$self = $this->t_sina->getSelf();
					$t_sina_token = $this->session->userdata('last_key');
					
					$this->user_t_sina_model->create_user_t_sina( $this->tank_auth->get_user_id(), array(
						't_sina_id' => $self['id'],
						'oauth_token' => $t_sina_token['oauth_token'],
						'oauth_token_secret' => $t_sina_token['oauth_token_secret'],
					) );
					
				}
			}
			
			$this->load->view('user/register_by_t_sina_view', $data );
		}
		
		/**
		 *	登出帐户
		 */
		function logout() {
			$this->tank_auth->logout();
		}
		
		
		/**
		 *	获取当前用户已加入的友群
		 */
		function joined_groups() {
			if ( !$this->tank_auth->is_logged_in() ) {
				redirect('user/login/user/joined_groups');
			} else {
				$current_user_id = $this->tank_auth->get_user_id();
//				$user_groups = $this->group_model->get_user_groups($current_user_id);
				
				$data = array(
					'user_groups' => $this->group_model->get_user_groups($current_user_id),
				);
				
				$this->load->view('user/joined_groups_view', $data);
			}
		}
		
		
		/**
		 *	AJAX的登录页面  iframe
		 */
		function iframe_login() {
			kk_show_view('user/login');
		}
		
		function iframe_register() {
			kk_show_view('user/register');
		}
		
		
		/**
		 *	Ajax获得指定省份的城市~    传入GET   :  province_id
		 */
		function ajax_get_cities() {
			$cities = $this->dict_model->get_cities( $_GET['province_id'] );
			
			ajaxReturn( $cities, 'City List', 1);
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
	}