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
		 *	获取指定的头像数据库条目
		 */
		function get_avatar_by_id( $avatar_id ) {
			$query = $this->db->get_where('user_avatars', array(
				'id' => $avatar_id,
			));
			$avatar = $query->row_array();
			
			
			return $avatar;
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
		
		
		
		/**
		 *	删除头像...
		 */
		function delete_user_avatar( $avatar_id ) {
			if ( !$avatar = $this->get_avatar_by_id( $avatar_id ) ) {
				return false;
			}
			
			$delete_avatar =  $this->db->delete('user_avatars', array(
				'id' => $avatar_id,
			));
			
			// 同时删除头像文件
			
			$ci =& get_instance();
			$avatar_dir = $ci->config->item('avatar_path');
			
			$avatar_file = realpath( $avatar_dir . '/' . $avatar['user_id'] . '/' . $avatar['avatar_file'] ) ;
			unlink( $avatar_file );
			
			// 头像图片缩略图地址
			$avatar_thumb_file = explode( '.', $avatar['avatar_file'] );
			$avatar_thumb_file = realpath( $avatar_dir . '/' . $avatar['user_id'] . '/' . $avatar_thumb_file[0] . '_thumb.' . $avatar_thumb_file[1]  ) ;
			unlink( $avatar_thumb_file );
			
			
			
			return $delete_avatar;
			
		}
		
		
		

	}