<?php
	session_start();
	require '../includes/include.php';
	
	$sessionid = $_GET["sessionid"];
	$wpsc_cielo[$sessionid]=$_SESSION['wpsc_cielo_'.$sessionid];
	
	// Resgata último pedido feito da SESSION
	$ultimoPedido = $_SESSION["pedidos"]->count();
	
	$ultimoPedido -= 1;
	$_SESSION['wpsc_cielo_'.$sessionid]['codigo'] = $ultimoPedido;
	
	$Pedido = new Pedido();
	$Pedido->FromString($_SESSION["pedidos"]->offsetGet($ultimoPedido));
	
	// Consulta situação da transação
	$objResposta = $Pedido->RequisicaoConsulta();
	
	// Atualiza status
	$Pedido->status = $objResposta->status;
	
	// Grava status na session 
	if($Pedido->status === '0'){ $_SESSION['wpsc_cielo_'.$sessionid]['status'] = 0; }
	if($Pedido->status == '1'){ $_SESSION['wpsc_cielo_'.$sessionid]['status'] = 1; }
	if($Pedido->status == '2'){ $_SESSION['wpsc_cielo_'.$sessionid]['status'] = 2; }
	if($Pedido->status == '3'){ $_SESSION['wpsc_cielo_'.$sessionid]['status'] = 3; }
	if($Pedido->status == '4'){ $_SESSION['wpsc_cielo_'.$sessionid]['status'] = 4; }
	if($Pedido->status == '5'){ $_SESSION['wpsc_cielo_'.$sessionid]['status'] = 5; }
	if($Pedido->status == '6'){ $_SESSION['wpsc_cielo_'.$sessionid]['status'] = 6; }
	if($Pedido->status == '7'){ $_SESSION['wpsc_cielo_'.$sessionid]['status'] = 7; }
	if($Pedido->status == '8'){ $_SESSION['wpsc_cielo_'.$sessionid]['status'] = 8; }
	if($Pedido->status == '9'){ $_SESSION['wpsc_cielo_'.$sessionid]['status'] = 9; }
	if($Pedido->status == '10'){ $_SESSION['wpsc_cielo_'.$sessionid]['status'] = 10; }
	
	//$_SESSION['wpsc_cielo_'.$sessionid]['tid'] = $Pedido->tid; 
		
	// Atualiza Pedido da SESSION
	$StrPedido = $Pedido->ToString();
	$_SESSION["pedidos"]->offsetSet($ultimoPedido, $StrPedido);
	
	
	// Grava TID no bd
	//$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array( 'transactid' => $Pedido->tid ), array( 'sessionid' => $sessionid ));
	//$wpdb->update( WPSC_TABLE_PURCHASE_LOGS, array( 'authcode' => $Pedido->status ), array( 'sessionid' => $sessionid ));
	
	header('location: /biblioteca/resultado/?sessionid='.$sessionid);
	exit;
?>
<html>
	<head>
		<title>Loja Exemplo : Fechamento pedido</title>
		<script type="text/javascript">
			window.location.href = "/biblioteca/resultado/?sessionid=<?php echo $sessionid; ?>"
		</script>
	</head>
	<body>
	<center>

		<h3>Fechamento (<?php echo date("D M d H:i:s T Y")?>)</h3>
		<table border="1">
			<tr>
				<th>Número pedido</th>
				<th>Finalizado com sucesso?</th>
				<th>Transação</th>
				<th>Status transação</th>
			</tr>
			<tr>
				<td><?php echo $Pedido->dadosPedidoNumero; ?></td>
				<td><?php echo $finalizacao ? "sim" : "não"; ?></td>
				<td><?php echo $Pedido->tid; ?></td>
				<td style="color: red;"><?php echo $Pedido->getStatus(); ?></td>
			</tr>			
		</table>				
		<h3>XML</h3>
		<textarea name="xmlRetorno" cols="80" rows="25" readonly="readonly">
<?php echo htmlentities($objResposta->asXML()); ?>
		</textarea>
		
		<p><a href="index.php">Menu</a></p>
		<p><a href="pedidos.php">Pedidos</a></p>
	</center>
	
	</body>
</html>
