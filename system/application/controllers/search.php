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
		
		
	}