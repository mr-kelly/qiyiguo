<?php

	class Relation extends KK_Controller {
		
		function __construct() {
			parent::__construct();
			$this->load->model('relation_model');
			
		}
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
				// 提醒to_user
				add_notice( $to_user_id, 
							'新粉丝',
							sprintf( '%s收藏了你', get_current_user_name() ),
							sprintf('/%s/%s','user', get_current_user_id() ),
							'user',
							get_current_user_id()   // 查看他的用户页面，那么清楚notice
								);
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
				// 取消关注不提醒		
			
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
		
		
		
		
		function ajax_choose_group_relation( $from_group_id ) {
		
			$render['from_group_id'] = $from_group_id;
			
			kk_show_view('relation/ajax_choose_group_relation_view',$render);// 
// 			if ( $relation_id = $this->relation_model->create_group_relation( $from_group_id, $to_group_id ) ) {
// 				// 创建 群组关联关系
// 				echo $relation_id;
// 			} else {
// 				echo 'fail';
// 			}
		}
		
		
		/**
		 *	用于IE 6
		 */
		function choose_group_relation( $from_group_id ) {
			$render['from_group_id'] = $from_group_id;
			$render['group'] = kk_get_group( $from_group_id );
			
			kk_show_view('relation/choose_group_relation_view', $render);
		}
		
		function ajax_add_group_relation( $from_group_id, $to_group_id ) {
			if ( $relation_id = $this->relation_model->create_group_relation( $from_group_id, $to_group_id ) ) {
				// 创建 群组关联关系
				ajaxReturn( $relation_id, '成功创建', 1);
			} else {
				ajaxReturn( null, '不能创建群组关系', 0 );
			}
		}
		
		
	}
