<?php

	/**
	 *	用户 Stream流的数据模型..
	 */
	class Stream_Model extends KK_Model {
		
		/**
		 *	获取用户加入群组的活动、任务的总数量
		 */
		function get_user_groups_events_count( $user_id ) {
			$groups_sql = sprintf( 'SELECT kk_group_user.group_id FROM kk_group_user INNER JOIN kk_group
							WHERE kk_group_user.user_id = %d
							AND kk_group_user.group_id = kk_group.id',
							$user_id );  // 不限制~获取全部群组～
							
			if ( !empty ( $privacy ) ) { // 获取关注的公开？私有群组？
				$groups_sql .= sprintf( ' AND kk_group.privacy = "%s"', $privacy );
			}
			
			$user_groups = $this->db->query( $groups_sql );
							
							
			if ( $user_groups->num_rows() == 0 ) {
				return false;
			}
			
			// 抓取events...
			$query_sql = 'SELECT * FROM kk_event WHERE';
			foreach ( $user_groups->result_array() as $key=>$user_group ) {
				if ( $key == 0 ) { // 第一次首行不加or
					$query_sql .= sprintf( ' ( model = "group" AND model_id = %d )', $user_group['group_id'] );
				} else {
					$query_sql .= sprintf( ' OR ( model = "group" AND model_id = %d )', $user_group['group_id'] );
				}
			}
			
			// 排序
			//$query_sql .= 'ORDER BY created DESC';
			// 限制
			//$query_sql .= sprintf( ' LIMIT %d,%d', $start, $limit );
			
			
			return $this->db->query( $query_sql )->num_rows();
			//return $this->db->query( $query_sql )->result_array() ;
		}
		/**
		 *	获取用户的活动、任务。。不论参与与否.
		 */
		function get_user_groups_events( $user_id, $limit=20, $start=0, $privacy=null ) {
			$groups_sql = sprintf( 'SELECT kk_group_user.group_id FROM kk_group_user INNER JOIN kk_group
							WHERE kk_group_user.user_id = %d
							AND kk_group_user.group_id = kk_group.id',
							$user_id );  // 不限制~获取全部群组～
							
			if ( !empty ( $privacy ) ) { // 获取关注的公开？私有群组？
				$groups_sql .= sprintf( ' AND kk_group.privacy = "%s"', $privacy );
			}
			
			$user_groups = $this->db->query( $groups_sql );
							
							
			if ( $user_groups->num_rows() == 0 ) {
				return false;
			}
			
			// 抓取events...
			$query_sql = 'SELECT * FROM kk_event WHERE';
			foreach ( $user_groups->result_array() as $key=>$user_group ) {
				if ( $key == 0 ) { // 第一次首行不加or
					$query_sql .= sprintf( ' ( model = "group" AND model_id = %d )', $user_group['group_id'] );
				} else {
					$query_sql .= sprintf( ' OR ( model = "group" AND model_id = %d )', $user_group['group_id'] );
				}
			}
			
			// 排序
			$query_sql .= 'ORDER BY created DESC';
			// 限制
			$query_sql .= sprintf( ' LIMIT %d,%d', $start, $limit );
			
			return $this->db->query( $query_sql )->result_array() ;
			
		}
		
		/**
		 *	获取用户的关注的群组的话题...
		 	
		 		// 是否搜查指定的群组。..public ? private?
		 */
		function get_user_groups_topics( $user_id, $limit=20, $start=0 , $privacy=null ) {
			// 先获得用户关注的群组~ // 获取全部，
			$groups_sql = sprintf( 'SELECT kk_group_user.group_id FROM kk_group_user INNER JOIN kk_group
											WHERE kk_group_user.user_id = %d
											AND kk_group_user.group_id = kk_group.id', 
											$user_id  );
			if ( ! empty ($privacy ) ) {
				// 指定获取 公开或私有的群组
				$groups_sql .= sprintf( ' AND kk_group.privacy = "%s"', $privacy );
			}
			
			
			
			//$groups_sql = .sprintf( ' LIMIT %d,%d', $start, $limit ); 不限制
			$user_groups = $this->db->query( $groups_sql );
			
			
			if ( $user_groups->num_rows() == 0 ) {
				return false;  //没有关注群组，返回空
			}
			
			// 抓取对应群组的topics..
			
			$query_sql = 'SELECT * FROM kk_topic WHERE';
			foreach ( $user_groups->result_array() as $key=>$user_group ) {
// 				$this->db->or_like( array(
// 					'model' => 'group',
// 					'model_id' => $user_group['group_id'],
// 				) );
				if ( $key == 0 ) { //第一次，不加 OR 查询
					$query_sql .= sprintf('( model = "%s" AND model_id = %d )', 'group', $user_group['group_id'] );
				} else {
					$query_sql .= sprintf(' OR ( model = "%s" AND model_id = %d )', 'group', $user_group['group_id'] );
				}
				
			}
			
			// 排序, 最新放前面
			$query_sql .= ' ORDER BY created DESC';
			// 限制
			$query_sql .= sprintf( ' LIMIT %d,%d', $start , $limit );
			
			
			$topics = $this->db->query( $query_sql )->result_array();
			
			foreach( $topics as $key=>$topic ) {
				$topics[$key]['User'] = kk_get_user( $topic['user_id'] );
				$topics[$key]['Group'] = kk_get_group( $topic['model_id'] );
			}
			
			return $topics;
			
//			return $this->db->get('topic', $limit, $start)->result_array();
			
			
		}
		
		
		
		function get_user_groups_topics_count( $user_id ) {
			// 先获得用户关注的群组~ // 获取全部，
			$groups_sql = sprintf( 'SELECT kk_group_user.group_id FROM kk_group_user INNER JOIN kk_group
											WHERE kk_group_user.user_id = %d
											AND kk_group_user.group_id = kk_group.id', 
											$user_id  );
			if ( ! empty ($privacy ) ) {
				// 指定获取 公开或私有的群组
				$groups_sql .= sprintf( ' AND kk_group.privacy = "%s"', $privacy );
			}
			
			
			
			//$groups_sql = .sprintf( ' LIMIT %d,%d', $start, $limit ); 不限制
			$user_groups = $this->db->query( $groups_sql );
			
			
			if ( $user_groups->num_rows() == 0 ) {
				return false;  //没有关注群组，返回空
			}
			
			// 抓取对应群组的topics..
			
			$query_sql = 'SELECT * FROM kk_topic WHERE';
			foreach ( $user_groups->result_array() as $key=>$user_group ) {
// 				$this->db->or_like( array(
// 					'model' => 'group',
// 					'model_id' => $user_group['group_id'],
// 				) );
				if ( $key == 0 ) { //第一次，不加 OR 查询
					$query_sql .= sprintf('( model = "%s" AND model_id = %d )', 'group', $user_group['group_id'] );
				} else {
					$query_sql .= sprintf(' OR ( model = "%s" AND model_id = %d )', 'group', $user_group['group_id'] );
				}
				
			}
			
			// 排序, 最新放前面
			//$query_sql .= ' ORDER BY created DESC';
			// 限制
			//$query_sql .= sprintf( ' LIMIT %d,%d', $start , $limit );
			return $this->db->query( $query_sql )->num_rows();
			
			
			
// 			$topics = $this->db->query( $query_sql )->result_array();
// 			
// 			foreach( $topics as $key=>$topic ) {
// 				$topics[$key]['User'] = kk_get_user( $topic['user_id'] );
// 				$topics[$key]['Group'] = kk_get_group( $topic['model_id'] );
// 			}
// 			
// 			return $topics;
		}
		
		
		
		
		/**
		 *	获得用户的的Stream....用于显示在用户页面~
		 
		 	包括： 用户发布的群话题、群活动
		 			用户评论的群话题、
		 			参与、关注的群活动
		 */
		function get_user_stream( $user_id, $limit=20, $start=0 ) {
			$stream_array = array();
			
			// 用户发的话题....
			$user_topics_sql = sprintf( 
							'SELECT kk_topic.* FROM kk_topic,kk_group 
								WHERE kk_topic.user_id=%d 
								AND kk_group.privacy="public" 
								AND kk_group.id = kk_topic.model_id  
								ORDER BY kk_topic.created DESC 
								LIMIT %d,%d', 
							$user_id ,
							$start,
							$limit
							);
						
						
			$user_topics = $this->db->query( $user_topics_sql )->result_array();
			
			foreach( $user_topics as $topic ) {
				$stream_array[] = array(
					'User' => kk_get_user( $topic['user_id'] ),
					'Group' => kk_get_group( $topic['model_id'] ),
					'Object' => array(
						'act' => '发布了',
						'title' => '话题',
						'text' => !empty( $topic['title'] ) ? $topic['title'] : kk_content_preview( $topic['content'], 36 ),
						'link' => sprintf( '/%s/%s', 'topic', $topic['id'] ),
					),
					'created' => $topic['created'],
					'modified' => $topic['modified'],
				);
			}
			
			
			// 用户发的活动
			$user_events_sql = sprintf(
								'SELECT kk_event.* FROM kk_event,kk_group 
									WHERE kk_event.user_id=%d 
									AND kk_group.privacy="public" 
									AND kk_group.id = kk_event.model_id  
									ORDER BY kk_event.created DESC 
									LIMIT %d,%d',
								$user_id,
								$start,
								$limit
								);
								
			$user_events = $this->db->query( $user_events_sql )->result_array();
			
			foreach( $user_events as $event ) {
				$stream_array[] = array(
					'User' => kk_get_user( $event['user_id'] ),
					'Group' => kk_get_group( $event['model_id'] ),
					'Object' => array(
						'act' => '组织了',
						'title' => '活动',
						'text' => $event['name'],
						'link' => sprintf( '/%s/%s', 'event', $event['id'] ),
					),
					'created' => $event['created'],
					'modified' => $event['modified'],
				);
			}
			
			// 用户关注的活动
			$user_join_events_sql = sprintf(
										'SELECT kk_event.id,
										kk_event.name,
										kk_event.model_id,
										kk_event_user.user_id,
										kk_event_user.created,
										kk_event_user.modified FROM kk_event, kk_event_user, kk_group
										WHERE kk_event_user.user_id=%d
										AND kk_event_user.event_id=kk_event.id
										AND kk_group.privacy="public"
										AND kk_group.id = kk_event.model_id
										ORDER BY kk_event_user.created DESC
										LIMIT %d,%d',
										$user_id,
										$start,
										$limit
									);
			$user_join_events = $this->db->query( $user_join_events_sql )->result_array();
			
			foreach( $user_join_events as $event ) {
				$stream_array[] = array(
					'User' => kk_get_user( $event['user_id'] ),
					'Group' => kk_get_group( $event['model_id'] ),
					'Object' => array(
						'act' => '参与了',
						'title' => '活动',
						'text' => $event['name'],
						'link' => sprintf( '/%s/%s', 'event', $event['id'] ),
					),
					'created' => $event['created'],
					'modified' => $event['modified'],
				);
			}
			
			
			// 用户的话题评论   //获得评论，并获取对应的topic的群组
			$user_topics_chat_sql = sprintf( 'SELECT 
										kk_chat.user_id, 
										kk_chat.model_id AS topic_id,
										kk_topic.title AS topic_title,
										kk_topic.content AS topic_content,
										kk_chat.created, 
										kk_chat.modified, 
										kk_topic.model_id AS group_id
										
										FROM kk_chat,kk_topic,kk_group
										WHERE kk_chat.user_id=%d
										AND kk_chat.model="topic"
										
										AND kk_chat.model_id = kk_topic.id
										AND kk_topic.model_id = kk_group.id
										
										ORDER BY kk_chat.created DESC
										LIMIT %d,%d',
										$user_id,
										$start,
										10 ); // 限制10条评论
										
			$user_topics_chat = $this->db->query( $user_topics_chat_sql )->result_array();
			
			foreach( $user_topics_chat as $chat ) {
				$stream_array[] = array(
					'User' => kk_get_user( $chat['user_id'] ),
					'Group' => kk_get_group( $chat['group_id'] ),
					'Object' => array(
						'act' => '评论了',
						'title' => '聊天',
						'text' => !empty( $chat['topic_title'] ) ? $chat['topic_title'] : kk_content_preview( $chat['topic_content'], 36) ,
						'link' => sprintf( '/%s/%s', 'topic', $chat['topic_id'] ),
					),
					'created' => $chat['created'],
					'modified' => $chat['modified'],
				);
			}
			
			
			// 时间排序函数
			function modified_sort( $a, $b ) {
				return $a['created'] < $b['created'];
			}
			
			// 按照modified排序
			usort( $stream_array, 'modified_sort' );
			
			return $stream_array;
		}
		
		
// 		function _modified_sort( $a, $b ) {
// 			return $a['created'] > $b['created'];
// 		}
		
		
		/**
		 *	搜索stream。。。 包括公开群组的（话题， 活动）
		 */
		function search_stream( $q, $limit=50, $start=0 ) {
		
			$return_stream = array();
			
			$topics_sql = 'SELECT kk_topic.* FROM kk_topic, kk_group
							WHERE kk_topic.model_id = kk_group.id
							AND kk_group.privacy = "public"
							AND ( kk_topic.title LIKE "%' . $q . '%"
							OR kk_topic.content LIKE "%' . $q . '%" )
							ORDER BY created DESC
							LIMIT ' . $start . ',' . $limit;
			
							
			$topics = $this->db->query( $topics_sql )->result_array();
			
			
			foreach( $topics as $topic ) {
				$return_stream[] = array(
					'User' => kk_get_user( $topic['user_id'] ),
					'Group' => kk_get_group( $topic['model_id'] ),
					'Object' => array(
						'act' => '发布了',
						'title' => '话题',
						'text' => !empty( $topic['title'] ) ? $topic['title'] : kk_content_preview($topic['content'],36) ,
						'link' => sprintf('/%s/%s', 'topic', $topic['id'] ),
					),
					'created' => $topic['created'],
					'modified' => $topic['modified'],
				);
			}
			
			
			
			$events_sql = 'SELECT kk_event.* FROM kk_event, kk_group
							WHERE kk_event.model_id = kk_group.id
							AND kk_group.privacy = "public"
							AND ( kk_event.name LIKE "%' . $q . '%"
							OR kk_event.content LIKE "%' . $q . '%" )
							ORDER BY created DESC
							LIMIT ' . $start . ',' . $limit;
			$events = $this->db->query( $events_sql )->result_array();
			
			foreach( $events as $event ) {
				$return_stream[] = array(
					'User' => kk_get_user( $event['user_id'] ),
					'Group' => kk_get_group( $event['model_id'] ),
					'Object' => array(
						'act' => '组织了',
						'title' => '活动',
						'text' => $event['name'],
						'link' => sprintf('/%s/%s', 'event', $event['id'] ),
					),
					'created' => $event['created'],
					'modified' => $event['modified'],
				);
			}
							
							
			
			
			
			return $return_stream;
			
		}
		
		
		function search_stream_count( $q ) {
			// 指定的搜索返回多少条
			
			
		}
		
		
		/**
		 *	获取指定用户发布、参与、感兴趣的活动
		 */
		function get_user_events( $user_id ) {
			
		}
		
		/**
		 *	获取用户最新发布 的话题    +(/评论) 
		 */
		function get_user_topics( $user_id ) {
			
		}
		
		
		/**
		 *	随机stream... 话题，活动
		 */
		function get_random_stream( $limit = 10, $start=0 ) {
		
			$return_stream = array();
			
			$topics_sql = 'SELECT kk_topic.* FROM kk_topic, kk_group
							WHERE kk_topic.model_id = kk_group.id
							AND kk_group.privacy = "public"
							ORDER BY rand()
							LIMIT ' . $start . ',' . $limit;
			
							
			$topics = $this->db->query( $topics_sql )->result_array();
			
			
			foreach( $topics as $topic ) {
				$return_stream[] = array(
					'User' => kk_get_user( $topic['user_id'] ),
					'Group' => kk_get_group( $topic['model_id'] ),
					'Object' => array(
						'act' => '发布了',
						'title' => '话题',
						'text' => !empty( $topic['title'] ) ? $topic['title'] : kk_content_preview($topic['content'],36) ,
						'link' => sprintf('/%s/%s', 'topic', $topic['id'] ),
					),
					'created' => $topic['created'],
					'modified' => $topic['modified'],
				);
			}
			
			
			
			$events_sql = 'SELECT kk_event.* FROM kk_event, kk_group
							WHERE kk_event.model_id = kk_group.id
							AND kk_group.privacy = "public"
							ORDER BY rand()
							LIMIT ' . $start . ',' . $limit;
			$events = $this->db->query( $events_sql )->result_array();
			
			foreach( $events as $event ) {
				$return_stream[] = array(
					'User' => kk_get_user( $event['user_id'] ),
					'Group' => kk_get_group( $event['model_id'] ),
					'Object' => array(
						'act' => '组织了',
						'title' => '活动',
						'text' => $event['name'],
						'link' => sprintf('/%s/%s', 'event', $event['id'] ),
					),
					'created' => $event['created'],
					'modified' => $event['modified'],
				);
			}
							
							
			
			
			
			return $return_stream;
		}
	}
