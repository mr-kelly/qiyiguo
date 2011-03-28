<?php

	class Attach extends KK_Controller {
		
		
		function __construct() {
			parent::__construct();
			$this->load->model('attach_model');
			
		}
		/**
		 *	下载附件... 文件或图片
		 */
		function download( $attach_id ) {
			$attach = $this->attach_model->get_attach_by_id( $attach_id );
			
			if ( $attach['type'] == 'file' ) {
				// 返回文件的网址
				redirect( $this->config->item('upload_path') . 'attach_file' . $attach['file'] );
			} else if ( $attach['type'] == 'image' ) {
				redirect( $this->config->item('upload_path') . 'attach_img' . $attach['file'] );
			}
		}
		
		
	}