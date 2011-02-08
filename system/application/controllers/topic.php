<?php

	class Topic extends KK_Controller {
	
		function iframe_add_topic( $model, $model_id ) {
		
			$render = array();
			kk_show_view('topic/iframe_add_topic_view', $render);
		}
	
	}