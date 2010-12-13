<?php
	class WebServices extends KK_Controller {
	
		function index() {
		
			$this->load->library('T_sina');
			$GLOBALS['t_sina'] = $this->t_sina;
			$t_sina = $this->t_sina;

			
			$options = array(
				'uri'=>'a',
			);
			$soapServer = new SoapServer(null, $options);
			
			$soapServer->setObject($t_sina->weibo);
			
			
			if ( !isset( $_GET['function'] )) {
				$soapServer->handle();
			} else {
				var_dump( $soapServer->getFunctions() );
			}
			
			
			
		}
		
		
		function test() {
			$client = new SoapClient(
				null,
				array(
					'location' => 'http://localhost:8888/'. site_url('api/webservices/'),
					'uri' => 'checkApi',
				)
			);
			$client->setUser('chepy6', '626626');
			var_dump( $client->__getFunctions() );
		}
		
		
		
		
		
		
		function chat() {
			
			function get_chats( $model, $model_id ) {
			
			}
			
			
			$options = array(
				'uri'=>'a',
			);
			$soapServer = new SoapServer(null, $options);
			
			$soapServer->addFunction('get_chats');
			
			$soapServer->handle();
		}
	}