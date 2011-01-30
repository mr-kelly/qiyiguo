<?php
	class Dict_Model extends KK_Model {
	
		function get_provinces() {
			$provinces = $this->db->get('dict_province')->result_array();;
			
			return $provinces;
		}
		
		function get_cities( $province_id=11 ) {
			$cities = $this->db->get_where('dict_city', array(
				'province_id' => $province_id,
			))->result_array();
			
			return $cities;
		}
		
		
		/**
		 *	通过省份ID， 城市id获取城市名称
		 */
		function get_city_name ( $city_id ) {
			$city = $this->db->get_where('dict_city', array(
				'id' => $city_id,
			))->result_array();
			
			return $city[0]['city_name'];
		}
		
		
		/**
		 *	通过省份id获取省份名称
		 */
		function get_province_name( $province_id ) {
			$province = $this->db->get_where('dict_province', array(
				'id' => $province_id,
			))->result_array();
			
			return $province[0]['province_name'];
		}
		
		
		/**
		 *	新浪微博的city_id是根据province_id 来获取的，通常为单数
		 
		 	这里通过province_id，city_id来获取新浪微博的city_id
		 	
		 	返回city_id
		 */
		function t_sina_city_adapter_id( $province_id, $city_id ) {
			$city = $this->db->get_where('dict_city', array(
				'province_id' => $province_id,
				'city_id' => $city_id,
			));
			
			if ( $city->num_rows != 0 ) {
				$city = $city->result_array();
				
				return $city[0]['id'];
			}
			
			
		}
	
	}