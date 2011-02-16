<?php

	class Relation extends KK_Controller {
		
		/**
		 *	关注某人~ 传入对方user_id
		 */
		function ajax_follow_user( $to_user_id ) {
			login_redirect();
			
			$current_user_id = get_current_user_id();
			
			$this->load->model('relation_model');
			if ( !$this->relation_model->create_user_relation( $current_user_id, $to_user_id )) {
				ajaxReturn(null, 'exist or duplicated', 0);
			} else {
				// 成功follow关联
				ajaxReturn( null, '关注了他！', 1 );
			}
			
		}
		
		
		/**
		 *	取消关注某人~
		 */
		function ajax_unfollow_user( $to_user_id ) {
			login_redirect();
			
			$this->load->model('relation_model');
			if ( $this->relation_model->del_user_relation( get_current_user_id(), $to_user_id )) {
				ajaxReturn( null, '已取消关注！', 1 );
			} else {
				ajaxReturn( null, 'failed!' , 0 );
			}
			
		}
		
		
		/**
		 *	ajax获得用户关注按钮的html视图, 用于ajax完之后，修改页面
		 */
		function ajax_get_user_relation_btn( $to_user_id ) {
			$render = array(
				'to_user_id' => $to_user_id,
			);
			
			kk_show_view('general/general_user_relation_btn_view', $render);
		}
		
		
	}