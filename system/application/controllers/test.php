<?
	class Test extends KK_Controller {
		
		function __construct() {
			parent::__construct();
			//exit('cannot enter test');
			
		}
		
		function test_upload_topic_pic() {
			echo sprintf('
				<form method="post" action="%s" enctype="multipart/form-data">
					<input id="add_topic_pic_input" type="file" size="45" name="userfile" />
					<input type="submit" />
				</form>', site_url('topic/ajax_topic_upload_pic') );


		}
		function test_qq() {
			$this->load->library('QQ_Connect');
			$qq_c = $this->qq_connect->get_client();
			print_r( $qq_c->getUserInfo( '00000000000000000000000000BAB27C', '9A48BFD06811864150BB1C61FF5915C6B7D2A36951AEEFDF') );
		}
		
		
		function test_decrypt() {
			$query = $this->db->get_where('user_t_sina', array( 'id'=> 35) );
			
			$result = $query->result_array();
			//print_r( $result );
			
			
			$this->load->library('fun_crypt');
			print $this->fun_crypt->deCrypt( $result[0]['t_sina_password'] );
		}
		
		function test_guo_id() {
			$this->load->library('Guo_id');
			echo $this->guo_id->generate_user_id();
		}
		
		function test_relation() {
			$this->load->model('relation_model');
			
			echo $this->relation_model->create_relation();
		}
		
		function index() {
			
// 			date_default_timezone_set('Asia/Shanghai');
// 			
// 			print $this->humanize->datetime('2010-09-01 14:03:11');
// 			
// 			print ',现在是'. date("Y-m-d H:i:s");
// 			
// 			print_r( getdate( strtotime(date("Y-m-d H:i:s"))));
// 			
// 			
// 			echo $this->humanize->constellation(date("Y-m-d H:i:s"));
// 			$this->load->model('chat_model');
// 			$chats = $this->chat_model->get_chats('group_topic', 27);
// 			
// 			print_r( $chats );



			//$this->load->library('kk_mailer');
			//$this->kk_mailer->send_mail( );
			
			//$this->load->library('t_sina');
			
			//$json = file_get_contents( 'http://api.t.sina.com.cn/provinces.json' );
		    $json = <<<EOT
	
{"provinces":[{"id":11,"name":"北京","citys":[{"1":"东城区"},{"2":"西城区"},{"3":"崇文区"},{"4":"宣武区"},{"5":"朝阳区"},{"6":"丰台区"},{"7":"石景山区"},{"8":"海淀区"},{"9":"门头沟区"},{"11":"房山区"},{"12":"通州区"},{"13":"顺义区"},{"14":"昌平区"},{"15":"大兴区"},{"16":"怀柔区"},{"17":"平谷区"},{"28":"密云县"},{"29":"延庆县"}]},
{"id":12,"name":"天津","citys":[{"1":"和平区"},{"2":"河东区"},{"3":"河西区"},{"4":"南开区"},{"5":"河北区"},{"6":"红桥区"},{"7":"塘沽区"},{"8":"汉沽区"},{"9":"大港区"},{"10":"东丽区"},{"11":"西青区"},{"12":"津南区"},{"13":"北辰区"},{"14":"武清区"},{"15":"宝坻区"},{"21":"宁河县"},{"23":"静海县"},{"25":"蓟县"}]},
{"id":13,"name":"河北","citys":[{"1":"石家庄"},{"2":"唐山"},{"3":"秦皇岛"},{"4":"邯郸"},{"5":"邢台"},{"6":"保定"},{"7":"张家口"},{"8":"承德"},{"9":"沧州"},{"10":"廊坊"},{"11":"衡水"}]},
{"id":14,"name":"山西","citys":[{"1":"太原"},{"2":"大同"},{"3":"阳泉"},{"4":"长治"},{"5":"晋城"},{"6":"朔州"},{"7":"晋中"},{"8":"运城"},{"9":"忻州"},{"10":"临汾"},{"23":"吕梁"}]},
{"id":15,"name":"内蒙古","citys":[{"1":"呼和浩特"},{"2":"包头"},{"3":"乌海"},{"4":"赤峰"},{"5":"通辽"},{"6":"鄂尔多斯"},{"7":"呼伦贝尔"},{"22":"兴安盟"},{"25":"锡林郭勒盟"},{"26":"乌兰察布盟"},{"28":"巴彦淖尔盟"},{"29":"阿拉善盟"}]},
{"id":21,"name":"辽宁","citys":[{"1":"沈阳"},{"2":"大连"},{"3":"鞍山"},{"4":"抚顺"},{"5":"本溪"},{"6":"丹东"},{"7":"锦州"},{"8":"营口"},{"9":"阜新"},{"10":"辽阳"},{"11":"盘锦"},{"12":"铁岭"},{"13":"朝阳"},{"14":"葫芦岛"}]},
{"id":22,"name":"吉林","citys":[{"1":"长春"},{"2":"吉林"},{"3":"四平"},{"4":"辽源"},{"5":"通化"},{"6":"白山"},{"7":"松原"},{"8":"白城"},{"24":"延边朝鲜族自治州"}]},
{"id":23,"name":"黑龙江","citys":[{"1":"哈尔滨"},{"2":"齐齐哈尔"},{"3":"鸡西"},{"4":"鹤岗"},{"5":"双鸭山"},{"6":"大庆"},{"7":"伊春"},{"8":"佳木斯"},{"9":"七台河"},{"10":"牡丹江"},{"11":"黑河"},{"12":"绥化"},{"27":"大兴安岭"}]},
{"id":31,"name":"上海","citys":[{"1":"黄浦区"},{"3":"卢湾区"},{"4":"徐汇区"},{"5":"长宁区"},{"6":"静安区"},{"7":"普陀区"},{"8":"闸北区"},{"9":"虹口区"},{"10":"杨浦区"},{"12":"闵行区"},{"13":"宝山区"},{"14":"嘉定区"},{"15":"浦东新区"},{"16":"金山区"},{"17":"松江区"},{"18":"青浦区"},{"19":"南汇区"},{"20":"奉贤区"},{"30":"崇明县"}]},
{"id":32,"name":"江苏","citys":[{"1":"南京"},{"2":"无锡"},{"3":"徐州"},{"4":"常州"},{"5":"苏州"},{"6":"南通"},{"7":"连云港"},{"8":"淮安"},{"9":"盐城"},{"10":"扬州"},{"11":"镇江"},{"12":"泰州"},{"13":"宿迁"}]},
{"id":33,"name":"浙江","citys":[{"1":"杭州"},{"2":"宁波"},{"3":"温州"},{"4":"嘉兴"},{"5":"湖州"},{"6":"绍兴"},{"7":"金华"},{"8":"衢州"},{"9":"舟山"},{"10":"台州"},{"11":"丽水"}]},
{"id":34,"name":"安徽","citys":[{"1":"合肥"},{"2":"芜湖"},{"3":"蚌埠"},{"4":"淮南"},{"5":"马鞍山"},{"6":"淮北"},{"7":"铜陵"},{"8":"安庆"},{"10":"黄山"},{"11":"滁州"},{"12":"阜阳"},{"13":"宿州"},{"14":"巢湖"},{"15":"六安"},{"16":"亳州"},{"17":"池州"},{"18":"宣城"}]},
{"id":35,"name":"福建","citys":[{"1":"福州"},{"2":"厦门"},{"3":"莆田"},{"4":"三明"},{"5":"泉州"},{"6":"漳州"},{"7":"南平"},{"8":"龙岩"},{"9":"宁德"}]},
{"id":36,"name":"江西","citys":[{"1":"南昌"},{"2":"景德镇"},{"3":"萍乡"},{"4":"九江"},{"5":"新余"},{"6":"鹰潭"},{"7":"赣州"},{"8":"吉安"},{"9":"宜春"},{"10":"抚州"},{"11":"上饶"}]},
{"id":37,"name":"山东","citys":[{"1":"济南"},{"2":"青岛"},{"3":"淄博"},{"4":"枣庄"},{"5":"东营"},{"6":"烟台"},{"7":"潍坊"},{"8":"济宁"},{"9":"泰安"},{"10":"威海"},{"11":"日照"},{"12":"莱芜"},{"13":"临沂"},{"14":"德州"},{"15":"聊城"},{"16":"滨州"},{"17":"菏泽"}]},
{"id":41,"name":"河南","citys":[{"1":"郑州"},{"2":"开封"},{"3":"洛阳"},{"4":"平顶山"},{"5":"安阳"},{"6":"鹤壁"},{"7":"新乡"},{"8":"焦作"},{"9":"濮阳"},{"10":"许昌"},{"11":"漯河"},{"12":"三门峡"},{"13":"南阳"},{"14":"商丘"},{"15":"信阳"},{"16":"周口"},{"17":"驻马店"}]},
{"id":42,"name":"湖北","citys":[{"1":"武汉"},{"2":"黄石"},{"3":"十堰"},{"5":"宜昌"},{"6":"襄樊"},{"7":"鄂州"},{"8":"荆门"},{"9":"孝感"},{"10":"荆州"},{"11":"黄冈"},{"12":"咸宁"},{"13":"随州"},{"28":"恩施土家族苗族自治州"}]},
{"id":43,"name":"湖南","citys":[{"1":"长沙"},{"2":"株洲"},{"3":"湘潭"},{"4":"衡阳"},{"5":"邵阳"},{"6":"岳阳"},{"7":"常德"},{"8":"张家界"},{"9":"益阳"},{"10":"郴州"},{"11":"永州"},{"12":"怀化"},{"13":"娄底"},{"31":"湘西土家族苗族自治州"}]},
{"id":44,"name":"广东","citys":[{"1":"广州"},{"2":"韶关"},{"3":"深圳"},{"4":"珠海"},{"5":"汕头"},{"6":"佛山"},{"7":"江门"},{"8":"湛江"},{"9":"茂名"},{"12":"肇庆"},{"13":"惠州"},{"14":"梅州"},{"15":"汕尾"},{"16":"河源"},{"17":"阳江"},{"18":"清远"},{"19":"东莞"},{"20":"中山"},{"51":"潮州"},{"52":"揭阳"},{"53":"云浮"}]},
{"id":45,"name":"广西","citys":[{"1":"南宁"},{"2":"柳州"},{"3":"桂林"},{"4":"梧州"},{"5":"北海"},{"6":"防城港"},{"7":"钦州"},{"8":"贵港"},{"9":"玉林"},{"10":"百色"},{"11":"贺州"},{"12":"河池"},{"21":"南宁"},{"22":"柳州"}]},
{"id":46,"name":"海南","citys":[{"1":"海口"},{"2":"三亚"},{"90":"其他"}]},
{"id":50,"name":"重庆","citys":[{"1":"万州区"},{"2":"涪陵区"},{"3":"渝中区"},{"4":"大渡口区"},{"5":"江北区"},{"6":"沙坪坝区"},{"7":"九龙坡区"},{"8":"南岸区"},{"9":"北碚区"},{"10":"万盛区"},{"11":"双桥区"},{"12":"渝北区"},{"13":"巴南区"},{"14":"黔江区"},{"15":"长寿区"},{"22":"綦江县"},{"23":"潼南县"},{"24":"铜梁县"},{"25":"大足县"},{"26":"荣昌县"},{"27":"璧山县"},{"28":"梁平县"},{"29":"城口县"},{"30":"丰都县"},{"31":"垫江县"},{"32":"武隆县"},{"33":"忠县"},{"34":"开县"},{"35":"云阳县"},{"36":"奉节县"},{"37":"巫山县"},{"38":"巫溪县"},{"40":"石柱土家族自治县"},{"41":"秀山土家族苗族自治县"},{"42":"酉阳土家族苗族自治县"},{"43":"彭水苗族土家族自治县"},{"81":"江津市"},{"82":"合川市"},{"83":"永川区"},{"84":"南川市"}]},
{"id":51,"name":"四川","citys":[{"1":"成都"},{"3":"自贡"},{"4":"攀枝花"},{"5":"泸州"},{"6":"德阳"},{"7":"绵阳"},{"8":"广元"},{"9":"遂宁"},{"10":"内江"},{"11":"乐山"},{"13":"南充"},{"14":"眉山"},{"15":"宜宾"},{"16":"广安"},{"17":"达州"},{"18":"雅安"},{"19":"巴中"},{"20":"资阳"},{"32":"阿坝"},{"33":"甘孜"},{"34":"凉山"}]},
{"id":52,"name":"贵州","citys":[{"1":"贵阳"},{"2":"六盘水"},{"3":"遵义"},{"4":"安顺"},{"22":"铜仁"},{"23":"黔西南"},{"24":"毕节"},{"26":"黔东南"},{"27":"黔南"}]},
{"id":53,"name":"云南","citys":[{"1":"昆明"},{"3":"曲靖"},{"4":"玉溪"},{"5":"保山"},{"6":"昭通"},{"23":"楚雄"},{"25":"红河"},{"26":"文山"},{"27":"思茅"},{"28":"西双版纳"},{"29":"大理"},{"31":"德宏"},{"32":"丽江"},{"33":"怒江"},{"34":"迪庆"},{"35":"临沧"}]},
{"id":54,"name":"西藏","citys":[{"1":"拉萨"},{"21":"昌都"},{"22":"山南"},{"23":"日喀则"},{"24":"那曲"},{"25":"阿里"},{"26":"林芝"}]},
{"id":61,"name":"陕西","citys":[{"1":"西安"},{"2":"铜川"},{"3":"宝鸡"},{"4":"咸阳"},{"5":"渭南"},{"6":"延安"},{"7":"汉中"},{"8":"榆林"},{"9":"安康"},{"10":"商洛"}]},
{"id":62,"name":"甘肃","citys":[{"1":"兰州"},{"2":"嘉峪关"},{"3":"金昌"},{"4":"白银"},{"5":"天水"},{"6":"武威"},{"7":"张掖"},{"8":"平凉"},{"9":"酒泉"},{"10":"庆阳"},{"24":"定西"},{"26":"陇南"},{"29":"临夏"},{"30":"甘南"}]},
{"id":63,"name":"青海","citys":[{"1":"西宁"},{"21":"海东"},{"22":"海北"},{"23":"黄南"},{"25":"海南"},{"26":"果洛"},{"27":"玉树"},{"28":"海西"}]},
{"id":64,"name":"宁夏","citys":[{"1":"银川"},{"2":"石嘴山"},{"3":"吴忠"},{"4":"固原"}]},
{"id":65,"name":"新疆","citys":[{"1":"乌鲁木齐"},{"2":"克拉玛依"},{"21":"吐鲁番"},{"22":"哈密"},{"23":"昌吉"},{"27":"博尔塔拉"},{"28":"巴音郭楞"},{"29":"阿克苏"},{"30":"克孜勒苏"},{"31":"喀什"},{"32":"和田"},{"40":"伊犁"},{"42":"塔城"},{"43":"阿勒泰"}]},
{"id":71,"name":"台湾","citys":[{"1":"台北"},{"2":"高雄"},{"90":"其他"}]},
{"id":81,"name":"香港","citys":[{"1":"香港"}]},
{"id":82,"name":"澳门","citys":[{"1":"澳门"}]},
{"id":100,"name":"其他","citys":[]},
{"id":400,"name":"海外","citys":[{"1":"美国"},{"2":"英国"},{"3":"法国"},{"4":"俄罗斯"},{"5":"加拿大"},{"6":"巴西"},{"7":"澳大利亚"},{"8":"印尼"},{"9":"泰国"},{"10":"马来西亚"},{"11":"新加坡"},{"12":"菲律宾"},{"13":"越南"},{"14":"印度"},{"15":"日本"},{"16":"其他"}]}]}
	
EOT;
			
			$location = json_decode( $json, true );
			print_r ( $location );
			foreach ( $location['provinces'] as $province ) {

				
				foreach ( $province['citys'] as $key=>$city ) {
					print_r( $city );
					$this->db->insert('dict_city', array(
						//'id' => $city['id'],
						'city_id' => key($city),
						'city_name' => current($city),
						'province_id' => $province['id'],
					));
				}
				
				
				
				$this->db->insert( 'dict_province', array(
					'id' => $province['id'],
					'province_name' => $province['name'],
				));
				
			}



// 			$this->load->library('t_sina');
// 			
// 			$user = $this->t_sina->getUser('chepy6', '626626');
// 			print_r( $user );
// 			$url = 'http://tp1.sinaimg.cn/1215059564/50/1284954473';
// 			$img = file_get_contents( str_replace( '/50/', '/180/', $url) );
// 			
// 			$path = $this->config->item('avatar_path') . '/' . '999' . '/';
// 			$this->_createDir($path);
// 			file_put_contents($path . md5(rand(0, 9999)), $img);
			
		}
		
		
		/**
		 *	创建目录函数，用于上传头像是自动生成用户的头像图片存放文件夹
		 */
		function _createDir($path) {
		   if (!file_exists($path)) {
		   	
			$this->_createDir(dirname($path));
		
			mkdir($path, 0777);
		   }
		}
		
		
		function server() {
			phpinfo();
		}
		
		
		/**
		 *	将所有学校 (cms_university, cms_provinces)转换成群组~
		 */
		function school_to_group() {
		
			// 获取学校和它所在省份
			$schools = $this->db->query('SELECT cms_university.university, cms_provinces.province FROM cms_university,cms_provinces WHERE cms_university.province_id = cms_provinces.province_id');
			foreach ( $schools->result_array() as $school ) {
				$u = $school['university'];  // 新群组的名称
				$p = $school['province'];
				
				$provs = $this->db->query('SELECT id FROM kk_dict_province WHERE province_name = "' . $p .'"');
				$provs = $provs->row_array();
				
				$real_province_id = $provs['id']; // 新群组对应的 省份 province_ID
				
				$cat_id = 4;    // 新群组所属分类 - 大学
				
				$this->load->model('group_model');
				
				// 防止学校名字重复!
				$check_school = $this->db->get_where('group', array(
					'name' => $u,
				));
				if ( $check_school->num_rows() == 0 ) {
					$this->group_model->create_group(array(
						'name' => $u,
						'province_id' => $real_province_id,
						'category_id' => $cat_id,
						'privacy' => 'public',
						'verify' => 'everyone',
						'owner_id' => 0,
					));
				} else {
					//
					
					echo('duplicated school');
				}
				
			}
			
			//print_r( $schools->result_array() );
			
		}
		

	}
