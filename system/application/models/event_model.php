<?php

	class Event_Model extends KK_Model {
		
		/*
			创建事件
			
			$data = array(
				'name'=>,
				'content'
				
				'start' =>
				'end'
				'model',
				'model_id',
				'user_id',
			); 
				
		 */
		function create_event( $data ) {
			$this->db->insert('event', $data);
			return $this->db->insert_id();
		}
		
	}