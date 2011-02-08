<?php
	/**
	 *	Page 是一个页面控制器
	 
	 		用来显示静态页面～
	 			用于网站的一些静态网页，比较关于、介绍～
	 				
	 				直接根据传入函数读取视图
	 */
	class Page extends KK_Controller {
	
		function page_lookup( $page ) {
		
			kk_show_view( "page/$page" );
		}
		
	}