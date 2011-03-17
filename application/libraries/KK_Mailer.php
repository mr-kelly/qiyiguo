<?php
	require_once('PHPMailer_v5.1/class.phpmailer.php');
	
	class KK_Mailer {
		
		
		
		
// 			$option = array(
// 				'to' => 'chepy.v@gmail.com',
// 				'from' => 'kiwiguo.net@gmail.com',
// 				'from_name' => '「奇异果」',
// 				'subject' => '默认主题',
// 				'body' => '默认的邮件内容',
// 				'reply_to' => array(
// 					array( 'kiwiguo.net@gmail.com', '「奇异果」' ),
// 					array( 'chepy.v@gmail.com', 'Mr Kelly' ),
// 				),
// 			);	
		function send_mail( $option = array('subject'=>'custom') ) {
			$ci =& get_instance();
			
			$default = array(
				'to' => array(
					array( 'chepy.v@gmail.com', 'Mrkelly'),
				),
				'from' => 'qiyiguo.cc@foxmail.com',
				'from_name' => '「奇异果」',
				'subject' => '默认主题',
				'body' => '默认的邮件内容',
				'reply_to' => array(
					//array( 'bnu.sife@gmail.com', '北师珠赛扶' ),
					array( 'chepy.v@gmail.com', 'Mr Kelly' ),
				),
			);
			
			$option += $default ; // 合並默認， 沒聲明設置的， 采用默認值
			
			
			$mail = new PHPMailer();
			
			$mail->CharSet = "UTF-8";
			$mail->IsSMTP();
// 			$mail->SMTPAuth = true;
// 			$mail->SMTPSecure = 'ssl';
// 			$mail->Host = 'smtp.gmail.com';
// 			$mail->Port = 465;
// 			
// 			$mail->Username = 'qiyiguo.cc@gmail.com';
// 			$mail->Password = '23110388';
			
			$mail->SMTPAuth = $ci->config->item('mail_smtp_auth');
			$mail->SMTPSecure = $ci->config->item('mail_smtp_secure');
			$mail->Host = $ci->config->item('mail_smtp_server');
			$mail->Port = $ci->config->item('mail_smtp_port');
			
			$mail->Username = $ci->config->item('mail_username');
			$mail->Password = $ci->config->item('mail_password');
			
			
			
			$mail->From = $option['from'];
			$mail->FromName = $option['from_name'];
			$mail->Subject = $option['subject'];
			
			$mail->AltBody = $option['body'];
			
			$mail->MsgHTML( $option['body'] );
			
			// reply_to是一个数组，包含回复多人
			foreach ( $option['reply_to'] as $reply_to ) {
				$mail->AddReplyTo( $reply_to[0] , $reply_to[1] );
			}
			
			//$mail->AddAttachment("/path/to/file.zip");             // attachment
			//$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); // attachment
			
			// to也是一个数组,多人
			foreach( $option['to'] as $to ) {
				$mail->AddAddress( $to[0], $to[1] );
			}
			
			//$mail->AddAddress( $option['to'] );
			
			$mail->IsHTML( true );
			
			
			return $mail->Send();
			
			if(!$mail->Send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			} else {
				echo "Message has been sent";
			}
			
		}
	}