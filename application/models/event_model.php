<?php

	class Event_Model extends KK_Model {
		
		/*
			创建事件
			
			$data = array(
				'name'=>,
				'content'
				
				'start' =>
				'end'
				'model',
				'model_id',
				'user_id',
			); 
				
		 */
		function create_event( $data ) {
			$this->db->insert('event', $data + array(
				'created' => date('Y-m-d H:i:s'),
			));
			return $this->db->insert_id();
		}
		
		
		/**
		 *	修改活动
		 */
		function update_event( $event_id, $data ) {
			$this->db->where('id', $event_id );
			return $this->db->update('event', $data);
		}
		
		/**
		 *	获得所有的活动 （慎用、测试
		 */
		function get_all_events( $limit=100, $start=0 ) {
		
		}
		
		
		/**
		 *	自定义要获取的event
		 */
		function get_events_custom( $data, $limit=100, $start=0 ) {
			$this->db->order_by('created', 'desc');
			
			$query = $this->db->get_where('event', $data , $limit, $start );
			
			
			
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			$events = $query->result_array();
			
			// 绑定 附加图片
			foreach ( $events as $k=>$v ) {
				$events[$k]['User'] = $this->_get_user( $events[$k]['user_id'] );
				
				if ( !empty( $events[$k]['attach_img_id'] ) ) {
					$events[$k]['Attach_Img'] = $this->_get_attach( $events[$k]['attach_img_id'], 'image' );
				}
			}
			
			return $events;
			
		}
		
		/**
		 * 获取 事件集（活动集，任务集）
		 */
		function get_events( $model, $model_id, $limit=100, $start=0 ) {
			 $this->db->order_by('created', 'desc');
			 
			 $query = $this->db->get_where('event', array(
			 	'model' => $model,
			 	'model_id' => $model_id,
			 ), $limit, $start );
			 
			 if ( $query->num_rows() == 0 ) {
			 	 return false;
			 } 
			 
			 $events = $query->result_array();
			// 绑定 附加图片
			foreach ( $events as $k=>$v ) {
				$events[$k]['User'] = $this->_get_user( $events[$k]['user_id'] );
				
				if ( !empty( $events[$k]['attach_img_id'] ) ) {
					$events[$k]['Attach_Img'] = $this->_get_attach( $events[$k]['attach_img_id'], 'image' );
				}
			}
			
			return $events;
			 
		}
		
		/**
		 *	获取指定活动的数量
		 */
		function get_events_count( $model, $model_id ) {
			$query = $this->db->get_where('event', array(
				'model' => $model,
				'model_id' => $model_id,
			));
			
			return $query->num_rows();
		}
	
		
		/**
		 *	获得用户参与的活动
		 */
		function get_user_events( $user_id, $limit=10, $start=0 ) {
			$this->db->order_by('created', 'desc');
			$query = $this->db->get_where('event_user', array(
				'user_id' => $user_id,
			), $limit, $start );
			
			
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			$return_events = array();
			foreach(  $query->result_array() as $event_user ) {
				$return_events[] = $this->get_event_by_id( $event_user['event_id'] );
			}
			
			return $return_events;
		}
		
		/**
		 *	根据ID指定获取事件（活动/任务）
		 */
		function get_event_by_id( $event_id ) {
			$query = $this->db->get_where('event', array(
				'id' => $event_id,
			));
			
			if ( $query->num_rows() == 0 ) {
				return false;
			} else {
				$event = $query->row_array();
				
				// 嵌入 对应的 Model, User
				$event['User'] = $this->_get_user( $event['user_id'] );
				
				if ( $event['model'] == 'group' ) {
					$event['Group'] = $this->_get_group( $event['model_id'] );
				}
				
				
				if ( !empty( $event['attach_img_id'] ) ) {
					$event['Attach_Img'] = $this->_get_attach( $event['attach_img_id'], 'image' );
				}
				
				return $event;
				
			}
		}
		
		/**
		 *	从公开群组获取最新的活动...
		 */
		function get_fresh_events( $limit=10, $start=0) {
			$sql = sprintf('SELECT * FROM kk_event 
								WHERE model_id = 
									( SELECT kk_group.id FROM kk_group WHERE kk_event.model_id = kk_group.id AND kk_group.privacy = "public" )
									ORDER BY created DESC
									LIMIT %d,%d', $start, $limit ); // kk_topic.model_id = kk_group.id AND
									
			$query = $this->db->query( $sql );
			
			return $query->result_array();
		}
		
		
		/**
		 *	删除符合条件的 事件（活动/任务)
		 */
		function del_event( $event_id ) {
			// 删除事件
			$delete_event = $this->db->delete('event', array(
				'id' => $event_id,
			));
			
			// 删除事件的参与情况
			$delete_event_user = $this->db->delete('event_user', array(
				'event_id' => $event_id,
			));
			
			// 删除事件的评论
			$delete_event_chats = $this->db->delete('chat', array(
				'model' => 'event',
				'model_id' => $event_id,
			));
			
			return ( $delete_event && $delete_event_user && $delete_event_chats );
		}
		
		
		
		/**
		 *	创建 事件、用户、参与者
		 */
		function create_event_user( $event_id, $user_id, $type='join' ) {
			// 防止重复
			$query = $this->db->get_where( 'event_user', array(
				'event_id' => $event_id,
				'user_id' => $user_id,
			));
			
			if ( $query->num_rows() != 0 ) {
				// 已存在～？ 看是join的，还是follow的，
				// 如果与当前要添加的不同，删除旧的，添加新的
				$event_user = $query->row_array();
				if ( $event_user['type'] != $type ) {
				
					$this->del_event_user( array(
						'id' => $event_user['id'] ,
					));
					
					// 继续运行...
				} else {
					return false;
				}
			}
			
			$this->db->insert('event_user', array(
				'event_id' => $event_id,
				'user_id' => $user_id,
				'type' => $type,
				'created' => date('Y-m-d H:i:s'),			
			));
			
			return $this->db->insert_id();
		}
		
		
		/**
		 *	判断用户是否与event有关系。  返回join / follow / false(没关系)  (join/follow不能同时出现)
		 */
		function is_event_user( $event_id, $user_id ) {
			$query = $this->db->get_where( 'event_user', array(
				'event_id' => $event_id,
				'user_id' => $user_id,
			));
			
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			$event_user = $query->row_array();
			
			return $event_user['type'];
			
		}
		
		/**
		 *	删除活动与用户参与状况~  必须type :   join / follow
		 */
		function del_event_user( $data ) {
			return $this->db->delete( 'event_user', $data);
		}
		
		
		
		/**
		 *	获取事件、活动 的参与者...
		 */
		function get_event_users( $event_id, $type='join' )  {
			
			$sql = sprintf( 'SELECT * FROM kk_event_user WHERE event_id=%d', $event_id );
			if ( $type ) {
				$sql .= sprintf( ' AND type="%s"', $type );
			}
			
			$event_users= $this->db->query( $sql );
			
// 			$event_users = $this->db->get_where('user_event', array(
// 				'event_id' => $event_id,
// 				'type' => $type,
// 			));
			$return_users = array();
			foreach( $event_users->result_array() as $event_user ) {
				$return_users[] = $this->_get_user( $event_user['user_id'] );
			}
			
			return $return_users;
		}
		
		
		/**
		 *	获取事件、活动、任务参与人数..数量
		 */
		function get_event_users_count( $event_id, $type='join' ) {
			$sql = sprintf( 'SELECT * FROM kk_event_user WHERE event_id=%d', $event_id );
			if ( $type ) {
				$sql .= sprintf( ' AND type="%s"', $type );
			}
			
			$event_users= $this->db->query( $sql );
			
			return $event_users->num_rows();
		}
		
		
		
		/**
		 *	提升活动、事务人气
		 */
		function up_event_page_view( $event_id ) {
			$event = $this->get_event_by_id( $event_id );
			
			$this->db->where('id', $event['id'] );
			return $this->db->update('event', array(
				'page_view' => $event['page_view'] + 1,
			));
		}
	}
