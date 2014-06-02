<?php /* Template Name: A Lot Of Posts */
/////////////////////////////////////////////////////////////
///////////////////////// FUNÇOES ///////////////////////////
/////////////////////////////////////////////////////////////

// VERIFICA SE O USUARIO ESTÁ LOGADO E TEM PERMISSÃO
if(!is_user_logged_in()) { header('location: /wp-admin/'); }
//if(get_role('edit_files')) { echo 'yes'; };

// POSSIBILITA O MAC RECONHECER A QUEBRA DE LINHA DO ARQUIVO CSV
ini_set("auto_detect_line_endings", 1);

// LISTA OS CAMPOS QUE PODEM SER UTILIZADOS COMO WP EQUIVALENTES
$wp_equivalentes = array(
	'post_title' => 				'post',
	'post_content' => 				'post',
	'post_excerpt' => 				'post',
	'post_type' => 					'post',
	'post_category' => 				'post',
	'category' =>					'taxonomy',
	'wpsc_product_category' => 		'taxonomy',
	'_wpsc_price' => 				'meta',
	'_wpsc_special_price' => 		'meta',
	'_wpsc_sku' => 					'meta',
	'_wpsc_stock' => 				'meta',
	'_wpsc_product_metadata' => 	'meta',
	'_wpsc_is_donation' => 			'meta',
	'_wpsc_currency' => 			'meta',
	'Índice' => 					'meta',
	'Teaser' => 					'meta',
);

// CRIA O SELECT PARA A DEFINIÇÃO DO CAMPO WP EQUIVALENTE
function select_wp($coluna) { 
	if($coluna) {
		global $wp_equivalentes;
		$r  = '';
		$r .= '<select name="coluna_'.$coluna.'" id="coluna_'.$coluna.'">';
		$r .= '<option value="">Ignorar</option>';
			foreach($wp_equivalentes as $campo => $tipo) {
				$r .= '<option value="'.$campo.';'.$tipo.'">'.$campo.'</option>';
			}
		$r .= '</select>';
		
		return $r;
	}
}
/////////////////////////////////////////////////////////////
///////////////////////// PASSO 2 ///////////////////////////
/////////////////////////////////////////////////////////////
if($_POST['step']==2) {
	
	if (isset($_FILES['csv_file'])) {
		
		/* Verifica o envio do arquivo */
		if(!$_FILES['csv_file']['tmp_name']) {
			header('Redirect:'.get_permalink().'?err=1');
		}
		
		/* Verifica as extensões autorizadas */
		$allowed_ext = array("csv");
		if (!in_array(end(explode(".",strtolower($_FILES['csv_file']['name']))), $allowed_ext)) {
			header('Redirect:'.get_permalink().'?err=2');
		}
		
		/* Define a unidade de medida a partir do tamanho */
		if ($_FILES['csv_file']['size'] > 1024 * 1024) {
			$tamanho = round(($_FILES['csv_file' ]['size'] / 1024 / 1024), 2);
			$med = "MB";
		} else if ($_FILES['csv_file']['size'] > 1024) {
			$tamanho = round(($_FILES['csv_file' ]['size'] / 1024), 2);
			$med = "KB";
		} else {
			$tamanho = $_FILES['csv_file']['size'];
			$med = "Bytes";
		}
		/* Verifica o tamanho máximo do arquivo em bytes: */
		if($_FILES['csv_file']['size'] > 5242880) { //Limite: 5MB
			header('Redirect:'.get_permalink().'?err=3');
		}

		$arquivo = fopen($_FILES['csv_file']['tmp_name'], 'r');
		
		if (!$arquivo){
			header('Redirect:'.get_permalink().'?err=0');
		}

	}
	
} // END STEP 2



/////////////////////////////////////////////////////////////
///////////////////////// PASSO 3 ///////////////////////////
/////////////////////////////////////////////////////////////
if($_POST['step']==3) {
	
	// LISTA E DEFINE OS TIPOS DE CAMPOS WP DE CADA COLUNA
	$titulos = array();
	for ($coluna = 1; $coluna <= $_POST['colunas']; $coluna++) {
		$titulo = explode(';', $_POST['coluna_'.$coluna]);
		$titulos[$coluna] = $titulo;
	}
	
	//PARA CADA LINHA EXECUTA A INSERÇÃO
	for ($linha = 1; $linha <= $_POST['linhas']; $linha++) {

		////////////////// POST /////////////////
		// DEFINE ARGUMENTOS INICIAIS
		$args_post = array(
			'post_title' => '',
			'post_excerpt' => '',
			'post_status' => 'publish',
			'post_type' => 'post',
		);
		
		// LOOP PARA REDEFINIR ARGUMETOS COM BASE NO CSV
		foreach($titulos as $coluna => $titulo) {
			if($titulo[1] == 'post') {
				$args_post[ $titulo[0] ] = $_POST['campo_'.$coluna.'_'.$linha];
			}
		}
		
		// INSERE NOVO POST
		$new_post_id = wp_insert_post( $args_post );

		/////////////// CATEGORIA ///////////////
		// LOOP PARA INSERIR CATEGORIAS COM BASE NOS ARGUMENTOS DE CADA TAXONOMIA DO CSV
		foreach($titulos as $coluna => $titulo) {
			if($titulo[1] == 'taxonomy') {
				// LISTA AS IDS
				$tax_ids = explode(',', $_POST['campo_'.$coluna.'_'.$linha]);
				// FORCA A ARRAY ARMAZENAR AS ID EM FORMATO DE NUMERO | caso contrario a id é inserida como titulo da categoria e nao a id
				foreach($tax_ids as $k => $v) { $tax_ids[$k] = ($v/1); }
				// INSERE CATEGORIAS
				wp_set_object_terms( $new_post_id, $tax_ids, $titulo[0] );
			}
		}
		
		///////////// CUSTOM FIELDS /////////////	
		// LOOP PARA INSERIR META DADOS / CUSTOM FIELDS COM BASE NOS ARGUMENTOS DE CADA TAXONOMIA
		foreach($titulos as $coluna => $titulo) {
			if($titulo[1] == 'meta') {
				// INSERE META
				add_post_meta($new_post_id, $titulo[0], $_POST['campo_'.$coluna.'_'.$linha], true);
			}
		}	
	}
} // END STEP 3 



/////////////////////////////////////////////////////////////
////////////////////////// ERROS ////////////////////////////
/////////////////////////////////////////////////////////////
$error_msg = array(
	1 => 'Nenhum arquivo enviado',
	2 => 'A extensão do arquivo deve ser .CSV',
	3 => 'O Arquivo não pode ser maior do que 5Mb',
	4 => '',
	5 => '',
	6 => '',
)

?>



<html dir="ltr" lang="pt-BR"> 
<head> 
	<meta charset="UTF-8" /> 
	<title>a lot of posts</title>		
	<meta name='robots' content='noindex,nofollow' /> 
	<script type='text/javascript' src='/wp-includes/js/jquery/jquery.js?ver=1.4.4'></script>
	<style type="text/css" media="screen"> 
		
	</style> 
</head>

<body>
	<h1>A Lot Of Posts</h1>
	
	<?php if($_GET['err']) { ?>
		<p class="erro"><?php echo $error_msg[$_GET['err']]; ?></p>
	<?php } ?>

<?php
/////////////////////////////////////////////////////////////
///////////////////////// PASSO 1 ///////////////////////////
/////////////////////////////////////////////////////////////
if(!$_POST['step']) { 
?>
	<h2>Passo 1 de 3 - Selecione o arquivo no formato CSV</h2>
	 
	<form action="<?php the_permalink(); ?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="step" value="2">
		<p>
			<label for="csv_file">Arquivo CSV (separado por vírgulas)</label><br />
			<input type="file" name="csv_file" value="" id="csv_file">
			<input type="submit" value="Passo 2 &rarr;">
		</p>
	</form>
	

<?php } // END STEP 1 ?>	

<?php 
/////////////////////////////////////////////////////////////
///////////////////////// PASSO 2 ///////////////////////////
/////////////////////////////////////////////////////////////
if($_POST['step']==2) { 
?>
	<h2>Passo 2 de 3 - Correção dos Valores</h2>
	<form action="<?php the_permalink(); ?>" method="post">
		<table border="1" cellspacing="0" cellpadding="0">
			<?php
				if ($arquivo) {
										
					//INICIA CONTROLE DE LINHAS E CABECALHO
					$count_linhas = 1;
					$cabecalhos = "";
					
					//INICIA LOOP DE LINHAS
					while($linha = fgetcsv ($arquivo, 10240, ';')) {
						echo '<tr>';

						//INICIA CONTROLE DE COLUNAS
						$count_colunas = 1;	
						
						// TESTA SE A PRIMEIRA LINHA E INSERE O CABECALHO DA TABELA
						if ($count_linhas == 1)  {
							foreach($linha as $coluna) {
								// MOSTRA OS SELECTS DO CABECALHO
								echo '<th>';
								echo select_wp($count_colunas);
								echo '</th>';
								$count_colunas++;
							}
							echo '</tr><tr>';
							//REINICIA CONTROLE DE COLUNAS
							$count_colunas = 1;	
						}
						
						// INICIA LOOP DE COLUNAS
						foreach($linha as $coluna) {
							// MOSTRA OS VALORES EM CAMPOS
							echo '<td>';
							// formato excel do mac
							echo '<input type="text" name="campo_'.$count_colunas.'_'.$count_linhas.'" id="campo_'.$count_colunas.'_'.$count_linhas.'" value="'.iconv("Macintosh", "UTF-8", $coluna).'" />'; 		
							// outros formatos
							//echo '<input type="text" name="campo_'.$count_colunas.'_'.$count_linhas.'" id="campo_'.$count_colunas.'_'.$count_linhas.'" value="'.$coluna.'" />';
							echo '</td>';								
							$count_colunas++;
						}
						
						$count_linhas++;
						echo '</tr>';
					}
					
				}
			?>
		</table>
		<input type="hidden" name="step" value="3">
		<input type="hidden" name="linhas" value="<?php echo $count_linhas-1; ?>" />	
		<input type="hidden" name="colunas" value="<?php echo $count_colunas-1; ?>" />	
		<p><input type="submit" value="Passo 3 &rarr;"></p>
	</form>
	
	
	

<?php } // END STEP 1 ?>
	
<?php /////////////////////////////////////////////////////////////
///////////////////////// PASSO 3 ///////////////////////////
/////////////////////////////////////////////////////////////
if($_POST['step']==3) {	
?>

	<p>Cadastro realizado com suscesso.</p>

	<p><a href="<?php the_permalink(); ?>">&larr; Voltar</a></p>

<?php } // END STEP 3 ?>


</body>
</html>
