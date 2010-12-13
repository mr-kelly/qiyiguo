<?php
	class Option_Model extends KK_Model {
	
		function create_custom_website($name, $slug, $url, $logo =null) {
			$data = array(
				'website_name' => $name,
				'website_slug' => $slug,
				'website_url' => $url,
				'website_logo' => $logo,
			);
			
			$this->db->insert('option_custom_website', $data);
		}
	}