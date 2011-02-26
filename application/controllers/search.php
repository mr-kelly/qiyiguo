<?php

	class Search extends KK_Controller {
		
		/**
		 *	iframe 搜索页
		 */
		function iframe_search() {
			$data = array();
			kk_show_view('search/iframe_search_view', $data);
		}
		
		
		/**
		 *	JS ModelWindow 获取指定学校
		 */
		function window_choose_school() {
			kk_show_view('search/window_choose_school_view');
		}
		
		
		function ajax_search_group_by_id( $group_id=0 ) {
			//$group_id = $this->input->get('group_id');
			
			$this->load->model('group_model');
			$render['group'] = $this->group_model->_get_group( $group_id );
			
			kk_show_view('search/ajax_search_group_view', $render);
		}
		
		
		/** 
		*	JS Ajax.  通过搜索获取指定学校
		*/
		function ajax_serach_group_by_string( $query_string ) {
		
		
		}
		
	}