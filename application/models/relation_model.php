<?php
	class Relation_Model extends KK_Model {
		function __construct() {
			parent::__construct();
		}

		
		function create_relation( $data = array(
											'from_id' => 0,
											'to_id' => 0,
											'model' => 'user',
											//'model_id' => 0,
											'relation' => '',
											) ) {
											
			/**
			 * 避免 from_id, to_id   相同、两者重复 
			 */
			if ( $data['from_id'] == $data['to_id'] ) { // 重复，失败
				return false;
			}
			
			// 避免完全重复
			$query = $this->db->get_where('relation', array(
				'from_id' => $data['from_id'],
				'to_id' => $data['to_id'],
				'model' => $data['model'],
				'relation' => $data['relation'],
			));
			if ( $query->num_rows() != 0 ) {
				return false;   // 已经存在了！
			}
			
			
			
			
			$this->db->insert('relation', $data + array(
				'created' => date('Y-m-d H:i:s'),
			));
			
			return $this->db->insert_id();
		}
		
		
		function del_relation ( $data ) {
			return $this->db->delete('relation', $data );
		}
		
		function get_relations( $data , $limit=10 ) {
			$query = $this->db->get_where('relation', $data, $limit );
			
			if ( $query->num_rows() == 0 ) {
				return false;
			} else {
			
				return $query->result_array();
			
			}
		}
		
		/**
		 *	获取关系的数量
		 */
		function get_relations_count( $data ) {
			$query = $this->db->get_where('relation', $data );
			
			return $query->num_rows();
		}
		
		
		/**
		 *	关联用户， 即“关注用户”,,  
		 
		 		关注后如果互相关注，添加朋友关系
		 */
		function create_user_relation( $from_user_id, $to_user_id, $relation = 'friend' ) {
			$relation_id =  $this->create_relation( array(
				'from_id' => $from_user_id,
				'to_id' => $to_user_id, 
				'model' => 'user',
				//'model_id' => 0,  
				'relation' => $relation, // 关系 - lover? dearfriend?
			) );
			if ( $relation_id ) { // 成功关注了对方，判断是否对方也关注自己，是的话添加朋友mutual
				$relation = $this->get_user_relation( $from_user_id, $to_user_id );
				if ( $relation == 'mutual' ) {
					$this->create_friends( $from_user_id, $to_user_id );
				}
			}
			
			return $relation_id;
		}
		
		/**
		 *	删除关联用户, 
		 		假如删除时用户互相关注，是朋友，删除朋友关系
		 */
		function del_user_relation( $from_user_id, $to_user_id, $relation='') {
			// 先判断是否删除用户的“朋友关系”
			if ( $this->get_user_relation( $from_user_id, $to_user_id ) == 'mutual' ) {
				$this->del_friends($from_user_id, $to_user_id);
			}
			
			
			
			return $this->del_relation(array(
				'from_id' => $from_user_id,
				'to_id' => $to_user_id,
				'model' => 'user',
				'relation' => 'friend',
			));
			
			
		}
		/**
		 *	获取用户的关系 
		 		1 - follow     from用户关注to用户
		 		  - fans         to用户关注from用户
		 		2 - mutual  	 互相关注, 即朋友
		 		0 - none		 没关系
		 */
		function get_user_relation( $from_user_id, $to_user_id ) {
			// 同一个用户查询关系？  返回失败！
			if ( $from_user_id == $to_user_id ) {
				return false;
			}
			
			$follow = false;
			$fans = false;
			
			$follow_query = $this->db->get_where('relation', array(
				'from_id' => $from_user_id,
				'to_id' => $to_user_id,
				'model' => 'user',
				'relation' => 'friend',
			));
			if ( $follow_query->num_rows() == 1 ) {
				$follow = true; // follow关系确定
			}
			//echo( $follow_query->num_rows());
			
			$fans_query = $this->db->get_where('relation', array(
				'from_id' => $to_user_id,
				'to_id' => $from_user_id,
				'model' => 'user',
				'relation' => 'friend',
			));
			if ( $fans_query->num_rows() == 1 ) {
				$fans = true; // fans关系确定
			}
			
			// 判断是否mutual
			if ( $follow == true && $fans == true ) {
				return 'mutual';
			} else if ( $follow == true && $fans == false ) {
				return 'follow';
			} else if ( $follow == false && $fans == true ) {
				return 'fans';
			} else if ( $follow == false && $fans == false ) {
				return 'none';
			}
		}
		
		
		/**
		 *	获得用户的拥趸数目
		 */

		
		
		
		
		/**
		 *		!!!!!! Relation_Mutual !!!!!!
		 *
		 *	Relation Mutual表用于存在双方关系的～
		 			在relation中，双方关注后，存放到relation_mutual
		 			
		    例如：  互相关注，他们成为朋友了。 
		    
		    			他们的朋友关系，存放到relation_mutual
		    			
		    			因此在relation_mutual中，不应该存在
		    				from   2    to 10 
		    				from   10   to 2
		    				这样的代表2次朋友关系的数据
		 */
		function create_relation_mutual( $data ) {
			// 先判断是否存在
			if ( $data['model_id'] == $data['mutual_id'] ) {
				return false;
			}
			
			$query_1 = $this->db->get_where('relation_mutual', array(
				'model_id' => $data['model_id'],
				'mutual_id' => $data['mutual_id'],
				'model' => $data['model'],
			));
			if ( $query_1->num_rows() != 0 ) return false;
			
			// 因为此表用于确立关系，所以双向不能重复( model_id, mutual_id 不能重复 )
			$query_2 = $this->db->get_where('relation_mutual', array(
				'model_id' => $data['mutual_id'],
				'mutual_id' => $data['model_id'],
				'model' => $data['model'],
			));
			if ( $query_2->num_rows() != 0 ) return false;
			
			
			
			
			
			$this->db->insert('relation_mutual', $data + array(
				'created' => 'Y-m-d H:i:s',
			));
			return $this->db->insert_id();
		}
		
		/**
		 *	获得mutual关系   两边所得相加
		 */
		function get_relation_mutual_query( $data ) {
		
		}
		
		/**
		 *	删除mutual删除， 需要双边删除
		 */
		function del_relation_mutual( $data ) {
			// 确保 mutual关系清楚， 双边删除！
			$this->db->delete('relation_mutual', array(
				'model_id' => $data['model_id'],
				'mutual_id' => $data['mutual_id'],
				'model' => $data['model'],
			));
			
			$this->db->delete('relation_mutual', array(
				'model_id' => $data['mutual_id'],
				'mutual_id' => $data['model_id'],
				'model' => $data['model'],
			));
		}
		
		
		/** 
	     *	添加朋友 (mutual)
	     */
		function create_friends( $from_user_id, $to_user_id ) {
			
			return $this->create_relation_mutual( array(
				'model_id' => $from_user_id,
				'mutual_id' => $to_user_id,
				'model' => 'user',
				'relation' => 'friend',
			) );
		}
		

		
		/**
		 *	解除朋友关系
		 */
		function del_friends( $from_user_id, $to_user_id ) {
			$this->del_relation_mutual( array(
				'model_id'=> $from_user_id,
				'mutual_id' => $to_user_id,
				'model'=> 'user',
				'relation' => 'friend',
			));
		}
		
		function get_friends( $user_id ) {
			$query_1 = $this->db->get_where('relation_mutual',array(
				'model_id' => $user_id,
				'model' => 'user',
				'relation' => 'friend',
			));
			$query_2 = $this->db->get_where('relation_mutual',array(
				'mutual_id' => $user_id,
				'model' => 'user',
				'relation' => 'friend',
			));
			
			$return = array();
			
			$result_1 = $query_1->result_array();
			foreach( $result_1 as $u ) {
				array_push( $return, $this->_get_user( $u['mutual_id'] ) );
			}
			
			$result_2 = $query_2->result_array();
			foreach ( $result_2 as $u ) {
				array_push( $return, $this->_get_user( $u['model_id'] ) );
			}
			
			return $return;
		}
		
		/**
		 *	获得朋友数量统计
		 */
		function get_friends_count( $user_id ) {
			$query_1 = $this->db->get_where('relation_mutual',array(
				'model_id' => $user_id,
				'model' => 'user',
				'relation' => 'friend',
			));
			$query_2 = $this->db->get_where('relation_mutual',array(
				'mutual_id' => $user_id,
				'model' => 'user',
				'relation' => 'friend',
			));
			
			return ($query_1->num_rows() + $query_2->num_rows());
		}
		
		/**
		 *	获取用户的拥趸
		 */
		function get_fans( $user_id ) {
			$query = $this->db->get_where('relation', array(
				'to_id' => $user_id,
				'model' => 'user',
				'relation' => 'friend',
			));
			$return = array();
			foreach( $query->result_array() as $fan ) {
				array_push( $return, $this->_get_user( $fan['from_id'] )); // 获取 谁关注你~获取来源，所以用from
			}
			
			return $return;
		}
		
		/**
		 *	获取用户拥趸数目
		 */
		function get_fans_count( $user_id ) {
			$query = $this->db->get_where('relation', array(
				'to_id' => $user_id,
				'model' => 'user',
				'relation' => 'friend',
			));
			
			return $query->num_rows();
		}
		
		
		/**
		 *	获得两个用户之间的共同朋友~
		 */
		function get_users_common_friends( $user_1_id, $user_2_id ) {
		
			//先分别获得两人的好友列表... 第一人
			$user_1_query_1 = $this->db->get_where('relation_mutual',array(
				'model_id' => $user_1_id,
				'model' => 'user',
				'relation' => 'friend',
			))->result_array();
			
			// 将朋友的ID添加到一个数组里~ 组成一个朋友ID列表
			$user_1_friends_id = array();  // user_1的朋友列表..
			
			foreach( $user_1_query_1 as $u_1_q_1 ) {
				$user_1_friends_id[] = $u_1_q_1['mutual_id'];
			}
			
			$user_1_query_2 = $this->db->get_where('relation_mutual',array(
				'mutual_id' => $user_1_id,
				'model' => 'user',
				'relation' => 'friend',
			))->result_array();
			
			foreach( $user_1_query_2 as $u_1_q_2 ) {
				$user_1_friends_id[] = $u_1_q_2['model_id'];
			}
			
			// User_1 结束，获得数组 $user_1_friends[] 为 user 1的朋友ID列表
			
			
			// 获取第二人的好友列表.... 第二人...
			$user_2_query_1 = $this->db->get_where('relation_mutual', array(
				'model_id' => $user_2_id,
				'model' => 'user',
				'relation' => 'friend',
			))->result_array();
			
			$user_2_query_2 = $this->db->get_where('relation_mutual',array(
				'mutual_id' => $user_2_id,
				'model' => 'user',
				'relation' => 'friend',
			))->result_array();
			
			$user_2_friends_id = array(); // user_2的朋友列表
			foreach( $user_2_query_1 as $u_2_q_1 ) {
				$user_2_friends_id[] = $u_2_q_1['mutual_id'];
			}
			foreach( $user_2_query_2 as $u_2_q_2 ) {
				$user_2_friends_id[] = $u_2_q_2['model_id'];
			}
			
			$common_friends = array();
			foreach ( $user_1_friends_id as $u_1_id ) {
				foreach( $user_2_friends_id as $u_2_id ) {
					if ( $u_1_id == $u_2_id ) {
						// 哦！ 发现一个共同好友！
						$common_friends[] = $this->_get_user($u_1_id);
					}
				}
			}
			
			
			return $common_friends;
			
		}
		
		
		
				/**
		 *	创建恋爱关系 love relation~  如果双向恋爱关系的时候再给星星吧
		 */
		function create_lover( $from_user_id, $to_user_id ) {
			
			// 创建之前， 先删除用户的其他恋爱关系
			// 因为恋爱关系只可以一个， 别花心嘛
			$this->del_lover( $from_user_id );
// 			$this->del_relation( array(
// 				'from_id' => $from_user_id,
// 				//'to_id' => $to_user_id,
// 				'model' => 'user',
// 				'relation' => 'lover',
// 			));
			

			return $this->create_relation( array(
				'from_id' => $from_user_id,
				'to_id' => $to_user_id,
				'model' => 'user',
				'relation' => 'lover',  //Lover
			));
			
// array(
// 											'from_id' => 0,
// 											'to_id' => 0,
// 											'model' => 'user',
// 											//'model_id' => 0,
// 											'relation' => '',
// 											) ) {
		}
		
		function del_lover( $from_user_id ) {
			return $this->del_relation( array(
				'from_id' => $from_user_id,
				'model' => 'user',
				'relation' => 'lover',
			));
		}
		
		/**
		 *	获得恋爱关系
		 */
		function get_lover( $user_id ) {
			
			$query = $this->db->get_where('relation', array(
				'from_id' => $user_id,
				'model' => 'user',
				'relation' => 'lover',
			));
			
			// 用户to_id用户
			if ( $query->num_rows() == 0 ) {
				return false;
			} else {
				$r = $query->row_array();
			}
			
			return $this->_get_user( $r['to_id'] );
			
			
		}
		
		
		
		
		
		
		/**
		 *	创建关联群组 、  （群组关系）~  单向关系~~~  
		 *
		 *
		 */
		function create_group_relation( $from_group_id, $to_group_id ) {
			return $this->create_relation( array(
				'model' => 'group',
				'relation' => 'related',
				
				'from_id' => $from_group_id,
				'to_id' => $to_group_id,
				
			));
			
			
		}
		
		/**
		 *	获取指定群组关联的群组s
		 */
		function get_relation_groups( $group_id, $limit=9 ) {
			$relations = $this->get_relations( array(
				'from_id' => $group_id,
				'model' => 'group',
				'relation' => 'related',
			), $limit);
			
			if ( !empty( $relations ) ) {
				$groups = array();
				foreach ( $relations as $relation ) {
					$groups[] = $this->_get_group( $relation['to_id'] );
				}
				
				return $groups;
			} else {
				// 如果没有群组关系，返回false
				return false;
			}
		}
		
		/**
		 *	获取指定群组的关联群组数量~~
		 */
		function get_relation_groups_count( $group_id ) {
			return $this->get_relations_count( array(
				'from_id' => $group_id,
				'model' => 'group',
				'relation' => 'related',
			));
			
			
		}
	}