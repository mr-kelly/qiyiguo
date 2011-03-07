<?php
	class Group extends KK_Controller {
		function __construct() {
			parent::__construct();
			$this->load->model('group_model');
			$this->load->model('request_model');
			$this->load->model('chat_model');
		}
		
		function index() {
			$data = array(
				'groups' => $this->group_model->get_groups(),
				'current_group' => 'current_menu',
			);
			kk_show_view('group/index_view', $data);
		}
		
		
		function test() {
			$message =  $this->input->post('message');
			
			echo $message == null ? 'null' : 'ok';
		}
		
		
		
		/**
		 *	友群的设置， 需要管理员权限  
		 */
		function setting($group_id, $action = 'setting' ) {
			login_redirect();
			
			// 管理员only
			if ( ! is_group_admin ( $group_id, get_current_user_id() ) ) {
				exit( 'group_admin only!' );
			}
			
			
			$this->_if_group_404( $group_id );
			$render = array();
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				//表单验证
				$this->form_validation->set_rules('name', '果群名称', 'trim|required|xss_clean|htmlspecialchars');
				$this->form_validation->set_rules('privacy', '果群公开性', 'trim|required|xss_clean');
				$this->form_validation->set_rules('category_id', '群类别', 'trim|required|xss_clean');
				$this->form_validation->set_rules('verify', '加入友群验证方式', 'trim|required|xss_clean');
				$this->form_validation->set_rules('intro', '果群简介', 'trim|xss_clean|htmlspecialchars');
				$this->form_validation->set_rules('website', '果群网页', 'trim|xss_clean');
				
				$this->form_validation->set_rules('province_id', '省份', 'trim|xss_clean');
				$this->form_validation->set_rules('city_id', '城市', 'trim|xss_clean');
				
				$this->form_validation->set_rules('slug', '群网址', 'trim|xss_clean|alpha_dash');
				
				if ( !$this->form_validation->run() ) {
					ajaxReturn( null, validation_errors(), 0);
				} else {
					// Slug Form Validation More
					// 群网址设置，不可以为纯数字
					$slug = $this->form_validation->set_value('slug');
					if ( is_numeric( $slug ) ) {
						ajaxReturn( null, '群网址不可以为纯数字', 0);
					}
					// 保证群网址，没有被别人设置了！
					if ( $this->group_model->is_group_slug_existed( $slug, $group_id ) ) { // 需要填入当前用户id， 允许用户重复同样地设置slug
						// 存在了？返回失败吧
						ajaxReturn( null, '你填写的群网址已经被人抢先一步了!', 0);
					}
					
					
					$group_privacy = $this->form_validation->set_value('privacy');
					$group_verify = $this->form_validation->set_value('verify');
					
					// 如果是公开群组，强制任何用户都可以加入！
					if ( $group_privacy == 'public' ) {
						$group_verify = 'everyone';
					}
					
					$this->group_model->update_group( $group_id , array(
						'name' => $this->form_validation->set_value('name'),
						'privacy' => $group_privacy,
						'category_id' => $this->form_validation->set_value('category_id'),
						
						'province_id' => $this->form_validation->set_value('province_id'),
						'city_id' => $this->form_validation->set_value('city_id'),
						
						'verify' => $group_verify,
						'intro' => $this->form_validation->set_value('intro'),
						'website' => $this->form_validation->set_value('website'),
						
						'slug' => $slug,
					));
					ajaxReturn( array(
									'group_url' => get_group_url( $group_id ),
									), 
									'果群修改成功', 1);
				}
			}
			
			
			$render['group'] = $this->group_model->get_group_by_id( $group_id );
			
			if ( $action == 'setting' ) {
			
				
				$render['group_categories'] = $this->group_model->get_group_categories();

				kk_show_view('group/setting_view', $render);
				
			} else if ( $action == 'members' ) {
				$render['group_id'] = $group_id;
				$render['group_members'] = $this->group_model->get_group_users( $group_id );
				
				kk_show_view('group/setting_members_view', $render);
			
			
			} else if ( $action == 'advanced' ) {
				
				kk_show_view('group/setting_advanced_view', $render);
			}
		}
		
		/**
		 *	上传群组logo标志
		 */	
		function logo_upload($group_id) {
			login_redirect();
			$data = array();
			
			$group_path = $this->config->item('group_logo_path') . $group_id;
			
			$this->_createDir($group_path);
			
		    $config['upload_path'] = $group_path;
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size'] = '2048';   //可以上传2MB
			$config['max_width']  = '2024';
			$config['max_height']  = '1768';
			$config['overwrite'] = true;  //覆盖
			$config['file_name'] = 'group_logo_' . $group_id . '.png' ;
			
			$this->load->library('upload', $config);
			
			if ( !$this->upload->do_upload() ) {
				// 上传失败信息
				//$this->session_message->set( $this->upload->display_errors() );
				
				$data['group_id'] = $group_id;
				$data['page_message'] = $this->upload->display_errors();
				
				
				
			} else {
				//上传成功，
				// 提供裁剪界面...
				$upload_data = $this->upload->data();
				$data['group_id'] = $group_id;
				$data['upload_data'] = $upload_data;
				$data['logo_url'] = static_url() . 'upload/groups/' . $group_id .'/' . $upload_data['file_name'];

			}
			
			
			$this->load->view('group/logo_upload_view', $data );
		}
		
		/**
		 *	将 Group Logo裁剪成正方形
		 */
		function logo_crop($group_id) {
			login_redirect();
			
			$x1 = $this->input->post('x1');
			$y1 = $this->input->post('y1');
			$x2 = $this->input->post('x2');
			$y2 = $this->input->post('y2');
			$logo_file = $this->input->post('logo_file');
			$logo_path = $this->config->item('group_logo_path') . $group_id;
			
			$width = $x2 - $x1;  // 根据x2, y2确定新图片高度
			$height = $y2 - $y1;
			
			$img_config = array(
				'image_library' => 'gd2',
				'source_image' => $logo_path . '/group_logo_' . $group_id . '.png',
				'maintain_ratio' => false,  //要裁剪成正方形～不保持原来比例
				'width' => $width,
				'height' => $height,   
				
				'x_axis'=> $x1,
				'y_axis'=>$y1,
				'create_thumb' => false,
			);
			
			$this->load->library('image_lib', $img_config);
			if ( !$this->image_lib->crop($x1, $y1)) {   // 裁剪！
				echo $this->image_lib->display_errors();
			} else {
				
				$this->group_model->set_group_logo($group_id);

				echo 'success!';
			}
		}
		
		
		/**
		 *   Group 查看单项
		 */
		function group_lookup($group_id_slug, $action='index', $do='') {
			
			$this->load->model('chat_model');
			$this->load->model('topic_model');
			$this->load->model('relation_model');
			$this->load->model('event_model');
			
			$start = $this->input->get('start');
			
			if ( is_numeric($group_id_slug) ) {
				// 若传入数字， 判断成ID～～读取该ID的用户
				$group_id = $group_id_slug;
				
				$this->_if_group_404( $group_id );
				
				
				
				
			} else {
				// 获得slug对应的用户
				$group_id = $this->group_model->get_group_id_by_slug( $group_id_slug );
				$this->_if_group_404( $group_id );
				
				// slug对应群组存在？ 通过ID登录吧！
				
			}
			

			
			// 提升一人气
			up_group_page_view( $group_id );
			//if ( !$this->tank_auth->is_logged_in() ) {
			//	redirect('user/login?redirect=/group/'. $group_id);
			//}
			
			$group = $this->group_model->get_group_by_id($group_id);
			
			
			/** 友群权限 */
			$current_user_id = $this->tank_auth->get_user_id();
			
			// 判断是否private私有群组，并且用户不属于该群组，
			// 那么，转到禁止进入页面 )  ~ 提示不能进入，或者让用户输入验证信息
			if ( $this->group_model->is_group_private($group_id) && !$this->group_model->is_group_user( $group_id, $current_user_id ) ) {
				$render['group'] = $group;
				$render['group_users_count'] = $this->group_model->get_group_users_count( $group_id );
				
				kk_show_view('group/group_forbidden_view', $render);
				
				return;
			}
			
			
			
			
			/**
			 *	****** 开始，群组首页
			 */
			

			
			
			$render = array(
				'group' => $group,
				'group_id' => $group_id,
				'group_users' => $this->group_model->get_group_users($group_id, 10),
				'group_users_count' => $this->group_model->get_group_users_count( $group_id ),
				//'topics' => $topics,
				
				'action' => $action,
				'current_group' => 'current_menu',
				
// 				'hide_header' => true,
// 				'hide_footer' => true,

				'relation_groups' => $this->relation_model->get_relation_groups( $group_id, 6 ), //获取关系群组,限制6个
				'relation_groups_count' => $this->relation_model->get_relation_groups_count( $group_id ),
			);
			
			if ( $action == 'index' ) {
				// 群组首页
				$render['current_group_lookup_home'] = true;
				// 獲取一些topics
				$render['topics'] = $this->topic_model->get_topics('group', $group_id, 10);
				$render['events'] = $this->event_model->get_events('group', $group_id, 11);
				
				$render['page_title'] = $group['name'];
				
				kk_show_view('group/group_lookup_view', $render);
				
			} else if ( $action == 'topic' ) {
			
				// 群组话题页
				// 友群话题，并在里面包含的latest chat
				$topics = $this->topic_model->get_topics('group', $group_id);
				foreach ( $topics as $key=>$topic ) {
					$topics[$key]['latest_chat'] = $this->chat_model->get_latest_chat( 'topic', $topics[$key]['id'] );
				}
				
				$render['topics'] = $topics;
				$render['current_group_lookup_topic'] = true;
				
				$render['page_title'] = $group['name'] . ' 话题';
				
				kk_show_view('group/group_lookup_topic_view', $render);
				
			} else if ( $action == 'stream' ) {
				// 群组信息盒子
				$render['current_group_lookup_stream'] = true;
				
				$render['page_title'] = $group['name'] . ' 信息';
				
				kk_show_view('group/group_lookup_stream_view', $render);
			} else if ( $action == 'event' ) {
			
				// 成员列表、成员管理
				$this->load->model('event_model');
				$events = $this->event_model->get_events('group', $group_id);
				
				$render['events'] = $events;
				$render['current_group_lookup_event'] = true;
				
				$render['page_title'] = $group['name'] . ' 活动';
				
				kk_show_view('group/group_lookup_event_view', $render);
				
			} else if ( $action == 'chat' ) {
				// 聊天
				$render['current_group_lookup_chat'] = true;
				
				$render['page_title'] = $group['name'] . ' 群聊';
				
				kk_show_view('group/group_lookup_chat_view', $render);
			} elseif ( $action == 'intro' ) {
				// 群组简介
				$render['current_group_lookup_intro'] = true;
				
				$render['page_title'] = $group['name'] . ' 介绍';
				
				kk_show_view('group/group_lookup_intro_view', $render);
				
			} elseif ( $action == 'relations' ) {
				// 关系群组
				
				$render['current_group_lookup_relations'] = true;
				
				$render['page_title'] = $group['name'] . ' 关系群组';
				
				$render['relation_lookup_groups'] = $this->relation_model->get_relation_groups( $group_id, 50, $start );
				
				
				kk_show_view('group/group_lookup_relations_view', $render );
				
			} elseif( $action == 'members' ) {
				$render['current_group_lookup_members'] = true;
				$render['page_title'] = $group['name'] . ' 成员列表';
				$render['group_members'] = $this->group_model->get_group_users( $group_id, 50, $start );
				
				kk_show_view('group/group_lookup_members_view', $render);
			}
		}
		
		
		
		
		/**
		 *  Controller Action
		 *  当前登录用户邀请其他用户加入群组
		 */
		function group_invite( $group_id ) {
			
			$render['group'] = $this->group_model->_get_group( $group_id );
			$render['current_group'] = 'current_menu';
			
			kk_show_view( 'group/group_invite_view' , $render );
		}
		
		
		/**
		 *	设置某人成某群组的管理员，前提当然是你是管理员
		 */
// 		function ajax_set_group_admin( $group_id, $user_id ) {
// 			
// 			if ( $this->group_model->set_group_admin( $group_id, $user_id ) ) {
// 				// 设置成管理员了
// 				ajaxReturn( null, '设置他为管理员了', 1 );
// 			} else {
// 				ajaxReturn( null, '无法设置成管理员', 0 );
// 			
// 			}
// 		}
		
		///////////    Ajax 下面
		
		

		
		function iframe_new_group() {
			$this->load->model('group_model');
			
			
			// POST 提交，Ajax返回
			// group_name
			// group_privacy
			// group_category
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				//表单验证
				$this->form_validation->set_rules('group_name', '果群名称', 'trim|required|xss_clean');
				$this->form_validation->set_rules('group_privacy', '果群公开性', 'trim|required|xss_clean');
				$this->form_validation->set_rules('group_category', 'Group Category', 'trim|required|xss_clean');
				
				$this->form_validation->set_rules('group_province_id', '群组省份', 'trim|xss_clean');
				$this->form_validation->set_rules('group_city_id', '群组城市', 'trim|xss_clean');
				
				$this->form_validation->set_rules('group_verify', '加入友群验证方式', 'trim|required|xss_clean');
				$this->form_validation->set_rules('intro', '果群简介', 'trim|xss_clean');
				
				if ( !$this->form_validation->run() ) {
					ajaxReturn( null, validation_errors(), 0);
				} else {
					// 验证成功，创建友群！
					$group_name = $this->form_validation->set_value('group_name');
					$group_privacy = $this->form_validation->set_value('group_privacy');
					$group_category = $this->form_validation->set_value('group_category');
					$group_verify = $this->form_validation->set_value('group_verify');
					$group_intro = $this->form_validation->set_value('intro');
					
					$owner_id = $this->tank_auth->get_user_id();  // 创始人 user id
					
					// 群组加入方式 - 公开群组: 任何人都可以(关注)加入！ 私有群组: 设置加入方式
					if ( $group_privacy == 'public' ) {
						$group_verify = 'everyone';
					}
					
					//$group_id = $this->group_model->create_group($group_name, $group_category, $group_privacy, $group_verify, $owner_id=$owner_id);
					$group_id = $this->group_model->create_group(array(
						'name' => $group_name,
						'category_id' => $group_category,
						'privacy' => $group_privacy,
						'verify' => $group_verify,
						'owner_id' => $owner_id,
						'intro' => $group_intro,
						'province_id' => $this->form_validation->set_value('group_province_id'),
						'city_id' => $this->form_validation->set_value('group_city_id'),
					));
					
					$this->session_message->set(
												sprintf( 'Hi.你已创建了群「%s」。<br />点击「邀请入群」，邀请你的朋友们加入吧。', $group_name )
											);
					
					ajaxReturn(
						array(
							'group_name' => $group_name,
							'group_id' => $group_id, 
						),
						'成功创建友群！', 1);
				}
				
				
				
				ajaxReturn( null, $this->input->post('group_category'), 0);
			}
			
			
			$render = array(
				'group_categories' => $this->group_model->get_group_categories( array(
					'parent_id' => 0,
				)),
			);
			kk_show_view('group/iframe_new_group_view', $render);
		}
		
		
		
		
		/**
		 *	取消当前用户在某个群组的管理员身份 ( admin => member )，
		 
		 		只改变身份，保留群组
		 */
		function ajax_cancel_group_admin( $group_id ) {
			login_redirect();
			
			// 最后一个管理员不能退出！就是只剩一个管理员的情况下
			if ( $this->group_model->get_group_admins_count( $group_id ) == 1 ) {
				ajaxReturn( null, '你是最后一个管理员。你需要找到另一个管理员，才能退出该群组', 0);
				//exit()
			} else {
				$this->group_model->update_group_user( $group_id, get_current_user_id(),array(
					'user_role' => 'member',
				));
			}
			
			ajaxReturn( null, '已取消管理员身份了', 1);
			
			
		}
		
		///////////////////// iframe 下面
		/**,. 
		 *   让当前登录用户加入友群 iframe
		 *   $action   ->   join 加入       exit  退出友群
		 */
		function ajax_join_group($group_id, $action='join') {
			if ( ! is_logged_in() ) {
				ajaxReturn( 'login_redirect', '尚未登录', 0 );
			}
			
			if ( !$this->tank_auth->is_logged_in() ) {
				exit('Error!! You directly enter here?');
			}
			$user_id = get_current_user_id();
			$group = $this->group_model->get_group_by_id($group_id);
			
							// 加入群组
			if ( $action == 'join' ) {
				// 判断group是否需要request verify
				if ( $group['verify'] == 'everyone' ) {
					// 每个人都可以加入，无需验证
					// 执行 友群加入用户~  
					$result = $this->group_model->create_group_user($group_id, $user_id);
					if ( $result ) {
						ajaxReturn( null, '成功加入'.$group['name'], 1);
					} else {
						ajaxReturn(null, '加入失败，可能已加入 may joined', 0);
					}
					
				} elseif ( $group['verify'] == 'request' ) {
					// 若没填message, 返回失败0，  ajax弹出提示框，让用户输入message
					$message = $this->input->post('message');
					if ( $message == '' ) {
						ajaxReturn( 'message', '请输入验证信息', 0);
					} else {				
						// 若已经有$message需要验证请求，那么生成验证信息 request
						if ( $this->request_model->create_or_update_request_group($group_id, $user_id, $message) ) {
							ajaxReturn( null, '成功发送加入群的验证信息' ,1 );
						}
					}
					
				}
			} else if ( $action == 'exit' ) { // 退出群组
			
			
				// 禁止管理员退出（群组）～ （需要先撤出管理员）
				if ( $this->group_model->is_group_admin( $group['id'], get_current_user_id() ) ) {
					ajaxReturn( 'fobbid admin exit group', '您需要先解除管理员的身份才能退出群组', 0 );
				} else {					
					$this->group_model->del_group_user( $group['id'], get_current_user_id() );
					ajaxReturn( 'exit', '已退出该群', 1 );
				}

				
			}
			
			echo 'direct here?';
		}
		
		/**
		 *	获取加入群组的按钮， 用于ajax重新读取页面 (html)
		 */
		function ajax_get_join_group_btn( $group_id ) {
			$group = $this->group_model->get_group_by_id( $group_id );
			
			$render['group'] = $group;
			kk_show_view('group/general_join_group_view', $render );
		}
		
		
		/**
		 *	让用户输入 “加入果群” 验证信息的iframe窗口 ajax html
		 */
		function ajax_request_join_group( $group_id ) {
			$render['group_id'] = $group_id;
			kk_show_view('group/ajax_request_join_group_view', $render );
		}
		
		
		
		/**
		 *	获取友群所有成员的微博信息，合并.
		 */
		function ajax_get_group_t_sina( $group_id ) {
			
			// 获得t_sina_stream
			$t_sina_array = $this->group_model->get_group_users_t_sina( $group_id );
			$stream = $this->stream->get_t_sina_stream( $t_sina_array );
			
			$data = array(
				'stream' => $stream,
			);
			
			$this->load->view('stream/ajax_get_stream_view', $data );
			

			
		}
		
		/**
		 *	设置某人为 群组的管理员
		 */
		function ajax_set_group_admin( $group_id, $user_id ) {
			if ( is_group_admin( $group_id, get_current_user_id() ) ) {
				// 判断当前用户是否是那个群组的管理员~否则不能操作
				if ( $return_data = $this->group_model->set_group_admin( $group_id, $user_id ) ) {
					// 成功提升某人为群组管理员
					ajaxReturn( $return_data, '提升管理员成功!', 1);
				} else {
					ajaxReturn( '提升不到', '不能提升其为管理员, 原因不明', 0 );
				}
			} else {
				ajaxReturn( 'no admin no action', '你不是管理员，不能提升管理员', 0 );
			}
		}
		
		
		/**
		 *	ajax获取某群的网址
		 */
		function ajax_get_group_url( $group_id ) {
			ajaxReturn( get_group_url( $group_id ), '群网址..', 1 );
		}
		

		/**
		 *	ajax 对应group的topics ( parent_id=0 )
		 */
// 		function group_chats($group_id) {
// 			$chats = $this->chat_model->get_chats('group',$group_id);
// 
// 			$data = array(
// 				'chats' => $chats,
// 				'group_id' => $group_id,
// 			);
// 			$this->load->view('group/group_chats_view', $data);
// 		}
// 
// 		function comments( $chat_id ) {
// 			
// 		}
		
		
		
		
		
		
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
		 *	用于判断当前action所需要的group对象是否存在，不存在，404页面吧
		 */
		function _if_group_404( $group_id ) {
			if ( !$this->group_model->get_group_by_id( $group_id ) ) {
				show_404();
			}
		}
		
	}
