<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class User_Profiles_Model extends KK_Model {

	function __construct() {
		parent::__construct();
		$ci =& get_instance();
		
		// 判断是否登录，登录了的话设置当前用户ID current_user_id
		if ( $ci->tank_auth->is_logged_in() ){
			$this->current_user_id = $ci->tank_auth->get_user_id();
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
	
	
	function get_users( $data=array(), $limit=10, $start=0 ) {
		$this->db->order_by('created','desc');
		$us = $this->db->get_where('users', $data, $limit, $start);
		
		$return_users = array();
		foreach ( $us->result_array() as $u ) {
			array_push( $return_users, $this->_get_user( $u['id'] ) );
		}
		return $return_users;
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
	
	function get_user_id_by_slug( $slug ) {
		$query = $this->db->get_where('user_profiles', array(
			'slug' => $slug,
		));
		if ( $query->num_rows() == 0 ) {
			return false;
		} else {
			$user_profiles = $query->row_array();
			return $user_profiles['user_id'];
		}
	}
	
	/**
	 *	获取用户的个人网址设置slug
	 */
	function get_user_slug( $user_id ) {
		$query = $this->db->get_where('user_profiles', array(
			'user_id' => $user_id,
		));
		if ( $query->num_rows() == 0 ) {
			return false;
		} else {
			$user_p = $query->row_array();
			return $user_p['slug'];
		}
	}
	
	/**
	 *	检查slug是否存在，  
	 	（但要忽略指定用户的当前设置，比如目前用户已经设置slug是mrkelly， 他可以重新设置mrkelly
	 	
	 */
	function is_user_slug_existed( $slug, $user_id ) {
		// 如果$slug为空，直接返回不存在吧 (就是不设置)
		if ( $slug == '' ) return false;
		
		
		$query = $this->db->get_where('user_profiles', array(
			'slug' => $slug,
			'user_id !=' => $user_id,
		));
		if ( $query->num_rows() == 0 ) {
			return false;  // 不存在
		} else {
			return true; // 存在了！
		}
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
