<?php

	class Search extends KK_Controller {
		
		/**
		 *	iframe 搜索页
		 */
		function iframe_search() {
			$data = array();
			kk_show_view('search/iframe_search_view', $data);
		}
	}