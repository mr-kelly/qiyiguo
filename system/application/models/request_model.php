<?php
	class Request_Model extends KK_Model {
		
		/**
		 *	创建群组的 request请求 (请求加入群组）
		 */
		function create_request_group( $group_id, $user_id, $message='') {
		
			// 重复,等待的，   则删除，覆盖
			$this->db->delete('request_group', array(
				'group_id' => $group_id,
				'user_id' => $user_id,
				'status' => 'waiting',
			));
			$data = array(
				'group_id' => $group_id,
				'user_id' => $user_id,
				'message' => $message,
				'status' => 'waiting',
				'created' => date('Y-m-d H:i:s'),
			);
			return $this->db->insert('request_group', $data);
		}
		
		
		
		/**
		 *	获取当前登录user身份是admin的所有小组的request_groups!
		 
		 	group_user ( user_role = admin) . group_id 
		 					==>    request_groups  . group_id
		 
		 */
		function get_request_admin_groups(  $user_id ) {
			//当前user的admin小组
			$admin_groups = $this->db->get_where('group_user', array(
				'user_id' => $user_id,
				'user_role' => 'admin',
			));
			if ( $admin_groups->num_rows() != 0 ) {
				$admin_groups = $admin_groups->result_array();
				
				// 透过一组group_id, 获取所有的request_group, 要在waiting状态
				$this->db->from('request_group');
				foreach ( $admin_groups as $request_group ) {
					$this->db->or_where('group_id =' . $request_group['group_id'] .' AND status="waiting"' ); // waiting状态必须
				}
				$request_groups = $this->db->get()->result_array();
				
				// 同时组合group, user,  使之成为关联模型
				foreach ( $request_groups as $key=>$val ) {
					$request_groups[$key]['Group'] = $this->_get_group( $request_groups[$key]['group_id']);
					$request_groups[$key]['User'] = $this->_get_user( $request_groups[$key]['user_id']);
				}
				
				return $request_groups;
			}
			return false;
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
				$this->db->from('request_group');
				foreach ( $admin_groups as $request_group ) {
					$this->db->or_where('group_id =' . $request_group['group_id'] .' AND status="waiting"' ); // waiting状态必须
				}
				$request_groups_query = $this->db->get();
				
				return $request_groups_query->num_rows();   // 返回行数
				
			}
			// 没有请求
			return false;
			
		}
		
		/**
		 *	判断用户是否正在等待审核，加入友群
		 */
		function is_request_group($group_id, $user_id) {
			$query = $this->db->get_where('request_group', array(
				'group_id' => $group_id,
				'user_id' => $user_id,
			));
			if ( $query->num_rows() > 0 ) {
				$r = $query->result_array();
				$r = $r[0];
				
				if ( $r['status'] == 'waiting') {
					return true;
				} else {
					return false;
				}
			}
			
			return false;
			
			
		}
		
		
		
		
		function update_request_group_by_id( $id, $data ) {
			$this->db->where('id', $id);
			$this->db->update('request_group', $data);
		}
	}
