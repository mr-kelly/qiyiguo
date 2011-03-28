<?php

	/**
	 *	一些人性化数据显示
	 */
	class Humanize {
	
		/**
		 *	人性化的时间显示，几天前（3天内），几小时前，几分钟前
		 */
		function datetime($the_time) {
			
			date_default_timezone_set('Asia/Shanghai');
			
			$now_time = date("Y-m-d H:i:s"); //,time()+8*60*60 有时区要求的话
			$now_time = strtotime($now_time);
			$show_time = strtotime($the_time);
			$dur = $now_time - $show_time;
			if($dur < 0){
			 return $the_time; 
			} elseif ( $dur == 0 ) {
				return '<span class="red">刚刚</span>';
			} else {
			 if($dur < 60){
			 	
				return '<span class="red">' . $dur. '秒前</span>'; 
			 }else{
			  if($dur < 3600){
			   return floor($dur/60).'分钟前'; 
			  }else{
			   if($dur < 86400){
				return floor($dur/3600).'小时前'; 
			   }else{
				if($dur < 259200){//3天内
				 return floor($dur/86400).'天前';
				}else{
				 return $the_time; 
				}
			   }
			  }
			 }
			}
			
		}
		
		// Not Used Yet
		function month_trans($str_month) {
			$Month_E = array(1  => "January",
							 2  => "February",
							 3  => "March",
							 4  => "April",
							 5  => "May",
							 6  => "June",
							 7  => "July",
							 8  => "August",
							 9  => "September",
							 10 => "October",
							 11 => "November",
							 12 => "December");
		}
		
		/** 
		 *	根据输入时间年份，获取年龄
		 
		 	输入 1989-6-26,  计算距离时间成timestamp，再转化实际年份多少天
		 */
		function age( $str_time ) {
			$target = strtotime($str_time);
			$now = time();
			$datetime = getdate(strtotime($str_time));
			$year = intval( $datetime['year'] );
			
			$age =   $now - $target ;
			$age = round( $age / (60*60*24*365), 0);
			
			return $age;
		}
		
		/** 
		 *	从字符串时间中获得 年、月、日    ( 如 1989-6-26, 析出 1989,  6,  26 )
		 */
		function get_year( $str_time ) {
			$str_time = strtotime($str_time);
			$datetime = getdate( $str_time );
			return $datetime['year'];
		}
		function get_month( $str_time ) {
			$str_time = strtotime($str_time);
			$datetime = getdate( $str_time );
			return $datetime['mon'];
		}
		function get_day( $str_time ) {
			$str_time = strtotime($str_time);
			$datetime = getdate( $str_time );
			return $datetime['mday'];
		}
		
		
		/* 
		* string get_zodiac_sign(string month, string day) 
		* 输入：2010-08-02 00:00:00
		* 输出：星座名称或者错误 
		*/ 
		
		function constellation($str_time) 
		{ 
		
		$datetime = getdate(strtotime($str_time));
		$month = intval( $datetime['mon'] );
		$day = intval( $datetime['mday'] );
		
		
		// 检查参数有效性 
		if ($month < 1 || $month > 12 || $day < 1 || $day > 31) 
		return (false); 
		
		// 星座名称以及开始日期 
		$signs = array( 
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
		); 
		list($sign_start, $sign_name) = each($signs[(int)$month-1]); 
		if ($day < $sign_start) 
		list($sign_start, $sign_name) = each($signs[($month -2 < 0) ? $month = 11: $month -= 2]); 
		return $sign_name; 
		
		} // end of function. 
		
		
		
		
	}