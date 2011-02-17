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
		
		
		/**
		 * 获取 事件集（活动集，任务集）
		 */
		function get_events( $data ) {
			 $query = $this->db->get_where('event', $data);
			 
			 if ( $query->num_rows() == 0 ) {
			 	 return false;
			 } else {
			 	return $query->result_array();
			 }
		}
		
		
		/**
		 *	根据ID指定获取事件（活动/任务）
		 */
		function get_event_by_id( $event_id ) {
			$query = $this->db->get_where('event', array(
				'id' => $event_id,
			));
			
			if ( $query->num_rows() == 0 ) {
				return false;
			} else {
				return $query->row_array();
			}
		}
		
		
		/**
		 *	删除符合条件的 事件（活动/任务)
		 */
		function del_event( $data ) [
			
		}
	}
