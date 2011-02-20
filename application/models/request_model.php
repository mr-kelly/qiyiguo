<?php
	class Request_Model extends KK_Model {
		
		/**
		 *	创建群组的 request请求 (请求加入群组）
		 */
		function create_or_update_request_group( $group_id, $user_id, $message='') {
		
			// 重复,的，   则清楚
			$this->db->delete('request', array(
				'model' => 'group',
				'model_id' => $group_id,
				'user_id' => $user_id,
				//'status' => 'waiting',
			));
			
			$data = array(
				'model' => 'group',
				'model_id' => $group_id,
				'user_id' => $user_id,
				'message' => $message,
				'status' => 'waiting',
				'created' => date('Y-m-d H:i:s'),
			);
			$this->db->insert('request', $data);
			return $this->db->insert_id();
		}
		
		
		
		/**
		 *	获取指定用户身份是admin的所有小组的request_groups (requests)!
		 
		 	group_user ( user_role = admin) . group_id 
		 					==>    request_groups  . group_id
		 
		 */
		function get_request_admin_groups(  $user_id ) {
			// 获取user的所有身份为管理员的小组
			$admin_groups = $this->db->get_where('group_user', array(
				'user_id' => $user_id,
				'user_role' => 'admin',
			));
			
			if ( $admin_groups->num_rows() != 0 ) {
			
				// 根据管理的小组，逐个读取所管理的小组的请求~  
				$return_requests = array();
				foreach( $admin_groups->result_array() as $admin_group ) {
					$requests = $this->db->get_where('request', array(
						'model' => 'group',
						'model_id' => $admin_group['group_id'],
						'status' => 'waiting',
					));
					if ( $requests->num_rows() != 0 ) {
						foreach( $requests->result_array() as $request ) {
							array_push($return_requests, $request);
						}
						
					}
				}
				
				// 为每个request添加 User, Group
				foreach( $return_requests as $key=>$val ) {
					$return_requests[$key]['User'] = $this->_get_user( $request['user_id'] );
					$return_requests[$key]['Group'] = $this->_get_group( $request['model_id'] );
				}
				
				return $return_requests;
				
				
			} else {
				return false;
			}
			
			
		}
		
		
		/**
		 *	判断用户是否 管理员小组 有用户请求加入， 返回请求request数量
		 
		 
		 
		 	获得group_user,    user是admin的group_ids
		 	
		 	通过group_ids, 到request_group寻找 requests
		 	
		 	group_user ( user_role = admin) . group_id 
		 					==>    request_groups  . group_id
		 */
		function get_request_admin_groups_num( $user_id) {
			//当前user的admin小组
			$admin_groups = $this->db->get_where('group_user', array(
				'user_id' => $user_id,
				'user_role' => 'admin',
			));
			if ( $admin_groups->num_rows() != 0 ) {
				$admin_groups = $admin_groups->result_array();
				
				// 透过一组group_id, 获取所有的request_group, 要在waiting状态
				$this->db->from('request');
				foreach ( $admin_groups as $request_group ) {
					$this->db->where('model', 'group');
					$this->db->where('model_id =' . $request_group['group_id'] .' AND status="waiting"' ); // waiting状态必须
				}
				$request_groups_query = $this->db->get();
				
				return $request_groups_query->num_rows();   // 返回行数
				
			}
			// 没有请求
			return false;
			
		}
		
		/**
		 *	判断用户是否正在 "等待审核",   加入友群
		 */
		function is_request_group($group_id, $user_id) {
			$query = $this->db->get_where('request', array(
				'model' => 'group',
				'model_id' => $group_id,
				'user_id' => $user_id,
			));
			
			if ( $query->num_rows() == 0 ) {
				return false;
			} else {
				$r = $query->row_array();
				if ( $r['status'] == 'waiting' ) {
					return true;
				} else {
					return false;
				}
			}// 
// 			if ( $query->num_rows() > 0 ) {
// 				$r = $query->result_array();
// 				$r = $r[0];
// 				
// 				if ( $r['status'] == 'waiting') {
// 					return true;
// 				} else {
// 					return false;
// 				}
// 			}
// 			
// 			return false;
			
			
		}
		
		
		
		
		function update_request_group_by_id( $id, $data ) {
			$this->db->where('id', $id);
			$this->db->update('request', $data);
		}
	}
