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
		
	}