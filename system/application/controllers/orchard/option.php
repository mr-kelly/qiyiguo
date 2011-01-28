<?php
	class Option extends KK_Controller {
		
		function index() {
			echo 'option page';
			$this->load->model('option_model');
		}
		
		function custom_website() {
			if ($_SERVER['REQUEST_METHOD'] == "POST") {
				$this->form_validation->set_rule('website_name', 'Website Name','required|xss_clean');
				$this->form_validation->set_rule('website_slug', 'Website slug','required|xss_clean');
				$this->form_validation->set_rule('website_url', 'Website URL','required|xss_clean');
				
				if ( !$this->form_validation->run() ) {
					echo validation_errors();
				} else {
					$website_name = $this->form_validation->set_value('website_name');
					$website_slug = $this->form_validation->set_value('website_slug');
					$website_url = $this->form_validation->set_value('website_url');
					
					$this->option_model->create_custom_website($website_name, $website_slug, $website_url );
				}
			}
			
			$data = array();
			$this->load->view('garden/option/custom_website_view', $data);
		}
	}