<?php
	class Search_Model extends KK_Model {
		/**
		 *	进行一个搜索记录...存在的话，count + 1， 不存在创建
		 */
		function search_record($string) {
			$query = $this->db->get_where('search', array(
				'string' => $string,
			));
			
			if ( $query->num_rows() == 0 ) {
				// 不存在，创建
				return $this->db->insert('search', array(
					'string' => $string,
				));
			} else {
				// 存在，加1
				$search = $query->row_array();
				
				// 加1
				$this->db->where('string', $string);
				return $this->db->update('search', array(
					'count' => $search['count']+1,
				));
				
			}
		}
	}