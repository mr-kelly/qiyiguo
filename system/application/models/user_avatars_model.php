<?php
	class User_Avatars_Model extends KK_Model {
		function create_user_avatar($user_id, $avatar_file_name) {
			$data = array(
				'user_id' => $user_id,
				'avatar_file' => $avatar_file_name,
				'created' => date('Y-m-d H:i:s'),
			);
			// 不存在则创建
			if ( $this->db->get_where('user_avatars', array('user_id'=>$user_id, 'avatar_file'=>$avatar_file_name,) )->num_rows == 0 ) {
				$this->db->insert('user_avatars', $data);
				
				
				// 返回插入数据的ID
				return $this->db->insert_id();
			}
			
		}
		
		/**
		 *	获取用户当前头像 deprecated
		 */
		function get_user_avatar($user_id) {
			$avatar = $this->db->get_where('user_avatars', array(
				'user_id' => $user_id,
			))->result_array();
			$avatar = $avatar[0];
			
			// 根据avatar_file头像文件名，显示头像缩略图的文件名， 通常为常规头像文件后面加thumb ：   xxxx_thumb.jpg
			$avatar_thumb = explode(".", $avatar['avatar_file'] , 2);
			$avatar['avatar_thumb'] = $avatar_thumb[0]. '_thumb' . '.'.  $avatar_thumb[1];

			return $avatar;
		}
		
		/**
		 * 获取用户上传过的头像
		 */
		function get_user_avatars($user_id) {
			$avatars = $this->db->get_where('user_avatars', array(
				'user_id' => $user_id,
			));
			
			
			// Add avatar_thumb缩略图文件
			if ( $avatars->num_rows() != 0) {
				$avatars = $avatars->result_array();
				foreach ( $avatars as $k=>$v) {
					// 根据avatar_file头像文件名，显示头像缩略图的文件名， 通常为常规头像文件后面加thumb ：   xxxx_thumb.jpg
					$avatar_thumb = explode(".", $avatars[$k]['avatar_file'] , 2);
					$avatars[$k]['avatar_thumb'] = $avatar_thumb[0]. '_thumb' . '.'.  $avatar_thumb[1];
				}
				
				return $avatars;
				
				
			} else {
				return null;
			}
			
			
			

		}
		
		/**
		 *	判断头像，是否属于指定的用户,,  即user_id跟 avatar表中的user_id搭配
		 */
		function is_user_avatar($user_id, $avatar_id) {
			$avatar = $this->db->get_where('user_avatars', array(
				'id'=> $avatar_id,
			))->result_array();
			$avatar = $avatar[0]; // First Rowan
			
			return $avatar['user_id'] == $user_id;
		}
		
		
		

	}