<?php

	class Topic extends KK_Controller {
	
		function ajax_add_topic( $model, $model_id ) {
		
			login_redirect();
			$this->load->library('KK_Filter');
			
			if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
				$this->form_validation->set_rules('title', '标题', 'xss_clean|trim');
				$this->form_validation->set_rules('content', '正文', 'xss_clean|required|trim');
				$this->form_validation->set_rules('attach_img_id','附加图片', 'integer|xss_clean|trim');
				
				if ( !$this->form_validation->run() ) {
					ajaxReturn( null, validation_errors(), 0 );
				} else {
					// Create Topic
					$title = $this->form_validation->set_value('title');
					
					$content = $this->kk_filter->filter( $this->form_validation->set_value('content') );
					$attach_img_id = $this->form_validation->set_value('attach_img_id');
					
					
					// 过滤<meta>等非法标签
					//$content = strip_tags( $content, '<p><a><span><div><b><font>');
					
					
					$this->load->model('topic_model');
					$topic_id = $this->topic_model->create_topic( $model, $model_id, 
														get_current_user_id(),  // Topic属于谁的
															$content, $title, 
																$attach_img_id );
					
					ajaxReturn( $this->input->post('content'), 'Success Topic Created', 1);
				
				}
				
			}
			
			// GET -->
			$render = array(
				'model' => $model,
				'model_id' => $model_id,
			);
			
			kk_show_view('topic/ajax_add_topic_view', $render);
		}
		
		function ajax_create_topic( $model, $model_id ) {

		
		}
	
	
	
	
		/**
		 *	小组主题
		 */
		function topic_lookup($topic_id = 0) {
		
			$this->load->model('topic_model');
			
// 			if ($_SERVER['REQUEST_METHOD'] == "POST") {
// 				$this->form_validation->set_rules('topic_title','Topic Title', 'trim|xss_clean');
// 				$this->form_validation->set_rules('topic_content','Topic Content', 'trim|required|xss_clean');
// 				$this->form_validation->set_rules('topic_group_id','Topic Group', 'trim|required|xss_clean');
// 				
// 				if ( !$this->form_validation->run() ) {
// 					ajaxReturn( null, validation_errors(), 0);
// 				} else {
// 					// 表单验证成功
// 					$user_id = $this->tank_auth->get_user_id();
// 					$topic_title = $this->form_validation->set_value('topic_title');
// 					$topic_content = $this->form_validation->set_value('topic_content');
// 					$topic_group_id = $this->form_validation->set_value('topic_group_id');
// 					
// 					$this->group_model->create_group_topic($topic_group_id, $user_id, $topic_title, $topic_content);
// 					ajaxReturn( null, '成功发布主题!', 1);
// 				}
// 				
// 				
// 			}
			
			$data['topic'] = $this->topic_model->get_topic_by_id($topic_id);
			
			$this->load->view('topic/topic_view', $data);
			
			
		}
		
		
		
		/**
		 *	话题的附加图片
		 */
		function ajax_topic_upload_pic() {
		
			$upload_path = sprintf("%sattach_img/%s", $this->config->item('upload_path'), date('Y/m/d/') ) ; // 根据年月日上传目录
			$this->_createDir($upload_path);
			
			$upload_config = array(
				'upload_path' => $upload_path,
				'allowed_types' => 'gif|jpg|png',
				'max_size' => '1024',
				'max_width' => '4096',
				'max_height' => '3000',
				'encrypt_name' => true, // 随机名
			);
			
			$this->load->library('upload', $upload_config);
			if ( !$this->upload->do_upload() ) {
				ajaxReturn( $this->upload->display_errors(), '图片上传失败~', 0);
			} else {
				// 上传成功, 处理图片
				$upload_data = $this->upload->data();
				
				$image_config = array(
					'image_library' => 'gd2',
					'source_image' => $upload_data['full_path'],
					'maintain_ratio' => true,
					'width' => 200,
					'height' => 120,
					'create_thumb' => true,
				);
				$this->load->library('image_lib');
				$this->image_lib->initialize( $image_config );
				$this->image_lib->resize();
				
				
				$this->load->model('attach_model');
				$return = array(
					'file' =>  date('/Y/m/d/') . $upload_data['file_name'], // 返回文件的目录+文件名
					'file_thumb' => date('/Y/m/d/') . $upload_data['raw_name'] . '_thumb'. $upload_data['file_ext'], // 目录+纯文件+thumb+后缀
					'attach_id' => $this->attach_model->add_picture( date('/Y/m/d/') . $upload_data['file_name'] ),
				);
				ajaxReturn( $return, '图片上传成功！', 1 );
			}
			
			
		}
		
		

	}