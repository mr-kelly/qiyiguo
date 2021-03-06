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
			if ( !is_logged_in() ) {
				ajaxReturn('login_required', '未登录', 0);
			}
			
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
				ajaxReturn( null, '收藏了他！', 1 );
			}
			
		}
		
		
		/**
		 *	取消关注某人~
		 */
		function ajax_unfollow_user( $to_user_id ) {
			if ( !is_logged_in() ) {
				ajaxReturn('login_required', '未登录', 0);
			}
			
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
		
		
		/**
		 *	创建群组关系
		 */
		function ajax_add_group_relation( $from_group_id, $to_group_id ) {
		
			// 先判断to有没有已经跟from创建关系， 如果有，令他们双向群组关系
			//if ( $this->relation_model->is_group_related( $to_group_id, $from_group_id ) ) {
				// 对方早就关系过from了。双方关系吧
			//	$this->relation_model->create_group_relation_mutual( $from_group_id, $to_group_id );
			//}
			
			
			
			// 然后再执行当前...普通关系添加
			if ( $relation_id = $this->relation_model->create_group_relation( $from_group_id, $to_group_id ) ) {
				// 创建 群组关联关系
				// 成功创建了。 提醒to_group的每个管理员...
				$this->load->model('group_model');
				$from_group = kk_get_group( $from_group_id );
				$to_group = kk_get_group( $to_group_id );
				
				$group_admins = $this->group_model->get_group_admins( $to_group_id );
				
				foreach( $group_admins as $admin ) {
					add_notice( $admin['id'], '友情群', 
								sprintf( '%s与%s成了关系群', $from_group['name'], $to_group['name'] ),
								'g/' . $from_group_id,
								'group',
								$from_group_id );
					
//function add_notice( $user_id, $title='', $content, $link, $model=null, $model_id=null, $type='notice' ) {
				}
				
				
				ajaxReturn( $relation_id, '成功创建', 1);
			} else {
				ajaxReturn( null, '不能创建群组关系', 0 );
			}
		}
		
		/**
		 *	删除群组关系
		 */
		function ajax_delete_group_relation( $from_group_id, $to_group_id ) {
			$group = kk_get_group( $from_group_id );
			
			if ( is_group_admin( $group['id'], get_current_user_id() ) ) {
				if ( $this->relation_model->del_group_relation( $from_group_id, $to_group_id ) ) {
					ajaxReturn( null, '已删除群组关系', 1 );
				} else {
					ajaxReturn( null, '无法删除群组关系', 0 );
				}
			} else {
				ajaxReturn(null, '权限不足，非管理员', 0 );
			}
		}
		
		
	}
