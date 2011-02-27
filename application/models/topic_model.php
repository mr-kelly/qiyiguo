<?php
	
	/**
	 *	话题 的数据模型
	 */
	class Topic_Model extends KK_Model {
	
		function __construct() {
			parent::__construct();

			$this->load->model('user_profiles_model');
			$this->load->model('request_model');
		}
		
		
		/**
		 *	类论坛主题，发布小组主题内容
		 */
		function create_topic($model, $model_id, $user_id, $content, $title='', $attach_img_id=null ) {
			$data = array(
				'title' => $title,
				'content' => $content,
				'model' => $model,
				'model_id' => $model_id,
				'user_id' => $user_id,
				'attach_img_id' => $attach_img_id,
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
		
		
		
		function get_topics( $model, $model_id, $limit=10, $start=0 ) {
			$this->db->order_by('created DESC');
			$query = $this->db->get_where('topic', array(
				'model' => $model,
				'model_id' => $model_id,
			),$limit, $start);
			
			$topics = $query->result_array();
			
			// 绑定 附加图片
			foreach ( $topics as $k=>$v ) {
				$topics[$k]['User'] = $this->_get_user( $topics[$k]['user_id'] );
				
				if ( isset( $topics[$k]['attach_img_id'] ) ) {
					$topics[$k]['Attach_Img'] = $this->_get_attach( $topics[$k]['attach_img_id'], 'image' );
				}
			}
			
			return $topics;
		}

		function del_topic( $topic_id ) {
			
		}

		
	
	}
