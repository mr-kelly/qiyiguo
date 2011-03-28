<?php

	class Attach_Model extends KK_Model {
		
		
		/**
		 *	添加图片 。。。。
		 */
		function add_picture( $file ) {
		
			$this->db->insert('attach', array(
				'file' => $file,
				'type' => 'image',
			));
			
			return $this->db->insert_id();
			
		}
		
		/**
		 *	添加附件文件
		 */
		function add_file( $file ) {
			$this->db->insert('attach', array(
				'file' => $file,
				'type' => 'file',
			));
			
			return $this->db->insert_id();
		}
		
		
		
		/**
		 *	获取指定附件的数据库资料
		 */
		function get_attach_by_id( $attach_id ) {
			$query = $this->db->get_where('attach', array(
				'id' => $attach_id,
			));
			
			if ( $query->num_rows() == 0 ) {
				return false;	
			}
			
			return $query->row_array();
			
		}
		
		/**
		 *	删除指定附件， 包括从数据库、上传目录删除
		 */
		function del_attach( $attach_id, $type ) {
			$query = $this->db->get_where('attach', array(
				'id' => $attach_id,
				'type' => $type,
			));
			
			if ( $query->num_rows() == 0 ) {
				return false;
			}
				
			$attach = $query->row_array();
			
			
			// 删除文件
			if ( $type == 'file' ) {
				
				unlink( 
							$this->config->item('upload_path') . 
							'attach_file/' . 
							$attach['file'] 
							);
			} elseif ( $type == 'image' ) {
				// 删除上传的图片文件
				try {
				unlink( 
							$this->config->item('upload_path') . 
							'attach_img/' . 
							$attach['file'] 
							);
							
				// 还有缩略图...
				//$file_name = substr( $attach['file'], strrpos( $attach['file'], '/' )+1 );
				$thumb_file = explode( '.', $attach['file'] );
				$thumb_file = $thumb_file[0] . '_thumb.' . $thumb_file[1];
				
				unlink(
							$this->config->item('upload_path') . 
							'attach_img/' . 
							$thumb_file
							);
				} catch ( Exception $e ) {
				
				}
			}
			
			// 好，删除数据库中的attach
			return $this->db->delete('attach', array(
				'id' => $attach_id,
				'type' => $type,
			));
			
		}
	}