<?php

	/**
	 *	KK Access Controller List   Functions 
	 */
	 
	 
	 
	 
	 
	/**
	 *	 群组 Group
	 */
	  
	/**
	 *	判断群组是否私有~~否则就是公有呗
	 */
	function is_group_private( $group_id ) {
		$ci =& get_instance();
		$ci->load->model('group_model');
		return $ci->group_model->is_group_private( $group_id );
	}
	
	/**
	 *	判断用户是否属于该群组
	 */
	function is_group_user( $group_id, $user_id ) {
		$ci =& get_instance();
		$ci->load->model('group_model');
		return $ci->group_model->is_group_user( $group_id, $user_id );
	}
	
	/** 
	 *	判断用户是否是群组管理员
	 */
	function is_group_admin( $group_id, $user_id ) {
		$ci =& get_instance();
		$ci->load->model('group_model');
		return $ci->group_model->is_group_admin( $group_id, $user_id );
	}
	
	
	
	/**
	 *	活动、任务 Event
	 */
	 
	 
	 /**
	  *	判断用户是否参加(签到)了event
	  
	  		返回 "join" / "follow"(兴趣) / false
	  */
	 function is_event_user( $user_id, $event_id ) {
	 	$ci =& get_instance();
	 	$ci->load->model('event_model');
	 	return $ci->event_model->is_event_user( $user_id, $event_id );
	 }
	 
	 /**
	  *	判断某用户是否对event感兴趣/关注..
	  */
// 	 function is_user_follow_event( $user_id, $event_id ) {
// 	 	$ci->load->model('event_model');
// 	 	return $ci->event_model->is_event_user;
// 	 }
	