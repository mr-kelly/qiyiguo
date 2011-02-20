<?php
	class Log_Model extends KK_Model {
		function __construct() {
			parent::__construct();
		}
		
		
		function create_log($url, $message) {
			$data = array(
				'url' => $url,
				'message' => $message,
				'created' => date('Y-m-d H:i:s'),
				'ip' => $this->input->ip_address(),
			);
			$this->db->insert('log', $data);
		}
	}