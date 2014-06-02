<?php


/// Informações Internas ///
$nzshpcrt_gateways[$num] = array(
	'name' => 'IEMI', //This is the gateway name used in the front end of the site (checkout page)
	'image' => get_bloginfo('template_directory').'/images/boleto.gif', // This is the gateway image
	'internalname' => 'gateway_iemi',//	This is the gateway name used internally
	'form' => 'form_iemi',//This is the name of the function that returns a form within the admin section where you would provide information regarding your gateway and account.
	'submit_function' => 'submit_iemi',//This is the name of the function used to validate and submit your form fields from the previous function (form_iemi)
	'function' => 'gateway_iemi',//This is the name of the function called on execution (usually the function that talks to your gateway).
);

	function form_field_iemi(){
		$output ='<img class="flft" src="'.get_bloginfo('template_directory').'/images/boleto_g.gif" /> ';
		$output .='<p>A Cobrança Direta IEMI permite efetuar o pagamento através <br />de um boleto gerado por nossos consultores.</p>';
		$output.='<p><label for="formaPagamentoIEMI">Opções de parcelamento</label> ';
		$output.='<select name="formaPagamentoIEMI" id="formaPagamentoIEMI" class="txt" style="width:auto;">';
		$output.='<option value="1">à vista (desconto de 5%)</option>';
		$output.='<option value="2">2x</option>';
		$output.='<option value="3">3x</option>';
		$output.='<option value="4">4x</option>';
		//$output.='<option value="5">5x</option>';
		//$output.='<option value="6">6x</option>';
		global $price_iemi;
		$output.='</select> <span id="price_iemi">Preço à vista: '.$price_iemi.'</span></p>';
		
		return $output;
	}

/// Formulário Admin ///
function form_iemi() {
	$output ='<tr><td colspan="2"> </td></tr>';
	return $output;
}

/// Submit Formulário Admin ///
function submit_iemi() { return true; }


function gateway_iemi($seperator, $sessionid) {

/////////////////////////////////////////////////////////////////
// RECUPERAÇÃO DAS INFORMAÇÕES DO PEDIDO
/////////////////////////////////////////////////////////////////
	//print_r($_POST);
	
	//$wpdb is the database handle, $wpsc_cart is the shopping cart object
	global $wpdb, $wpsc_cart;

	$notes  = 'Forma de Pagamento: boleto bancário'."\r\n";
	$notes .= 'Parcelamento: '.$_POST["formaPagamentoIEMI"].'x';	

	//This changes the processed code for 2 e insert notes
	$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array( 'processed' => '2', 'notes' => $notes, ), array( 'sessionid' => $sessionid ) );

	$notes  = 'Forma de Pagamento: boleto bancário'."\r\n";
	$notes .= 'Parcelamento: '.$_POST["formaPagamentoIEMI"].'x';	
	
	// Corrige dados para parcelamento
	if(intval($_POST["formaPagamentoIEMI"])==1) {
		
		//This grabs the purchase log id from the database that refers to the $sessionid
		$purchasesql = "SELECT * FROM ".WPSC_TABLE_PURCHASE_LOGS."
			WHERE sessionid = '".$sessionid."' 
			LIMIT 1";
		$purchase_log = $wpdb->get_row($purchasesql, ARRAY_A);
		
		$totalprice = $purchase_log['totalprice'] + $purchase_log['discount_value'];
		$discount_value = $totalprice * 0.05 + $purchase_log['discount_value'];
		$totalprice = $totalprice - $discount_value;
		if($purchase_log['discount_data']) {
			$discount_data = $purchase_log['discount_data'].' + Pagamento à Vista no Boleto';
		} else {
			$discount_data = 'Pagamento à Vista';
		}
		

		
		$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, 
			array( 
				'totalprice' => $totalprice,
				'discount_value' => $discount_value,
				'discount_value' => $discount_value,
				'discount_data' => $discount_data,
			), 
			array( 'sessionid' => $sessionid ) 
		);
		
	}
	
	
	header('location: /biblioteca/resultado/?sessionid='.$sessionid); 
	
	exit;
	
	
}


?>
