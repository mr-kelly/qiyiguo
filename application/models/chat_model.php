<?php
	/**
	 *		Topic ---- parent_id = 0
	 		Comment -----  parent_id !=0
	 */
	class Chat_Model extends KK_Model {
	
	
		function __construct() {
			parent::__construct();
			// 留言嵌套层数
			$this->threaded_num = 10;
			
			$this->chat_and_children = array();
		}
		
		
		
		/**
		 *	获取指定的chat～
		 */
		function get_chat_by_id( $chat_id ) {
			$query = $this->db->get_where('chat', array(
				'id' => $chat_id,
			));
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			return $query->row_array();
			
		}
		/**
		 *	获取指定model_id的评论数目
		 */
		function get_chats_count( $model, $model_id ) {
			return $this->db->get_where('chat', array(
				'model' => $model, 
				'model_id' => $model_id,
			))->num_rows();
		}
		
		/**
		 *	获取指定对象最后一条评论
		 */
		function get_latest_chat( $model, $model_id ) {
			// $this->db->order_by('created DESC');
// 			$chats =  $this->db->get_where('chat', array(
// 				'model' => $model,
// 				'model_id' => $model_id,
// 			));
// 			
// 			if ( $chats->num_rows != 0 ) {
// 				$chats = $chats->result_array();
// 				$chat = $chats[0];
// 				
// 				return $chat;
// 			} else {
// 			
// 				return false;
// 			
// 			}
			$chats = $this->get_chats( $model, $model_id );
			if ( sizeof( $chats ) != 0 ) {
				return $chats[0];
			} else {
				return false;
			}
			
		}
		/**
		 *
		 */
		function get_chats( $model, $model_id, $limit = 10, $parent_id=0 ) {
			$topics_and_comments = array();  // 中间存取变量
			
			$this->db->order_by('created DESC');
			$topics = $this->db->get_where('chat', array(
				'model' => $model,
				'model_id' => $model_id,
				'parent_id' => $parent_id,
			), $limit);

			if ( $topics->num_rows != 0 ) {			
				$topics = $topics->result_array();
				
				
				foreach ( $topics as $topic ) {
					//if ( $topics_and_comments == array() ) {
					
					// 合并topic, comments， 整合数组
					foreach ( $this->get_chat_and_children( $topic['id'] ) as $chat ) {
						array_push( $topics_and_comments,  $chat);
					}
					
					
				}
			}
			
			return $topics_and_comments;
		}
		
		/**
		 *	获取指定chat和它所有子chat，返回它们
		 
		 
		 		利用该其私有方法_get_chat_and_children
		 */
		function get_chat_and_children( $chat_id ) {
			//清空
			$this->chat_and_children = array();
			$this->_get_chat_and_children($chat_id);
			
			return $this->chat_and_children;
		}
		
		
		/**
		 *	获取指定chat所有子chat,  ** 放在$this->children!!
		 
		 	利用变量$this->chat_and_children
		 */
		private function _get_chat_and_children( $chat_id ,$depth=0) {
			$this->db->order_by('created DESC');
			$chat = $this->db->get_where('chat', array(
				'id'=>$chat_id,
			));
			
			$chat = $chat->result_array();
			$chat = $chat[0];
			$chat['depth'] = $depth;
			
			// 关联模型，加入User模型
			$user = $this->_get_user($chat["user_id"]);
			$chat['User'] = $user;
			//$chat['depth'] = $depth;
			//$chat = $chat[0];
			array_push($this->chat_and_children, $chat );
			
			//$this->children = $chat;
			
			
			$this->db->order_by('created DESC');
			$child_chats = $this->db->get_where('chat', array(
				'parent_id' => $chat_id,
			));
			
			if ( $child_chats->num_rows != 0) {
				// 令深度+1
				$depth++;
				// 存在子chat
				// 先放入children,再循环检测
				$child_chats = $child_chats->result_array();
				//array_push($this->chat_and_children, $child_chats); //不用push，会重复
				
				foreach ( $child_chats as $child_chat ) {
					$this->_get_chat_and_children($child_chat['id'], $depth);
				}
			}
		}
		
		function create_chat( $model, $model_id=0, $title='', $content='', $parent_id=0, $user_id=0 ) {
			$data = array(
				'model' => $model,
				'model_id' => $model_id,
				'title' => $title,
				'content' => $content,
				'parent_id' => $parent_id,
				'user_id' => $user_id,
				'created' => date('Y-m-d H:i:s'),
			);
			
			$this->db->insert('chat', $data);
		}
		/**
		 *	获取单条chat及其下所有chat
		 
		 //是否有子
		 // 有子取子
		 // 子是否有子
		   /  有子继续取子
		 */
// 		 function get_chat($chat_id) {
// 		 	$chat = $this->db->get_where( 'chat', array(
// 		 		'id'=> $chat_id,
// 		 	));
// 		 	$chat = $chat->result_array();
// 		 	$chat = $chat[0];
// 		 	
// 		 	$child_chats = $this->db->get_where( 'chat' ,array(
// 		 		'parent_id' => $chat_id,
// 		 	));
// 		 	
// 		 	if ( $child_chats->num_rows() != 0 ) {
// 		 		// 有子取子
// 		 		$child_chats = $child_chats->result_array();
// 		 		foreach ( $child_chats as $k=>$v ) {
// 		 			$child_chats[$k]['depth'] = 1;
// 		 		}
// 		 		$chat['child_chats'] = $child_chats;
// 		 		
// 		 		
// 		 	}
// 		 	return $chat;
// 		 	
// 		 }
// 		 
		 
// 		 function get_chats( $model, $model_id, $limit=10) {
// 		 	
// 		 }
		 
		// 返回chat,  
// 		function get_chats( $model, $model_id, $limit=10 ) {
// 			$chats = $this->db->get_where( 'chat', array(
// 				'model'=> $model,
// 				'model_id' => $model_id,
// 				
// 				'parent_id'=>0,
// 			));
// 			
// 			// 利用循环制造`嵌套评论` 的 嵌套数组 ['child_chats'] - 嵌套的数量
// 			$chats = $chats->result_array();
// //			foreach ( $chats as $key=>$value ) {
// 			
// 				//if ( $this->has_child_chats( $chats[$key]['id']) != 0 ) {
// //					$chats[$key]['child_chats_num'] = $this->has_child_chats($chats[$key]['id']);
// 					
// 				//}
// 				
// 				//$child_chats =& $chats[$key]['child_chats'];
// 				
// // 				foreach ( $child_chats as $key=>$value ) {
// // 					if ( $this->has_child_chats( $child_chats[$key]['id'] ) != 0  ) {
// // 						$child_chats[$key]['child_chats'] = $this->child_chats($child_chats[$key]['id']);
// // 					}
// // 				}
// // 				
// // 				// 根据嵌套书目，循环多次
// // 
// // 					$child_chats =& $child_chats[$key]['child_chats'];
// // 
// // 					foreach ( $child_chats as $key=>$value ) {
// // 						if ( $this->has_child_chats( $child_chats[$key]['id'] ) != 0  ) {
// // 							$child_chats[$key]['child_chats'] = $this->child_chats($child_chats[$key]['id']);
// // 						}
// // 					}
// 
// 
// 				
// //			}
// 			
// 			return $chats;
// 			
// 		}
// 		/**
// 		 *	获得chat,  循环集合，层层递进
// 		 
// 		    // 首先获取第一层
// 		    // 循环第一层id ， 寻找parent_id = id的所有留言 则停止
// 		    // 获得留言，再循环，  如果没有，则停止
// 		 */
// 		function get_chats( $model, $model_id ) {
// 			$chats = $this->db->get_where('chat', array(
// 				'model' => $model, 
// 				'model_id' => $model_id,
// 				
// 				'parent_id' => 0,
// 			));
// 			$chats = $chats->result_array();
// 			// 重新调整顺序
// 			foreach ( $chats as $chat ) {
// 				$cs = $this->db->get_where('chat', array(
// 					'model'=>$model,
// 					'model'=>$model_id,
// 					'parent_id'=>$chat['id'],
// 				));
// 				if ( $cs->num_rows != 0 ) {
// 					foreach ( $cs->result_array() as $c ) {
// 						
// 					}
// 				}
// 			}
// 			
// 			
// 			return $chats;
// 		}
// 		function get_topics( $model, $model_id ) {
// 			$this->db->order_by('modified', 'desc');
// 			$query = $this->db->get_where('chat', array(
// 				'model' => $model,
// 				'model_id' => $model_id,
// 				'parent_id' => 0,
// 			));
// 		   $topics =  $query->result_array();
// 		   
// 		   // 组合，关联模型
// 		   foreach ( $topics as $key=>$value ) {
// 		       $topics[$key]['User'] = $this->_get_user( $topics[$key]['user_id'] );
// 		   }
// 		   
// 		   return $topics;
// 		}
// 		
// 		function get_comments( $chat_id ) {
// 			
// 		}
		
		
		
		/**
		 *	是否有子留言
		 */
// 		function has_child_chats( $chat_id ) {
// 			$child_chats = $this->db->get_where('chat', array(
// 				'parent_id'=> $chat_id,
// 			));
// 			return $child_chats->num_rows();
// 		}
// 		/**
// 		 *	检查一个chat是否函数子chat， 
// 		 
// 		 ×  即子chat的parent_id是这个chatid
// 		 */
// 		function child_chats($chat_id) {
// 			$child_chats = $this->db->get_where('chat', array(
// 				'parent_id'=> $chat_id,
// 			));
// 			$child_chats = $child_chats->result_array();
// 			
// 			return $child_chats;
// 		}
	}