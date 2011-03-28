<?php
	/**
	 *	获取星座， 打印图标 class  :    icon_juxie...
	 
		array( "20" => "水瓶座"), 
		array( "19" => "双鱼座"), 
		array( "21" => "白羊座"), 
		array( "20" => "金牛座"), 
		array( "21" => "双子座"), 
		array( "22" => "巨蟹座"), 
		array( "23" => "狮子座"), 
		array( "23" => "处女座"), 
		array( "23" => "天秤座"), 
		array( "24" => "天蝎座"), 
		array( "22" => "射手座"), 
		array( "22" => "摩羯座") 
	 */
	function kk_constellation_icon( $constellation ) {
		switch( $constellation ) {

			case '摩羯座':
				return 'icon_mojie';
				break;
			case '水瓶座':
				return 'icon_shuiping';
				break;
			case '双鱼座':
				return 'icon_shuangyu';
				break;
			case '白羊座':
				return 'icon_baiyang';
				break;
			case '金牛座':
				return 'icon_jinniu';
				break;
			case '双子座':
				return 'icon_shuangzi';
				break;
			case '巨蟹座':
				return 'icon_juxie';
				break;
			case '狮子座':
				return 'icon_shizi';
				break;
			case '处女座':
				return 'icon_chunv';
				break;
			case '天秤座':
				return 'icon_tiancheng';
				break;
			case '天蝎座':
				return 'icon_tianxie';
				break;
			case '射手座':
				return 'icon_sheshou';
				break;
				
			
		}
	}