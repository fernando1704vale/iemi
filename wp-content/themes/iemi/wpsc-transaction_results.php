<?php
	global $purchase_log, $errorcode, $sessionid, $echo_to_screen, $cart, $message_html, $wpdb, $wpsc_cart, $wpsc_checkout, $wpsc_gateway;
	$sessionid = $_GET['sessionid'];
	
	//This grabs the purchase log id from the database that refers to the $sessionid
	$purchasesql = "SELECT * FROM ".WPSC_TABLE_PURCHASE_LOGS."
		WHERE sessionid = '".$sessionid."' 
		LIMIT 1";
	$purchase_log = $wpdb->get_row($purchasesql, ARRAY_A);
	
	
	//print_r($purchase_log);
?>

<div class="wrap">
	
	
<?php
	if($purchase_log['gateway']=="gateway_cielo") {
		// verifica se foi autorizado o pagamento
		if($_SESSION['wpsc_cielo_'.$sessionid]['status'] == '4' || $_SESSION['wpsc_cielo_'.$sessionid]['status'] == '6' ) {
		
			// Muda status do pedido
			$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array( 'processed' => '3' ), array( 'sessionid' => $sessionid ));
			$purchase_log['processed'] = 3;
			
			// Grava TID no bd
			$stid = simplexml_load_string($_SESSION['pedidos'][$_SESSION['wpsc_cielo_'.$sessionid]['codigo']]);
			$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array( 'transactid' => $stid->tid ), array( 'sessionid' => $sessionid ));
			// grava status do pedido no bd
			//$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array( 'authcode' => $Pedido->status ), array( 'sessionid' => $sessionid ));	
			
			// Limpa Carrinho
			$wpsc_cart->empty_cart();
			
			if(!$purchase_log['email_sent'] || isset($_GET['email_buyer_id'])){
				// Cria Email
				global $current_user;
				get_currentuserinfo();
			
				$to = $current_user->user_email;

				$telefone = $wpdb->get_var( "SELECT value FROM ".WPSC_TABLE_SUBMITED_FORM_DATA." WHERE log_id=".$purchase_log['id']." AND form_id=18 LIMIT 1" );
				$address = $wpdb->get_var( "SELECT value FROM ".WPSC_TABLE_SUBMITED_FORM_DATA." WHERE log_id=".$purchase_log['id']." AND form_id=13 LIMIT 1" );
				$zipcode = $wpdb->get_var( "SELECT value FROM ".WPSC_TABLE_SUBMITED_FORM_DATA." WHERE log_id=".$purchase_log['id']." AND form_id=17 LIMIT 1" );
				$city = $wpdb->get_var( "SELECT value FROM ".WPSC_TABLE_SUBMITED_FORM_DATA." WHERE log_id=".$purchase_log['id']." AND form_id=14 LIMIT 1" );
				$estate = $wpdb->get_var( "SELECT value FROM ".WPSC_TABLE_SUBMITED_FORM_DATA." WHERE log_id=".$purchase_log['id']." AND form_id=15 LIMIT 1" );

				$subject = "IEMI - Pedido ".$purchase_log['id'];
				$headers = "From: IEMI <iemi@iemi.com.br>\r\n";
				$headers .= "Reply-To: IEMI <iemi@iemi.com.br>\r\n";
				$headers .= "Return-Path: IEMI <iemi@iemi.com.br>\r\n";

				// cria mensagem de confirmação
				$message = "Olá, ".$current_user->user_firstname." ".$current_user->user_lasttname."!\n\n";
				$message .= "Seu pedido ".$purchase_log['id']." foi aprovado.\n\n";
				$message .= "Daremos continuidade ao processamento do seu pedido. Um consultor do IEMI entrará em contato confirmando o envio de seus estudos.\n\n";
				$message .= "Descrição de seu pedido:\n\n";
				$message .= "------------------------------------------------------------\n\n";
				$message .= "Estudos:\n";

				// cria mensagem de aviso
				$message_cc  = "O pedido ".$purchase_log['id']." foi processado.\n\n";
				$message_cc .= "É necessário entrar em contato com ".$current_user->user_firstname." ".$current_user->user_lasttname." para confirmar dados de compra e envio da compra.\n\n";
				$message_cc .= "------------------------------------------------------------\n\n";
				$message_cc .= "INFORMAÇÕES DE CONTATO:\n\n";
				$message_cc .= "Perfil: http://www.iemi.com.br/wp-admin/user-edit.php?user_id=".$current_user->ID."\n\n";
				$message_cc .= "Nome: ".$current_user->user_firstname." ".$current_user->user_lasttname."\n";
				$message_cc .= "Email: ".$current_user->user_email."\n";
				$message_cc .= "Telefone: ".$telefone."\n\n";
				$message_cc .= "------------------------------------------------------------\n\n";
				$message_cc .= "DESCRIÇÃO DO PEDIDO:\n\n";
				$message_cc .= "Pedido: http://www.iemi.com.br/wp-admin/index.php?page=wpsc-sales-logs&purchaselog_id=".$purchase_log['id']."\n\n";			
				$message_cc .= "Estudos:\n";

			
				$cartsql = "SELECT * FROM ".WPSC_TABLE_CART_CONTENTS." 
					WHERE purchaseid=".$purchase_log['id'];
				$cart = $wpdb->get_results($cartsql, ARRAY_A);
			
				foreach( $cart as $row ) {	
					$message .= " -  ".$row['quantity']."x ".$row['name']."\n";
					$message_cc .= " -  ".$row['quantity']."x ".$row['name']."\n";
				}
				$message .= "\nPreço total: ".wpsc_currency_display($purchase_log[totalprice]+$purchase_log[discount_value], array( 'display_as_html' => false ))."\n";
				$message .= "Desconto: ".wpsc_currency_display($purchase_log[discount_value], array( 'display_as_html' => false ))."\n";
				$message .= "Preço final: ".wpsc_currency_display($purchase_log[totalprice], array( 'display_as_html' => false ))."\n\n";

				$message_cc .= "\nPreço total: ".wpsc_currency_display($purchase_log[totalprice]+$purchase_log[discount_value], array( 'display_as_html' => false ))."\n";
				$message_cc .= "Desconto: ".wpsc_currency_display($purchase_log[discount_value], array( 'display_as_html' => false ))."\n";
				$message_cc .= "Preço final: ".wpsc_currency_display($purchase_log[totalprice], array( 'display_as_html' => false ))."\n\n";
			
				if($_SESSION['wpsc_cielo_'.$sessionid]['formaPagamento']==1) { $formaPagamento = "Cartão de Crédito"; }
				if($_SESSION['wpsc_cielo_'.$sessionid]['formaPagamento']==2) { $formaPagamento = "Cartão de Crédito"; }
				if($_SESSION['wpsc_cielo_'.$sessionid]['formaPagamento']==3) { $formaPagamento = "Cartão de Crédito"; }
				if($_SESSION['wpsc_cielo_'.$sessionid]['formaPagamento']=='A') { $formaPagamento = "Cartão de Débito"; }
			
				if($_SESSION['wpsc_cielo_'.$sessionid]['codigoBandeira']=='visa') { $codigoBandeira = "Visa"; }
				if($_SESSION['wpsc_cielo_'.$sessionid]['codigoBandeira']=='mastercard') { $codigoBandeira = "Mastercard"; }
				if($_SESSION['wpsc_cielo_'.$sessionid]['codigoBandeira']=='diners') { $codigoBandeira = "Diners"; }
				if($_SESSION['wpsc_cielo_'.$sessionid]['codigoBandeira']=='discover') { $codigoBandeira = "Discover"; }
				if($_SESSION['wpsc_cielo_'.$sessionid]['codigoBandeira']=='elo') { $codigoBandeira = "Elo"; }
			
				$message .= "Forma de Pagamento: ".$formaPagamento." – ".$codigoBandeira."\n\n";
				$message_cc .= "Forma de Pagamento: ".$formaPagamento." – ".$codigoBandeira."\n\n";
				
			
				$message .= "Endereço de Entrega:\n";
				$message .= $address."\n";
				$message .= "".$zipcode." ".$city." - ".$estate."\n";
				$message .= "\n------------------------------------------------------------\n\n";

				$message_cc .= "Endereço de Entrega:\n";
				$message_cc .= $address."\n";
				$message_cc .= "".$zipcode." ".$city." - ".$estate."\n";
				$message_cc .= "\n------------------------------------------------------------\n\n";
			
				$message .= "Em caso de dúvida, entre em contato através do e-mail iemi@iemi.com.br ou pelo telefone 11 3238-5800.\n\n";
				$message .= "Obrigado! \n\n";
				$message .= "Equipe IEMI \n\n";
			
				if( wp_mail( $to, $subject, $message, $headers ) ) {
					wp_mail( 'faleconosco@iemi.com.br', $subject, $message_cc, $headers );
					$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array( 'email_sent' => '1' ), array( 'sessionid' => $sessionid ));
				}
				
			}
			
			?>
			<p>O pagamento de sua compra foi autorizado mediante o código <?php echo $purchase_log['id']?>. Obrigado!</p>
			<p>Enviamos um e-mail com informações desta compra. Um consultor do IEMI entrará em contato confirmando o envio de seus estudos.</p>
			<p>Em caso de dúvida, entre em contato através do e-mail <a href="mailto:iemi@iemi.com.br">iemi@iemi.com.br</a> ou pelo telefone 11 3238-5800.</p>

		<?php 
		// verifica se não foi autorizado
		} elseif($_SESSION['wpsc_cielo_'.$sessionid]['status'] == '3' || $_SESSION['wpsc_cielo_'.$sessionid]['status'] == '5') { 		
			// Muda status do pedido
			$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array( 'processed' => '6' ), array( 'sessionid' => $sessionid ));
			$purchase_log['processed'] = 6;
			?>
			<p>A compra não foi concluída pois o pagamento não foi autorizado por sua operadora de cartão. Para mais esclarecimentos sobre este questão, por favor entre em contato com a central de atendimento de seu cartão.</p>
			<p>Para concluir a compra através de outra forma de pagamento, <a href="/biblioteca/carrinho/">retorne ao carrinho clicando aqui</a> e conclua a compra utilizando o novo método de pagamento.</p>

		<?php 
		// caso não seja possível verificar a autorização da Cielo
		} else { 
			// Muda status do pedido
			$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array( 'processed' => '6' ), array( 'sessionid' => $sessionid ));
			$purchase_log['processed'] = 6;
			?>

			<p>A compra não foi concluída pois o pagamento não pode ser verificado. Para mais esclarecimentos sobre este questão, por favor entre em contato com a central de atendimento de seu cartão.</p>
			<p>Para concluir a compra através de outra forma de pagamento, <a href="/biblioteca/carrinho/">retorne ao carrinho clicando aqui</a> e conclua a compra utilizando o novo método de pagamento.</p>



		<?php 
		}
		
	} elseif($purchase_log['gateway']=="gateway_iemi") { 
		
		//This changes the processed code for 2
		//$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array( 'processed' => '2' ), array( 'sessionid' => $sessionid ));
		
		
		// Limpa Carrinho
		$wpsc_cart->empty_cart();
		
		if(!$purchase_log['email_sent'] || isset($_GET['email_buyer_id'])){
			// Cria Email
			global $current_user;
			get_currentuserinfo();
		
			$telefone = $wpdb->get_var( "SELECT value FROM ".WPSC_TABLE_SUBMITED_FORM_DATA." WHERE log_id=".$purchase_log['id']." AND form_id=18 LIMIT 1" );
			$address = $wpdb->get_var( "SELECT value FROM ".WPSC_TABLE_SUBMITED_FORM_DATA." WHERE log_id=".$purchase_log['id']." AND form_id=13 LIMIT 1" );
			$zipcode = $wpdb->get_var( "SELECT value FROM ".WPSC_TABLE_SUBMITED_FORM_DATA." WHERE log_id=".$purchase_log['id']." AND form_id=17 LIMIT 1" );
			$city = $wpdb->get_var( "SELECT value FROM ".WPSC_TABLE_SUBMITED_FORM_DATA." WHERE log_id=".$purchase_log['id']." AND form_id=14 LIMIT 1" );
			$estate = $wpdb->get_var( "SELECT value FROM ".WPSC_TABLE_SUBMITED_FORM_DATA." WHERE log_id=".$purchase_log['id']." AND form_id=15 LIMIT 1" );

			$subject = "IEMI - Pedido ".$purchase_log['id'];
			$headers = "From: IEMI <iemi@iemi.com.br>\r\n";
			$headers .= "Reply-To: IEMI <iemi@iemi.com.br>\r\n";
			$headers .= "Return-Path: IEMI <iemi@iemi.com.br>\r\n";

			// cria mensagem de aviso
			$message  = "O pedido ".$purchase_log['id']." foi processado.\n\n";
			$message .= "É necessário entrar em contato com ".$current_user->user_firstname." ".$current_user->user_lasttname." para fornecer informações sobre o pagamento.\n\n";
			
			$message .= "------------------------------------------------------------\n\n";
			$message .= "INFORMAÇÕES DE CONTATO:\n\n";
			
			$message .= "Perfil: http://www.iemi.com.br/wp-admin/user-edit.php?user_id=".$current_user->ID."\n\n";
			$message .= "Nome: ".$current_user->user_firstname." ".$current_user->user_lasttname."\n";
			$message .= "Email: ".$current_user->user_email."\n";
			$message .= "Telefone: ".$telefone."\n\n";
						
			$message .= "------------------------------------------------------------\n\n";
			$message .= "DESCRIÇÃO DO PEDIDO:\n\n";
			
			$message .= "Pedido: http://www.iemi.com.br/wp-admin/index.php?page=wpsc-sales-logs&purchaselog_id=".$purchase_log['id']."\n\n";			
			$message .= "Estudos:\n";
		
			$cartsql = "SELECT * FROM ".WPSC_TABLE_CART_CONTENTS." 
				WHERE purchaseid=".$purchase_log['id'];
			$cart = $wpdb->get_results($cartsql, ARRAY_A);
		
			foreach( $cart as $row ) {	
				$message .= " -  ".$row['quantity']."x ".$row['name']."\n";
			}
			$message .= "\nPreço total: ".wpsc_currency_display($purchase_log[totalprice]+$purchase_log[discount_value], array( 'display_as_html' => false ))."\n";
			$message .= "Desconto: ".wpsc_currency_display($purchase_log[discount_value], array( 'display_as_html' => false ))."\n";
			$message .= "Preço final: ".wpsc_currency_display($purchase_log[totalprice], array( 'display_as_html' => false ))."\n\n";	
			$message .= "Forma de Pagamento: Cobrança Direta IEMI\n\n";
			
		
			$message .= "Endereço de Entrega:\n";
			$message .= $address."\n";
			$message .= "".$zipcode." ".$city." - ".$estate."\n";
		
			$message .= "\n------------------------------------------------------------\n\n";
		
			wp_mail( 'faleconosco@iemi.com.br', $subject, $message, $headers );
			
		}
	?>	
	
	<p>Seu pedido foi processado mediante o código <?php echo $purchase_log['id']?>. Para concluí-lo, um atendente do IEMI entrará em contato para fornecer informações adicionais sobre a forma de pagamento.</p>
	<p>Em caso de dúvida, entre em contato com o IEMI através do e-mail <a href="mailto:iemi@iemi.com.br">iemi@iemi.com.br</a> ou pelo telefone 11 3238-5800.</p>

<?php

 	} else {
?>
	<p>Não foi possível concluir sua compra, por favor <a href="/biblioteca/carrinho/">retorne ao carrinho clicando aqui</a> para concluir sua compra
<?php
	}
?>

</div>
