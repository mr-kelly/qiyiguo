<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_Profiles_Model extends KK_Model {

	function __construct() {
		parent::Model();
		$this->ci =& get_instance();
		
		// 判断是否登录，登录了的话设置当前用户ID current_user_id
		if ( $this->ci->tank_auth->is_logged_in() ){
			$this->current_user_id = $this->ci->tank_auth->get_user_id();
		} else {
			$this->current_user_id = null;
		}
		
	}
	
	
	/**
	 *	创建User Profile
	 	注意， 传入$data!
	 */
	function create_user_profile( $user_id , $data ){
		$data['user_id'] = $user_id;
		$this->db->insert('user_profiles', $data + array(
			'created' => date('Y-m-d H:i:s'),
		));
		return $this->db->insert_id();
	}
	
	function update_user_profile( $user_id, $data) {
		$this->db->where('user_id', $user_id);
		$this->db->update('user_profiles', $data);
	}
	/**
	 *	获取用户详细资料，单条记录
	 *  $user_id
	 */
	function get_profile( $user_id=null ) {
		return $this->_get_user($user_id);
		
		//若不填写user_id ,设置user_id为当前用户ID（若再也是空，返回空)
// 		if ( $user_id == null) {
// 			if ($this->current_user_id != null ) {
// 				$user_id = $this->current_user_id;
// 			} else {
// 				return null;
// 			}
// 		}
// 		
// 		// Get User Email
// 		$userQ = $this->db->get_where('users', array(
// 			'id' => $user_id,
// 		));
// 		$user = $userQ->result_array();
// 		$user = $user[0]; //取第一条记录
// 		
// 		
// 		// Get UserProfile
// 		$query = $this->db->get_where('user_profiles',array(
// 			'user_id' => $user_id,
// 		));
// 		
// 		$user_profile = $query->result_array();
// 		$user_profile = $user_profile[0]; //取第一条记录
// 		
// 		//unset($user['id']); // BUG,  helper get id BUG
// 		unset($user['password']);
// 		
// 		// 设置一个帐户通用名 name, 根据nickname, realname, email生成
// 		if ( $user_profile['realname'] == '') {
// 			if ( $user_profile['nickname'] == '' ) {
// 				$user_profile['name'] = $user['email'];
// 			} else {
// 				$user_profile['name'] = $user_profile['nickname'];
// 			}
// 		} else {
// 			$user_profile['name'] = $user_profile['realname'].' '.$user_profile['nickname'];
// 		}
// 		
// 		//return $user;
// 		return array_merge($user_profile, $user);
	}
	
	
	/**
	 *	修改用户当前的头像～
	 */
	function set_user_avatar($user_id,  $avatar_id ) {
		$this->db->where('user_id', $user_id);
		
		$data = array(
			'avatar_id' => $avatar_id,
		);
		$this->db->update('user_profiles', $data);
		
	}
	
	
	
	
	
	
	/**
	 *	判断用户是否已绑定新浪微博帐号，即user_t_sina存在数据
	 */
	function is_user_t_sina_binding($user_id) {
	
	}
	
	
	/**
	 *	User是否存在~
	 */
	function is_user( $user_id ) {
		$query = $this->db->get_where('users', array(
			'id' => $user_id,
		));
		
		if ( $query->num_rows() == 0 ) {
			return false;
		} else {
			return $query->num_rows();
		}
		
	}
}