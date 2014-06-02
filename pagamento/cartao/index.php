<?php 
	session_start();
	require "../includes/include.php";
	$sessionid = $_GET["sessionid"];
	$wpsc_cielo[$sessionid]=$_SESSION['wpsc_cielo_'.$sessionid];
	//var_dump($_SESSION);
	//print($sessionid);
?>


<!DOCTYPE html>
<html dir="ltr" lang="pt-BR">
<head>
<meta charset="UTF-8" />
	<title>Redirecionando | IEMI</title>
	<link rel="stylesheet" type="text/css" media="all" href="http://www.iemi.com.br/wp-content/themes/iemi/fontface/stylesheet.css" />
	<link rel="stylesheet" type="text/css" media="all" href="http://www.iemi.com.br/wp-content/themes/iemi/style.css?0547" />
	<link rel="stylesheet" href="http://www.iemi.com.br/wp-content/themes/iemi/colorbox/colorbox.css" type="text/css" media="screen" />		
	<link rel='stylesheet' id='wpsc-thickbox-css'  href='http://www.iemi.com.br/wp-content/plugins/wp-e-commerce/wpsc-core/js/thickbox.css?ver=3.8.6.1.438283' type='text/css' media='all' />
	<link rel='stylesheet' id='wpsc-theme-css-css'  href='http://www.iemi.com.br/wp-content/themes/iemi/wpsc-default.css?ver=3.8.6.1.438283' type='text/css' media='all' />
	<link rel='stylesheet' id='wpsc-theme-css-compatibility-css'  href='http://www.iemi.com.br/wp-content/plugins/wp-e-commerce/wpsc-theme/compatibility.css?ver=3.8.6.1.438283' type='text/css' media='all' />
	<link rel='stylesheet' id='wp-e-commerce-dynamic-css'  href='http://www.iemi.com.br/index.php?wpsc_user_dynamic_css=true&#038;category&#038;ver=3.8.6.1.438283' type='text/css' media='all' />
	<link rel='stylesheet' id='contact-form-7-css'  href='http://www.iemi.com.br/wp-content/plugins/contact-form-7/styles.css?ver=3.0' type='text/css' media='all' />

	<script type='text/javascript' src='http://www.iemi.com.br/wp-includes/js/l10n.js?ver=20101110'></script>
	<script type='text/javascript' src='http://www.iemi.com.br/wp-includes/js/jquery/jquery.js?ver=1.6.1'></script>
	<script type='text/javascript' src='http://www.iemi.com.br/wp-content/plugins/wp-e-commerce/wpsc-core/js/wp-e-commerce.js?ver=3.8.6.1.438283'></script>
	<script type='text/javascript' src='http://www.iemi.com.br/wp-content/plugins/wp-e-commerce/wpsc-core/js/jquery.infieldlabel.min.js?ver=3.8.6.1.438283'></script>
	<script type='text/javascript' src='http://www.iemi.com.br/wp-content/plugins/wp-e-commerce/wpsc-core/js/ajax.js?ver=3.8.6.1.438283'></script>
	<script type='text/javascript'>
	/* <![CDATA[ */
	var wpsc_ajax = {
		ajaxurl: "http://www.iemi.com.br/wp-admin/admin-ajax.php"
	};
	/* ]]> */
	</script>
	<script type='text/javascript' src='http://www.iemi.com.br/index.php?wpsc_user_dynamic_js=true&#038;ver=3.8.6.1.438283'></script>
	<script type='text/javascript' src='http://www.iemi.com.br/wp-content/plugins/wp-e-commerce/wpsc-admin/js/jquery.livequery.js?ver=1.0.3'></script>
	<script type='text/javascript' src='http://www.iemi.com.br/wp-content/plugins/wp-e-commerce/wpsc-core/js/user.js?ver=3.8.6.1438283'></script>
	<script type='text/javascript' src='http://www.iemi.com.br/wp-content/plugins/wp-e-commerce/wpsc-core/js/thickbox.js?ver=Instinct_e-commerce'></script>

	<style type="text/css" media="screen">
		html { margin-top: 28px !important; }
		* html body { margin-top: 28px !important; }
	</style>

	<script src="http://www.iemi.com.br/wp-content/themes/iemi/jquery.cycle.all.js" type="text/javascript"></script>
	<script src="http://www.iemi.com.br/wp-content/themes/iemi/colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
	<script src="http://www.iemi.com.br/wp-content/themes/iemi/script.js?0547" type="text/javascript"></script>
	
</head>

<body class="redirect-cielo">
<div id="container">
	<div id="header">
		<div id="logo">
			<a href="http://www.iemi.com.br/" title="IEMI" rel="home">IEMI</a>
		</div>
	</div>

	<div id="wrapper">
		<div id="content" class="entry ">	
			<h1 class="entry-title">Redirecionando</h1>
			<div class="entry-content">
				<div class="wrap">
					<p>Para concluir sua compra, você será direcionado ao ambiente seguro de sua operadora de cartão.</p>
					<p>Após a digitação dos dados de seu cartão, você será redirecionado novamente à página de conclusão de compra.</p>

<?php
	$Pedido = new Pedido();
	
	// Lê dados do $_POST
	
	$Pedido->formaPagamentoBandeira = $wpsc_cielo[$sessionid]["codigoBandeira"]; 
	if($wpsc_cielo[$sessionid]["formaPagamento"] != "A" && $wpsc_cielo[$sessionid]["formaPagamento"] != "1"){
		$Pedido->formaPagamentoProduto = $wpsc_cielo[$sessionid]["tipoParcelamento"];
		$Pedido->formaPagamentoParcelas = $wpsc_cielo[$sessionid]["formaPagamento"];
	} else {
		$Pedido->formaPagamentoProduto = $wpsc_cielo[$sessionid]["formaPagamento"];
		$Pedido->formaPagamentoParcelas = 1;
	}
	
	$Pedido->dadosEcNumero = CIELO;
	$Pedido->dadosEcChave = CIELO_CHAVE;
	
	$Pedido->capturar = $wpsc_cielo[$sessionid]["capturarAutomaticamente"];	
	$Pedido->autorizar = $wpsc_cielo[$sessionid]["indicadorAutorizacao"];
	
	$Pedido->dadosPedidoNumero = $wpsc_cielo[$sessionid]["sessionid"];
	
	//$wpsc_cielo[$sessionid]["produto"] = 100;
	$Pedido->dadosPedidoValor = $wpsc_cielo[$sessionid]["produto"];
	
	
	$Pedido->urlRetorno = 'http://www.iemi.com.br/pagamento/cartao/retorno.php?sessionid='.$sessionid;
	
	// ENVIA REQUISIÇÃO SITE CIELO
	$objResposta = $Pedido->RequisicaoTransacao(false);
	
	$Pedido->tid = $objResposta->tid;
	$Pedido->pan = $objResposta->pan;
	$Pedido->status = $objResposta->status;
	
	
	
	$urlAutenticacao = "url-autenticacao";
	$Pedido->urlAutenticacao = $objResposta->$urlAutenticacao;

	// Serializa Pedido e guarda na SESSION
	$StrPedido = $Pedido->ToString();
	$_SESSION["pedidos"]->append($StrPedido);
	
	//print_r($Pedido);

?>

				<p>Caso o redirecionamento não aconteça automaticamente, <a href="<?php echo $Pedido->urlAutenticacao; ?>">clique aqui para continuar</a>.</p>
				
				<script type="text/JavaScript">
					
					setTimeout("location.href = '<?php echo $Pedido->urlAutenticacao; ?>';",5000);
					
				</script>
				</div>
			</div>
		</div>
		<p class="clr"></p>
	</div>	
	<div class="window"></div>
	<div id="footer">
		<div id="footer-nav">
		</div>
	</div> 
</div>

</body>
</html>



