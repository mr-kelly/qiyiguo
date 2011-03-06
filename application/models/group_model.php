<?php
	class Group_Model extends KK_Model {
		function __construct() {
			parent::__construct();
			
			$this->load->model('user_profiles_model');
			$this->load->model('request_model');
		}
		
		/**
		 *	创建一个友群
		 *	 $cat_id 对应的group_category_id
		 */
// 		function create_group($name, $cat_id=0, $privacy='public', $verify='request', $owner_id=0, $slug='') {
// 			
// 			
// 			$ci =& get_instance();
// 			$ci->load->library('Guo_id');
// 			
// 			$data = array(
// 				'id' => $ci->guo_id->generate_group_id(), // 随机生成群组的果ID
// 			
// 				'name' => $name,
// 				'category_id' => $cat_id,
// 				'privacy' => $privacy,
// 				'owner_id' => $owner_id,  // 创始人
// 				'slug' => $slug,
// 				'verify' => $verify,    // 需要经过管理员验证，提交请求通过
// 				'created' => date('Y-m-d H:i:s'),
// 			);
// 			$this->db->insert('group', $data);
// 			
// 			$group_id =  $this->db->insert_id();
// 			
// 			
// 			// 将owner创始人加入群组，并设为管理员
// 			$data = array(
// 				'group_id' => $this->db->insert_id(),
// 				'user_id' => $owner_id,
// 				'user_role' => 'admin',
// 				'created' => date('Y-m-d H:i:s'),
// 			);
// 			$this->db->insert('group_user',$data);
// 			
// 			return $group_id;
// 		}
		
		function create_group( $data ) {
			$ci =& get_instance();
			$ci->load->library('Guo_id');
			
			$this->db->insert('group', $data + array(
				'id' => $ci->guo_id->generate_group_id(),
				'created' => date('Y-m-d H:i:s'),
			));
			
			$group_id = $this->db->insert_id(); // 获得果群ID
			
			$owner_id = $data['owner_id'];
			
			// 将owner创始人加入群组，并设为管理员
			// 如果owner_id = 0?那么。 不添加创始人！
			if ( $owner_id != 0 ) {
				$this->create_group_user( $group_id, $owner_id,'', 'admin');
			}
			return $group_id;
			
		}
		
		
		/**
		 *	更新群组的信息
		 */
		function update_group( $group_id, $data ) {
		
			$this->db->where('id', $group_id);
			return $this->db->update('group', $data );
			
		}
		
		/**
		 *   新设置 友群成员，
		 *   制定友群，令用户成为成员 
		 
		 		××× 如果群组原来是没成员的，第一个成员成为管理员
		 		
		 *   重复，出错，返回false
		 */
		function create_group_user($group_id, $user_id, $group_nickname = '', $user_role='member') {
			// 先判断是否重复，用户是否已经存在该群组
			$query = $this->db->get_where('group_user',array(
				'group_id' => $group_id,
				'user_id' => $user_id,
				//'user_role' => $user_role,
			));
			if ( $query->num_rows() != 0) {
				// 证明已经重复了
				return false;
			}
			
			// 判断用户是否是第一个加入群组的（原来群组为空）
			// 第一个加入成为管理者
			if ( $this->get_group_users_count( $group_id ) == 0 ) {
				// 群组还没有人？强制成为管理员！
				$user_role = 'admin';
			}
			
			
			
			$data = array(
				'group_id' => $group_id,
				'user_id' => $user_id,
				'group_nickname' => $group_nickname,
				'user_role' => $user_role,
				'created' => date('Y-m-d H:i:s'),
			);
			return $this->db->insert('group_user', $data);
		}
		
		/**
		 *		更改群组中用户的数据资料
		 */
		function update_group_user( $group_id, $user_id, $data ) {
			$this->db->where('group_id', $group_id);
			$this->db->where('user_id', $user_id);
			
			return $this->db->update('group_user', $data);
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
			if ( $query->num_rows() == 0 ) {
				return false;
			} else {
				return $query->row_array();
			}
		}
		
		
		/**
		 *	通过传入群组的slug,获得对应的ID
		 */
		function get_group_id_by_slug( $slug ) {
			$group = $this->db->get_where('group', array(
				'slug' => $slug,
			));
			
			if ( $group->num_rows() == 0 ) {
				return false;
			}
			
			$group = $group->row_array();
			return $group['id'];
		}
		
		function get_topic_by_id( $topic_id) {
			$topic = $this->db->get_where('group_topic', array(
				'id'=>$topic_id,
			));
			
			if ( $topic->num_rows() == 0 ) {
				return false;
			}
			
			return $topic->row_array();
		}
		
		function get_groups( $data=array(), $limit=10, $start=0, $random=false ) {
			
			if ( $random ) $this->db->order_by( 'id', 'random' );
			
			$query = $this->db->get_where('group', $data, $limit);
			
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			return $query->result_array();
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
		function get_group_categories( $data=array() ) {
		
			$query = $this->db->get_where('group_category', $data);
			
			return $query->result_array();
		}
		
		/**
		 *	获取指定用户所加入的群组groups具体数据
		 */
		function get_user_groups($user_id, $limit=6, $start=0, $random=false , $option=null) {
			
// 			$query = $this->db->get_where('group_user', array(
// 				'user_id' => $user_id,
// 				
// 			));
// 			$user_groups = $query->result_array();
			
			$user_groups_sql = sprintf('SELECT * FROM kk_group_user WHERE user_id = %d', $user_id);
			
			if ( isset( $option['role'] ) ) {
				// 是否查询指定用户角色.... admin? member?
				$user_groups_sql .= sprintf( ' AND user_role = "%s"', $option['role'] );
			}
			
			
			$user_groups = $this->db->query( $user_groups_sql )->result_array();
			
			if ( empty( $user_groups ) ) { // 根本没有加入任何群组。。返回0
				return false;
			}
			// 上面获得的是用户所加入的友群的ID号，下面来获得友群group 具体数据
// 			$return_groups = array();
// 			foreach( $user_groups as $user_group ) {
// 									// 数据库多查询...
// 				$return_groups[] = $this->_get_group( $user_group['group_id'] ); 
// 			}
// 			
// 			return $return_groups;
			
			//$this->db->from('group');		// 单查询
			
			
			$groups_sql =  'SELECT * FROM kk_group WHERE ';
			foreach( $user_groups as $key=>$ug ) {
				if ( $key == 0 ) {
					// 首项不加or
					$groups_sql .= sprintf( ' id = %d ', $ug['group_id'] );
				} else {
					$groups_sql .= sprintf( ' OR id = %d ', $ug['group_id'] );
				}
			}
			if ( $random ) $groups_sql .= ' ORDER BY rand()';
			$groups_sql .= sprintf( ' LIMIT %d,%d ', $start, $limit );
			
			
			 
			return $this->db->query( $groups_sql )->result_array();
			
// 			if ( $random ) $this->db->order_by('id', 'random');
// 			foreach ( $user_groups as $ug ) {
// 				$this->db->or_where('id' , $ug['group_id']);
// 			}
// 			return $this->db->get('group', $limit, $start )->result_array();
// 			
		}
		
		
		/**
		 *	获得用户加入的群组数目
		 */
		function get_user_groups_count( $user_id ) {
			$query = $this->db->get_where('group_user', array(
				'user_id' => $user_id,
			));
			
			return $query->num_rows();
		}
		/**
		 *	获取用户为管理员的群组~
		 */
		function get_user_admin_groups( $user_id, $limit=6, $start=0 ) {
			$admin_group_user = $this->db->get_where('group_user', array(
				'user_id' => $user_id,
				'user_role' => 'admin', //管理员~
			), $limit, $start);
			
			if ( $admin_group_user->num_rows() == 0 ) { //没的话..
				return false;
			}
			
			
			foreach ( $admin_group_user->result_array() as $group_user ) {
				$this->db->or_where('id', $group_user['group_id'] );
			}
			return $this->db->get('group', $limit, $start )->result_array();
			
		}
		
		/**
		 *	获取用户管理的群组的数量
		 */
		function get_user_admin_groups_count( $user_id ) {
			$admin_groups = $this->db->get_where('group_user', array(
				'user_id' => $user_id,
				'user_role' => 'admin',
			));
			
			return $admin_groups->num_rows();
		}
		
		
		/**
		 *	获取两个用户的共同群组~  共群
		 */
		function get_users_common_groups( $user_1_id , $user_2_id , $limit=6, $start=0, $random=false) {
		
			if ( $user_1_id == $user_2_id ) return false; // 对比同一个人，返回false
			
			// 获得用户一群.. 对比用户二群...
			$user_1_groups = $this->db->get_where('group_user', array(
				'user_id' => $user_1_id,
			))->result_array();
			
			$user_2_groups = $this->db->get_where('group_user', array(
				'user_id' => $user_2_id,
			))->result_array();
			
			// 他们当中有一个为空， 没有加入任何群组，返回false
			if ( empty( $user_1_groups ) || empty( $user_2_groups ) ) {
				return false;
			}
			
//			print_r ( $user_1_groups );
			
			$common_groups_id = array();
			foreach ( $user_1_groups as $user_1_group ) {
				foreach( $user_2_groups as $user_2_group ) {
					
					// 判断是否ID共群~ 如果ID重复、相同，往commont_groups添加ID...
					if ( $user_1_group['group_id'] == $user_2_group['group_id'] ) {
						$common_groups_id[] = $user_1_group['group_id'];
					}
					
				}
			}
			
			// 将共同群组的详细资料写入.. // 多查询
// 			$common_groups = array();
// 			foreach( $common_groups_id as $common_group_id ) {
// 				$common_groups[] = $this->_get_group( $common_group_id );
// 			}
// 
// 			return $common_groups; 
			
			// 将共同群组的详细资料写入.. // 单查询
			//$this->db->from('group');
			if ( $random ) $this->db->order_by('id', 'random');
			foreach( $common_groups_id as $common_group_id ) {
				$this->db->or_where( 'id', $common_group_id );
			}
			
			return $this->db->get('group', $limit, $start )->result_array();
			
			
		}
		
		/**
		 *	获取一些新鲜果群... ( 新建的群，并且用户数大于10 ）？
		 */
		function get_fresh_groups( $user_num = 10 ) {
			$sql = sprintf( 'SELECT * FROM kk_group WHERE 
								( SELECT count( * ) FROM kk_group_user 
									WHERE group_id = kk_group.id ) > %d
									ORDER BY created DESC', 
									$user_num);
			
			$query = $this->db->query( $sql );
			
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			return $query->result_array();
		}
		

		
		
		/** 
		 *	获指定ID 友群的所有用户, 返回profile组
		 */
		function get_group_users( $group_id, $limit=10, $start=0 ) {
			$query = $this->db->get_where('group_user', array(
				'group_id' => $group_id,
			), $limit, $start );
			
			if ( $query->num_rows() != 0 ) {
				
				$group_users = $query->result();
				
				$users_arr = array(); // set null array
				
				// 通过遍历用户id，获得用户资料，组成新数组
				foreach ( $group_users as $group_user ) {
					$users_arr[] = $this->_get_user( $group_user->user_id );
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
				return false;
			}
		}
		
		
		
		/**
		 *	获取指定群组目前有多少成员~
		 */
		function get_group_users_count( $group_id ) {
			$query = $this->db->get_where('group_user', array(
				'group_id' => $group_id,
			));
			return $query->num_rows();
		}
		
		/**
		 *	获取的群组管理员的数量，返回数字
		 */
		function get_group_admins_count( $group_id ) {
			$query = $this->db->get_where('group_user', array(
				'group_id' => $group_id,
				'user_role' => 'admin',
			));
			
			return $query->num_rows();
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
		 *	设置某用户成 某群组的 管理员
		 */
		function set_group_admin( $group_id, $user_id ) {
			// 先判断 该用户是不是已经是群组成员~~  只能提升当前群组成员的人
			$query = $this->db->get_where('group_user', array(
				'group_id' => $group_id, 
				'user_id' => $user_id,
			));
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			$group_user = $query->row_array();
			
			// 不是管理员，设置成管理员
			if ( $group_user['user_role'] != 'admin' ) {
				$this->db->where(array(
					'group_id' => $group_id,
					'user_id' => $user_id,
				));
				return $this->db->update('group_user', array(
					'user_role' => 'admin',
				));
			} else {
				// 是管理员，失败
				return false;
			}
			
		}
		
		function search_groups( $data ) {
			$this->db->or_like( $data );
			$query = $this->db->get('group');
			
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			return $query->result_array();
			
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
		 *	解除用户指定群组成员关系
		 */
		function del_group_user($group_id, $user_id) {
		
			return $this->db->delete( 'group_user', array(
				'group_id' => $group_id,
				'user_id' => $user_id,
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
		 *	 提升某群组的查看量
		 */
		function up_group_page_view( $group_id ) {
			$group = $this->get_group_by_id( $group_id );
			
			$this->db->where('id', $group['id'] );
			return $this->db->update('group', array(
				'page_view' => $group['page_view'] + 1,
			));
		}
		

		
	}
