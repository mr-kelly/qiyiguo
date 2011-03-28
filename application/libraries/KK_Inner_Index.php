<?php
	/**
	 *	内在指数~ 内涵指数~ 
	 		传入用户profile 数组， 获得内涵数组
	 		
	 		逐个判断用户的资料， 生成一个百分比~
	 		
	 		其实用户资料填完整，这样内涵指数就高～
	 */
	class KK_Inner_Index {
		
		function get_inner_index( $profile ) {
			
			$inner_index = 0;
			
			// Nickname 1
			if ( $profile['nickname'] != '' ) {
				$inner_index += 2;
			}
			
			// 省市  2
			if ( $profile['province_id'] != '' ) {
				$inner_index += 2;
			}
			if ( $profile['city_id'] != '' ) {
				$inner_index += 2;
			}
			
			// 籍贯
			if ( $profile['hometown_province_id'] != '' ) {
				$inner_index += 2;
			}
			if ( $profile['hometown_city_id'] != '' ) {
				$inner_index += 2;
			}
			
			// 生日 2
			if ( $profile['birth'] != '' ) {
				$inner_index += 6;
			}
			
			// 星座
			if ( $profile['constellation'] != '' ) {
				$inner_index += 2;
			}
			
			// 年龄
			if ( $profile['age'] != '' ) {
				$inner_index += 2;
			}
			
			// 恋爱状态
			if ( $profile['love_status'] != '' ) {
				$inner_index += 6;
			}
			
			
			// 恋爱状态 2
// 			if ( $profile['love'] != '' ) {
// 				$inner_index += 1;
// 			}
			
			// 性别 2
			if ( $profile['gender'] != '' ) {
				$inner_index += 3;
			}
			
			// Height 身高 2
// 			if ( $profile['height'] != '' ) {
// 				$inner_index += 2;
// 			}
			
			// Face 容貌 2
// 			if ( $profile['face'] != '' ) {
// 				$inner_index += 2;
// 			}
			
			// Phone 电话 比重大
			if ( $profile['phone'] != '' ) {
				$inner_index += 10;
			}
			
			// QQ 比重大
			if ( $profile['qq'] != '' ) {
				$inner_index += 3;
			}
			// MSN 电话 比重大
			if ( $profile['msn'] != '' ) {
				$inner_index += 6;
			}
			// Gtalk 电话 比重大
			if ( $profile['gtalk'] != '' ) {
				$inner_index += 6;
			}
			
			// 个人主页
			if ( $profile['website'] != '' ) {
				$inner_index += 2;
			}
			
			if ( !empty( $profile['link_renren'] ) ) {
				$inner_index += 2;
			}
			
			
			// 交友目的
// 			if ( $profile['target'] != '' ) {
// 				$inner_index += 2;
// 			}
			
			// 兴趣爱好
			if ( !empty ( $profile['hobby'] ) ) {
				$inner_index += 2;
			}
			
			// 个人介绍 // 判断字数长度，TODO
			if ( $profile['description'] != '' ) {
				
				$des_len = strlen( $profile['description'] );
				
				if ( $des_len > 35 ) {
					$inner_index += 15;
				} else if ( $des_len > 15 ) {
					$inner_index += 10;
				} else if ( $des_len > 0 ) {
					$inner_index += 2;
				} else {
					//$inner_index += 0;
					//没写个人简介，不加分
				}
				
			}
			
			// 教育水平
// 			if ( $profile['education'] != '' ) {
// 				$inner_index += 2;
// 			}
			
			// 工作职业
// 			if ( $profile['job'] != '' ) {
// 				if ( $profile['job'] == '学生' ) {
// 					$inner_index += 2;
// 				} else {
// 					$inner_index += 8;
// 				}
// 			}
			
			// 工资
// 			if ( $profile['salary'] != '' ) {
// 				$inner_index += 2;
// 			}
			
			// 体型
// 			if ( $profile['figure'] != '' ) {
// 				$inner_index += 2;
// 			}
			
			// 书
			if ( $profile['like_books'] != '' ) {
				$len = strlen( $profile['like_books'] );
				if ( $len > 10 ) {
					$inner_index += 3;
				} else {
					$inner_index += 1;
				}
			}
			
			// 喜欢的音乐
			if ( $profile['like_music'] != '' ) {
				$len = strlen( $profile['like_music'] );
				if ( $len > 10 ) {
					$inner_index += 3;
				} else {
					$inner_index += 1;
				}
			}
			
			// 喜欢的运动
			if ( $profile['like_sports'] != '' ) {
				$len = strlen( $profile['like_sports'] );
				if ( $len > 10 ) {
					$inner_index += 3;
				} else {
					$inner_index += 1;
				}
			}
			
			// 电影
			if ( $profile['like_movies'] != '' ) {
				$len = strlen( $profile['like_movies'] );
				if ( $len > 10 ) {
					$inner_index += 3;
				} else {
					$inner_index += 1;
				}
			}
			
			// 人物
			if ( $profile['like_personages'] != '' ) {
				$len = strlen( $profile['like_personages'] );
				if ( $len > 10 ) {
					$inner_index += 3;
				} else {
					$inner_index += 1;
				}
			}
			
			// 座右铭
			if ( $profile['motto'] != '' ) {
				$inner_index += 2;
			}
			
			// 标准择偶 ， 根据写的长度
// 			if ( $profile['standard'] != '' ) {
// 				$std_len = strlen( $profile['standard'] );
// 				
// 				if ( $std_len > 35 ) {
// 					$inner_index += 15;
// 				} else if ( $std_len > 15 ) {
// 					$inner_index += 10;
// 				} else if ( $std_len > 0 ) {
// 					$inner_index += 4;
// 				} else {
// 					$inner_index += 1;
// 				}
// 			}

			// 是不是单身，非单身加分多一点哦
			if ( !empty( $profile['love_status'] ) ) {
				if ( $profile['love_status'] != 'single' ||
						$profile['love_status'] != '' ) {
					
					$inner_index += 8;
						
				} elseif ( $profile['love_status'] == 'single' ) {
					$inner_index += 5;
				}
			}
			
			return $inner_index;

		}
	
	}