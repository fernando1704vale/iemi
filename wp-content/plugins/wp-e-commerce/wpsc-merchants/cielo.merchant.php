<?php
ob_start();

/// Informações Internas ///
$nzshpcrt_gateways[$num] = array(
	//This is the gateway name used in the front end of the site (checkout page)
	'name' => 'Cielo',	
	
	// This is the gateway image
	'image' => get_bloginfo('template_directory').'/images/cartoes.gif',
	
	//	This is the gateway name used internally
	'internalname' => 'gateway_cielo',
	
	//This is the name of the function that returns a form within the admin section where you would provide information regarding your gateway and account.
	'form' => 'form_cielo',
	
	//This is the name of the function used to validate and submit your form fields from the previous function (form_cielo)
	'submit_function' => 'submit_cielo',

	//This is the name of the function called on execution (usually the function that talks to your gateway).
	'function' => 'gateway_cielo',
	
	
);

function form_field_cielo($price=null){

	$output ='<p>Selecione o cartão:</p>';
	$output.='<div class="credit cards">';
	$output.='<label><input type="radio" name="codigoBandeira" value="visa"><img src="'.get_bloginfo('template_directory').'/images/card_visa.gif" alt="Visa" /></label>';
	$output.='<label><input type="radio" name="codigoBandeira" value="mastercard"><img src="'.get_bloginfo('template_directory').'/images/card_mastercard.gif" alt="Mastercard" /></label>';
	$output.='<label><input type="radio" name="codigoBandeira" value="diners"><img src="'.get_bloginfo('template_directory').'/images/card_diners.gif" alt="Diners" /></label>';
	$output.='<label><input type="radio" name="codigoBandeira" value="discover"><img src="'.get_bloginfo('template_directory').'/images/card_discover.gif" alt="Discover" /></label>';
	$output.='<label><input type="radio" name="codigoBandeira" value="elo"><img src="'.get_bloginfo('template_directory').'/images/card_elo.gif" alt="Elo" /></label>';
	$output.='<label><input type="radio" name="codigoBandeira" value="amex"><img id="card_amex" src="'.get_bloginfo('template_directory').'/images/card_amex.jpg" alt="Amex" /></label>';

	$output.='</div>';
	$output.='<div class="debit cards">';
	$output.='<label><input type="radio" name="codigoBandeira" value="visaelectron"><img src="'.get_bloginfo('template_directory').'/images/card_visaelectron.gif" alt="Visa Electron" /></label>';
	$output.='</div>';
	$output.='<p class="parcelamento"><label for="formaPagamentoCielo">Opções de parcelamento</label> ';
	$output.='<select name="formaPagamentoCielo" class="txt">';
	$output.='<option value="1">à vista</option>';
	$output.='<option value="2">2x</option>';
	$output.='<option value="3">3x</option>';
	$output.='<option value="4">4x</option>';
	//$output.='<option value="5">5x</option>';
	//$output.='<option value="6">6x</option>';
	$output.='</select></p>';
	$output.='<p class="description">O parcelamento é válido apenas para pagamentos com os cartões de crédito Visa, Mastercard, Diners e Elo. Para compras com cartão de crédito Discover ou cartões de débito, o pagamento deve ser à vista.</p>';

	//$output.='<input type="hidden" name="formaPagamento" value="1">';
	//$output.='<input type="hidden" name="tipoParcelamento" value="2">';
	//$output.='<input type="hidden" name="capturarAutomaticamente" value="true">';
	//$output.='<input type="hidden" name="indicadorAutorizacao" value="3">';
	
	/*if($price) { 
		$preco_cielo = $price['new_price'];  
	} else { 
		$preco_cielo = wpsc_cart_total(); 
	}
			
	$old_s = array('R', '$', '&#036;',  'span', 'class', 'pricedisplay', '=', '\'', '"', '<', '>', '/', ' ', '.', ',');
	$new_s = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
	$preco_cielo = str_replace($old_s, $new_s, $preco_cielo);
	$preco_cielo = substr($preco_cielo, 0, -2).'00'; */
			
	//$output.='<input type="hidden" name="produto" value="'.$preco_cielo.'">';
	$output.='</td>';
	$output.='</tr>';
	return $output;
}

/// Formulário Admin ///
function form_cielo(){

	$output ='<tr><td>';
	$output .='<label for="cielo_number">Número</label>';
	$output .='</td><td>';
	$output .='<input name="cielo_number" type="text" value="'.get_option('cielo_number').'" />';
	$output .='</td></tr>';
	
	$output .='<tr><td>';
	$output .='<label for="cielo_key">Chave</label>';
	$output .='</td><td>';
	$output .='<input name="cielo_key" type="text" value="'.get_option('cielo_key').'" />';
	$output .='</td></tr>';
	
	return $output;

}

/// Submit Formulário Admin ///
function submit_cielo(){

	if($_POST['cielo_number'] != null) {
		update_option('cielo_number', $_POST['cielo_number']);
	}

	if($_POST['cielo_key'] != null) {
		update_option('cielo_key', $_POST['cielo_key']);
	}

	return true;

}


function gateway_cielo($seperator, $sessionid) {

/////////////////////////////////////////////////////////////////
// RECUPERAÇÃO DAS INFORMAÇÕES DO PEDIDO
/////////////////////////////////////////////////////////////////
	//print_r($_POST);
	
	//$wpdb is the database handle, $wpsc_cart is the shopping cart object
	global $wpdb, $wpsc_cart;
	// Confirma se cartão foi selecionado
	if(!$_POST["codigoBandeira"]) {
		$_SESSION['cart_alert_payment'][10] = '<p class="alert alert-error">Selecione o cartão para finalizar a compra.</p>';
		header("location: /biblioteca/carrinho/");
		exit();
	}
	
	// Corrige dados para parcelamento
	if(intval($_POST["formaPagamentoCielo"])>1) {
		$_POST["tipoParcelamento"]=2;
	} else {
		$_POST["tipoParcelamento"]=1;
	}
	
	// Corrige tipo de autorização
	if($_POST["codigoBandeira"]=="diners" || $_POST["codigoBandeira"]=="discover" || $_POST["codigoBandeira"]=="elo") {
		$_POST["indicadorAutorizacao"]=3;//autorizar sem autenticar
	} else {
		$_POST["indicadorAutorizacao"]=2;//autorizar autenticada e não autenticada;
	}
	
	// Corrige dados para cartão de débito
	if($_POST["codigoBandeira"]=="visaelectron"){
		
		if(intval($_POST["formaPagamentoCielo"])>1) {
			$_SESSION['cart_alert_payment'][20] = '<p class="alert alert-error">Não é possível efetuar compras parceladas com cartão de débito. <br />Por favor modifique o campo "opções de parcelamento" para "à vista" ou utilize outra forma de pagamento.</p>';
			header("location: /biblioteca/carrinho/");
			exit();
		} else {
			$_POST["codigoBandeira"] = 'visa';
			$_POST["formaPagamentoCielo"]='A';
			$_POST["tipoParcelamento"]=1;
			$_POST["indicadorAutorizacao"]=1;//autorizar apenas se autenticada;
		}
	}
	
	// Corrige dados para cartão de crédito Discover
	if($_POST["codigoBandeira"]=="discover"){
		
		if(intval($_POST["formaPagamentoCielo"])>1) {
			$_SESSION['cart_alert_payment'][20] = '<p class="alert alert-error">Não é possível efetuar compras parceladas com cartão de crédito <strong>Discover</strong>. <br />Por favor modifique o campo "opções de parcelamento" para "à vista" ou utilize outra forma de pagamento.</p>';
			header("location: /biblioteca/carrinho/");
			exit();
		} else {
			$_POST["codigoBandeira"] = 'discover';
			$_POST["formaPagamentoCielo"]=1;
			$_POST["tipoParcelamento"]=1;
			$_POST["indicadorAutorizacao"]=3;//autorizar sem autenticar;
		}
	}

	$notes  = 'Forma de Pagamento: '.$_POST["codigoBandeira"]."\r\n";
	$notes .= 'Parcelamento: '.$_POST["formaPagamentoCielo"].'x';	

	
	//This changes the processed code for 1
	$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array( 'processed' => '1', 'notes' => $notes ), array( 'sessionid' => $sessionid ));

	//This grabs the purchase log id from the database that refers to the $sessionid
	$purchasesql = "SELECT * FROM ".WPSC_TABLE_PURCHASE_LOGS."
		WHERE sessionid = '".$sessionid."' 
		LIMIT 1";
	$purchase_log = $wpdb->get_row($purchasesql, ARRAY_A);
	//limpa a string de preco
	$old_s = array('R', '$', '&#036;',  'span', 'class', 'pricedisplay', '=', '\'', '"', '<', '>', '/', ' ', '.', ',');
	$new_s = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '');
	$totalprice_cielo = str_replace($old_s, $new_s, $purchase_log['totalprice']);
	$wpsc_cielo[$sessionid]["produto"]=$totalprice_cielo;
	$wpsc_cielo[$sessionid]["codigoBandeira"]=$_POST["codigoBandeira"];
	$wpsc_cielo[$sessionid]["formaPagamento"]=$_POST["formaPagamentoCielo"];
	$wpsc_cielo[$sessionid]["tipoParcelamento"]=$_POST["tipoParcelamento"];
	$wpsc_cielo[$sessionid]["capturarAutomaticamente"]=true;
	$wpsc_cielo[$sessionid]["indicadorAutorizacao"]=$_POST["indicadorAutorizacao"]; 
	$wpsc_cielo[$sessionid]["sessionid"]=$sessionid;
	
	$_SESSION['wpsc_cielo_'.$sessionid]=$wpsc_cielo[$sessionid];
	
	//print_r($wpsc_cielo[$sessionid]);
	
	header('location: /pagamento/cartao/?sessionid='.$sessionid); 
	
	exit;
	
	
}


?>
