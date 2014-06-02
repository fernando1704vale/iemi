<?php //get_header(); ?>
<?php 

///////////////////////////// START OF ERRORHANDLING.PHP //
	$logFile = "cielo/log.log";
	
	// Verifica em Resposta XML a ocorrência de erros 
	// Parâmetros: XML de envio, XML de Resposta
	function VerificaErro($vmPost, $vmResposta) {
		$error_msg = null;
		
		try {
			if(stripos($vmResposta, "SSL certificate problem") !== false) {
				throw new Exception("CERTIFICADO INVÁLIDO - O certificado da transação não foi aprovado", "099");
			}
			
			$objResposta = simplexml_load_string($vmResposta, null, LIBXML_NOERROR);
			if($objResposta == null) {
				throw new Exception("HTTP READ TIMEOUT - o Limite de Tempo da transação foi estourado", "099");
			}
		}
		catch (Exception $ex) {
			$error_msg = "     Código do erro: " . $ex->getCode() . "\n";
			$error_msg .= "     Mensagem: " . $ex->getMessage() . "\n";
			
			// Gera página HTML
			echo '<html><head><title>Erro na transação</title></head><body>';
			echo '<span style="color:red;, font-weight:bold;">Ocorreu um erro em sua transação!</span>' . '<br />';
			echo '<span style="font-weight:bold;">Detalhes do erro:</span>' . '<br />';
			echo '<pre>' . $error_msg . '<br /><br />';
			//echo "     XML de envio: " . "<br />" . htmlentities($vmPost);
			echo '</pre><p><center>';
			echo '<input type="button" value="Retornar" onclick="javascript:if(window.opener!=null){window.opener.location.reload();' . 
				 'window.close();}else{window.location.href=' . "'index.php';" . '}" />';
			echo '</center></p></body></html>';
			$error_msg .= "     XML de envio: " . "\n" . $vmPost;
		
			// Dispara o erro
			trigger_error($error_msg, E_USER_ERROR);
			
			return true;
		}
		
		if($objResposta->getName() == "erro") {
			$error_msg = "     Código do erro: " . $objResposta->codigo . "\n";
			$error_msg .= "     Mensagem: " . utf8_decode($objResposta->mensagem) . "\n";
			// Gera página HTML
			echo '<html><head><title>Erro na transação</title></head><body>';
			echo '<span style="color:red;, font-weight:bold;">Ocorreu um erro em sua transação!</span>' . '<br />';
			echo '<span style="font-weight:bold;">Detalhes do erro:</span>' . '<br />';
			echo '<pre>' . $error_msg . '<br /><br />';
			//echo "     XML de envio: " . "<br />" . htmlentities($vmPost);
			echo '</pre><p><center>';
			echo '<input type="button" value="Retornar" onclick="javascript:if(window.opener!=null){window.opener.location.reload();' . 
				 'window.close();}else{window.location.href=' . "'index.php';" . '}" />';
			echo '</center></p></body></html>';
			$error_msg .= "     XML de envio: " . "\n" . $vmPost;
		
			// Dispara o erro
			trigger_error($error_msg, E_USER_ERROR);
		}
	}
	
	
	// Grava erros no arquivo de log
	function Handler($eNum, $eMsg, $file, $line, $eVars) {
		$logFile = "cielo/log.log";
		$e = "";
		$Data = date("Y-m-d H:i:s (T)");
		
		$errortype = array(
			E_ERROR 			=> 'ERROR',
			E_WARNING			=> 'WARNING',
			E_PARSE				=> 'PARSING ERROR',
			E_NOTICE			=> 'RUNTIME NOTICE',
			E_CORE_ERROR		=> 'CORE ERROR',
			E_CORE_WARNING      => 'CORE WARNING',
			E_COMPILE_ERROR     => 'COMPILE ERROR',
			E_COMPILE_WARNING   => 'COMPILE WARNING',
			E_USER_ERROR        => 'ERRO NA TRANSACAO',
			E_USER_WARNING      => 'USER WARNING',
			E_USER_NOTICE       => 'USER NOTICE',
			E_STRICT            => 'RUNTIME NOTICE',
			E_RECOVERABLE_ERROR	=> 'CATCHABLE FATAL ERROR'
		);

		$e .= "**********************************************************\n";
		$e .= $eNum . " " . $errortype[$eNum] . " - ";
		$e .= $Data . "\n";
		$e .= "     ARQUIVO: " . $file . "(Linha " . $line .")\n";
		$e .= "     MENSAGEM: " . "\n" . $eMsg . "\n\n";
		
		error_log($e, 3, $logFile);
		
		exit();
	}
	
	$olderror = set_error_handler("Handler");
	ini_set('error_log', $logFile);
	ini_set('log_errors', 'On');
	ini_set('display_errors', 'On');
	ini_set("date.timezone", "America/Sao_Paulo");
///////////////////////////// END OF ERRORHANDLING.PHP //


///////////////////////////// START OF PEDIDO.PHP //
	
	class Pedido{
		private $logger;
				
		public $dadosEcNumero;
		public $dadosEcChave;
		
		public $dadosPortadorNumero;
		public $dadosPortadorVal;
		public $dadosPortadorInd;
		public $dadosPortadorCodSeg;
		public $dadosPortadorNome;
		
		public $dadosPedidoNumero;
		public $dadosPedidoValor;
		public $dadosPedidoMoeda = "986";
		public $dadosPedidoData;
		public $dadosPedidoDescricao;
		public $dadosPedidoIdioma = "PT";
		
		public $formaPagamentoBandeira;
		public $formaPagamentoProduto;
		public $formaPagamentoParcelas;
		
		public $urlRetorno;
		public $autorizar;
		public $capturar;
		
		public $tid;
		public $status;
		public $urlAutenticacao;
		
		const ENCODING = "ISO-8859-1";
		
		function __construct(){
			// cria um logger
			$this->logger = new Logger();
		}
		
		// Geradores de XML
		private function XMLHeader(){
			return '<?xml version="1.0" encoding="' . self::ENCODING . '" ?>'; 
		}
		
		private function XMLDadosEc(){
			$msg = '<dados-ec>' . "\n      " .
						'<numero>'
							. $this->dadosEcNumero . 
						'</numero>' . "\n      " .
						'<chave>'
							. $this->dadosEcChave .
						'</chave>' . "\n   " .
					'</dados-ec>';
							
			return $msg;
		}
		
		private function XMLDadosPortador(){
			$msg = '<dados-portador>' . "\n      " . 
						'<numero>' 
							. $this->dadosPortadorNumero .
						'</numero>' . "\n      " .
						'<validade>'
							. $this->dadosPortadorVal .
						'</validade>' . "\n      " .
						'<indicador>'
							. $this->dadosPortadorInd .
						'</indicador>' . "\n      " .
						'<codigo-seguranca>'
							. $this->dadosPortadorCodSeg .
						'</codigo-seguranca>' . "\n   ";
			
			// Verifica se Nome do Portador foi informado
			if($this->dadosPortadorNome != null && $this->dadosPortadorNome != ""){
				$msg .= '   <nome-portador>'
							. $this->dadosPortadorNome .
						'</nome-portador>' . "\n   " ;
			}
			
			$msg .= '</dados-portador>';
			
			return $msg;
		}
		
		private function XMLDadosCartao(){
			$msg = '<dados-cartao>' . "\n      " . 
						'<numero>' 
							. $this->dadosPortadorNumero .
						'</numero>' . "\n      " .
						'<validade>'
							. $this->dadosPortadorVal .
						'</validade>' . "\n      " .
						'<indicador>'
							. $this->dadosPortadorInd .
						'</indicador>' . "\n      " .
						'<codigo-seguranca>'
							. $this->dadosPortadorCodSeg .
						'</codigo-seguranca>' . "\n   ";

			// Verifica se Nome do Portador foi informado				
			if($this->dadosPortadorNome != null && $this->dadosPortadorNome != ""){
				$msg .= '   <nome-portador>'
							. $this->dadosPortadorNome .
						'</nome-portador>' . "\n   " ;
			}
			
			$msg .= '</dados-cartao>';
			
			return $msg;
		}
		
		private function XMLDadosPedido(){
			$this->dadosPedidoData = date("Y-m-d") . "T" . date("H:i:s");
			$msg = '<dados-pedido>' . "\n      " .
						'<numero>'
							. $this->dadosPedidoNumero . 
						'</numero>' . "\n      " .
						'<valor>'
							. $this->dadosPedidoValor .
						'</valor>' . "\n      " .
						'<moeda>'
							. $this->dadosPedidoMoeda .
						'</moeda>' . "\n      " .
						'<data-hora>'
							. $this->dadosPedidoData .
						'</data-hora>' . "\n      ";
			if($this->dadosPedidoDescricao != null && $this->dadosPedidoDescricao != ""){
				$msg .= '<descricao>'
					. $this->dadosPedidoDescricao .
					'</descricao>' . "\n      ";
			}
			$msg .= '<idioma>'
						. $this->dadosPedidoIdioma .
					'</idioma>' . "\n   " .
					'</dados-pedido>';
							
			return $msg;
		}
		
		private function XMLFormaPagamento(){
			$msg = '<forma-pagamento>' . "\n      " .
						'<bandeira>' 
							. $this->formaPagamentoBandeira .
						'</bandeira>' . "\n      " .
						'<produto>'
							. $this->formaPagamentoProduto .
						'</produto>' . "\n      " .
						'<parcelas>'
							. $this->formaPagamentoParcelas .
						'</parcelas>' . "\n   " .
					'</forma-pagamento>';
							
			return $msg;
		}
		 
		private function XMLUrlRetorno(){
			$msg = '<url-retorno>' . $this->urlRetorno . '</url-retorno>';
			
			return $msg;
		}
		
		private function XMLAutorizar(){
			$msg = '<autorizar>' . $this->autorizar . '</autorizar>';
			
			return $msg;
		}
		
		private function XMLCapturar(){
			$msg = '<capturar>' . $this->capturar . '</capturar>';
			
			return $msg;
		}
		
		// Envia Requisição
		public function Enviar($vmPost, $transacao){
			$this->logger->logWrite("ENVIO: " . $vmPost, $transacao);
	
			// ENVIA REQUISIÇÃO SITE CIELO
			$vmResposta = httprequest(ENDERECO, "mensagem=" . $vmPost);
			$this->logger->logWrite("RESPOSTA: " . $vmResposta, $transacao);
			
			VerificaErro($vmPost, $vmResposta);
	
			return simplexml_load_string($vmResposta);
		}
		
		// Requisições
		public function RequisicaoTransacao($incluirPortador){
			$msg = $this->XMLHeader() . "\n" .
				   '<requisicao-transacao id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				   		. $this->XMLDadosEc() . "\n   ";
			if($incluirPortador == true)
			{
					$msg .=	$this->XMLDadosPortador() . "\n   ";
			}
			$msg .=		  $this->XMLDadosPedido() . "\n   "
				   		. $this->XMLFormaPagamento() . "\n   "
				   		. $this->XMLUrlRetorno() . "\n   "
				   		. $this->XMLAutorizar() . "\n   "
				   		. $this->XMLCapturar() . "\n" ;
			
			$msg .= '</requisicao-transacao>';
			
			$objResposta = $this->Enviar($msg, "Transacao");
			return $objResposta;
		}
		
		public function RequisicaoTid(){
			$msg = $this->XMLHeader() . "\n" .
				   '<requisicao-tid id="' . md5(date("YmdHisu")) . '" versao ="' . VERSAO . '">' . "\n   "
				        . $this->XMLDadosEc() . "\n   " 
				        . $this->XMLFormaPagamento() . "\n" .
				   '</requisicao-tid>';
				        
			$objResposta = $this->Enviar($msg, "Requisicao Tid");
			return $objResposta;
		}
		
		public function RequisicaoAutorizacaoPortador(){
			$msg = $this->XMLHeader() . "\n" .
				   '<requisicao-autorizacao-portador id="' . md5(date("YmdHisu")) . '" versao ="' . VERSAO . '">' . "\n"
				   		. '<tid>' . $this->tid . '</tid>' . "\n   "
				        . $this->XMLDadosEc() . "\n   " 
				        . $this->XMLDadosCartao() . "\n   "
				        . $this->XMLDadosPedido() . "\n   "
				        . $this->XMLFormaPagamento() . "\n   "
				        . '<capturar-automaticamente>' . $this->capturar . '</capturar-automaticamente>' . "\n" .
				   '</requisicao-autorizacao-portador>';
			
			$objResposta = $this->Enviar($msg, "Autorizacao Portador");
			return $objResposta;
		}
		
		public function RequisicaoAutorizacaoTid(){
			$msg = $this->XMLHeader() . "\n" .
				 '<requisicao-autorizacao-tid id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n  "
				 	. '<tid>' . $this->tid . '</tid>' . "\n  "
				 	. $this->XMLDadosEc() . "\n" .
				 '</requisicao-autorizacao-tid>';
				 	
			$objResposta = $this->Enviar($msg, "Autorizacao Tid");
			return $objResposta;
		}
		
		public function RequisicaoCaptura($PercentualCaptura, $anexo){
			$msg = $this->XMLHeader() . "\n" .
				    '<requisicao-captura id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				   	. '<tid>' . $this->tid . '</tid>' . "\n   "
				   	. $this->XMLDadosEc() . "\n   "
				   	. '<valor>' . $PercentualCaptura . '</valor>' . "\n";
			if($anexo != null && $anexo != "")
			{
				$msg .=	'   <anexo>' . $anexo . '</anexo>' . "\n";
			}
			$msg .= '</requisicao-captura>';
			
			$objResposta = $this->Enviar($msg, "Captura");
			return $objResposta;
		}
		
		public function RequisicaoCancelamento(){
			$msg = $this->XMLHeader() . "\n" . 
				   '<requisicao-cancelamento id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				    . '<tid>' . $this->tid . '</tid>' . "\n   "
				    . $this->XMLDadosEc() . "\n" .
				   '</requisicao-cancelamento>';
			
			$objResposta = $this->Enviar($msg, "Cancelamento");
			return $objResposta;
		}
		
		public function RequisicaoConsulta(){
			$msg = $this->XMLHeader() . "\n" .
				   '<requisicao-consulta id="' . md5(date("YmdHisu")) . '" versao="' . VERSAO . '">' . "\n   "
				    . '<tid>' . $this->tid . '</tid>' . "\n   "
				    . $this->XMLDadosEc() . "\n" .
				   '</requisicao-consulta>';
			
			$objResposta = $this->Enviar($msg, "Consulta");
			return $objResposta;
		}
		
		
		// Transforma em/lê string
		public function ToString(){
			$msg = $this->XMLHeader() .
				   '<objeto-pedido>'
				    . '<tid>' . $this->tid . '</tid>'
				    . '<status>' . $this->status . '</status>'
				   	. $this->XMLDadosEc()
				   	. $this->XMLDadosPedido()
				   	. $this->XMLFormaPagamento() .
				   '</objeto-pedido>';
				   	
			return $msg;
		}
		
		public function FromString($Str){
			$DadosEc = "dados-ec";
			$DadosPedido = "dados-pedido";
			$DataHora = "data-hora";
			$FormaPagamento = "forma-pagamento";
			
			$XML = simplexml_load_string($Str);
			
			$this->tid = $XML->tid;
			$this->status = $XML->status;
			$this->dadosEcChave = $XML->$DadosEc->chave;
			$this->dadosEcNumero = $XML->$DadosEc->numero;
			$this->dadosPedidoNumero = $XML->$DadosPedido->numero;
			$this->dadosPedidoData = $XML->$DadosPedido->$DataHora;
			$this->dadosPedidoValor = $XML->$DadosPedido->valor;
			$this->formaPagamentoProduto = $XML->$FormaPagamento->produto;
			$this->formaPagamentoParcelas = $XML->$FormaPagamento->parcelas;
		}
		
		// Traduz cógigo do Status
		public function getStatus(){
			$status;
			
			switch($this->status)
			{
				case "0": $status = "Criada";
						break;
				case "1": $status = "Em andamento";
						break;
				case "2": $status = "Autenticada";
						break;
				case "3": $status = "Não autenticada";
						break;
				case "4": $status = "Autorizada";
						break;
				case "5": $status = "Não autorizada";
						break;
				case "6": $status = "Capturada";
						break;
				case "8": $status = "Não capturada";
						break;
				case "9": $status = "Cancelada";
						break;
				case "10": $status = "Em autenticação";
						break;
				default: $status = "n/a";
						break;
			}
			
			return $status;
		}
		
	}
	
///////////////////////////// END OF PEDIDO.PHP //



///////////////////////////// START OF LOGGER.PHP //
	class Logger{
		private $log_file = "cielo/xml.log";
		private $fp = null;
	
		public function logOpen(){
			$this->fp = fopen($this->log_file, 'a');
		}
	 
		public function logWrite($strMessage, $transacao){
			if(!$this->fp)
				$this->logOpen();
		
			$path = $_SERVER["REQUEST_URI"];
			$data = date("Y-m-d H:i:s:u (T)");
		
			$log = "***********************************************" . "\n";
			$log .= $data . "\n";
			$log .= "DO ARQUIVO: " . $path . "\n"; 
			$log .= "OPERAÇÃO: " . $transacao . "\n";
			$log .= $strMessage . "\n\n"; 

			fwrite($this->fp, $log);
		}
	}
///////////////////////////// END OF LOGGER.PHP //


///////////////////////////// START OF INCLUDE.PHP //
	define('VERSAO', "1.1.0");

	//session_start();

	if(!isset($_SESSION["pedidos"])) {
		$_SESSION["pedidos"] = new ArrayObject();
	}

	// CONSTANTES
	define("ENDERECO_BASE", "https://qasecommerce.cielo.com.br");
	define("ENDERECO", ENDERECO_BASE."/servicos/ecommwsec.do");

	define("LOJA", "1006993069");
	define("LOJA_CHAVE", "25fbb99741c739dd84d7b06ec78c9bac718838630f30b112d033ce2e621b34f3");
	define("CIELO", "1001734898");
	define("CIELO_CHAVE", "e84827130b9837473681c2787007da5914d6359947015a5cdb2b8843db0fa832");


	// Envia requisição
	function httprequest($paEndereco, $paPost){

		$sessao_curl = curl_init();
		curl_setopt($sessao_curl, CURLOPT_URL, $paEndereco);

		curl_setopt($sessao_curl, CURLOPT_FAILONERROR, true);

		//  CURLOPT_SSL_VERIFYPEER
		//  verifica a validade do certificado
		curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYPEER, true);
		//  CURLOPPT_SSL_VERIFYHOST
		//  verifica se a identidade do servidor bate com aquela informada no certificado
		curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYHOST, 2);

		//  CURLOPT_SSL_CAINFO
		//  informa a localização do certificado para verificação com o peer
		curl_setopt($sessao_curl, CURLOPT_CAINFO, getcwd() .
				"/ssl/VeriSignClass3PublicPrimaryCertificationAuthority-G5.crt");
		curl_setopt($sessao_curl, CURLOPT_SSLVERSION, 3);

		//  CURLOPT_CONNECTTIMEOUT
		//  o tempo em segundos de espera para obter uma conexão
		curl_setopt($sessao_curl, CURLOPT_CONNECTTIMEOUT, 10);

		//  CURLOPT_TIMEOUT
		//  o tempo máximo em segundos de espera para a execução da requisição (curl_exec)
		curl_setopt($sessao_curl, CURLOPT_TIMEOUT, 40);

		//  CURLOPT_RETURNTRANSFER
		//  TRUE para curl_exec retornar uma string de resultado em caso de sucesso, ao
		//  invés de imprimir o resultado na tela. Retorna FALSE se há problemas na requisição
		curl_setopt($sessao_curl, CURLOPT_RETURNTRANSFER, true);

		curl_setopt($sessao_curl, CURLOPT_POST, true);
		curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, $paPost );

		$resultado = curl_exec($sessao_curl);

		curl_close($sessao_curl);

		if ($resultado) {
			return $resultado;
		} else {
			return curl_error($sessao_curl);
		}
	}

	// Monta URL de retorno
	function ReturnURL() {
		$pageURL = 'http';

		if ($_SERVER["SERVER_PORT"] == 443)  { // protocolo https
			$pageURL .= 's';
		}
		$pageURL .= "://";
		if ($_SERVER["SERVER_PORT"] != "80") {
			$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"]. substr($_SERVER["REQUEST_URI"], 0);
		}
		// ALTERNATIVA PARA SERVER_NAME -> HOST_HTTP

		$file = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);

		$ReturnURL = str_replace($file, "retorno.php", $pageURL);

		return $ReturnURL;
	}

///////////////////////////// END OF INCLUDE.PHP //

	$Pedido = new Pedido();
	
	// Lê dados do $_POST
	$Pedido->formaPagamentoBandeira = 'visa'; 

	$Pedido->formaPagamentoProduto = 1;
	$Pedido->formaPagamentoParcelas = 1;
	
	$Pedido->dadosEcNumero = CIELO;
	$Pedido->dadosEcChave = CIELO_CHAVE;
	
	$Pedido->capturar = true;	
	$Pedido->autorizar = 3;
	
	$Pedido->dadosPedidoNumero = rand(1000000, 9999999); 
	$Pedido->dadosPedidoValor = 123000;
	
	$Pedido->urlRetorno = ReturnURL();
	
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
	

	echo '<script type="text/javascript">
			window.location.href = "' . $Pedido->urlAutenticacao . '"
		 </script>';



?>



	<div id="content" class="entry no-sidebar">	
		<?php //while ( have_posts() ) : the_post(); ?>
	
			<?php //the_title('<h1 class="entry-title">', '</h1>'); ?>
			<div class="entry-content">
				<?php //the_content(); ?>
				<p>Caso você não seja redirecionado automaticamente, <a href="">clique aqui</a> para acessar a página de pagamento.</p>
			</div>
			
		<?php //endwhile; ?>
	</div><?php // #content .entry ? ?>


<?php //get_footer(); ?>
