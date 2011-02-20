<?php

	class Attach_Model extends KK_Model {
		
		function add_picture( $file ) {
		
			$this->db->insert('attach', array(
				'file' => $file,
				'type' => 'image',
			));
			
			return $this->db->insert_id();
			
		}
		
	}