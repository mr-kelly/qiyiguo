<?php
	class KK_Model extends Model {
		function __construct() {
			parent::Model();
		}
		function KK_Controller() {
			$this->__construct();
		}
		
		
		/**
		 *		用于关联模型
		 */
		 
		function _get_request_group( $id = null ) {
			$query = $this->db->get_where('request_group', array(
				'id'=> $id,
			));
			$arr = $query->result_array();
			return $arr[0];
		}
		 
		// 获得指定group
		function _get_group( $group_id ) {
			$query = $this->db->get_where('group', array(
				'id' => $group_id,
			));
			
			$arr = $query->result_array();
			return $arr[0]; //第一条
		}
		
		/*获得用户的user profile详细, 除去密码*/
		function _get_user( $user_id=null ) {
			//若不填写user_id ,设置user_id为当前用户ID（若再也是空，返回空)
			if ( $user_id === null) {
				if ($this->current_user_id != null ) {
					$user_id = $this->current_user_id;
				} else {
					return null;
				}
			}
			
			// Get User Email
			$userQ = $this->db->get_where('users', array(
				'id' => $user_id,
			));
				// 如果用户不存在，可能被删了，返回空用户
				if ( $userQ->num_rows == 0 ) {
					return array(
						'id'=>0,
						'user_id'=>0,
						'realname'=>'用户不存在',
						'nickname'=>'用户不存在',
						'description'=>'',
						'country'=>'',
						'website' => 'http://www.mrkelly.org',
						'qq' => '',
						'msn' => '',
						'gtalk' => '',
						'email_1' => '',
						'email_2' => '',
						'email_3' => '',
						'birth' => '',
						'link_renren' => '',
						'avatar_id' => '',
						'province_id' => '',
						'city_id' => '',
						
						 
// 						'Avatar' => Array
// 							(
// 								'id' => 0,
// 								'user_id' => 0,
// 								'avatar_file' => '',
// 								'created' => '',
// 								'modified' => '',
// 								'avatar_thumb' => '',
// 							),
					 
						'name' => '用户不存在',
						'email' => '',
						'activated' => '',
						'banned' => '',
						'ban_reason' => '',
						'new_password_key' => '',
						'new_password_requested' => '',
						'new_email' => '',
						'new_email_key' => '',
						'last_ip' => '',
						'last_login' => '',
						'created' => '',
						'modified' => '',
					);
				}
				
			$user = $userQ->result_array();
			$user = $user[0]; //取第一条记录
			
			
			// Get UserProfile
			$query = $this->db->get_where('user_profiles',array(
				'user_id' => $user_id,
			));
			
			$user_profile = $query->row_array(); //取第一条记录
//			$user_profile = $user_profile[0]; //取第一条记录
			
			// 用户的birth转化成birth_year, birth_month, birth_day
			$user_profile['birth_year'] = $this->humanize->get_year($user_profile['birth']);
			$user_profile['birth_month'] = $this->humanize->get_month($user_profile['birth']);
			$user_profile['birth_day'] = $this->humanize->get_day( $user_profile['birth'] );
			
			// 关联 User Avatar 用户的头像信息，可参考user_avatars_model里的get_user_model
			$this->load->model('user_avatars_model');
			$avatar = $this->db->get_where('user_avatars',array(
				'id' => $user_profile['avatar_id'],  // 根据UserProfile获取user_profile里的头像信息
			));
			// 用户有头像
			if ( $avatar->num_rows() != 0 ) {
				$avatar = $avatar->result_array();
				$avatar = $avatar[0];
				
				$avatar_thumb = explode(".", $avatar['avatar_file'] , 2);
				$avatar['avatar_thumb'] = $avatar_thumb[0]. '_thumb'. '.' . $avatar_thumb[1];
				
				$user_profile['Avatar'] = $avatar;
			}
			
			

			// 用户省份、城市
			$this->load->model('dict_model');
			
			

			//unset($user['id']);
			unset($user['password']);
			
			// 设置一个帐户通用名 name, 根据nickname, realname, email生成
			if ( $user_profile['realname'] == '') {
				if ( $user_profile['nickname'] == '' ) {
					$user_profile['name'] = $user['email'];
				} else {
					$user_profile['name'] = $user_profile['nickname'];
				}
			} else {
				$user_profile['name'] = $user_profile['realname'].' '.$user_profile['nickname'];
			}
			
			
			
			
			/** 
			 * 第三方网站链接
			 */
			
			// 人人网
			if ( $user_profile['link_renren'] ) {
				$renren_url = $this->config->item('renren_url');
				$user_profile['renren_url'] = sprintf( $renren_url, $user_profile['link_renren'] );
			}
			
			
			// 新浪微博
			$user_t_sina = $this->db->get_where('user_t_sina', array(
				'user_id' => $user['id'],
			));
			if ( $user_t_sina->num_rows() == 1 ) {
				$user_t_sina = $user_t_sina->result_array();
				
				$user_profile['t_sina_url'] = $this->config->item('t_sina_url') . $user_t_sina[0]['t_sina_id'];
			
			} else {
				// 没绑定新浪微博， 设空
				$user_profile['t_sina_url'] = '';
			}
			
			
			
			//return $user;
			return array_merge($user_profile, $user);
		
		}
		

		
		
	}