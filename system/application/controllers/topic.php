<?php

	class Topic extends KK_Controller {
	
		function iframe_add_topic( $model, $model_id ) {
		
			$render = array(
				'model' => $model,
				'model_id' => $model_id,
			);
			kk_show_view('topic/iframe_add_topic_view', $render);
		}
		
		function ajax_create_topic( $model, $model_id ) {
			login_redirect();
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$this->form_validation->set_rules('title', '标题', 'xss_clean|trim');
				$this->form_validation->set_rules('content', '正文', 'xss_clean|required|trim');
				
				if ( !$this->form_validation->run() ) {
					ajaxReturn( null, validation_errors(), 0 );
				} else {
					// Create Topic
					$title = $this->form_validation->set_value('title');
					$content = $this->form_validation->set_value('content');
					
					$this->load->model('topic_model');
					$topic_id = $this->topic_model->create_topic( $model, $model_id, 
														get_current_user_id(),  // Topic属于谁的
															$content, $title );
					
					ajaxReturn( null, 'Success Topic Created', 1);
				
				}
				
			} else {
				echo 'not post? why?';
			}
		
		}
	
	}