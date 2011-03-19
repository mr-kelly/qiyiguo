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
		function create_topic($model, $model_id, $user_id, $content, $title='', $attach_img_id=null, $attach_file_id=null ) {
			$data = array(
				'title' => $title,
				'content' => $content,
				'model' => $model,
				'model_id' => $model_id,
				'user_id' => $user_id,
				'attach_img_id' => $attach_img_id,
				'attach_file_id' => $attach_file_id,
				
				'created' => date('Y-m-d H:i:s'),
			);
			
			$this->db->insert('topic', $data);
			
			return $this->db->insert_id();
		}

		
		
		function get_topic_by_id( $topic_id) {
			$topic = $this->db->get_where('topic', array(
				'id'=>$topic_id,
			));
			
			if ( $topic->num_rows() == 0 ) {
				return false;
			}
			
			$topic = $topic->row_array();
			
			if ( isset( $topic['attach_img_id'] ) ) {
				$topic['Attach_Img'] = $this->_get_attach( $topic['attach_img_id'], 'image' );
			}
			
			// 绑定 附加文件
			if ( isset( $topic['attach_file_id'] ) ) {
				$topic['Attach_File'] = $this->_get_attach( $topic['attach_file_id'], 'file' );
			}
			
			return $topic;
		}
		
		
		/**
		 *	从公开群组获取最新的话题...  (来自公开群组！)
		 *			判断话题所属群组是否私密群组
		 */
		function get_fresh_topics( $limit=10 , $start=0) {
			$sql = sprintf('SELECT * FROM kk_topic 
								WHERE model_id = 
									( SELECT kk_group.id FROM kk_group WHERE kk_topic.model_id = kk_group.id AND kk_group.privacy = "public" )
									LIMIT %d,%d', $start, $limit ); // kk_topic.model_id = kk_group.id AND
			//获得公开群组
			$query = $this->db->query( $sql );
			
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			return $query->result_array();
			
		}
		
		function get_all_topics( $limit=10, $start=0 ) {
			$this->db->order_by('created', 'desc');
			
			$query = $this->db->get('topic', $limit, $start);
			
			if ( $query->num_rows() == 0 ) {
				return false;
			}
			
			return $query->result_array();
		}
		/**
		 *	一共有多少个话题
		 */
		function get_all_topics_count() {
			$query = $this->db->get('topic');
			return $query->num_rows();
		}
		
		function get_topics( $model, $model_id, $limit=10, $start=0 ) {
			$this->db->order_by('created', 'desc');
			
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
				
				// 绑定 附加文件
				if ( isset( $topics[$k]['attach_file_id'] ) ) {
					$topics[$k]['Attach_File'] = $this->_get_attach( $topics[$k]['attach_file_id'], 'file' );
				}
				
			}
			
			
			
			return $topics;
		}
		
		function get_topics_count( $model, $model_id ) {
			$query = $this->db->get_where('topic', array(
				'model' => $model,
				'model_id' => $model_id,
			));
			return $query->num_rows();
		}
		
		function del_topic( $topic_id ) {
		
			// TODO 同时删除评论、图片、附件
			
			
			return $this->db->delete('topic', array(
				'id' => $topic_id,
			));	
		}
		
		
		/**
		 *	获取热门话题...人气比较高的. 人气 > 10的
		 */
		function get_hot_topics( $limit, $start, $random=true ) {
		
		}

		
		/**
		 *	 提升某话题的查看量
		 */
		function up_topic_page_view( $topic_id ) {
			$topic = $this->get_topic_by_id( $topic_id );
			
			$this->db->where('id', $topic['id'] );
			return $this->db->update('topic', array(
				'page_view' => $topic['page_view'] + 1,
			));
		}
	
	}
