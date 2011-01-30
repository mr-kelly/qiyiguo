<?php
	class Group_Model extends KK_Model {
		function __construct() {
			parent::__construct();
			$this->ci =& get_instance();
			$this->ci->load->model('user_profiles_model');
			$this->ci->load->model('request_model');
		}
		
		/**
		 *	创建一个友群
		 *	 $cat_id 对应的group_category_id
		 */
		function create_group($name, $cat_id=0, $privacy='public', $verify='request', $owner_id=0, $slug='') {
		
			
			$ci =& get_instance();
			$ci->load->library('Guo_id');
			
			$data = array(
				'id' => $ci->guo_id->generate_group_id(), // 随机生成群组的果ID
			
				'name' => $name,
				'category_id' => $cat_id,
				'privacy' => $privacy,
				'owner_id' => $owner_id,  // 创始人
				'slug' => $slug,
				'verify' => $verify,    // 需要经过管理员验证，提交请求通过
				'created' => date('Y-m-d H:i:s'),
			);
			$this->db->insert('group', $data);
			
			$group_id =  $this->db->insert_id();
			// 将owner创始人加入群组，并设为管理员
			$data = array(
				'group_id' => $this->db->insert_id(),
				'user_id' => $owner_id,
				'user_role' => 'admin',
				'created' => date('Y-m-d H:i:s'),
			);
			$this->db->insert('group_user',$data);
			
			return $group_id;
		}
		
		/**
		 *   新设置 友群成员，
		 *   制定友群，令用户成为成员
		 *   重复，出错，返回false
		 */
		function create_group_user($group_id, $user_id, $group_nickname = '') {
			// 先判断是否重复
			$query = $this->db->get_where('group_user',array(
				'group_id' => $group_id,
				'user_id' => $user_id,
				//'user_role' => 'member',
			));
			if ( $query->num_rows() != 0) {
				// 证明已经重复了
				return false;
			}	
			
			
			$data = array(
				'group_id' => $group_id,
				'user_id' => $user_id,
				'group_nickname' => $group_nickname,
				'user_role' => 'member',
				'created' => date('Y-m-d H:i:s'),
			);
			return $this->db->insert('group_user', $data);
		}
		
		
		/**
		 *	类论坛主题，发布小组主题内容
		 */
		function create_group_topic($group_id, $user_id, $title, $content ) {
			$data = array(
				'title' => $title,
				'content' => $content,
				'group_id' => $group_id,
				'user_id' => $user_id,
				'created' => date('Y-m-d H:i:s'),
			);
			
			return $this->db->insert('group_topic', $data);
		}
		/**
		 *	获取指定Group ,   
		 *  
		 *  $get_group
		 */ 
		function get_group_by_id( $group_id ) {
			$query = $this->db->get_where('group', array(
				'id' => $group_id
			));
			$arr =  $query->result_array();
			return $arr[0];
		}
		
		
		function get_topic_by_id( $topic_id) {
			$topic = $this->db->get_where('group_topic', array(
				'id'=>$topic_id,
			))->result_array();
			
			return $topic[0];
		}
		function get_groups( $limit=10 ) {
			$query = $this->db->get_where('group',array(
				'privacy'=>'public',  // 只获取公开的友群组
			),$limit);
			
			return $query->result();
		}
		
		
		
		function get_group_topics( $group_id, $limit=10 ) {
			$this->db->order_by('created DESC');
			$query = $this->db->get_where('group_topic', array(
				'group_id' => $group_id,
			),$limit);
			
			$topics = $query->result_array();
			foreach ( $topics as $k=>$v ) {
				$topics[$k]['User'] = $this->_get_user( $topics[$k]['user_id'] );
				
			}
			
			return $topics;
		}
		/**
		 *	获得所有 友群的 分类~
		 */
		function get_group_categories() {
		
			$query = $this->db->get('group_category');
			
			return $query->result();
		}
		
		/**
		 *	获取指定用户所加入的群组groups具体数据
		 */
		function get_user_groups($user_id) {
			$query = $this->db->get_where('group_user', array(
				'user_id' => $user_id,
			));
			$user_groups = $query->result();
			
			// 上面获得的是用户所加入的友群的ID号，下面来获得友群group 具体数据
			$this->db->from('group');
			foreach ( $user_groups as $ug ) {
				$this->db->or_where('id =' . $ug->group_id);
			}
			return $this->db->get()->result();
			
		}
		
		/** 
		 *	获指定ID 友群的所有用户, 返回profile组
		 */
		function get_group_users($group_id) {
			$query = $this->db->get_where('group_user', array(
				'group_id' => $group_id,
			));
			if ( $query->num_rows() != 0 ) {
				
				$group_users = $query->result();
				
				$users_arr = array(); // set null array
				
				// 通过遍历用户id，获得用户资料，组成新数组
				foreach ( $group_users as $group_user ) {
					array_push( $users_arr, $this->_get_user( $group_user->user_id ) );
				}
				
				return $users_arr;
				
				
				
// 				$group_users = $query->result();
// 				
// 				// 获得所有的用户ID号，获取它们users表所有的数据
// 				$this->db->from('users');
// 				foreach ( $group_users as $u ) {
// 					$this->db->or_where('id =' . $u->user_id);
// 				}
// 				
// 				$users = $this->db->get();
// 				
// 				if ( $users->num_rows() != 0 ) {
// 				
// 					$users = $users->result();
// 					
// 					// 通过user_id 获取 它们的user_profile, 合并追加数组
// 					$arr= array();
// 					foreach ( $users as $u ) {
// 						array_push( $arr, $this->ci->user_profiles_model->get_profile($u->id) );
// 					}
// 					return $arr;
// 				}
				
				
			} else {
				// 该组没有成员！
				return array();
			}
		}
		
		/**
		 *	获取小组所有已绑定新浪微博的成员的微博, 经过时间排序
		 
		 	返回   t_sina_stream array
		 */	
		function get_group_users_t_sina( $group_id ) {
			$this->load->library('t_sina');
			
			$group_users = $this->group_model->get_group_users( $group_id );
			
			// 信息流
			$stream = array();
			
			foreach ( $group_users as $group_user ) {
			
				$weibo = $this->t_sina->getWeibo( $group_user['id'] );
				
				// 微博帐号密码通过验证了。那么返回weibo处理客户端
				if ( $weibo ) {
					
					$stream = array_merge($stream, $weibo->self_timeline() );
					
				}
			
			}
			
			return $stream;
			
			
		}
		
		/**
		 *	判断友群是否已设置logo   (is_logo = 1)
		 */
		function is_group_logo($group_id) {
			$group = $this->db->get_where('group', array(
				'id' => $group_id,
			));
			
			if ( $group->num_rows != 0 ) {
				$group = $group->result_array();
				return $group[0]['is_logo'];
			}
			
		}
		/**
		 *	设置group 的is_logo 为1，  已设置logo，则到目录里找logo图片文件
		 */
		function set_group_logo($group_id) {
			$this->db->where('id', $group_id);
			$this->db->update('group', array(
				'is_logo' => 1,
			));
			
		}
		
		/**
		 *	判断友群是否私有
		 */
		function is_group_private( $group_id ) {
			$group = $this->_get_group( $group_id );
			return ( $group['privacy'] == 'private' );
		}
		/**
		 *	判断用户是否关联, 即用户是否加入该友群
		 */
		function is_group_user($group_id, $user_id) {
			$query = $this->db->get_where('group_user', array(
				'group_id' => $group_id, 
				'user_id' => $user_id,
			));
			if ( $query->num_rows() != 0 ) {
				return true;
			} else {
				// 没有组群关系
				return false;
			}
		}
		
		/**
		 *	判断用户是否为友群的管理员
		 *   返回boolean
		 */
		function is_group_admin($group_id, $user_id) {
			$query = $this->db->get_where('group_user', array(
				'group_id' => $group_id,
				'user_id' => $user_id,
			));
			if ( $query->num_rows() != 0 ) {
				$group_user = $query->result_array();
				$group_user = $group_user[0];  // 取数组数据第一条
				return $group_user['user_role'] == 'admin';
			} else {
				// 不存在记录，则用户没加入这个友群
				return false;
			}

		}
		
		
		
		
		
		
		/**
		 *	解除用户指定群组成员关系
		 */
		function del_group_user($group_id, $user_id) {
		
			return $this->db->delete( 'group_user', array(
				'group_id' => $group_id,
				'user_id' => $user_id,
			));
			
		}
		

		
	}