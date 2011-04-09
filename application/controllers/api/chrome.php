<?php
	/**
	 *	Chrome 插件
	 */
	class Chrome extends KK_Controller {
		
		/**
		 *	Chrome 插件, popup窗口的iframe, 获得自己加入的群组
		 */
		function ext_popup() {

			$render[] = '';
			kk_show_view('api/chrome/ext_popup_view', $render);
		}
		
		function ext_get_user_groups_count() {
			$this->load->model('group_model');
			
			echo $this->group_model->get_user_groups_count( get_current_user_id() );
			
		}
	}