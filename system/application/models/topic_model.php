<?php

	class Topic_Model extends KK_Model {
	
		function __construct() {
			parent::__construct();
			$this->ci =& get_instance();
			$this->ci->load->model('user_profiles_model');
			$this->ci->load->model('request_model');
		}
		
		
		/**
		 *	类论坛主题，发布小组主题内容
		 */
		function create_topic($model, $model_id, $user_id, $content, $title='' ) {
			$data = array(
				'title' => $title,
				'content' => $content,
				'model' => $model,
				'model_id' => $model_id,
				'user_id' => $user_id,
				'created' => date('Y-m-d H:i:s'),
			);
			
			$this->db->insert('topic', $data);
			
			return $this->db->insert_id();
		}

		
		
		function get_topic_by_id( $topic_id) {
			$topic = $this->db->get_where('topic', array(
				'id'=>$topic_id,
			))->result_array();
			
			return $topic[0];
		}
		
		
		
		function get_topics( $model, $model_id, $limit=10 ) {
			$this->db->order_by('created DESC');
			$query = $this->db->get_where('topic', array(
				'model' => $model,
				'model_id' => $model_id,
			),$limit);
			
			$topics = $query->result_array();
			foreach ( $topics as $k=>$v ) {
				$topics[$k]['User'] = $this->_get_user( $topics[$k]['user_id'] );
				
			}
			
			return $topics;
		}

		function del_topic( $topic_id ) {
			
		}

		
	
	}