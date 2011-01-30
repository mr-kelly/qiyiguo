<?php
	
	/**
	 *	一个用于生成 果号 （用户、群组 编号） 的库
	 *
	 *	分配给用户ID ~   1000000 - 100000000     6 位数 - 9位数    即是999900000(9亿9千9百90万个数字, 可以注册999900000个用户而号码不重复... 够了吧
	 
	 		自动从数据库 users 库查找是否已经存在改ID的用户，
	 				若存在，继续随机
	 					直到随机到一个没人注册的ID为止
	 					
	 */
	class Guo_id {
		
		function __construct() {
			$this->generate_min = 100000; // 随机生成的最小数
			$this->generate_max = 1000000000;  // 随机生成的最大数   现在是6-9位数
			
			$this->ci =& get_instance(); // 获得codeigniter~
		}
		
		function generate_user_id() {
			$return_id = rand( $this->generate_min, $this->generate_max );
			
			$query = $this->ci->db->get_where('users', array(
				'id' => $return_id,
			));
			if ( $query->num_rows() != 0 ) {   // 该随机ID已经有用户拥有了！ 重新生成一个吧！
				return $this->generate_user_id();
			}
			
			return $return_id;    // 该ID未被其他人拥有， 返回！
		}
		
		function generate_group_id() {
			$return_id = rand( $this->generate_min, $this->generate_max );
			
			$query = $this->ci->db->get_where('group', array(
				'id' => $return_id,
			));
			if ( $query->num_rows() != 0 ) {   // 该随机ID已经有用户拥有了！ 重新生成一个吧！
				return $this->generate_group_id();
			}
			
			return $return_id;    // 该ID未被其他人拥有， 返回！
		}
		
		
	}