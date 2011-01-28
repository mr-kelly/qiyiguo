<?php

	/**
	 *	该模型主要用于 用新浪微博第三方登录
	 
	 	
	 		普通网站用户的的绑定，数据处理，放在user_profiles_model~
	 */
	class User_T_Sina_Model extends KK_Model {
	
		/**
		 *	OAuth 绑定。全新改
		 */
		function create_user_t_sina( $user_id, $data ) {
			$this->db->insert('user_t_sina', array(
				'user_id' => $user_id,
				'created' => date('Y-m-d H:i:s'),
			) + $data);
			
			return $this->db->insert_id();
		}
		
		
		/**
		 *	判断是否存在user_t_sina绑定信息
		 */
		function is_user_t_sina( $data ) {
			$q = $this->db->get_where('user_t_sina', $data );
			
			if ( $q->num_rows() == 0 ) {
				return false;
			} else {
				return true;
			}
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		/**
		 *	用户通过新浪微博方式登录
		 		通过user_t_sina数据表数据，获得user_id对应的user数据,
		 		再登录
		 */
		function t_sina_login($login, $password, $remember) {
			$t_sina_user = $this->db->get_where('user_t_sina', array(
				't_sina_login' => $login,
				//'type' => 't_sina',
			))->result_array();
			$t_sina_user = $t_sina_user[0];
			$user = $this->_get_user($t_sina_user['user_id']);
			
			$this->tank_auth->login( $user['email'], $password, $remember, false, true);
			
		}
		
		/**
		 *	检验$password 加密处理后是否跟现在数据库的密码一样
		 
		 例用户输入 123,
		 	读取数据库中加密过的密码，进行解密处理，
		 	与现在的密码对比
		 */
		function checkPassword($login, $password) {
			$this->load->library('fun_crypt');
			
			//$password_hash = $this->fun_crypt->enCrypt($password);
			
			$t_sina_user = $this->db->get_where('user_t_sina', array(
				't_sina_login' => $login,
				//'type' => 't_sina',
			))->result_array();
			
			if ( sizeof( $t_sina_user ) != 0 ) {
				$t_sina_user = $t_sina_user[0]; // 取第一条
			} else return false; // 不存在该user_t_sina
			
			
			// 解密数据库中密码后，是否匹配输入的密码？
			
			return ( $this->fun_crypt->deCrypt($t_sina_user['t_sina_password']) == $password );

			
			
			
		}
		
		
		/**
		 *	微博密码不匹配，更改user_t_sina和users两个表中的密码
		 */
		function changePassword($login,  $new_pass) {
			
			// user_t_sina表中密码改变
			$this->db->where('t_sina_login', $login);
			//$this->db->where('type', 't_sina');  // 微博登录用户类型
			
			// 密码作可逆处理
			$this->load->library('fun_crypt');
			
			$data = array(
				't_sina_password'=> $this->fun_crypt->enCrypt($new_pass),
			);
			$this->db->update('user_t_sina', $data);
			
			
			// users表
				// 先获取user_t_sina对应的user_id
			$user_t_sina = $this->db->get_where('user_t_sina',
				array(
					't_sina_login'=> $login,
				))->result_array();
			$user_id = $user_t_sina[0]['user_id'];
			
			$this->load->library('tank_auth');
			$this->tank_auth->change_password_by_user_id($user_id, $new_pass);
			
			
			
		}
		/**
		 *	判断该新浪微博用户，是否已经存在于数据库(即以前登录过)
		 
		 不存在数据， =》可能正常用户，未绑定
		 
		 存在数据 =》 可能正常用户，已绑定
		 		 =》 可能微博用户，未绑定
		 
			
			
			Depreciated 用于旧版http
			
		 */
		function is_user_t_sina_old_http($t_sina_login) {
			$query = $this->db->get_where('user_t_sina',array(
				't_sina_login' => $t_sina_login,
				//'type'=> 't_sina',
			));
			if ( $query->num_rows() == 0 ) {
				return false;
			} else {
				return true;
			}
			
		}
		
		/**
		 *	绑定帐户，用于普通帐户的create_user_t_sina
		 */
		function bind_user_t_sina($user_id, $login, $password, $type="user") {
			$this->load->library('fun_crypt');
			
			// 绑定前，判断是否已存在数据（可能通过微博登录的）
			if ($this->is_user_t_sina($login)) {
				// 存在,
				$t_sina_user = $this->db->get_where('user_t_sina', array(
					't_sina_login' => $login,
				))->result_array();
				
				$t_sina_user = $t_sina_user[0];
				
				// 并且 type是t_sina， 错误！
				if ( $t_sina_user['type'] == 't_sina' ) {
				
					return false;
					
				} else if ( $t_sina_user['type'] == 'user' ) {
					// 存在，但type是user, 更新
					$this->db->where('user_id', $user_id);
					$data = array(
						't_sina_login' => $login,
						't_sina_password' => $this->fun_crypt->enCrypt($password),
					);
					$this->db->update('user_t_sina', $data);
					
				}
				
				
			} else {
				// 获得微博帐号信息
				$this->load->library('t_sina');
				$t_sina_user = $this->t_sina->getUser( $login, $password );
			
				$data = array(
					'user_id' => $user_id,
					't_sina_id' => $t_sina_user['id'],
					't_sina_login' => $login,
					't_sina_password' => $this->fun_crypt->enCrypt($password),
					'type' => $type,
				);
				$this->db->insert('user_t_sina', $data);
			}
		}
		
		
		/**
		 *	通过新浪微博登录，添加user_t_sina,并添加user, user_profiles
		 
		 
		 	depreciated  用于http auth的旧版 
		 */
		function create_user_t_sina_old_http($login, $password, $type='t_sina') {
			$ci =& get_instance();
			$ci->load->model('dict_model');
			
			// 如果$login不是email, 那么应该是早期新浪微博用户，添加 @sina.com
// 			if (!filter_var($login, FILTER_VALIDATE_EMAIL)) {
// 				$login_email = $login . '@sina.com';
// 			} else {
// 				$login_email = $login;
// 			}

			// 所有t_sina login, 加上@t.sina.com，以区分
			$login_email = $login . '@t.sina.com';
			
			// 密码作可逆处理
			$this->load->library('fun_crypt');
			
			
			// 先插入user						// 强制的email~  // 原始密码,系统user会另外加密处理
			$this->tank_auth->create_user('', $login_email, $password,FALSE);
			$user_id = $this->db->insert_id();
			
			// 再插入user_t_sina表
			$password_hash = $this->fun_crypt->enCrypt($password);  // 加密
			
			// 获得微博帐号信息
			$this->load->library('t_sina');
			$t_sina_user = $this->t_sina->getUser( $login, $password );
			
			$data = array(
				'user_id' => $user_id,
				't_sina_id' => $t_sina_user['id'],
				't_sina_login' => $login,   // 原始登录名
				't_sina_password' => $password_hash,  // 加密过的
				'type' => $type,   // 使用微博帐号登录的类型，    
			);
			$this->db->insert('user_t_sina', $data);
			
			// 再插入user_profiles, 同步新浪微博与奇异果帐号的资料
			$this->load->model('user_profiles_model');
			
			
			
			
			// 同步头像 ( 先同步头像， 同步资料时放入头像文件的数据id )
			if ( isset($t_sina_user['profile_image_url'] ) ) {
			
															// 修改默认新浪微博配置的头像大小
				$avatar = file_get_contents( str_replace( '/50/', '/180/', $t_sina_user['profile_image_url']) );
				
				// 写入头像到指定头像上传文件夹
				$avatar_path = $this->config->item('avatar_path') . '/' . $user_id . '/';
				$this->_createDir($avatar_path);
				
				$avatar_file_name = md5(rand(0,9999));
				$avatar_file_normal_name = $avatar_file_name . '.png';
				$avatar_file_thumb_name =  $avatar_file_name . '_thumb.png';
				
				// 下载成2个头像文件, 一个正常，一个thumb缩略图
				file_put_contents( $avatar_path . $avatar_file_normal_name , $avatar);  // 写入头像文件,用md5加随机数生成随机文件名
				file_put_contents( $avatar_path . $avatar_file_thumb_name, $avatar );
				
				// 头像下载完了，配置数据库绑定
				
				$ci->load->model('user_avatars_model');
				$avatar_id = $ci->user_avatars_model->create_user_avatar( $user_id, $avatar_file_normal_name );
				
			}
			
			
			// 同步资料
			$data = array(
				'email_1' =>  !filter_var($login, FILTER_VALIDATE_EMAIL) ? $login.'@sina.com' : $login, // 设置profile中的email
				'nickname'=> $t_sina_user['screen_name'],
				'description' => $t_sina_user['description'],
				'website' => $t_sina_user['url'],
				
				// 性别, 根据api, f => female f => male,
				'gender' =>  ( $t_sina_user['gender'] == 'f' ) ? 'female' : 'male',
				
				//省份城市同步
				'province_id' => $t_sina_user['province'],
				'city_id' => $ci->dict_model->t_sina_city_adapter_id( $t_sina_user['province'], $t_sina_user['city'] ),
				
				// 头像
				'avatar_id' => $avatar_id,
			);
			$this->user_profiles_model->create_user_profile( $user_id, $data);
			
			

			
		}
		
		
		//function update_user_t_sina(
		/**
		 *	获取指定用户的新浪微博绑定数据，
		 	没绑定，返回false
		 */
		function get_user_t_sina( $user_id ) {
			$t = $this->db->get_where('user_t_sina', array(
				'user_id' => $user_id,
			));
			
			if ( $t->num_rows() == 1 ) {
				$t = $t->result_array();
				return $t[0];
				
			} else {
				return false;
			}
		}
		
		function get_user_t_sina_by_t_sina_id ( $t_sina_id ) {
			$t = $this->db->get_where('user_t_sina', array(
				't_sina_id' => $t_sina_id,
			));
			
			if ( $t->num_rows() == 1 ) {
				$t = $t->result_array();
				return $t[0];
			} else {
				 return false;
			}
		}
		
		/**
		 *	用户是否绑定新浪微博帐号
		 
		 	返回 t_sina
		 	  或 user
		 	  或 false
		 	  
		 	  不等于 t_sina
		 */
		function is_bind_user_t_sina( $login , $by_what='by_login') {
		
			if ( $by_what == 'by_id') {
				//相当于声调一个函数is_bind_user_t_sina_by_id
				$user_t_sina = $this->db->get_where('user_t_sina', array(
					'user_id' => $login
				));
			} else {
				// by_login, 通过帐号		
				$user_t_sina = $this->db->get_where('user_t_sina', array(
					't_sina_login' => $login,
				));
			}
			
			if ( $user_t_sina->num_rows() != 0) {
				$user_t_sina = $user_t_sina->result_array();
				$user_t_sina = $user_t_sina[0];
				
				return $user_t_sina['type'];
				
			} else {
				//没绑定 ， 
				return false;
			}
			
		}
		
		
		/**
		 *	删除一个绑定信息
		 */
		function delete_user_t_sina( $user_id ) {
			$this->db->where('user_id', $user_id);
			return $this->db->delete('user_t_sina');
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