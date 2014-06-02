	<?php

///////////////////// INICIA SESSÃO /////////////////////
session_start();

if(!function_exists('_log')){
    function _log( $message ) {
        if( WP_DEBUG === true ){
            if( is_array( $message ) || is_object( $message ) ){
                error_log( print_r( $message, true ) );
            } else {
                error_log( $message );
            }
        }
    }
}

/**
 * CW Framework
 */
require('cw_framework/functions.php');


///////////////////// FUNCAO INICIAL /////////////////////
add_action( 'init', 'register_extras' );
function register_extras() {

	///////////////////// NOT ADMIN REDIRECT /////////////////////
	$current_user = wp_get_current_user();
	if (is_admin() && $current_user->roles[0]=='subscriber' ) { header('Location: /');}


	///////////////////// JQUERY /////////////////////
	if (!is_admin()) { wp_enqueue_script('jquery'); }


	///////////////////// SUPORTES AO TEMA /////////////////////
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' ); // <- Melhor usar custom fields


	///////////////////// LINK NO RESUMO DO POST /////////////////////
	function new_excerpt_more($more) {
		global $post;
		return '... <a href="'. get_permalink($post->ID) . '">[leia mais]</a>';
	}
	add_filter('excerpt_more', 'new_excerpt_more');


	///////////////////// SUPORTE A BARRA LATERAL /////////////////////
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Barra Lateral Principal Superior', 'iemi' ),
		'id' => 'top-sidebar',
		'description' => __( 'Barra Lateral Principal Superior', 'iemi' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Barra Lateral Principal Central', 'iemi' ),
		'id' => 'middle-sidebar',
		'description' => __( 'Barra Lateral Principal Central', 'iemi' ),
		'before_widget' => '<li class="widget">',
		'after_widget' => '</li>',
		'before_title' => '<div class="red_title"><h3 class="widget-title">',
		'after_title' => '</h3><div class="red_title_r"></div></div>',
	) );

	register_sidebar( array(
		'name' => __( 'Barra Lateral Principal Inferior', 'iemi' ),
		'id' => 'bottom-sidebar',
		'description' => __( 'Barra Lateral Principal Inferior', 'iemi' ),
		'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</li>',
		'before_title' => '<h3 class="widget-title">',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => __( 'Home - Área Esquerda', 'iemi' ),
		'id' => 'home-left',
		'description' => __( 'Área de widgets na coluna esquerda da Home', 'iemi' ),
		'before_widget' => '<div class="left_gray"><div class="left_gray_top"></div><div class="left_gray_middle"><div id="%1$s" class="widget-container widget widget_meta %2$s">',
		'after_widget' => '</div></div><div class="left_gray_bottom"></div></div>',
		'before_title' => '<div class="gray_title"><h3 class="widget-title">',
		'after_title' => '</h3></div>',
	) );

	register_sidebar( array(
		'name' => __( 'Home - Área Central', 'iemi' ),
		'id' => 'home-center',
		'description' => __( 'Área de widgets na coluna central da Home', 'iemi' ),
		'before_widget' => '<div class="left_gray"><div class="left_gray_top"></div><div class="left_gray_middle"><div id="%1$s" class="widget-container widget widget_meta %2$s">',
		'after_widget' => '</div></div><div class="left_gray_bottom"></div></div>',
		'before_title' => '<div class="gray_title"><h3 class="widget-title">',
		'after_title' => '</h3></div>',
	) );

	register_sidebar( array(
		'name' => __( 'Home - Área Direita', 'iemi' ),
		'id' => 'home-right',
		'description' => __( 'Área de widgets na coluna direita da Home', 'iemi' ),
		'before_widget' => '<div class="left_gray"><div class="left_gray_top"></div><div class="left_gray_middle"><div id="%1$s" class="widget-container widget widget_meta %2$s">',
		'after_widget' => '</div></div><div class="left_gray_bottom"></div></div>',
		'before_title' => '<div class="gray_title"><h3 class="widget-title">',
		'after_title' => '</h3></div>',
	) );


	///////////////////// SUPORTE AOS MENUS /////////////////////
	register_nav_menus(
		array(
			'main-nav' => __('Navegação Principal'),
			'extra-nav' => __('Navegação Secundária'),
			'footer-nav' => __('Navegação do Rodapé')
		)
	);


	///////////////////// TRADUÇÕES /////////////////////
	/*load_theme_textdomain( 'Iemi', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );*/


	///////////////////// CUSTOM POST: ANÚNCIOS /////////////////////
	$labels = array( // Títulos
	    'name' => _x('Anúncios', 'post type general name'),
	    'singular_name' => _x('Anúncio', 'post type singular name'),
	    'add_new' => _x('Adicionar Novo', 'local'),
	    'add_new_item' => __('Adicionar Novo Anúncio'),
	    'edit_item' => __('Editar Anúncio'),
	    'new_item' => __('Novo Anúncio'),
	    'view_item' => __('Ver Anúncios'),
	    'search_items' => __('Buscar Anúncio'),
	    'not_found' =>  __('Nenhum Anúncio Encontrado'),
	    'not_found_in_trash' => __('Nenhum Anúncio Encontrado no Lixo'),
	    'parent_item_colon' => '',
	    'menu_name' => 'Anúncios'
	);
	$args = array( // Configurações
		'labels' => $labels,
		'public' => false,
	    'publicly_queryable' => true,
	    'show_ui' => true,
	    'show_in_menu' => true,
	    'query_var' => true,
	    'rewrite' => array('slug' => 'anuncios-iemi'),
	    'capability_type' => 'post',
	    'menu_position' => null,
		'menu_icon' => '/wp-content/themes/iemi/images/application-blog.png',
	    'supports' => array('title', 'editor', 'custom-fields', 'excerpt'),
	);
	register_post_type('anuncios_iemi',$args);

 	// Mensagens customizadas
	function anuncios_iemi_updated_messages( $messages ) {
		global $post, $post_ID;

		$messages['anuncios_iemi'] = array(
	    	0 => '',
	    	1 => sprintf( __('Anúncio atualizado. <a href="%s">Ver Anúncio</a>'), esc_url( get_permalink($post_ID) ) ),
	    	2 => __('Anúncio atualizado.'),
	    	3 => __('Anúncio deletado.'),
	    	4 => __('Anúncio atualizado.'),
		    5 => isset($_GET['revision']) ? sprintf( __('Anúncio restaurado para a revisão %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
	    	6 => sprintf( __('Anúncio publicado. <a href="%s">Ver Anúncio</a>'), esc_url( get_permalink($post_ID) ) ),
	    	7 => __('Anúncio salvo.'),
	    	8 => sprintf( __('Anúncio enviado. <a target="_blank" href="%s">Ver rascunho de Anúncio</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	    	9 => sprintf( __('Anúncio agendado para <strong>%1$s</strong>. <a target="_blank" href="%2$s">Ver rascunho de Anúncio</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
	    	10 => sprintf( __('Rascunho de Anúncio atualizado. <a target="_blank" href="%s">Ver rascunho de Anúncio</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
	  	);
	  	return $messages;
	}
	add_filter('post_updated_messages', 'anuncios_iemi_updated_messages');


	///////////////////// FLUSH REWRITE RULES /////////////////////
	//flush_rewrite_rules();

	///////////////////// ELIMINAR O CACHE DE ARQUIVOS /////////////////////
	function nc() { echo '?' . date(is); }


	/////////////////////////////////////////////////////////////////////////
	/////////////////////////////// FUNCTIONS ///////////////////////////////
	/////////////////////////////////////////////////////////////////////////


	/*////////////////////////////////////////////////////////////////////////
		NOME		calculate_price($original_price)
		FUNÇÃO		Calcula preços com base no cupom cadastrado
		PARÂMETROS
		$original_price ->		Valor original
	*////////////////////////////////////////////////////////////////////////
	function calculate_price($original_price = 0) {

		$old_s = array('R', '$', '&#036;',  'span', 'class', 'pricedisplay', '=', '\'', '"', '<', '>', '/', ' ', '.', ',');
		$new_s = array('', '', '', '', '', '', '', '', '', '', '', '', '', '', '.');
		$r['from_price'] = floatval(str_replace($old_s, $new_s, $original_price));

		/*if (stripos($r['from_price'], '$') === false) {
		    $r['from_price'] = floatval(substr($r['from_price'], 1, 0));
		}*/

		if($_SESSION['user_coupon']) {
			if($_SESSION['user_coupon']['is-percentage']){
				$r['discount'] = $r['from_price'] * $_SESSION['user_coupon']['value'] / 100;
			} else {
				$r['discount'] = $r['from_price'] - $_SESSION['user_coupon']['value'];
			}
		} else {
			$r['discount'] = 0.00;
		}

		$r['new_price'] = $r['from_price'] - $r['discount'];
		$r['iemi_price'] = $r['from_price'] * 0.95 - $r['discount'];;

		$r['from_price'] = 'R$ '.number_format($r['from_price'], 2, ',', '.');
		$r['discount'] = 'R$ '.number_format($r['discount'], 2, ',', '.');
		$r['new_price'] = 'R$ '.number_format($r['new_price'], 2, ',', '.');
		$r['iemi_price'] = 'R$ '.number_format($r['iemi_price'], 2, ',', '.');

		return $r;
	}



	/*////////////////////////////////////////////////////////////////////////
		NOME		get_banners($tb, $ea)
		FUNÇÃO		Listar os anúncios(posts customizados) de acordo com as variáveis
		PARÂMETROS
		$tb ->		Define o tipo de anúncio com base nos campos customizados do
					anúncio(post customizado). Deve ser string com base na listagem
					pré-definida no campo customizado
		$ea	->		Define se existem argumentos extras para filtragem dos anúncios
	*////////////////////////////////////////////////////////////////////////
	function get_banners($tb, $ea) {

		if ($tb) {// verifica se a
			$args = array(
				'post_type' => 'anuncios_iemi',
				'post_status' => 'publish',
				'order_by' => 'date',
				'order' => 'DESC',
				// 'meta_query' => array(
				// 	array(
				// 		'key' => 'Tipo de Anúncio',
				// 		'value' => $tl,
				// 	),
				// ),
			);

			if($ea) { //se existirem argumentos extras
				foreach ($ea as &$value) { array_push($args['meta_query'], $value); }
			}

			$r = new WP_Query($args);
			return $r;

		}

	}


	/*////////////////////////////////////////////////////////////////////////
		NOME		validate($type, $value)
		FUNÇÃO		Verifica se o dado está correto de acordo com o tipo sugerido
		GRUPO		Controle de cadastro e login
		PARÂMETROS
		$type 	->	string, pode ser cnpj ou cpf
		$value	->	string, valor a ser analisado
	*////////////////////////////////////////////////////////////////////////
	function validate($type, $value) {
		// init
		$r = false;
		$value = str_replace(".","",$value);
		$value = str_replace("/","",$value);
		$value = str_replace("-","",$value);
		$value = str_replace("(","",$value);
		$value = str_replace(")","",$value);
		$value = str_replace(" ","",$value);

		// cpf
		if($type=='cpf') {
			$soma = 0;

			if (strlen($value) <> 11) { $r = false; }

			// Verifica 1º digito
			for ($i = 0; $i < 9; $i++) { $soma += (($i+1) * $value[$i]); }
			$d1 = ($soma % 11);
			if ($d1 == 10) { $d1 = 0; }
			$soma = 0;

			// Verifica 2º digito
			for ($i = 9, $j = 0; $i > 0; $i--, $j++) { $soma += ($i * $value[$j]); }
			$d2 = ($soma % 11);
			if ($d2 == 10) { $d2 = 0; }

			if ($d1 == $value[9] && $d2 == $value[10]) {
				$r = true;
			} else {
				$r = false;
			}
		}

		// cnpj
		if($type=='cnpj') {

			if (strlen($value) <> 14) { $r = false; }

			$soma = 0;

			$soma += ($value[0] * 5);
			$soma += ($value[1] * 4);
			$soma += ($value[2] * 3);
			$soma += ($value[3] * 2);
			$soma += ($value[4] * 9);
			$soma += ($value[5] * 8);
			$soma += ($value[6] * 7);
			$soma += ($value[7] * 6);
			$soma += ($value[8] * 5);
			$soma += ($value[9] * 4);
			$soma += ($value[10] * 3);
			$soma += ($value[11] * 2);

			$d1 = $soma % 11;
			$d1 = $d1 < 2 ? 0 : 11 - $d1;

			$soma = 0;
			$soma += ($value[0] * 6);
			$soma += ($value[1] * 5);
			$soma += ($value[2] * 4);
			$soma += ($value[3] * 3);
			$soma += ($value[4] * 2);
			$soma += ($value[5] * 9);
			$soma += ($value[6] * 8);
			$soma += ($value[7] * 7);
			$soma += ($value[8] * 6);
			$soma += ($value[9] * 5);
			$soma += ($value[10] * 4);
			$soma += ($value[11] * 3);
			$soma += ($value[12] * 2);

			$d2 = $soma % 11;
			$d2 = $d2 < 2 ? 0 : 11 - $d2;

			if ($value[12] == $d1 && $value[13] == $d2) {
				$r = true;
			} else {
				$r = false;
			}
		}

		if($type=='phone') {

			if (strlen($value) <> 10) {
				$r = false;
			} else {
				$r = true;
			}

		}

		return $r;
	}


	/*////////////////////////////////////////////////////////////////////////
		NOME		newsletter_areas
		FUNÇÃO		Array contendo áreas de interesse do newsletter
		GRUPO		Controle de cadastro e login
	*////////////////////////////////////////////////////////////////////////
	global $newsletter_areas;
	$newsletter_areas = array(
		'Calçados' => array('Calçados em Geral', 'Calçados Esportivos', 'Calçados Infantis'),
		//'Cama, Mesa e Banho' => array(),
		'Têxteis' => array('Fios', 'Tecidos', 'Malhas', 'Não Tecidos'),
		'Vestuário' => array('Moda Praia', 'Moda Íntima e Meias', 'Moda Esportiva', 'Moda Infantil', 'Jeanswear'),
		'Móveis' => array('Móveis para Escritório', 'Móveis para Cozinha', 'Móveis Estofados', 'Colchões e Cama Box'),
		//'Outros' => array('Informações adicionais')
	);

	/*////////////////////////////////////////////////////////////////////////
		NOME		pg_fix_error_message()
		FUNÇÃO		Corrige as mensagens de erro
		GRUPO		Controle de cadastro e login
		PARÂMETROS	nenhum
	*////////////////////////////////////////////////////////////////////////
	function pg_fix_error_message($err) {
		if(is_string($err)) {

			if(stripos($err, 'campo') && stripos($err, 'senha') && stripos($err, 'vazio') ) {
				$r = '<p class="alert alert-warning">O campo da senha não foi preenchido.</p>';
			}

			if(stripos($err, 'username') || stripos($err, 'usuário') ) {
				$r = '<p class="alert alert-warning">Combinação incorreta de email e senha. <a href="/conta/senha/">Esqueceu sua senha?</a></p>';
			}


		} else {
			$r = '';
		}

		return $r;
	}



	/*////////////////////////////////////////////////////////////////////////
		NOME		pg_login()
		FUNÇÃO		Tenta logar o usuário a partir do formulário ou devolve o erro
		GRUPO		Controle de cadastro e login
		PARÂMETROS	nenhum
	*////////////////////////////////////////////////////////////////////////
	function pg_login_action() {
		// confere se todos os campos existem
		if(isset($_POST) && ( isset($_POST['log']) || isset($_POST['pwd']) ) ){
			//puxa variavel global
			global $pg_user;
			global $login_alert;
			global $activated;
			$logged = $_SESSION['logged'];
			$_SESSION['logged'] = null;
			$login_alert = array();
			// tenta conectar
			$pg_user = wp_signon();
			// verifica se conectou e recarrega página
			// (hack para resolver recarregamento da página)
			if ( !is_wp_error($pg_user) ) {
				if(get_user_meta( $pg_user->ID, 'active', true )) {
					//$_SESSION['login_ok'] = true;
					$_SESSION['logged'] = true;
					array_push($login_alert, '<p class="alert alert-ok">Login efetuado.</p>');
					header('location: '.$_POST['redirect_to']);
				} else {
					if($_POST['key'] == get_user_meta( $pg_user->ID, 'token', true )) {
						update_user_meta( $pg_user->ID, 'active', 1 );
						array_push($login_alert, '<p class="alert alert-ok">Seu cadastro foi ativado com sucesso.</p>');
						$activated = true;
					} else {
						wp_logout();
						$_SESSION['login_ok'] = false;
						array_push($login_alert, '<p class="alert alert-error">Este cadastro ainda não foi ativado.</p>');
						return false;
					}
				}
			} else {
				// se não conectou retorna erro
				return $pg_user;
			}
		} else {
			// retorna false se não existir todos os campos necessários
			return false;
		}
	}



	/*////////////////////////////////////////////////////////////////////////
		NOME		pg_login_form($args=array())
		FUNÇÃO		Exibe o formulário customizado de login
		GRUPO		Controle de cadastro e login
		PARÂMETROS
		$args ->	Define os argumentos, deve ser uma array
			$args[echo] -> Define se o formulário será impresso ou enviado em forma de dados, boleano
			$args[action] -> Define o link de acao do formulário, deve ser um url válido
			$args[log] -> Define o valor para o campo de login, deve ser string
			$args[rememberme] -> define se o campo de lembrar senha deve estar marcado, boleano
			$args[redirect_to] -> define o valor para o campo oculto de redirecionamento, deve ser um url
			$args[activation] -> define o valor para o campo oculto de redirecionamento, deve ser um url
	*////////////////////////////////////////////////////////////////////////
	function pg_login_form($args=array()){
		// init
		global $pg_user;
		global $login_alert;
		global $activated;
		$r = '';

		// tratamento de variáveis
		if(!isset($args['echo'])) { $args['echo']=1; }
		//$action=null,$log=null,$rememberme=null,$redirect_to=null
		if(!$args['action']) {
			if($_POST['action']){
				$args['action'] = $_POST['action'];
			} else {
				$args['action'] = '/iemi/conta/login/?'.$_SERVER['QUERY_STRING']; }
			}
		if(!$args['log']) { $args['log'] = $_POST['log']; }
		if($args['rememberme'] || $_POST['rememberme']) { $args['rememberme'] = 'checked'; }
		if(!$args['redirect_to']) {
			if($_POST['redirect_to']){
				$args['redirect_to'] = $_POST['redirect_to'];
			} else {
				$args['redirect_to'] = get_permalink();
			}
		}
		if($args['activation'] && $_GET['login'] && $_GET['key']) {
			$args['log'] = $_GET['login'];
			$args['key'] = $_GET['key'];
		}

		if($args['activation'] && !$activated) {
			$r .= '<p>Digite seu login e senha para ativar seu cadastro.</p>';
		}

		// cria formulário
		$r .= '<form name="loginform" action="http://www.iemi.com.br/wp-login.php" method="post">';
		$r .= '<table border="0" cellspacing="0" cellpadding="0" class="simpleinfo">';

		if ( is_wp_error($pg_user)) {
			$r .= '<tr><th colspan="2">';
			$r .= pg_fix_error_message($pg_user->get_error_message());
			$r .= '</th></tr>';
		}
		if ($login_alert) {
			$r .= '<tr><th colspan="2">';
			foreach ($login_alert as $l_alert) {
				$r .= $l_alert;
			}
			$r .= '</th></tr>';
		}

		// se ativado recentement
		if($activated) {

			//fecha tabela e formulario
			$r .= '</table>';
			$r .= '</form>';
			$r .= '<p>Agora você terá acesso a conteúdos exclusivos e aquisição de estudos. Acesse a <a href="/">Home Page</a> ou utilize o menu superior para continuar a navegar pelo site.</p>';
			$r .= '<p>Siga-nos nas redes sociais e receba informações diariamente:<br />
				<a href="http://twitter.com/IEMIpesquisas" target="_blank"><img title="Twitter" src="http://www.iemi.com.br/wp-content/uploads/2011/07/Twitter_48x48.png" alt="" width="48" height="48" /></a>
				<a href="http://www.facebook.com/home.php?sk=group_189448191094706" target="_blank"><img title="Facebook" src="http://www.iemi.com.br/wp-content/uploads/2011/07/FaceBook_48x48.png" alt="" width="48" height="48" /></a>
				<a href="http://www.orkut.com.br/Main#Profile?uid=15033782513126313840" target="_blank"><img title="Orkut" src="http://www.iemi.com.br/wp-content/uploads/2011/07/Orkut_48x48.png" alt="" width="48" height="48" /></a>
				<a href="http://www.linkedin.com/profile/view?id=106910593" target="_blank"><img title="LinkedIn" src="http://www.iemi.com.br/wp-content/uploads/2011/07/LinkedIn_48x48.png" alt="" width="48" height="48" /></a>
				<a href="http://www.youtube.com/iemipesquisas" target="_blank"><img title="YouTube" src="http://www.iemi.com.br/wp-content/uploads/2011/07/Youtube_48x48.png" alt="" width="48" height="48" /></a>
			</p>';

		// mostra formulario normal
		} else {


			// criar campo de login
			$r .= '<tr  class="login-username"><th>';
			$r .= '<label for="user_login">E-mail</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="log" id="user_login" class="txt txt360" value="'.stripslashes($args['log']).'" size="10" tabindex="10" />';
			$r .= '</td></tr>';

			//cria campo de senha
			$r .= '<tr class="login-password"><th>';
			$r .= '<label for="user_pass">Senha</label>';
			$r .= '</th><td>';
			$r .= '<input type="password" name="pwd" id="user_pass" class="txt txt360" value="" size="10" tabindex="11" />';
			$r .= '</td></tr>';

			// cria opção de lembrar senha
			$r .= '<tr class="login-remember"><th>';
			$r .= '</th><td>';
			$r .= '<label><input name="rememberme" type="checkbox" id="rememberme" value="forever" tabindex="13" class="txt" '.$args['rememberme'].' /> Lembrar a senha</label>';
			$r .= '</td></tr>';

			// criar botão de envio
			$r .= '<tr><th>';
			$r .= '</th><td>';
			$r .= '<input type="submit" name="wp-submit" id="wp-submit" class="button-primary btn" value="Acessar" tabindex="14" />';
			$r .= '</td></tr>';

			// criar opção de redirecionamento
			if($args['activation']) { $r .= '<input type="hidden" name="key" value="'.$_GET['key'].'" />'; }
			$r .= '<input type="hidden" name="redirect_to" value="http://iemi.com.br/wp-admin/" />';
			$r .= '<input type="hidden" name="action" value="'.$args['action'].'" />';

			// fecha formulário
			$r .= '</table>';
			$r .= '</form>'.$logged;

		}


		// verifica se o formulário deve ser impresso ou devolvido em forma de dados
		if($args['echo']){ echo $r; } else { return $r; }

	}


	/*////////////////////////////////////////////////////////////////////////
		NOME		pg_password_form($args=array())
		FUNÇÃO		Exibe o formulário ara troca de senha
		GRUPO		Controle de cadastro e login
		PARÂMETROS	nenhum
		$args ->	Define os argumentos, deve ser uma array

	*////////////////////////////////////////////////////////////////////////
	function pg_password_form($args=array()) {

		// init
		global $pg_user;
		global $password_alert;
		$r = '';

		// tratamento de variáveis
		if(!isset($args['echo'])) { $args['echo']=1; }

		if(!$args['action']) {
			if($_POST['action']){
				$args['action'] = $_POST['action'];
			} else {
				$args['action'] = '/conta/senha/';
				if($_SERVER['QUERY_STRING']) { $args['action'] .= '?'.$_SERVER['QUERY_STRING']; }
			}
		}

		if(!$args['email']) {
			if ($_POST['e']) {
				$args['email'] = $_POST['email'];
			} else {
				$args['email'] = $_GET['e'];
			}
		}

		if(!$args['token']) {
			if ($_POST['t']) {
				$args['token'] = $_POST['token'];
			} else {
				$args['token'] = $_GET['t'];
			}
		}

		if(!$args['type']) {
			if ($_POST['type']) {
				$args['type'] = $_POST['type'];
			} else {
				$args['type'] = $_GET['type'];
			}
		}


		if($args['type']=='pass') {
			$r .= '<p>Digite sua nova senha.</p>';
		} else{
			$r .= '<p>Digite o email cadastrado para recuperar a senha.</p>';
		}

		// cria formulário
		$r .= '<form name="loginform" action="'.$args['action'].'" method="post">';
		$r .= '<input type="hidden" name="email" value="'.$args['email'].'">';
		$r .= '<input type="hidden" name="token" value="'.$args['token'].'">';
		$r .= '<input type="hidden" name="type" value="'.$args['type'].'">';
		$r .= '<table border="0" cellspacing="0" cellpadding="0" class="simpleinfo">';

		if ($password_alert) {
			$r .= '<tr><th colspan="2">';
			foreach ($password_alert as $p_alert) {
				$r .= $p_alert;
			}
			$r .= '</th></tr>';
		}

		if($args['type']=='pass') {
			$r .= '<tr class="pass"><th>';
			$r .= '<label for="user_pass"'.$class.'>Senha</label>';
			$r .= '</th><td>';
			$r .= '<input type="password" name="user_pass" id="user_pass" class="txt txt250" value="" size="20" tabindex="95" /> <br />';
			$r .= '<input type="password" name="user_pass_confirmation" id="user_pass_confirmation" class="txt txt250" value="" size="20" tabindex="100" /><br />';
			$r .= '<p class="description">Redigite sua senha para confirmação.';
			$r .= '</td></tr>';
		} else {
			$r .= '<tr class="pass"><th>';
			$r .= '<label for="user_mail"'.$class.'>E-mail</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="user_mail" id="user_mail" class="txt txt250" value="'.$_POST['user_mail'].'" size="20" tabindex="95" /> <br />';
			$r .= '</td></tr>';

		}

		// criar botão de envio
		$r .= '<tr><th>';
		$r .= '</th><td>';
		$r .= '<input type="submit" name="submit" id="submit" class="btn" value="Enviar" tabindex="14" />';
		$r .= '</td></tr>';

		// divisao
		$r .= '</table>';
		$r .= '</form>';



		// verifica se o formulário deve ser impresso ou devolvido em forma de dados
		if($args['echo']){ echo $r; } else { return $r; }

	}


	function pg_password_action($args=array()) {
		// confere se é metodo POST
		if($_POST) {
			//inicia aviso
			global $password_alert;
			$password_alert = array();
			$id = '';

			if($_POST['type']=='pass') {

				//confere se a senhas sao iguais - cadastro simples
				if($_POST['user_pass'] && $_POST['user_pass_confirmation']) {
					if($_POST['user_pass'] != $_POST['user_pass_confirmation']) {
						array_push($password_alert, '<p class="alert alert-error">As senhas digitadas não são iguais.</p>');
					}
				} else {
					array_push($password_alert, '<p class="alert alert-error">A senha não foi digitada corretamente.</p>');
				}

				if(is_user_logged_in()){
					global $current_user;
					get_currentuserinfo();
					$id = $current_user->ID;
				} else {
					if(get_user_meta(email_exists($_POST['email']), "token", true) == $_POST['token']) {
						$id = email_exists($_POST['email']);
					} else {
						array_push($password_alert, '<p class="alert alert-error">A senha não pode ser alterada.</p>'.$_POST['token']);
					}
				}


				if(!count($password_alert) && $id) {
					$userdata = array (
						'ID' => $id,
						'user_pass' => $_POST['user_pass']
					);
					wp_update_user( $userdata );
					array_push($password_alert, '<p class="alert alert-ok">Senha alterada com sucesso.</p>');
				}

			} else {

				if($_POST['user_mail'] && is_email($_POST['user_mail'])) {
					if($id = email_exists($_POST['user_mail'])) {

						// configuração da mensagem de confirmação
						$to = $_POST['user_mail'];
						$subject = "Recuperação de Senha";
						$headers = "From: IEMI <naoresponda@iemi.com.br>\r\n";
						$headers .= "Reply-To: IEMI <faleconosco@iemi.com.br>\r\n";
						$headers .= "Return-Path: IEMI <faleconosco@iemi.com.br>\r\n";

						// cria mensagem de confirmação
						$message = "Olá,

Você solicitou o serviço de recuperação de senha. Para cadastrar sua nova senha, acesse o endereço abaixo digite sua nova senha.

http://www.iemi.com.br/conta/senha/?e=".$_POST['user_mail']."&t=".get_user_meta(email_exists($_POST['user_mail']), "token", true)."

Caso não tenha efetuado essa requisição, nenhum ação precisa ser tomada e sua senha não será alterada.

Atenciosamente,

IEMI - Instituto de Estudos e Marketing Industrial
http://www.iemi.com.br
";

						wp_mail( $to, $subject, $message, $headers );
						$send_it_to = $_POST['user_mail'];
						$_POST = array();


						array_push($password_alert, '<p class="alert alert-ok">Foi enviado uma mensagem para seu email.</p>');

					} else {
						array_push($password_alert, '<p class="alert alert-error">E-mail não encontrado.</p>');
					}
				} else {
					array_push($password_alert, '<p class="alert alert-error">E-mail inválido..</p>');
				}


			}
		}

	}

	/*////////////////////////////////////////////////////////////////////////
		NOME		pg_user($args=array())
		FUNÇÃO		Tenta criar um novo usuário a partir do formulário ou devolve o erro
		GRUPO		Controle de cadastro e login
		PARÂMETROS	nenhum
		$args ->	Define os argumentos, deve ser uma array

	*////////////////////////////////////////////////////////////////////////
	function pg_update_action($args=array()) {
		// confere se é metodo POST
		if($_POST){
                    
                        _log(print_r($_POST,true));
                    
                        /*foreach($_GET as $name => $value) {
                            print "$name : $value<br>";
                        }

                        foreach($_POST as $name => $value) {
                            print "$name : $value<br>";
                        }*/

			//inicia aviso
			global $register_alert;
			global $register_field;
			$register_alert = array();
			$register_field = array();


			//confere se o tipo de cadastro foi escolhido
			if($_POST['type']) {

				//confere se todos os campos foram digitados
				if(isset($_POST['wp-submit'])) {
					// faz verificação para cadastro tipo pf
					if($_POST['type']=='estudante') {
						// verifica campos necessário para pf - cadastro simples
						if(!trim($_POST['first_name']) || !trim($_POST['user_email']) || !trim($_POST['state']) || !trim($_POST['phone'])) {
							array_push($register_alert, '<p class="alert alert-error">Todos os campos com * devem ser preenchidos.</p>');
							$register_field['obligated'] = true;
						// verifica campos necessário para pf - cadastro
						}
						/*if (!trim($_POST['cpf']) || !validate('cpf',trim($_POST['cpf']))) {
							array_push($register_alert, '<p class="alert alert-error">O CPF parece inválido.</p>');
							$register_field['cpf'] = true;
						}*/
						// verifica telefones para pf
						if((!eregi("^\([0-9]{2}\) [0-9]{4}-[0-9]{4}$", $_POST['phone'])) && (!eregi("^\([0-9]{2}\) [0-9]{5}-[0-9]{4}$", $_POST['phone']))  ) {
							array_push($register_alert, '<p class="alert alert-error">É necessário o preenchimento de um telefone para contato na forma (DDD) 3333-3333.</p>');
							$register_field['phone'] = true;
						}

					// faz verificação para cadastro tipo pj
					} elseif($_POST['type']=='pj' || $_POST['type']=='empresario') {
						/*if(!$_POST['cnpj'] || !validate('cnpj',trim($_POST['cnpj']))) {
							array_push($register_alert, '<p class="alert alert-error">O CNPJ parece inválido.</p>');
							$register_field['cnpj'] = true;
						}*/
						
						// verifica campos necessário para pj
						if(!trim($_POST['company']) || !trim($_POST['first_name']) || !trim($_POST['user_email']) || !trim($_POST['country']) || !trim($_POST['city']) || !trim($_POST['cep']) || !trim($_POST['state']) || !trim($_POST['address']) || !trim($_POST['role'])) {
							array_push($register_alert, '<p class="alert alert-error">Todos os campos com * devem ser preenchidos.</p>');
							$register_field['obligated'] = true;
						// verifica campos necessário para pf - cadastro
						}
						// verifica telefones para pf
						if(!(trim($_POST['phone_work'])) || ( (!eregi("^\([0-9]{2}\) [0-9]{4}-[0-9]{4}$", $_POST['phone_work'])) && (!eregi("^\([0-9]{2}\) [0-9]{5}-[0-9]{4}$", $_POST['phone_work'])) )) {
							array_push($register_alert, '<p class="alert alert-error">É necessário o preenchimento de um telefone para contato na forma (DDD) 3333-3333.</p>');
							$register_field['phone_work'] = true;
						}
					} else {			//Se for jornalista
						// verifica campos necessário para pj
						if(!trim($_POST['first_name']) || !trim($_POST['phone_work']) || !trim($_POST['state']) || !trim($_POST['country']) || !trim($_POST['user_email']) || !trim($_POST['periodicity']) || !trim($_POST['media'])) {
							array_push($register_alert, '<p class="alert alert-error">Todos os campos com * devem ser preenchidos.</p>');
							$register_field['obligated'] = true;
						// verifica campos necessário para pf - cadastro
						}
						
						// verifica telefones para pf
						if((!eregi("^\([0-9]{2}\) [0-9]{4}-[0-9]{4}$", $_POST['phone_work'])) && (!eregi("^\([0-9]{2}\) [0-9]{5}-[0-9]{4}$", $_POST['phone_work']))) {
							array_push($register_alert, '<p class="alert alert-error">Por favor preencha o telefone na forma (DDD) 3333-3333.</p>');
							$register_field['phone'] = true;
						}
					}

					// verifica dados do ecommerce - cadastro ecommerce
					if($_POST['full']) {
						if(!trim($_POST['billingaddress']) || !trim($_POST['billingcity']) || !trim($_POST['billingstate']) || !trim($_POST['billingpostcode']) || !trim($_POST['shippingaddress']) || !trim($_POST['shippingcity']) || !trim($_POST['shippingstate']) || !trim($_POST['shippingpostcode'])) {
							array_push($register_alert, '<p class="alert alert-error">Os endereços de cobrança e entrega devem ser preenchidos completamente.</p>');
							$register_field['ecommerce'] = true;
						}
					}

					//confere se a senhas sao iguais - cadastro simples
					if($_POST['user_pass'] && $_POST['user_pass_confirmation'] && !$_POST['id']) {
						if($_POST['user_pass'] != $_POST['user_pass_confirmation']) {
							array_push($register_alert, '<p class="alert alert-error">As senhas digitadas não são iguais.</p>');
							$register_field['password'] = true;
						}
					} else {
						// confere se não é atualização
						if(!$_POST['id']) {
							array_push($register_alert, '<p class="alert alert-error">A senha não foi digitada corretamente.</p>');
							$register_field['password'] = true;
						}
					}
				}
			// verifica se o tipo de cadastro nao foi selecionado
			} else {
				array_push($register_alert, '<p class="alert alert-error">Selecione o tipo de cadastro para continuar.</p>');
				$register_field['type'] = true;
			}


			//confere se o email é valido para novos cadastros
			if(!$_POST['id']) {
				if(trim($_POST['user_email']) && !is_email(trim($_POST['user_email']))){
					array_push($register_alert, '<p class="alert alert-error">O endereço de email parece inválido.</p>');
					$register_field['email'] = true;
				// confere se o email está em uso
				} elseif (trim($_POST['user_email'])  && email_exists(trim($_POST['user_email']))) {
					array_push($register_alert, '<p class="alert alert-error">Já existe um usuário cadastrado com este email.</a>');
					$register_field['email'] = true;
				}
			}

			// inicia processo de gravação
			if(count($register_alert) == 0) {

				//init
				$userdata = array();

				// configura array $userdata
				$userdata['first_name'] = trim($_POST['first_name']);
				$userdata['last_name'] = trim($_POST['last_name']);
				$userdata['display_name'] = trim($_POST['first_name'].' '.$_POST['last_name']);


				if(!$_POST['id']) {
					// configura dados que serão usados apenas no cadastro
					$userdata['user_email'] = trim($_POST['user_email']);
					$userdata['user_login'] = trim($_POST['user_email']);
					$userdata['user_pass'] = trim($_POST['user_pass']);
					$userdata['role'] = 'subscriber';
				} else {
					// configura dados que serão usados apenas no atualização
					$userdata['ID'] = trim($_POST['id']);

					$objuser = new WP_User( trim($_POST['id']) );
					if ( !empty( $objuser->roles ) && is_array( $objuser->roles ) ) {
						foreach ( $objuser->roles as $role ) { $userdata['role'] = $role; }
					}

				}

				if(!$_POST['id']) {
					// tenta cadastrar novo usuario
					$userCreationResponse = $user = wp_insert_user( $userdata );
					if (trim($_POST['type']) == "estudante"){
													$mensagem = "\n
													Novo usuário cadastrado.
													Nome: ".$_POST['first_name'].' '.$_POST['last_name']."
													Atuação: Estudante
													Universidade: ".trim($_POST['university'])."
													Curso: ".trim($_POST['course'])."
													Email: ".$_POST['user_email']."
													Telefone: ".$_POST['phone_work']." ".$_POST['phone_cel']." ".$_POST['phone'];
												}elseif (trim($_POST['type'] == "jornalista")){
													$mensagem = "
													Novo usuário cadastrado.
													Nome: ".$_POST['first_name'].' '.$_POST['last_name']."
													Atuação: Jornalista
													Veículo: ".trim($_POST['media'])."
													Email: ".$_POST['user_email']."
													Telefone: ".$_POST['phone_work']." ".$_POST['phone_cel']." ".$_POST['phone'];												
												}else if(trim($_POST['type']) == "empresario"){
													$mensagem = "
													Novo usuário cadastrado.
													Nome: ".$_POST['first_name'].' '.$_POST['last_name']."
													Atuação: Profissional da área
													Empresa: ".trim($_POST['company'])."
													Cargo: ".trim($_POST['role'])."
													Email: ".$_POST['user_email']."
													Telefone: ".$_POST['phone_work']." ".$_POST['phone_cel']." ".$_POST['phone'];
												}
                                               
					$headers = 'From: Site IEMI <faleconosco@iemi.com.br>' . "\r\n";
                                        
            
                    
                    //wp_mail('web@big4web.com.br', 'Novo usuário cadastrado', $mensagem, $headers);                    
                    
                
                /*if(isset ($_POST['first_name']) &&  $_POST['first_name']!=''){
                    wp_mail('karzin@gmail.com', 'Novo usuário cadastrado', $mensagem, $headers);
                }*/
                
          

					//print_r($user);
				} else {
					// tenta atualizar usuario
					$user = wp_update_user( $userdata );
				}



				// verifica se foi cadastrado
				if(is_numeric($user)) {

					// gera token de confirmação
					$token = md5(uniqid(rand(), true));

					// insere campos extras
					update_usermeta( $user, 'type', trim($_POST['type']) );
					update_usermeta( $user, 'gender', trim($_POST['gender']) );
					update_usermeta( $user, 'media', trim($_POST['media']) );
					update_usermeta( $user, 'periodicity', trim($_POST['periodicity']) );
                                         if(isset($_POST['phone'])) $_POST['phone']  = $_POST['phone'];
					update_usermeta( $user, 'phone', trim($_POST['phone']) );
					update_usermeta( $user, 'cpf', trim($_POST['cpf']) );
					update_usermeta( $user, 'coupon', trim($_POST['coupon']) );
					update_usermeta( $user, 'university', trim($_POST['university']) );
					update_usermeta( $user, 'state', trim($_POST['state']) );
					update_usermeta( $user, 'course', trim($_POST['course']) );
                                        if(isset($_POST['phone_home']))  $_POST['phone_home']  = $_POST['phone_home'];
                                        if(isset($_POST['phone_work'])) $_POST['phone_work']  = $_POST['phone_work'];
                                        if(isset($_POST['phone_cel'])) $_POST['phone_cel']  = $_POST['phone_cel'];
					update_usermeta( $user, 'phone_home', trim($_POST['phone_home']) );
					update_usermeta( $user, 'phone_work', trim($_POST['phone_work']) );
					update_usermeta( $user, 'phone_cel', trim($_POST['phone_cel']) );
					update_usermeta( $user, 'activity', trim($_POST['activity']) );
					update_usermeta( $user, 'company', trim($_POST['company']) );
					update_usermeta( $user, 'cnpj', trim($_POST['cnpj']) );
					update_usermeta( $user, 'foundation_year', trim($_POST['foundation_year']) );
					update_usermeta( $user, 'address', trim($_POST['address']) );
					update_usermeta( $user, 'cep', trim($_POST['cep']) );
					update_usermeta( $user, 'city', trim($_POST['city']) );
					update_usermeta( $user, 'country', trim($_POST['country']));
					update_usermeta( $user, 'role', trim($_POST['role']) );
					update_usermeta( $user, 'title', trim($_POST['title']) );
					if(!$_POST['id']) { update_usermeta( $user, 'token', $token ); }
					update_usermeta( $user, 'newsletteroutrasareas', $_POST['newsletter-outras-areas'] );

					global $newsletter_areas;
					foreach ($newsletter_areas as $grupo => $areas) {

						foreach ($areas as $area) {
							if($_POST['newsletter-'.sanitize_title($area)]) {
								// add ao bd
								update_usermeta( $user, 'newsletter'.str_replace('-', '', sanitize_title($area)), 1 );
							} else {
								// exclue do bd
								update_usermeta( $user, 'newsletter'.str_replace('-', '', sanitize_title($area)), 0 );
							}
						}

					}

					update_usermeta( $user, 'billingaddress', trim($_POST['billingaddress']) );
					update_usermeta( $user, 'billingcity', trim($_POST['billingcity']) );
					update_usermeta( $user, 'billingstate', trim($_POST['billingstate']) );
					update_usermeta( $user, 'billingpostcode', trim($_POST['billingpostcode']) );
					update_usermeta( $user, 'billingcountry', trim($_POST['billingcountry']) );

					update_usermeta( $user, 'shippingaddress', trim($_POST['shippingaddress']) );
					update_usermeta( $user, 'shippingcity', trim($_POST['shippingcity']) );
					update_usermeta( $user, 'shippingstate', trim($_POST['shippingstate']) );
					update_usermeta( $user, 'shippingpostcode', trim($_POST['shippingpostcode']) );
					update_usermeta( $user, 'shippingcountry', trim($_POST['shippingcountry']) );

					if(!$_POST['id']) {
						// configuração da mensagem de confirmação
						$to = $_POST['user_email'];
						$subject = "Confirmação de E-mail";
						$headers = "From: IEMI <naoresponda@iemi.com.br>\r\n";
						$headers .= "Reply-To: IEMI <faleconosco@iemi.com.br>\r\n";
						$headers .= "Return-Path: IEMI <faleconosco@iemi.com.br>\r\n";

						// cria mensagem de confirmação
						$message = "Olá ".$_POST['first_name']." ".$_POST['last_name']."

Agradecemos seu cadastro no site IEMI. Por razões de segurança é necessário confirmar a propriedade deste email.

Se você efetuou este cadastro e deseja ativá-lo, acesse o link abaixo:
http://www.iemi.com.br/conta/ativacao/?login=".$_POST['user_email']."&key=".$token."

Caso contrário, nenhum ação precisa ser tomada, seu email será descadastrado automaticamente.

Atenciosamente,

IEMI - Instituto de Estudos e Marketing Industrial
http://www.iemi.com.br
";

						wp_mail( $to, $subject, $message, $headers );
                                                $email_remetente = 
                                                $userCreationResponse = $user = wp_insert_user( $userdata );
                                                
                                                
                                                if (trim($_POST['type']) == "estudante"){
													$mensagem = "\n
													Novo usuário cadastrado.
													Nome: ".$_POST['first_name'].' '.$_POST['last_name']."
													Atuação: Estudante
													Universidade: ".trim($_POST['university'])."
													Curso: ".trim($_POST['course'])."
													Email: ".$_POST['user_email']."
													Telefone: ".$_POST['phone_work']." ".$_POST['phone_cel']." ".$_POST['phone'];
												}elseif (trim($_POST['type'] == "jornalista")){
													$mensagem = "
													Novo usuário cadastrado.
													Nome: ".$_POST['first_name'].' '.$_POST['last_name']."
													Atuação: Jornalista
													Veículo: ".trim($_POST['media'])."
													Email: ".$_POST['user_email']."
													Telefone: ".$_POST['phone_work']." ".$_POST['phone_cel']." ".$_POST['phone'];												
												}else if(trim($_POST['type']) == "empresario"){
													$mensagem = "
													Novo usuário cadastrado.
													Nome: ".$_POST['first_name'].' '.$_POST['last_name']."
													Atuação: Profissional da área
													Empresa: ".trim($_POST['company'])."
													Cargo: ".trim($_POST['role'])."
													Email: ".$_POST['user_email']."
													Telefone: ".$_POST['phone_work']." ".$_POST['phone_cel']." ".$_POST['phone'];
												}
                                               
                                                
                                                
                                                $email_remetente = "faleconosco@iemi.com.br";
												$to = "faleconosco@iemi.com.br";
												$headers = "MIME-Version: 1.1\n";
												$headers .= "Content-type: text/plain; charset=utf-8\n";
												$headers .= "From: $email_remetente\n"; // remetente
												$headers .= "Return-Path: $to\n"; // return-path
												$headers .= "Reply-To: $to\n"; // Endereço (devidamente validado) que o seu usuário informou no contato
												//$envio = mail($to, 'Novo usuário cadastrado', $mensagem, $headers, "-f$email_remetente");
												
												wp_mail('faleconosco@iemi.com.br', 'Novo usuário cadastrado', $mensagem, $headers,"-f$email_remetente");
                                                //wp_mail('web@big4web.com.br', 'Novo usuário cadastrado', $mensagem, $headers);
                                                
                                                
						global $send_it_to;
						$send_it_to = $_POST['user_email'];

						$_POST = array();

					} else {
						// redireciona se for atualização
						$_SESSION['updated'] = 1;
						header('location: '.$_POST['redirect_to']);
						exit();
					}

					$r = true;
				}
			}

		} else {
			// retorna false se não existir todos os campos necessários
			$r = false;
		}

		return $r;
	}



	/*////////////////////////////////////////////////////////////////////////
		NOME		pg_register_form($args=array())
		FUNÇÃO		Exibe o formulário customizado de cadastro
		GRUPO		Controle de cadastro e login
		PARÂMETROS
		$args ->	Define os argumentos, deve ser uma array
			$args[$echo] -> Define se o formulário será impresso ou enviado em forma de dados, boleano
			$args[$action] -> Define o link de acao do formulário, deve ser um url válido
			$args[$redirect_to] -> define o valor para o campo oculto de redirecionamento, deve ser um url
			$args[$type] -> define o tipo de cadastro a ser mostrado
			$args[$newsletter] -> exibe apenas formulario da newsletter
			$args[$id] -> define a ID do usuário a ser atualizado;
			$args[$full] -> exibe formulário completo
	*////////////////////////////////////////////////////////////////////////
	function pg_register_form($args=array()){
	// init
	global $pg_user;
	global $register_alert;
	global $register_field;
	global $send_it_to;
	global $newsletter_areas;

	if($send_it_to && !$register_alert) {
		array_push($register_alert, '<p class="alert alert-ok">O seu cadastro foi preenchido corretamente. Enviamos uma mensagem para o email '.$send_it_to.' com instruções para a validação do seu cadastro.</p>');
	}

	if($_SESSION['updated'] && !$register_alert) {
		$register_alert[1000] = '<p class="alert alert-ok">Cadastro atualizado com sucesso.</p>';
		$_SESSION['updated'] = 0;
	}


	$r = '';

	// tratamento de variáveis
	if(!isset($args['echo'])) { $args['echo']=1; }
	if(!$args['action']) { $args['action'] = get_permalink(); }
	if(!$args['redirect_to']) {
		if($_POST['redirect_to']) {
			$args['redirect_to'] = $_POST['redirect_to'];
		} else {
			$args['redirect_to'] = get_permalink();
		}
	}
	if(!$args['full']) { $args['full'] = $_POST['full']; }
	if(!$args['type']) {
		if($_POST['type']) {
			$args['type'] = $_POST['type'];
		} elseif(is_numeric($args['id'])) {
			$args['type'] = get_user_meta($args['id'], 'type', true);
		}
	}
	if(!is_numeric($args['id'])) { $args['id'] = ''; }


	// tratamento dos valores
	if($args['id']) { $user_info = get_userdata($args['id']); }
	if($args['id'] && !trim($_POST['type'])) { $type = get_user_meta($args['id'], 'type', true); } else { $type = trim($_POST['type']); }
	if($args['id'] && !trim($_POST['first_name'])) { $first_name = $user_info->user_firstname; } else { $first_name = trim($_POST['first_name']); }
	if($args['id'] && !trim($_POST['last_name'])) { $last_name = $user_info->user_lastname; } else { $last_name = trim($_POST['last_name']); }
	if($args['id'] && !trim($_POST['user_email'])) { $user_email = $user_info->user_email; } else { $user_email = trim($_POST['user_email']); }
	//$_POST['phone'] = $_POST['code_country']. " " . $_POST['phone'];
        if($args['id'] && !trim($_POST['phone'])) { $phone = get_user_meta($args['id'], 'phone', true); } else { $phone = trim($_POST['phone']); }
	if($args['id'] && !trim($_POST['gender'])) { $gender = get_user_meta($args['id'], 'gender', true); } else { $gender = trim($_POST['gender']); }
	if($args['id'] && !trim($_POST['media'])) { $media = get_user_meta($args['id'], 'media', true); } else { $media = trim($_POST['media']); }
	if($args['id'] && !trim($_POST['periodicity'])) { $periodicity = get_user_meta($args['id'], 'periodicity', true); } else { $periodicity = trim($_POST['periodicity']); }	
	if($args['id'] && !trim($_POST['cpf'])) { $cpf = get_user_meta($args['id'], 'cpf', true); } else { $cpf = trim($_POST['cpf']); }
	if($args['id'] && !trim($_POST['university'])) { $university = get_user_meta($args['id'], 'university', true); } else { $university = trim($_POST['university']); }
	if($args['id'] && !trim($_POST['state'])) { $state = get_user_meta($args['id'], 'state', true); } else { $state = trim($_POST['state']); }
	if($args['id'] && !trim($_POST['course'])) { $course = get_user_meta($args['id'], 'course', true); } else { $course = trim($_POST['course']); }
	if($args['id'] && !trim($_POST['coupon'])) { $coupon = get_user_meta($args['id'], 'coupon', true); } else { $coupon = trim($_POST['coupon']); }
	//$_POST['phone_home'] = $_POST['code_country']. " " . $_POST['phone_home'];
        //$_POST['phone_work'] = $_POST['code_country']. " " . $_POST['phone_work'];
        //$_POST['phone_cel'] = $_POST['code_country']. " " . $_POST['phone_cel'];
        
        if($args['id'] && !trim($_POST['phone_home'])) { $phone_home = get_user_meta($args['id'], 'phone_home', true); } else { $phone_home = trim($_POST['phone_home']); }
	if($args['id'] && !trim($_POST['phone_work'])) { $phone_work = get_user_meta($args['id'], 'phone_work', true); } else { $phone_work = trim($_POST['phone_work']); }
	if($args['id'] && !trim($_POST['phone_cel'])) { $phone_cel = get_user_meta($args['id'], 'phone_cel', true); } else { $phone_cel = trim($_POST['phone_cel']); }
	if($args['id'] && !trim($_POST['company'])) { $company = get_user_meta($args['id'], 'company', true); } else { $company = trim($_POST['company']); }
	if($args['id'] && !trim($_POST['foundation_year'])) { $foundation_year = get_user_meta($args['id'], 'foundation_year', true); } else { $foundation_year = trim($_POST['foundation_year']); }
	if($args['id'] && !trim($_POST['address'])) { $address = get_user_meta($args['id'], 'address', true); } else { $address = trim($_POST['address']); }
	if($args['id'] && !trim($_POST['cep'])) { $cep = get_user_meta($args['id'], 'cep', true); } else { $cep = trim($_POST['cep']); }
	if($args['id'] && !trim($_POST['city'])) { $city = get_user_meta($args['id'], 'city', true); } else { $city = trim($_POST['city']); }
	if($args['id'] && !trim($_POST['country'])) { $country = get_user_meta($args['id'], 'country', true); } else { $country = $_POST['country']; }
	if($args['id'] && !trim($_POST['activity'])) { $activity = get_user_meta($args['id'], 'activity', true); } else { $activity = trim($_POST['activity']); }
	if($args['id'] && !trim($_POST['role'])) { $role = get_user_meta($args['id'], 'role', true); } else { $role = trim($_POST['role']); }
	if($args['id'] && !trim($_POST['cnpj'])) { $cnpj = get_user_meta($args['id'], 'cnpj', true); } else { $cnpj = trim($_POST['cnpj']); }
	foreach ($newsletter_areas as $grupo => $areas) {
		foreach ($areas as $area) {
			if($args['id'] && !trim($_POST['newsletter-'.sanitize_title($area)])) { $newsletter[sanitize_title($area)] = get_user_meta($args['id'], str_replace('-', '', 'newsletter-'.sanitize_title($area)), true); } else { $newsletter[sanitize_title($area)] = trim($_POST['newsletter-'.sanitize_title($area)]); }
		}
	}
	if($args['id'] && !trim($_POST['newsletter-outras-areas'])) { $newsletter['outras-areas'] = get_user_meta($args['id'], 'newsletteroutrasareas', true); } else { $newsletter['outras-areas'] = trim($_POST['newsletter-outras-areas']); }
	if($args['id'] && !trim($_POST['billingaddress'])) { $billingaddress = get_user_meta($args['id'], 'billingaddress', true); } else { $billingaddress = trim($_POST['billingaddress']); }
	if($args['id'] && !trim($_POST['billingcity'])) { $billingcity = get_user_meta($args['id'], 'billingcity', true); } else { $billingcity = trim($_POST['billingcity']); }
	if($args['id'] && !trim($_POST['billingstate'])) { $billingstate = get_user_meta($args['id'], 'billingstate', true); } else { $billingstate = trim($_POST['billingstate']); }
	if($args['id'] && !trim($_POST['billingpostcode'])) { $billingpostcode = get_user_meta($args['id'], 'billingpostcode', true); } else { $billingpostcode = trim($_POST['billingpostcode']); }
	if($args['id'] && !trim($_POST['billingcountry'])) { $billingcountry = get_user_meta($args['id'], 'billingcountry', true); } else { $billingcountry = trim($_POST['billingcountry']); }
	if($args['id'] && !trim($_POST['shippingaddress'])) { $shippingaddress = get_user_meta($args['id'], 'shippingaddress', true); } else { $shippingaddress = trim($_POST['shippingaddress']); }
	if($args['id'] && !trim($_POST['shippingcity'])) { $shippingcity = get_user_meta($args['id'], 'shippingcity', true); } else { $shippingcity = trim($_POST['shippingcity']); }
	if($args['id'] && !trim($_POST['shippingstate'])) { $shippingstate = get_user_meta($args['id'], 'shippingstate', true); } else { $shippingstate = trim($_POST['shippingstate']); }
	if($args['id'] && !trim($_POST['shippingpostcode'])) { $shippingpostcode = get_user_meta($args['id'], 'shippingpostcode', true); } else { $shippingpostcode = trim($_POST['shippingpostcode']); }
	if($args['id'] && !trim($_POST['shippingcountry'])) { $shippingcountry = get_user_meta($args['id'], 'shippingcountry', true); } else { $shippingcountry = trim($_POST['shippingcountry']); }

	// cria formulário
	$r .= '<form name="registerform" action="'.$args['action'].'" method="post">';

	// incia tabela
	$r .= '<table border="0" cellspacing="0" cellpadding="0" class="simpleinfo double">';
	$r .= '<tr><td colspan="4">';
	$r .= '<p class="description">Os campos com * são de preenchimento obrigatório.</p>';
	$r .= '</td></tr>';


	// exibe mensagens
	if ( count($register_alert) ) {
		$r .= '<tr><th colspan="4">';
		foreach ($register_alert as $r_alert) {
			$r .= $r_alert;
			//array_push($pages, $value);
		}
		$r .= '</th></tr>';
	}

	if($send_it_to && !$register_alert) {
		$r .='</table></form>';
	} else {


		// título gerais
		$r .= '<tr><td colspan="4">';
		$r .= '<h3>Informações Gerais</h3>';
		$r .= '</td></tr>';

		// cria campo tipo de cadastro
		if($register_field['obligated'] && !$type) { $class = ' class="error"'; } else { $class = ''; }
		$r .= '<tr><th>';
		$r .= '<label for="type"'.$class.'>Cadastro*</label>';
		$r .= '</th><td>';
		$r .='<select name="type" id="type" class="txt txtauto register_type" tabindex="49" >';
		$r .= '<option value="">Selecione</option>';
		$r .= '<option value="estudante" '.selected( $type, 'estudante', false ).'>Estudante</option>';
		$r .= '<option value="empresario" '.selected( $type, 'empresario', false ).'>Empresário/Profissional da Área</option>';
		$r .= '<option value="jornalista" '.selected( $type, 'jornalista', false ).'>Jornalista</option>';
		$r .= '</select>';
		$r .= '</td><th></th><td></td></tr>';

		if ( 'estudante' == $args['type'] ) {
			// cria campo de nome
			if($register_field['obligated'] && !$first_name) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="first_name"'.$class.'>Nome*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="first_name" id="first_name" class="txt txt250" value="'.stripslashes($first_name).'" size="20" tabindex="50" />';
			$r .= '</td></tr>';
                        
                        //pais
			if($register_field['obligated'] && !$country) {  $class = ' class="error"'; } else { $class = ''; }
			$r .='<tr><th><label for="country" '.$class.'>País*</label></th>';
      			$r .= '<td><select onchange="altera_codigo(this)" name="country" id="country" class="txt txt250"  tabindex="50">';
			$r .= country_select($country).'</select></td>';
                                
			// estado
			// estado
			if($register_field['obligated'] && !$state) {  $class = ' class="error"'; } else { $class = ''; }
			$r .='<th><label for="state" '.$class.'>Estado*</label></th>';
      			$r .= '<td><input type="text" name="state" id="state" class="txt txt250" value="'.stripslashes($state).'" size="20" tabindex="50" />';
			$r .='</td></tr>';
			// telefone
			if($register_field['obligated'] && !$phone) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="phone"'.$class.'>Telefone*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" maxlength="5" name="code_country" id="code_country" class="txt" style="width:50px"  value="+55" size="10" tabindex="50" />
                            <input type="text" maxlength="15" name="phone" onkeypress="mascara( this, mtel )" id="phone" class="txt" style="width:190px" value="'.stripslashes($phone).'" size="20" tabindex="50" />';
			$r .= '</td>';

			// email
			if($register_field['obligated'] && !$user_email) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<th>';
			$r .= '<label for="user_email"'.$class.'>E-mail*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="user_email" id="user_email" class="txt txt250" value="'.stripslashes($user_email).'" size="20" tabindex="50" />';
			$r .= '</td></tr>';

			// faculdade
			if($register_field['obligated'] && !$university) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="university"'.$class.'>Faculdade*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="university" id="university" class="txt txt250" value="'.stripslashes($university).'" size="20" tabindex="50" />';
			$r .= '</td>';

			// curso
			if($register_field['obligated'] && !$course) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<th>';
			$r .= '<label for="course"'.$class.'>Curso*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="course" id="course" class="txt txt250" value="'.stripslashes($course).'" size="20" tabindex="50" />';
			$r .= '</td></tr>';
                        
                        

		} elseif ( 'empresario' == $args['type'] ) {
			// empresa
			if($register_field['obligated'] && !$company) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="company"'.$class.'>Empresa*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="company" id="company" class="txt txt250" value="'.stripslashes($company).'" size="20" tabindex="50" />';
			$r .= '</td></tr>';

			// ano
			//if($register_field['obligated'] && !$phone) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="foundation_year">Ano de Fundação</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="foundation_year" id="foundation_year" class="txt txt250" value="'.stripslashes($foundation_year).'" size="20" tabindex="50" />';
			$r .= '</td>';

			// cnpj
			//if($register_field['obligated'] && !$cnpj) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<th>';
			$r .= '<label for="cnpj"'.$class.'>CNPJ*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="cnpj" id="cnpj" class="txt txt250" value="'.stripslashes($cnpj).'" size="20" tabindex="50" />';
			$r .= '</td></tr>';

			// nome
			if($register_field['obligated'] && !$first_name) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="first_name"'.$class.'>Nome*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="first_name" id="first_name" class="txt txt250" value="'.stripslashes($first_name).'" size="20" tabindex="50" />';
			$r .= '</td></tr>';
                        
                        //pais
			if($register_field['obligated'] && !$country) {  $class = ' class="error"'; } else { $class = ''; }
			$r .='<tr><th><label for="country" '.$class.'>País*</label></th>';
      			$r .= '<td><select onchange="altera_codigo(this)" name="country" id="country" class="txt txt250"  tabindex="50">';
			$r .= country_select($country).'</select></td>';
                                
                        // telefone
			if($register_field['obligated'] && !$phone) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="phone"'.$class.'>Telefone*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" maxlength="5" name="code_country" id="code_country" class="txt" style="width:50px"  value="'.retorna_codigo_pais($country).'" size="10" tabindex="50" />
                   <input type="text" maxlength="15" name="phone_work" onkeypress="mascara( this, mtel )" id="phone_work" class="txt" style="width:190px" value="'.stripslashes($phone_work).'" size="20" tabindex="50" />';
			$r .= '</td>';
                       
			// email
			if($register_field['obligated'] && !$user_email) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<th>';
			$r .= '<label for="user_email"'.$class.'>E-mail empresarial*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="user_email" id="user_email" class="txt txt250" value="'.stripslashes($user_email).'" size="20" tabindex="50" />';
			$r .= '</td></tr>';

			// cargo
			if($register_field['obligated'] && !$role) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="role"'.$class.'>Cargo*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="role" id="role" class="txt txt250" value="'.stripslashes($role).'" size="20" tabindex="50" />';
			$r .= '</td></tr>';
                        
                        
                        
                        // estado
			// estado
			if($register_field['obligated'] && !$state) {  $class = ' class="error"'; } else { $class = ''; }
			$r .='<th><label for="state" '.$class.'>Estado*</label></th>';
      			$r .= '<td><input type="text" name="state" id="state" class="txt txt250" value="'.stripslashes($state).'" size="20" tabindex="50" />';
			$r .='</td></tr>';
                        
			// endereço
			if($register_field['obligated'] && !$address) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="address"'.$class.'>Endereço*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="address" id="address" class="txt txt250" value="'.stripslashes($address).'" size="20" tabindex="50" />';
			$r .= '</td>';

                        // cidade
			if($register_field['obligated'] && !$city) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<th>';
			$r .= '<label for="city"'.$class.'>Cidade*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="city" id="city" class="txt txt250" value="'.stripslashes($city).'" size="20" tabindex="50" />';
			$r .= '</td></tr>';
                        
			// cep
			if($register_field['obligated'] && !$cep) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="cep"'.$class.'>CEP*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="cep" id="cep" class="txt txt250" value="'.stripslashes($cep).'" size="20" tabindex="50" />';
			$r .= '</td>';

			
			

			

		} elseif ( 'jornalista' == $args['type'] ) {
			// cria campo de nome
			if($register_field['obligated'] && !$first_name) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="first_name"'.$class.'>Nome*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="first_name" id="first_name" class="txt txt250" value="'.stripslashes($first_name).'" size="20" tabindex="50" />';
			$r .= '</td>';

			

			// email
			if($register_field['obligated'] && !$user_email) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<th>';
			$r .= '<label for="user_email"'.$class.'>E-mail*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="user_email" id="user_email" class="txt txt250" value="'.stripslashes($user_email).'" size="20" tabindex="50" />';
			$r .= '</td></tr>';

			// veiculo
			if($register_field['obligated'] && !$media) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="media"'.$class.'>Veículo*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" name="media" id="media" class="txt txt250" value="'.stripslashes($media).'" size="20" tabindex="50" />';
			$r .= '</td>';

			// periodicidade
			if($register_field['obligated'] && !$periodicity) { $class = ' class="error"'; } else { $class = ''; }
			$r .='<th><label for="periodicity" '.$class.'>Periodicidade*</label></th>';
			$r .='<td><select name="periodicity" id="periodicity" class="txt txtauto">';
			$r .= '<option value="">Selecione</option>
				<option value="daily" '.selected( esc_attr($periodicity), 'daily', false ).'>Diário</option>
				<option value="weekly" '.selected( esc_attr($periodicity), 'weekly', false ).'>Semanal</option>
				<option value="monthly" '.selected( esc_attr( $periodicity), 'monthly', false ).'>Mensal</option>';
			$r .= '</select>';
			$r .='</td></tr>';
                        
                        //pais
			if($register_field['obligated'] && !$country) {  $class = ' class="error"'; } else { $class = ''; }
			$r .='<tr><th><label for="country" '.$class.'>País*</label></th>';
      			$r .= '<td><select onchange="altera_codigo(this)" name="country" id="country" class="txt txt250"  tabindex="50">';
			$r .= country_select($country).'</select></td>';
                                
                        // estado
			// estado
			if($register_field['obligated'] && !$state) {  $class = ' class="error"'; } else { $class = ''; }
			$r .='<th><label for="state" '.$class.'>Estado*</label></th>';
      			$r .= '<td><input type="text" name="state" id="state" class="txt txt250" value="'.stripslashes($state).'" size="20" tabindex="50" />';
			$r .='</td></tr>';
                        
                         // telefone
			if($register_field['obligated'] && !$phone) { $class = ' class="error"'; } else { $class = ''; }
			$r .= '<tr><th>';
			$r .= '<label for="phone"'.$class.'>Telefone*</label>';
			$r .= '</th><td>';
			$r .= '<input type="text" maxlength="5" name="code_country" id="code_country" class="txt" style="width:50px"  value="+55" size="10" tabindex="50" />
                            <input type="text" maxlength="15" name="phone_work" onkeypress="mascara( this, mtel )" id="phone_work" class="txt" style="width:190px" value="'.stripslashes($phone_work).'" size="20" tabindex="50" />';
			$r .= '</td>';
                       
		}

		// se já houver um tipo de cadastro selecionado
		if($args['type']) {

			// divisao
			$r .= '<tr><th class="division" colspan="4"></th></tr>';

			if(!$args['id']) {
				if($register_field['password']) { $class = ' class="error"'; } else { $class = ''; }
				//cria campo de senha e confirmação e seleção da associação
				$r .= '<tr class="pass"><th>';
				$r .= '<label for="user_pass"'.$class.'>Senha*</label>';
				$r .= '</th><td>';
				$r .= '<input type="password" name="user_pass" id="user_pass" class="txt txt250" value="" size="20" tabindex="95" /> <br />';
				$r .= '<input type="password" name="user_pass_confirmation" id="user_pass_confirmation" class="txt txt250" value="" size="20" tabindex="100" /><br />';
				$r .= '<p class="description">Redigite sua senha para confirmação.';
				$r .= '</td><td colspan="2">';
				$r .= '</td></tr>';
				$r .= '<tr><th class="division" colspan="4"></th></tr>';
			}

			// título newsletter
			$r .= '<tr><td colspan="4">';
			$r .= '<h3>Newsletter</h3>';
			$r .= '</td></tr>';

			// newsletter
			$r .= '<tr><td colspan="4">';
			$r .= '<p>Deseja receber nosso Newsletter? Selecione as áreas de interesse:</p>';
			$r .= '</td></tr>';
			$g = 0; $tabindex = 110;
			foreach ($newsletter_areas as $grupo => $areas) {
				$g++;
				$tabindex++;
				if( $g % 2 != 0 ) { // colunas formulario
					$r .= '<tr><th><label>'.$grupo.'</label></th><td>';
				} else {
					$r .= '<th class="double"><label>'.$grupo.'</label></th><td>';
				}

					$r .= '<table border="0" cellspacing="0" cellpadding="0" style="width:100%;">';
					$a = 0;
					foreach ($areas as $area) {
						if( $a % 2 === 0 ) { $r .= '<tr>'; }
						$r .= '<td style="width:50%; vertical-align:top;"><label for="newsletter-'.sanitize_title($area).'" style="padding-top:0;"><input type="checkbox" name="newsletter-'.sanitize_title($area).'" '.checked( $newsletter[sanitize_title($area)], 1, 0 ).' value="1" tabindex="'.$tabindex.'"> '.$area.'</label></td>';
						$a++;
						if( $a % 2 === 0 ) { $r .= '</tr>'; }
					}
					if( $a % 2 != 0 ) { $r .= '<td></td></tr>'; }
					$r .= '</table>';


				if( $g % 2 != 0 ) { // colunas formulario
					$r .= '</td>';
				} else {
					$r .= '</td></tr><tr><th class="division" colspan="4"></th></tr>';
				}
			}
			//cria outras áreas de interesse
			$r .= '<tr><th>';
			$r .= '<label for="newsletter-outras-areas">Outras Áreas</label>';
			$r .= '</th><td colspan="3">';
			$r .= '<input type="text" name="newsletter-outras-areas" id="newsletter-outras-areas" class="txt txt250" value="'.stripslashes($newsletter['outras-areas']).'" size="20" tabindex="200" />';
			$r .= '</td></tr>';


			if($args['full']) {

				// ECOMMERCE --------

				// divisao
				$r .= '<tr class="ecommerce"><th class="division" colspan="4"></th></tr>';

				// título cobrança
				$r .= '<tr class="ecommerce"><td colspan="4">';
				$r .= '<h3>Endereço para Cobrança</h3>';
				$r .= '</td></tr>';

				//cria endereço de cobranca
				if($register_field['ecommerce'] && !$billingaddress) { $class = ' class="error"'; } else { $class = ''; }
				$r .= '<tr class="ecommerce"><th rowspan="3">';
				$r .= '<label for="billingaddress".'.$class.'>Endereço*</label>';
				$r .= '</th><td rowspan="3">';
				$r .= '<textarea name="billingaddress" id="billingaddress" class="txt txt250" rows="6" cols="40" tabindex="205">'.stripslashes($billingaddress).'</textarea>';
				$r .= '</td>';

				//cria cidade de cobranca
				if($register_field['ecommerce'] && !$billingcity) { $class = ' class="error"'; } else { $class = ''; }
				$r .= '<th>';
				$r .= '<label for="billingcity"'.$class.'>Cidade*</label>';
				$r .= '</th><td>';
				$r .= '<input type="text" name="billingcity" id="billingcity" class="txt txt250" value="'.stripslashes($billingcity).'" size="20" tabindex="210" />';
				$r .= '</td></tr>';
				
				//cria país de cobranca
				            //pais
				if($register_field['ecommerce'] && !$billingcountry) { $class = ' class="error"'; } else { $class = ''; }
			$r .='<tr><th><label for="billingcountry" '.$class.'>País*</label></th>';
      			$r .= '<td><select name="billingcountry" id="billingcountry" class="txt txt250"  tabindex="50">';
				$r .=country_select($billingcountry);
				$r .= '</select></td>';
      			$r .='</tr>';
      			
				//cria estado de cobranca
				if($register_field['ecommerce'] && !$billingstate) { $class = ' class="error"'; } else { $class = ''; }
				$r .= '<tr class="ecommerce"><th>';
				$r .= '<label for="billingstate"'.$class.'>Estado*</label>';
				$r .= '</th><td>';
				$r .='<select name="billingstate" id="billingstate" class="txt txtauto" tabindex="215" >';
				$r .= '<option value="">Selecione</option>';
				$r .= '	<option value="AC" '.selected( esc_attr( $billingstate ), "AC", false ).'>AC</option>
						<option value="AL" '.selected( esc_attr( $billingstate ), 'AL', false ).'>AL</option>
						<option value="AM" '.selected( esc_attr( $billingstate ), 'AM', false ).'>AM</option>
						<option value="AP" '.selected( esc_attr( $billingstate ), 'AP', false ).'>AP</option>
						<option value="BA" '.selected( esc_attr( $billingstate ), 'BA', false ).'>BA</option>
						<option value="CE" '.selected( esc_attr( $billingstate ), 'CE', false ).'>CE</option>
						<option value="DF" '.selected( esc_attr( $billingstate ), 'DF', false ).'>DF</option>
						<option value="ES" '.selected( esc_attr( $billingstate ), 'ES', false ).'>ES</option>
						<option value="GO" '.selected( esc_attr( $billingstate ), 'GO', false ).'>GO</option>
						<option value="MA" '.selected( esc_attr( $billingstate ), 'MA', false ).'>MA</option>
						<option value="MG" '.selected( esc_attr( $billingstate ), 'MG', false ).'>MG</option>
						<option value="MS" '.selected( esc_attr( $billingstate ), 'MS', false ).'>MS</option>
						<option value="MT" '.selected( esc_attr( $billingstate ), 'MT', false ).'>MT</option>
						<option value="PA" '.selected( esc_attr( $billingstate ), 'PA', false ).'>PA</option>
						<option value="PB" '.selected( esc_attr( $billingstate ), 'PB', false ).'>PB</option>
						<option value="PE" '.selected( esc_attr( $billingstate ), 'PE', false ).'>PE</option>
						<option value="PI" '.selected( esc_attr( $billingstate ), 'PI', false ).'>PI</option>
						<option value="PR" '.selected( esc_attr( $billingstate ), 'PR', false ).'>PR</option>
						<option value="RJ" '.selected( esc_attr( $billingstate ), 'RJ', false ).'>RJ</option>
						<option value="RN" '.selected( esc_attr( $billingstate ), 'RN', false ).'>RN</option>
						<option value="RO" '.selected( esc_attr( $billingstate ), 'RO', false ).'>RO</option>
						<option value="RR" '.selected( esc_attr( $billingstate ), 'RR', false ).'>RR</option>
						<option value="RS" '.selected( esc_attr( $billingstate ), 'RS', false ).'>RS</option>
						<option value="SC" '.selected( esc_attr( $billingstate ), 'SC', false ).'>SC</option>
						<option value="SE" '.selected( esc_attr( $billingstate ), 'SE', false ).'>SE</option>
						<option value="SP" '.selected( esc_attr( $billingstate ), 'SP', false ).'>SP</option>
						<option value="TO" '.selected( esc_attr( $billingstate ), 'TO', false ).'>TO</option>';
				$r .= '</select>';
				$r .= '</td></tr>';

				//cria cep de cobranca
				if($register_field['ecommerce'] && !$billingpostcode) { $class = ' class="error"'; } else { $class = ''; }
				$r .= '<tr class="ecommerce"><th>';
				$r .= '<label for="billingpostcode"'.$class.'>CEP*</label>';
				$r .= '</th><td>';
				$r .= '<input type="text" name="billingpostcode" id="billingpostcode" class="txt txt250 vcep" value="'.stripslashes($billingpostcode).'" size="20" tabindex="220" />';
				$r .= '</td></tr>';



				// divisao
				$r .= '<tr class="ecommerce"><th class="division" colspan="4"></th></tr>';


				// título entrega
				$r .= '<tr class="ecommerce"><td colspan="4">';
				$r .= '<h3>Endereço para Entrega <a href="#" id="repeat" class="description"></a></h3>';
				$r .= '</td></tr>';


				//cria endereço de envio
				if($register_field['ecommerce'] && !$shippingaddress) { $class = ' class="error"'; } else { $class = ''; }
				$r .= '<tr class="ecommerce"><th rowspan="3">';
				$r .= '<label for="shippingaddress"'.$class.'>Endereço*</label>';
				$r .= '</th><td rowspan="3">';
				$r .= '<textarea name="shippingaddress" id="shippingaddress" class="txt txt250" rows="6" cols="40" tabindex="245">'.stripslashes($shippingaddress).'</textarea>';
				$r .= '</td>';

				//cria cidade de envio
				if($register_field['ecommerce'] && !$shippingcity) { $class = ' class="error"'; } else { $class = ''; }
				$r .= '<th>';
				$r .= '<label for="shippingcity"'.$class.'>Cidade*</label>';
				$r .= '</th><td>';
				$r .= '<input type="text" name="shippingcity" id="shippingcity" class="txt txt250" value="'.stripslashes($shippingcity).'" size="20" tabindex="250" />';
				$r .= '</td></tr>';

					//cria país de envio
				if($register_field['ecommerce'] && !$shippingcountry) { $class = ' class="error"'; } else { $class = ''; }
				$r .='<tr><th><label for="shippingcountry" '.$class.'>País*</label></th>';
      			$r .= '<td><select name="shippingcountry" id="shippingcountry" class="txt txt250"  tabindex="50">';
      			     			
      			$r .= country_select($shippingcountry).'</td></select>';
      			$r .='</tr>';

				//cria estado de envio
				if($register_field['ecommerce'] && !$shippingstate) { $class = ' class="error"'; } else { $class = ''; }
				$r .= '<tr class="ecommerce"><th>';
				$r .= '<label for="shippingstate"'.$class.'>Estado*</label>';
				$r .= '</th><td>';
				$r .='<select name="shippingstate" id="shippingstate" class="txt txtauto" tabindex="255" >';
				$r .= '<option value="">Selecione</option>';
				$r .= '	<option value="AC" '.selected( esc_attr( $shippingstate ), "AC", false ).'>AC</option>
						<option value="AL" '.selected( esc_attr( $shippingstate ), 'AL', false ).'>AL</option>
						<option value="AM" '.selected( esc_attr( $shippingstate ), 'AM', false ).'>AM</option>
						<option value="AP" '.selected( esc_attr( $shippingstate ), 'AP', false ).'>AP</option>
						<option value="BA" '.selected( esc_attr( $shippingstate ), 'BA', false ).'>BA</option>
						<option value="CE" '.selected( esc_attr( $shippingstate ), 'CE', false ).'>CE</option>
						<option value="DF" '.selected( esc_attr( $shippingstate ), 'DF', false ).'>DF</option>
						<option value="ES" '.selected( esc_attr( $shippingstate ), 'ES', false ).'>ES</option>
						<option value="GO" '.selected( esc_attr( $shippingstate ), 'GO', false ).'>GO</option>
						<option value="MA" '.selected( esc_attr( $shippingstate ), 'MA', false ).'>MA</option>
						<option value="MG" '.selected( esc_attr( $shippingstate ), 'MG', false ).'>MG</option>
						<option value="MS" '.selected( esc_attr( $shippingstate ), 'MS', false ).'>MS</option>
						<option value="MT" '.selected( esc_attr( $shippingstate ), 'MT', false ).'>MT</option>
						<option value="PA" '.selected( esc_attr( $shippingstate ), 'PA', false ).'>PA</option>
						<option value="PB" '.selected( esc_attr( $shippingstate ), 'PB', false ).'>PB</option>
						<option value="PE" '.selected( esc_attr( $shippingstate ), 'PE', false ).'>PE</option>
						<option value="PI" '.selected( esc_attr( $shippingstate ), 'PI', false ).'>PI</option>
						<option value="PR" '.selected( esc_attr( $shippingstate ), 'PR', false ).'>PR</option>
						<option value="RJ" '.selected( esc_attr( $shippingstate ), 'RJ', false ).'>RJ</option>
						<option value="RN" '.selected( esc_attr( $shippingstate ), 'RN', false ).'>RN</option>
						<option value="RO" '.selected( esc_attr( $shippingstate ), 'RO', false ).'>RO</option>
						<option value="RR" '.selected( esc_attr( $shippingstate ), 'RR', false ).'>RR</option>
						<option value="RS" '.selected( esc_attr( $shippingstate ), 'RS', false ).'>RS</option>
						<option value="SC" '.selected( esc_attr( $shippingstate ), 'SC', false ).'>SC</option>
						<option value="SE" '.selected( esc_attr( $shippingstate ), 'SE', false ).'>SE</option>
						<option value="SP" '.selected( esc_attr( $shippingstate ), 'SP', false ).'>SP</option>
						<option value="TO" '.selected( esc_attr( $shippingstate ), 'TO', false ).'>TO</option>';
				$r .= '</select>';
				$r .= '</td></tr>';

				//cria cep de envio
				if($register_field['ecommerce'] && !$shippingpostcode) { $class = ' class="error"'; } else { $class = ''; }
				$r .= '<tr class="ecommerce"><th>';
				$r .= '<label for="shippingpostcode"'.$class.'>CEP*</label>';
				$r .= '</th><td>';
				$r .= '<input type="text" name="shippingpostcode" id="shippingpostcode" class="txt txt250 vcep" value="'.stripslashes($shippingpostcode).'" size="20" tabindex="260" />';
				$r .= '</td></tr>';

			}

		}

		// criar botão de envio
		$r .= '<tr><th>';
		$r .= '</th><td colspan="3">';
		// define label do submit
		if($args['type']){
			if($args['id']){
				$r .= '<input type="submit" name="wp-submit" id="wp-submit" class="button-primary btn" value="Atualizar" tabindex="500" />';
			} else {
				$r .= '<input type="submit" name="wp-submit" id="wp-submit" class="button-primary btn" value="Cadastrar" tabindex="500" />';
			}
		} else {
			$r .= '<input type="submit" name="wp-submit-continuar" id="wp-submit" class="button-primary btn" value="Continuar" tabindex="500" />';
		}
		$r .= '</td></tr>';


		// cria id se for atualização
		if($args['id']) { $r .= '<input type="hidden" name="id" value="'.$args['id'].'" id="id">';  }

		// criar opção de formulario full
		if($args['full']) {$r .= '<input type="hidden" name="full" value="'.$args['full'].'" />'; }

		// criar opção de redirecionamento
		$r .= '<input type="hidden" name="redirect_to" value="'.$args['redirect_to'].'" />';

		// fecha formulário
		$r .= '</table>';
		$r .= '</form>';

	}

	// limpa array de campos com erros
	//$register_field = array();



	// verifica se o formulário deve ser impresso ou devolvido em forma de dados
	if($args['echo']){ echo $r; } else { return $r; }

}



	/*////////////////////////////////////////////////////////////////////////
		NOME		pg_register_confirmation()
		FUNÇÃO		Confirma o cadastro a partir do email enviado para o usuario
		GRUPO		Controle de cadastro e login
		PARÂMETROS	nenhum
	*////////////////////////////////////////////////////////////////////////
	function pg_register_confirmation() {
		// declarra variavel de avisos
		global $confirm_alert;

		// verifica se o email esta cadastrado
		if($id = email_exists($_GET['login'])) {

			// verifica o token
			if(get_user_meta($id, 'token', true ) == $_GET['key']) {

				// verifica se já está ativo
				if(get_user_meta($id, 'active', true )) {
					// aviso de cadastro ativado anteriormente
					$confirm_alert = '<p>Este cadastro já está ativo.</p>';

				} else {

					// ativa usuário
					update_usermeta( $id, 'active', true );

					// aviso de cadastro ativado
					$confirm_alert = '
						<h2>Cadastro Ativo</h2>
						<p>Seu cadastro foi ativado com sucesso.</p>
						<p>Agora você terá acesso a conteúdos exclusivos e aquisição de estudo.</p>
						<p>Navegue por nossa <a href="/biblioteca/">Biblioteca</a> para conhecer nossos estudos.</p>
					';

					header('location: /?login');
				}
			} else {

				// aviso de tokem errado
				$confirm_alert = '
					<h2>Erro na Ativação</h2>
					<p>Não foi possível ativar seu cadastro. Verifique se o endereço digitado está correto.<p>
				';

			}
		} else {
			// aviso de email errado
			$confirm_alert = '
				<h2>Erro na Ativação</h2>
				<p>Não foi possível ativar seu cadastro. Verifique se o endereço digitado está correto.<p>
			';

		}
	}



	/*////////////////////////////////////////////////////////////////////////
		NOME		pg_update_form($args=array())
		FUNÇÃO		Exibe o formulário para atualização da informações
		GRUPO		Controle de cadastro e login
		PARÂMETROS
		$args ->	Define os argumentos, deve ser uma array
			$args[$echo] -> Define se o formulário será impresso ou enviado em forma de dados, boleano
			$args[$action] -> Define o link de acao do formulário, deve ser um url válido
			$args[$redirect_to] -> define o valor para o campo oculto de redirecionamento, deve ser um url
	*////////////////////////////////////////////////////////////////////////
	function pg_update_form($args=array()){
		// init
		global $pg_user;
		global $register_alert;
		$r = '';

		// tratamento de variáveis
		if(!isset($args['echo'])) { $args['echo']=1; }
		if(!$args['action']) { $args['action'] = get_permalink(); }
		if(!$args['redirect_to']) { $args['redirect_to'] = get_permalink(); }

		// cria formulário
		$r .= '<form name="registerform" action="'.$args['action'].'" method="post">';
		$r .= '<table border="0" cellspacing="0" cellpadding="0" class="simpleinfo">';
		$r .= '<tr><td colspan="4">';
		$r .= '<p class="description">Os campos com * são de preenchimento obrigatório. O demais campos são necessários apenas para compra de estudos.</p>';
		$r .= '</td></tr>';


		if ( count($register_alert) ) {
			$r .= '<tr><th colspan="2">';
			foreach ($register_alert as $r_alert) {
				$r .= $r_alert;
				//array_push($pages, $value);
			}
			$r .= '</th></tr>';
		}

		// cria campo de nome
		$r .= '<tr><th>';
		$r .= '<label for="first_name">Nome*</label>';
		$r .= '</th><td>';
		$r .= '<input type="text" name="first_name" id="first_name" class="txt txt360" value="'.stripslashes($_POST['first_name']).'" size="20" tabindex="50" />';
		$r .= '</td></tr>';

		// cria campo de sobrenome
		$r .= '<tr><th>';
		$r .= '<label for="last_name">Sobrenome*</label>';
		$r .= '</th><td>';
		$r .= '<input type="text" name="last_name" id="last_name" class="txt txt360" value="'.stripslashes($_POST['last_name']).'" size="20" tabindex="55" />';
		$r .= '</td></tr>';

		// cria campo de login
		$r .= '<tr><th>';
		$r .= '<label for="user_email">E-mail*</label>';
		$r .= '</th><td>';
		$r .= '<input type="text" name="user_email" id="user_email" class="txt txt360" value="'.stripslashes($_POST['user_email']).'" size="20" tabindex="60" />';
		$r .= '</td></tr>';

		// cria campo sexo
		$r .= '<tr><th>';
		$r .= '<label for="gender">Sexo*</label>';
		$r .= '</th><td>';
		$r .='<select name="gender" id="gender" class="txt txtauto" tabindex="65" >';
		$r .= '<option value="">Selecione</option>';
		$r .= '<option value="male" '.selected( $_POST['gender'], 'male', false ).'>Masculino</option>';
		$r .= '<option value="female" '.selected( $_POST['gender'], 'female', false ).'>Feminino</option>';
		$r .= '</select>';
		$r .= '</td></tr>';





		//cria campo de telefone residencial
		$r .= '<tr><th>';
		$r .= '<label for="phone_home">Telefone Residencial</label>';
		$r .= '</th><td>';
		$r .= '<input type="text" maxlength="15" name="phone_home" id="phone_home" class="txt txt360 vphone" value="'.stripslashes($_POST['phone_home']).'" size="20" tabindex="70" />';
		$r .= '</td></tr>';

		//cria campo de telefone comercial
		$r .= '<tr><th>';
		$r .= '<label for="phone_work">Telefone Comercial</label>';
		$r .= '</th><td>';
		$r .= '<input type="text" maxlength="15" name="phone_work" id="phone" class="txt txt360 vphone" value="'.stripslashes($_POST['phone_work']).'" size="20" tabindex="75" />';
		$r .= '</td></tr>';

		//cria campo de telefone celular
		$r .= '<tr><th>';
		$r .= '<label for="phone_cel">Telefone Celular</label>';
		$r .= '</th><td>';
		$r .= '<input type="text" maxlength="15" name="phone_cel" id="phone_cel" class="txt txt360 vphone" value="'.stripslashes($_POST['phone_cel']).'" size="20" tabindex="80" />';
		$r .= '</td></tr>';

		// divisao
		$r .= '<tr><th class="division" colspan="2"></th></tr>';

		//cria campo de empresa - nome fantasia
		$r .= '<tr><th>';
		$r .= '<label for="company">Empresa</label>';
		$r .= '</th><td>';
		$r .= '<input type="text" name="company" id="company" class="txt txt360" value="'.stripslashes($_POST['company']).'" size="20" tabindex="85" />';
		$r .= '</td></tr>';

		//cria campo de função
		$r .= '<tr><th>';
		$r .= '<label for="role">Cargo</label>';
		$r .= '</th><td>';
		$r .= '<input type="text" name="role" id="role" class="txt txt360" value="'.stripslashes($_POST['role']).'" size="20" tabindex="90" />';
		$r .= '</td></tr>';

		// divisao
		$r .= '<tr><th class="division" colspan="2"></th></tr>';

		//cria campo de senha e confirmação
		/*$r .= '<tr><th>';
		$r .= '<label for="user_pass">Senha*</label>';
		$r .= '</th><td>';
		$r .= '<input type="password" name="user_pass" id="user_pass" class="txt txt360" value="" size="20" tabindex="95" /> <br />';
		$r .= '<input type="password" name="user_pass_confirmation" id="user_pass_confirmation" class="txt txt360" value="" size="20" tabindex="40" /><br />';
		$r .= '<p class="description">Redigite sua senha para confirmação.';
		$r .= '</td></tr>';*/

		// criar botão de envio
		$r .= '<tr><th>';
		$r .= '</th><td>';
		$r .= '<input type="submit" name="wp-submit" id="wp-submit" class="button-primary btn" value="Cadastrar" tabindex="100" />';
		$r .= '</td></tr>';

		// criar opção de redirecionamento
		$r .= '<input type="hidden" name="redirect_to" value="'.$args['redirect_to'].'" />';

		// fecha formulário
		$r .= '</table>';
		$r .= '</form>';

		// verifica se o formulário deve ser impresso ou devolvido em forma de dados
		if($args['echo']){ echo $r; } else { return $r; }

	}



	/*////////////////////////////////////////////////////////////////////////
		NOME		pg_user($args=array())
		FUNÇÃO		Tenta criar um novo usuário a partir do formulário ou devolve o erro
		GRUPO		Controle de cadastro e login
		PARÂMETROS	nenhum
		$args ->	Define os argumentos, deve ser uma array

	*////////////////////////////////////////////////////////////////////////
	function pg_newsletter_action($args=array()) {
		// confere se é metodo POST
		if($_POST){

			//inicia aviso
			global $newsletter_alert;
			$newsletter_alert = array();

			//confere se todos os campos foram digitados
			if(!$_POST['full_name'] && !$_POST['email']) {

			} elseif(!$_POST['full_name'] || !$_POST['email']) 	{
				array_push($newsletter_alert, '<p class="alert alert-error">Todos os campos devem ser preenchidos.</p>');
			}

			//confere se o email é valido
			if($_POST['email'] && !is_email($_POST['email'])){
				array_push($newsletter_alert, '<p class="alert alert-error">O endereço de email parece inválido.</p>');
			}

			if(count($newsletter_alert) == 0) {

				//include 'http://integracao.nitronews.com.br/integracao.php';

			}
		} else {
			// retorna false se não existir todos os campos necessários
			return false;
		}
	}



	/*////////////////////////////////////////////////////////////////////////
		NOME		pg_newsletter_form()
		FUNÇÃO		Tenta logar o usuário a partir do formulário ou devolve o erro
		GRUPO		Controle de cadastro e login
		$args ->	Define os argumentos, deve ser uma array
			$args[$echo] -> Define se o formulário será impresso ou enviado em forma de dados, boleano
			$args[$action] -> Define o link de acao do formulário, deve ser um url válido
			$args[$redirect_to] -> define o valor para o campo oculto de redirecionamento, deve ser um url
	*////////////////////////////////////////////////////////////////////////
	function pg_newsletter_form($args=array()) {
		// init
		global $newsletter_alert;
		$r = '';

		// tratamento de variáveis
		if(!isset($args['echo'])) { $args['echo']=1; }
		if(!$args['action']) { $args['action'] = get_permalink(); }
		if(!$args['redirect_to']) { $args['redirect_to'] = get_permalink(); }
                
                //$args['action'] = get_home_url();
                $args['redirect_to']='';
                $args['action'] = '';

		// cria formulário
		$r .= '<form name="newsletterform" action="'.$args['action'].'" method="post">';
		$r .= '<table border="0" cellspacing="0" cellpadding="0" class="simpleinfo">';

		if ( count($newsletter_alert) ) {
			$r .= '<tr><th colspan="2">';
			foreach ($newsletter_alert as $r_alert) {
				$r .= $r_alert;
				//array_push($pages, $value);
			}
			$r .= '</th></tr>';
		}

		// cria campo de nome
		/*$r .= '<tr><th>';
		$r .= '<label for="full_name">Nome Completo*</label>';
		$r .= '</th><td>';
		$r .= '<input type="text" name="full_name" id="name" class="txt txt360" value="'.stripslashes($_POST['full_name']).'" size="20" tabindex="150" />';
		$r .= '</td></tr>';*/

		// cria campo de login
		$r .= '<tr><th>';
		//$r .= '<label for="email">E-mail*</label>';
		$r .= '</th><td>';
		$r .= '<input type="text" name="email" id="email" class="txt txt360" value="'.stripslashes($_POST['email']).'" size="20" tabindex="155" />';
		//$r .= '</td></tr>';

		// criar botão de envio
		//$r .= '<tr><th>';
		//$r .= '</th><td>';
		$r .= '<input type="submit" name="wp-submit" id="wp-submit" class="button-primary btn ok_btn" placeholder="@ informe seu e-mail" value="ok" tabindex="160" />';
		$r .= '</td></tr>';

		// criar opção de redirecionamento
		$r .= '<input type="hidden" name="redirect_to" value="'.$args['redirect_to'].'" />';

		// fecha formulário
		$r .= '</table>';
		$r .= '</form>';


		if($args['echo']){ echo $r; } else { return $r; }


	}



	// LOGIN FORM SHORTCUT
	function pg_register_form_shortcode( $atts, $content = null ) { return pg_register_form(array('echo'=>0)); }
	add_shortcode( 'register_form', 'pg_register_form_shortcode' );

	// REGISTER FORM SHORTCUT
	function pg_login_form_shortcode( $atts, $content = null ) { return pg_login_form(array('echo'=>0)); }
	add_shortcode( 'login_form', 'pg_login_form_shortcode' );

	// NEWSLETTER FORM SHORTCUT
	function pg_newsletter_form_shortcode( $atts, $content = null ) { return pg_newsletter_form(array('echo'=>0)); }
	add_shortcode( 'newsletter_form', 'pg_newsletter_form_shortcode' );

	// REGISTER CONFIRMATION SHORTCUT
	function pg_register_confirmation_shortcode( $atts, $content = null ) {
		global $confirm_alert;
		return $confirm_alert;
	}
	add_shortcode( 'register_confirmation', 'pg_register_confirmation_shortcode' );

	// HIDE ADMIN BAR FOR SUBSCRIBERS
	// subscriber -> contributor -> editor -> administrator
	if ( !current_user_can('administrator') ) {
      add_filter( 'show_admin_bar', '__return_false' );
   }

}





///////////////////// CUSTOMIZAÇÃO DOS CAMPOS DOS USUARIOS /////////////////////

// visualiação do novo grupo de informações
add_action( 'show_user_profile', 'show_extra_profile_fields' );
add_action( 'edit_user_profile', 'show_extra_profile_fields' );
add_action( 'show_user_profile', 'show_billing_profile_fields' );
add_action( 'edit_user_profile', 'show_billing_profile_fields' );
add_action( 'show_user_profile', 'show_shipping_profile_fields' );
add_action( 'edit_user_profile', 'show_shipping_profile_fields' );
add_action( 'show_user_profile', 'show_newsletter_fields' );
add_action( 'edit_user_profile', 'show_newsletter_fields' );
// interatividade com o banco de dados do novo grupo de informações
add_action( 'personal_options_update', 'save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_profile_fields' );
// modificação dos campos no grupo Informações de Contato
add_filter( 'user_contactmethods', 'extra_contact_info' );


// função - cria a visualiação de um novo grupo de informações
function show_extra_profile_fields( $user ) {
	$r = '';
	$r .='<h3>Outras Informações</h3>';
	$r .='<table class="form-table">';

	// Tipo de Cadastro
	$r .='<tr>';
	$r .='<th><label for="type">Tipo de Cadastro</label></th>';
	$r .='<td><select name="type" id="type">';
	$r .= '<option value="">Selecione</option>';
	//$r .= '<option value="pf" '.selected( esc_attr( get_the_author_meta( 'type', $user->ID ) ), 'pf', false ).'>Pessoa Física</option>';
	//$r .= '<option value="pj" '.selected( esc_attr( get_the_author_meta( 'type', $user->ID ) ), 'pj', false ).'>Pessoa Jurídica</option>';
        $r .= '<option value="estudante" '.selected( esc_attr( get_the_author_meta( 'type', $user->ID ) ), 'estudante', false ).'>Estudante</option>';
	$r .= '<option value="empresario" '.selected( esc_attr( get_the_author_meta( 'type', $user->ID ) ), 'empresario', false ).'>Empresário</option>';
        $r .= '<option value="jornalista" '.selected( esc_attr( get_the_author_meta( 'type', $user->ID ) ), 'jornalista', false ).'>Jornalista</option>';        
	$r .= '</select>';
	$r .='</tr>';
	
	$tipo_cadastro = get_the_author_meta( 'type', $user->ID );
	if ($tipo_cadastro == "estudante") {
			// Faculdade
		$r .='<tr>';
		$r .='<th><label for="university">Faculdade</label></th>';
		$r .='<td><input type="text" name="university" id="university" value="'.esc_attr( get_the_author_meta( 'university', $user->ID ) ).'" class="regular-text" />';
		$r .='</tr>';
		
		// Curso
		$r .='<tr>';
		$r .='<th><label for="course">Curso</label></th>';
		$r .='<td><input type="text" name="course" id="course" value="'.esc_attr( get_the_author_meta( 'course', $user->ID ) ).'" class="regular-text" />';
		$r .='</tr>';

                //País
                $r .='<tr>';
                $r .='<th><label for="country">País</label></th>';
                $r .='<td><input type="text" name="country" id="country" value="'.esc_attr( get_the_author_meta( 'country', $user->ID ) ).'" class="regular-text" />';
                $r .='</tr>';
                
                //Estado
                $r .='<tr>';
                $r .='<th><label for="state">Estado</label></th>';
                $r .='<td><input type="text" name="state" id="state" value="'.esc_attr( get_the_author_meta( 'state', $user->ID ) ).'" class="regular-text" />';
                $r .='</tr>';

		
	}else if ($tipo_cadastro == "jornalista"){
			// veiculo
			// Faculdade
			$r .='<tr>';
			$r .='<th><label for="media">Veículo</label></th>';
			$r .='<td><input type="text" name="media" id="media" value="'.esc_attr( get_the_author_meta( 'media', $user->ID ) ).'" class="regular-text" />';
			$r .='</tr>';
		
			// periodicidade
			$r .='<th><label for="periodicity">Periodicidade</label></th>';
			$r .='<td><select name="periodicity" id="periodicity" class="txt txtauto">';
			$r .= '<option value="">Selecione</option>
				<option value="daily" '.selected( esc_attr( get_the_author_meta( 'periodicity', $user->ID ) ), 'daily', false ).'>Diário</option>
				<option value="weekly" '.selected( esc_attr( get_the_author_meta( 'periodicity', $user->ID ) ), 'weekly', false ).'>Semanal</option>
				<option value="monthly" '.selected( esc_attr( get_the_author_meta( 'periodicity', $user->ID ) ), 'monthly', false ).'>Mensal</option>';
			$r .= '</select>';
			$r .='</tr>';
	}else {
				// Empresa
			$r .='<tr>';
			$r .='<th><label for="company">Empresa</label></th>';
			$r .='<td><input type="text" name="company" id="company" value="'.esc_attr( get_the_author_meta( 'company', $user->ID ) ).'" class="regular-text" />';
			$r .='</tr>';
			
			//Ano de fundação
			$r .='<tr>';
			$r .='<th><label for="foundation_year">Ano de Fundação</label></th>';
			$r .='<td><input type="text" name="foundation_year" id="foundation_year" value="'.esc_attr( get_the_author_meta( 'foundation_year', $user->ID ) ).'" class="regular-text" />';
			$r .='</tr>';
			
			//Ano de fundação
			$r .='<tr>';
			$r .='<th><label for="cnpj">CNPJ*</label></th>';
			$r .='<td><input type="text" name="cnpj" id="cnpj" value="'.esc_attr( get_the_author_meta( 'cnpj', $user->ID ) ).'" class="regular-text" />';
			$r .='</tr>';
			
			//Endereço
			$r .='<tr>';
			$r .='<th><label for="address">Endereço</label></th>';
			$r .='<td><input type="text" name="address" id="address" value="'.esc_attr( get_the_author_meta( 'address', $user->ID ) ).'" class="regular-text" />';
			$r .='</tr>';
				
			//CEP
			$r .='<tr>';
			$r .='<th><label for="cep">CEP</label></th>';
			$r .='<td><input type="text" name="cep" id="cep" value="'.esc_attr( get_the_author_meta( 'cep', $user->ID ) ).'" class="regular-text" />';
			$r .='</tr>';
			
                        $r .='<tr><th><label for="state">Estado*</label></th>';
			$r .='<td><input type="text" name="state" id="state" value="'.esc_attr( get_the_author_meta( 'state', $user->ID ) ).'" class="regular-text" /></tr>';
			
			//Cidade
			$r .='<tr>';
			$r .='<th><label for="city">Cidade</label></th>';
			$r .='<td><input type="text" name="city" id="city" value="'.esc_attr( get_the_author_meta( 'city', $user->ID ) ).'" class="regular-text" />';
			$r .='</tr>';
			
			//País
			$r .='<tr>';
			$r .='<th><label for="country">País</label></th>';
			$r .='<td><input type="text" name="country" id="country" value="'.esc_attr( get_the_author_meta( 'country', $user->ID ) ).'" class="regular-text" />';
			$r .='</tr>';
			

			// Cargo
			$r .='<tr>';
			$r .='<th><label for="role">Cargo / Função</label></th>';
			$r .='<td><input type="text" name="role" id="role" value="'.esc_attr( get_the_author_meta( 'role', $user->ID ) ).'" class="regular-text" />';
			$r .='</tr>';

		
	}
	// Cupom de Desconto
	global $wpdb;
	$coupons = $wpdb->get_results( "
		SELECT *
		FROM wp_test_wpsc_coupon_codes
		WHERE active = 1
		ORDER BY coupon_code
		", ARRAY_A
	);

	$r .='<tr>';
	$r .='<th><label for="coupon">Cupom de Desconto</label></th>';
	$r .='<td><select name="coupon" id="coupon">';
	$r .= '<option value="">Selecione</option>';
	foreach ($coupons as $coupon) {
		$r .= '<option value="'.$coupon['id'].'" '.selected( esc_attr( get_the_author_meta( 'coupon', $user->ID ) ), $coupon['id'], false ).'>'.$coupon['coupon_code'].'</option>';
	}
	$r .= '</select>';
	$r .='</tr>';


	$r .='</table>';

	echo $r;
}

function show_billing_profile_fields( $user ) {
	$r = '';
	$r .='<h3>Informações de Faturamento</h3>';
	$r .='<table class="form-table">';

	// Company - Nome Fantasia
	$r .='<tr>';
	$r .='<th><label for="company">Nome Fantasia</label></th>';
	$r .='<td><input type="text" name="company" id="company" value="'.esc_attr( get_the_author_meta( 'company', $user->ID ) ).'" class="regular-text" /></td>';
	$r .='</tr>';

	// Company Name - Razão Social
	$r .='<tr>';
	$r .='<th><label for="company_name">Razão Social</label></th>';
	$r .='<td><input type="text" name="company_name" id="company_name" value="'.esc_attr( get_the_author_meta( 'company_name', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';

	// CNPJ
	$r .='<tr>';
	$r .='<th><label for="cnpj">CNPJ*</label></th>';
	$r .='<td><input type="text" name="cnpj" id="cnpj" value="'.esc_attr( get_the_author_meta( 'cnpj', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';

	// Endereço
	$r .='<tr>';
	$r .='<th><label for="billingaddress">Endereço</label></th>';
	$r .='<td><input type="text" name="billingaddress" id="billingaddress" value="'.esc_attr( get_the_author_meta( 'billingaddress', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';

	// Cidade
	$r .='<tr>';
	$r .='<th><label for="billingcity">Cidade</label></th>';
	$r .='<td><input type="text" name="billingcity" id="billingcity" value="'.esc_attr( get_the_author_meta( 'billingcity', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';
        
        // Estado
	$r .='<tr>';
	$r .='<th><label for="billingstate">Estado</label></th>';
	$r .='<td><input type="text" name="billingstate" id="billingstate" value="'.esc_attr( get_the_author_meta( 'billingstate', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';

	// País
	$r .='<tr>';
	$r .='<th><label for="billingcountry">País</label></th>';
	$r .='<td><input type="text" name="billingcountry" id="billingcountry" value="'.esc_attr( get_the_author_meta( 'billingcountry', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';

	// CEP
	$r .='<tr>';
	$r .='<th><label for="billingpostcode">CEP</label></th>';
	$r .='<td><input type="text" name="billingpostcode" id="billingpostcode" value="'.esc_attr( get_the_author_meta( 'billingpostcode', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';

	$r .='</table>';

	echo $r;
}

function show_shipping_profile_fields( $user ) {
	$r = '';
	$r .='<h3>Informações de Entrega</h3>';
	$r .='<table class="form-table">';

	// Endereço
	$r .='<tr>';
	$r .='<th><label for="shippingaddress">Endereço</label></th>';
	$r .='<td><input type="text" name="shippingaddress" id="shippingaddress" value="'.esc_attr( get_the_author_meta( 'shippingaddress', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';

	// Cidade
	$r .='<tr>';
	$r .='<th><label for="shippingcity">Cidade</label></th>';
	$r .='<td><input type="text" name="shippingcity" id="shippingcity" value="'.esc_attr( get_the_author_meta( 'shippingcity', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';
        
        // Estado
	$r .='<tr>';
	$r .='<th><label for="shippingstate">Estado</label></th>';
	$r .='<td><input type="text" name="shippingstate" id="shippingstate" value="'.esc_attr( get_the_author_meta( 'shippingstate', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';

	// País
	$r .='<tr>';
	$r .='<th><label for="shippingcountry">País</label></th>';
	$r .='<td><input type="text" name="shippingcountry" id="shippingcountry" value="'.esc_attr( get_the_author_meta( 'shippingcountry', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';

	// CEP
	$r .='<tr>';
	$r .='<th><label for="shippingpostcode">CEP</label></th>';
	$r .='<td><input type="text" name="shippingpostcode" id="shippingpostcode" value="'.esc_attr( get_the_author_meta( 'shippingpostcode', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';

	$r .='</table>';

	echo $r;
}

function show_newsletter_fields( $user ) {
	$r = '';
	$r .='<h3>Newsletter</h3>';
	$r .='<table class="form-table">';

	global $newsletter_areas;
	foreach ($newsletter_areas as $grupo => $areas) {
		$r .= '<tr>';
		$r .= '<th>'.$grupo.'</th>';
		$r .= '<td>';
		foreach ($areas as $area) {
			$r .= '<label for="newsletter-'.sanitize_title($area).'" style="padding-top:0;"><input type="checkbox" name="newsletter-'.sanitize_title($area).'" '.checked( esc_attr( get_the_author_meta( 'newsletter-'.sanitize_title($area), $user->ID ) ), 1, 0 ).' value="1">'.$area.'</label><br />';
		}
		$r .='</td></tr>';
	}

	// Outras Áreas
	$r .='<tr>';
	$r .='<th><label for="newsletter-outras-areas">Outras Áreas</label></th>';
	$r .='<td><input type="text" name="newsletter-outras-areas" id="newsletter-outras-areas" value="'.esc_attr( get_the_author_meta( 'newsletter-outras-areas', $user->ID ) ).'" class="regular-text" />';
	$r .='</tr>';

	$r .='</table>';

	echo $r;
}


// função - cria a interatividade com o banco de dados do novo grupo de informações
function save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	update_usermeta( $user_id, 'gender', $_POST['gender'] );
	update_usermeta( $user_id, 'type', $_POST['type'] );
	update_usermeta( $user_id, 'title', $_POST['title'] );
	update_usermeta( $user_id, 'cpf', $_POST['cpf'] );
	update_usermeta( $user_id, 'coupon', $_POST['coupon'] );

	update_usermeta( $user_id, 'activity', $_POST['activity'] );
	update_usermeta( $user_id, 'company', $_POST['company'] );
	update_usermeta( $user_id, 'company_name', $_POST['company_name'] );
	update_usermeta( $user_id, 'cnpj', $_POST['cnpj'] );

	update_usermeta( $user_id, 'billingaddress', $_POST['billingaddress'] );
	update_usermeta( $user_id, 'billingcity', $_POST['billingcity'] );
	update_usermeta( $user_id, 'billingstate', $_POST['billingstate'] );
	update_usermeta( $user_id, 'billingcountry', $_POST['billingcountry'] );
	update_usermeta( $user_id, 'billingpostcode', $_POST['billingpostcode'] );
	update_usermeta( $user_id, 'shippingaddress', $_POST['shippingaddress'] );
	update_usermeta( $user_id, 'shippingcity', $_POST['shippingcity'] );
	update_usermeta( $user_id, 'shippingstate', $_POST['shippingstate'] );
	update_usermeta( $user_id, 'shippingcountry', $_POST['shippingcountry'] );
	update_usermeta( $user_id, 'shippingpostcode', $_POST['shippingpostcode'] );

	global $newsletter_areas;
	foreach ($newsletter_areas as $grupo => $areas) {
		foreach ($areas as $area) {
			update_usermeta( $user_id, 'newsletter-'.sanitize_title($area), $_POST['newsletter-'.sanitize_title($area)] );
		}
		$r .='</td></tr>';
	}
	update_usermeta( $user_id, 'newsletter-outras-areas', $_POST['newsletter-outras-areas'] );
}


// função - altera campos do grupo Informações de Contato
function extra_contact_info($contactmethods) {
	unset($contactmethods['site']);
	unset($contactmethods['aim']);
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);

	$contactmethods['phone'] = 'Telefone';
	$contactmethods['phone_home'] = 'Telefone Residencial';
	$contactmethods['phone_work'] = 'Telefone Comercial';
	$contactmethods['phone_cel'] = 'Telefone Celular';

	$contactmethods['token'] = 'Token';
	$contactmethods['active'] = 'Ativação';

	return $contactmethods;
}



function string_limit_words($string, $word_limit)
{
  $words = explode(' ', $string, ($word_limit + 1));
  if(count($words) > $word_limit)
  array_pop($words);
  return implode(' ', $words);
}

/* Parceiros */

add_action('init', 'parc_register');

function parc_register() {

	$labels = array(
		'name' => _x('Parceiros', 'post type general name'),
		'singular_name' => _x('Parceiro', 'post type singular name'),
		'add_new' => _x('Adicionar', 'parceiro'),
		'add_new_item' => __('Adicionar novo parceiro'),
		'edit_item' => __('Editar parceiro'),
		'new_item' => __('Novo parceiro'),
		'view_item' => __('Ver parceiro'),
		'search_items' => __('Procurar parceiro'),
		'not_found' =>  __('Nada encontrado'),
		'not_found_in_trash' => __('Nada encontrado no lixo'),
		'parent_item_colon' => ''
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'menu_icon' => get_stylesheet_directory_uri() . '/images/generic.png',
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','editor','thumbnail')
	  );

	register_post_type( 'parceiros' , $args );
}

add_action("admin_init", "admin_init");

function admin_init(){
  add_meta_box("credits_meta", "Detalhamento de servi&ccedil;os prestados", "credits_meta", "parceiros", "normal", "low");
  add_meta_box("ordem", "Ordem", "ordem", "parceiros", "side", "low");
}

function ordem(){
  global $post;
  $custom = get_post_custom($post->ID);
  $ordem = $custom["ordem"][0];
  ?>
  <label>Ordem:</label>
  <input name="ordem" value="<?php echo $ordem; ?>" />
  <?php
}

function credits_meta() {
  global $post;
  $custom = get_post_custom($post->ID);
  $url = $custom["url"][0];
  ?>
  <p><label>Site:</label><br />
  <textarea cols="50" rows="1" name="url" style="width:100%;"><?php echo $url; ?></textarea></p>
  <?php
}

add_action('save_post', 'save_details');
function save_details(){
  global $post;

  update_post_meta($post->ID, "ordem", $_POST["ordem"]);
  update_post_meta($post->ID, "url", $_POST["url"]);
}


add_action("manage_posts_custom_column",  "parceiros_custom_columns");
add_filter("manage_edit-parceiros_columns", "parceiros_edit_columns");

function parceiros_edit_columns($columns){
  $columns = array(
    "cb" => "<input type=\"checkbox\" />",
    "ordem" => "Ordem",
    "title" => "Nome do parceiro",
    "description" => "Site",
  );

  return $columns;
}
function parceiros_custom_columns($column){
  global $post;

  switch ($column) {
    case "ordem":
      $custom = get_post_custom();
      echo $custom["ordem"][0];
      break;
    case "description":
      $custom = get_post_custom();
      echo $custom["url"][0];
      break;
  }
}

//Função que monta o menu flutuante com os nomes dos países
function country_select($country){
	$retorno = '<option selected="" value="">Selecione o País</option>
				<option value="AF" '.selected( esc_attr( $country ), 'AF', false ).'>Afeganistão</option>
				<option value="ZA" '.selected( esc_attr( $country ), 'ZA', false ).'>África do Sul</option>
				<option value="AL" '.selected( esc_attr( $country ), 'AL', false ).'>Albânia</option>
				<option value="DE" '.selected( esc_attr( $country ), 'DE', false ).'>Alemanha</option>
				<option value="AD" '.selected( esc_attr( $country ), 'AD', false ).'>Andorra</option>
				<option value="AO" '.selected( esc_attr( $country ), 'AO', false ).'>Angola</option>
				<option value="AI" '.selected( esc_attr( $country ), 'AI', false ).'>Anguilla</option>
				<option value="AG" '.selected( esc_attr( $country ), 'AG', false ).'>Antigua e Barbuda</option>
				<option value="SA" '.selected( esc_attr( $country ), 'SA', false ).'>Arábia Saudita</option>
				<option value="AR" '.selected( esc_attr( $country ), 'AR', false ).'>Argentina</option>
				<option value="AW" '.selected( esc_attr( $country ), 'AW', false ).'>Aruba</option>
				<option value="AU" '.selected( esc_attr( $country ), 'AU', false ).'>Australia</option>
				<option value="AT" '.selected( esc_attr( $country ), 'AT', false ).'>Austria</option>
				<option value="BS" '.selected( esc_attr( $country ), 'BS', false ).'>Bahamas</option>
				<option value="BH" '.selected( esc_attr( $country ), 'BH', false ).'>Bahrain</option>
				<option value="BB" '.selected( esc_attr( $country ), 'BB', false ).'>Barbados</option>
				<option value="BE" '.selected( esc_attr( $country ), 'BE', false ).'>Bélgica</option>
				<option value="BZ" '.selected( esc_attr( $country ), 'BZ', false ).'>Belize</option>
				<option value="BM" '.selected( esc_attr( $country ), 'BM', false ).'>Bermuda</option>
				<option value="BO" '.selected( esc_attr( $country ), 'BO', false ).'>Bolívia</option>
				<option value="BW" '.selected( esc_attr( $country ), 'BW', false ).'>Botswana</option>
				<option value="BR" '.selected( esc_attr( $country ), 'BR', false ).'>Brasil</option>
				<option value="BN" '.selected( esc_attr( $country ), 'BN', false ).'>Brunei</option>
				<option value="BG" '.selected( esc_attr( $country ), 'BG', false ).'>Bulgária</option>
				<option value="BI" '.selected( esc_attr( $country ), 'BI', false ).'>Burundi</option>
				<option value="CV" '.selected( esc_attr( $country ), 'CV', false ).'>Cabo Verde</option>
				<option value="KH" '.selected( esc_attr( $country ), 'KH', false ).'>Camboja</option>
				<option value="CA" '.selected( esc_attr( $country ), 'CA', false ).'>Canadá</option>
				<option value="TD" '.selected( esc_attr( $country ), 'TD', false ).'>Chade</option>
				<option value="CL" '.selected( esc_attr( $country ), 'CL', false ).'>Chile</option>
				<option value="CN" '.selected( esc_attr( $country ), 'CN', false ).'>China</option>
				<option value="CO" '.selected( esc_attr( $country ), 'CO', false ).'>Colômbia</option>
				<option value="DJ" '.selected( esc_attr( $country ), 'DJ', false ).'>Djibouti</option>
				<option value="DM" '.selected( esc_attr( $country ), 'DM', false ).'>Dominicana</option>
				<option value="AE" '.selected( esc_attr( $country ), 'AE', false ).'>Emirados Árabes</option>
				<option value="EC" '.selected( esc_attr( $country ), 'EC', false ).'>Equador</option>
				<option value="ES" '.selected( esc_attr( $country ), 'ES', false ).'>Espanha</option>
				<option value="US" '.selected( esc_attr( $country ), 'US', false ).'>Estados Unidos</option>
				<option value="FJ" '.selected( esc_attr( $country ), 'FJ', false ).'>Fiji</option>
				<option value="PH" '.selected( esc_attr( $country ), 'PH', false ).'>Filipinas</option>
				<option value="FI" '.selected( esc_attr( $country ), 'FI', false ).'>Finlândia</option>
				<option value="FR" '.selected( esc_attr( $country ), 'FR', false ).'>França</option>
				<option value="GA" '.selected( esc_attr( $country ), 'GA', false ).'>Gabão</option>
				<option value="GH" '.selected( esc_attr( $country ), 'GH', false ).'>Ghana</option>
				<option value="GI" '.selected( esc_attr( $country ), 'GI', false ).'>Gibraltar</option>
				<option value="GD" '.selected( esc_attr( $country ), 'GD', false ).'>Granada</option>
				<option value="GR" '.selected( esc_attr( $country ), 'GR', false ).'>Grécia</option>
				<option value="GP" '.selected( esc_attr( $country ), 'GP', false ).'>Guadalupe</option>
				<option value="GU" '.selected( esc_attr( $country ), 'GU', false ).'>Guam</option>
				<option value="GT" '.selected( esc_attr( $country ), 'GT', false ).'>Guatemala</option>
				<option value="GY" '.selected( esc_attr( $country ), 'GY', false ).'>Guiana</option>
				<option value="GF" '.selected( esc_attr( $country ), 'GF', false ).'>Guiana Francesa</option>
				<option value="HT" '.selected( esc_attr( $country ), 'HT', false ).'>Haiti</option>
				<option value="NL" '.selected( esc_attr( $country ), 'NL', false ).'>Holanda</option>
				<option value="HN" '.selected( esc_attr( $country ), 'HN', false ).'>Honduras</option>
				<option value="HK" '.selected( esc_attr( $country ), 'HK', false ).'>Hong Kong</option>
				<option value="HU" '.selected( esc_attr( $country ), 'HU', false ).'>Hungria</option>
				<option value="CK" '.selected( esc_attr( $country ), 'CK', false ).'>Ilha Cook</option>
				<option value="MH" '.selected( esc_attr( $country ), 'MH', false ).'>Ilha Marshall</option>
				<option value="IN" '.selected( esc_attr( $country ), 'IN', false ).'>Índia</option>
				<option value="ID" '.selected( esc_attr( $country ), 'ID', false ).'>Indonésia</option>
				<option value="EN" '.selected( esc_attr( $country ), 'EN', false ).'>Inglaterra</option>
				<option value="IR" '.selected( esc_attr( $country ), 'IR', false ).'>Irã</option>
				<option value="IQ" '.selected( esc_attr( $country ), 'IQ', false ).'>Iraque</option>
				<option value="IE" '.selected( esc_attr( $country ), 'IE', false ).'>Irlanda</option>
				<option value="IS" '.selected( esc_attr( $country ), 'IS', false ).'>Islândia</option>
				<option value="IL" '.selected( esc_attr( $country ), 'IL', false ).'>Israel</option>
				<option value="IT" '.selected( esc_attr( $country ), 'IT', false ).'>Itália</option>
				<option value="JM" '.selected( esc_attr( $country ), 'JM', false ).'>Jamaica</option>
				<option value="JP" '.selected( esc_attr( $country ), 'JP', false ).'>Japão</option>
				<option value="KI" '.selected( esc_attr( $country ), 'KI', false ).'>Kiribati</option>
				<option value="KW" '.selected( esc_attr( $country ), 'KW', false ).'>Kuwait</option>
				<option value="LA" '.selected( esc_attr( $country ), 'LA', false ).'>Laos</option>
				<option value="LS" '.selected( esc_attr( $country ), 'LS', false ).'>Lesotho</option>
				<option value="LB" '.selected( esc_attr( $country ), 'LB', false ).'>Líbano</option>
				<option value="LY" '.selected( esc_attr( $country ), 'LY', false ).'>Líbia</option>
				<option value="LI" '.selected( esc_attr( $country ), 'LI', false ).'>Liechtenstein</option>
				<option value="LU" '.selected( esc_attr( $country ), 'LU', false ).'>Luxemburgo</option>
				<option value="MT" '.selected( esc_attr( $country ), 'MT', false ).'>Malta</option>
				<option value="MA" '.selected( esc_attr( $country ), 'MA', false ).'>Marrocos</option>
				<option value="MR" '.selected( esc_attr( $country ), 'MR', false ).'>Mauritânia</option>
				<option value="MU" '.selected( esc_attr( $country ), 'MU', false ).'>Mauritius</option>
				<option value="MX" '.selected( esc_attr( $country ), 'MX', false ).'>México</option>
				<option value="MZ" '.selected( esc_attr( $country ), 'MZ', false ).'>Moçambique</option>
				<option value="MC" '.selected( esc_attr( $country ), 'MC', false ).'>Mônaco</option>
				<option value="MN" '.selected( esc_attr( $country ), 'MN', false ).'>Mongólia</option>
				<option value="NA" '.selected( esc_attr( $country ), 'NA', false ).'>Namíbia</option>
				<option value="NP" '.selected( esc_attr( $country ), 'NP', false ).'>Nepal</option>
				<option value="NI" '.selected( esc_attr( $country ), 'NI', false ).'>Nicarágua</option>
				<option value="NG" '.selected( esc_attr( $country ), 'NG', false ).'>Nigéria</option>
				<option value="NO" '.selected( esc_attr( $country ), 'NO', false ).'>Noruega</option>
				<option value="NZ" '.selected( esc_attr( $country ), 'NZ', false ).'>Nova Zelândia</option>
				<option value="OM" '.selected( esc_attr( $country ), 'OM', false ).'>Omã</option>
				<option value="PA" '.selected( esc_attr( $country ), 'PA', false ).'>Panamá</option>
				<option value="PK" '.selected( esc_attr( $country ), 'PK', false ).'>Paquistão</option>
				<option value="PY" '.selected( esc_attr( $country ), 'PY', false ).'>Paraguai</option>
				<option value="PE" '.selected( esc_attr( $country ), 'PE', false ).'>Peru</option>
				<option value="PF" '.selected( esc_attr( $country ), 'PF', false ).'>Polinésia Francesa</option>
				<option value="PL" '.selected( esc_attr( $country ), 'PL', false ).'>Polônia</option>
				<option value="PT" '.selected( esc_attr( $country ), 'PT', false ).'>Portugal</option>
				<option value="QA" '.selected( esc_attr( $country ), 'QA', false ).'>Qatar</option>
				<option value="DO" '.selected( esc_attr( $country ), 'DO', false ).'>República Dominicana</option>
				<option value="RO" '.selected( esc_attr( $country ), 'RO', false ).'>Romênia</option>
				<option value="RU" '.selected( esc_attr( $country ), 'RU', false ).'>Rússia</option>
				<option value="SH" '.selected( esc_attr( $country ), 'SH', false ).'>Santa Helena</option>
				<option value="LC" '.selected( esc_attr( $country ), 'LC', false ).'>Santa Lúcia</option>
				<option value="VC" '.selected( esc_attr( $country ), 'VC', false ).'>Santo Vicente e Grenadines</option>
				<option value="SY" '.selected( esc_attr( $country ), 'SY', false ).'>Síria</option>
				<option value="SD" '.selected( esc_attr( $country ), 'SD', false ).'>Sudão</option>
				<option value="SE" '.selected( esc_attr( $country ), 'SE', false ).'>Suécia</option>
				<option value="CH" '.selected( esc_attr( $country ), 'CH', false ).'>Suiça</option>
				<option value="SR" '.selected( esc_attr( $country ), 'SR', false ).'>Suriname</option>
				<option value="TH" '.selected( esc_attr( $country ), 'TH', false ).'>Tailândia</option>
				<option value="TW" '.selected( esc_attr( $country ), 'TW', false ).'>Taiwan</option>
				<option value="TO" '.selected( esc_attr( $country ), 'TO', false ).'>Tonga</option>
				<option value="TT" '.selected( esc_attr( $country ), 'TT', false ).'>Trinidad e Tobago</option>
				<option value="TR" '.selected( esc_attr( $country ), 'TR', false ).'>Turquia</option>
				<option value="TV" '.selected( esc_attr( $country ), 'TV', false ).'>Tuvalu</option>
				<option value="UY" '.selected( esc_attr( $country ), 'UY', false ).'>Uruguai</option>
				<option value="VU" '.selected( esc_attr( $country ), 'VU', false ).'>Vanuatu</option>
				<option value="ZM" '.selected( esc_attr( $country ), 'ZM', false ).'>Zâmbia</option>
				<option value="ZW" '.selected( esc_attr( $country ), 'ZW', false ).'>Zimbabwe</option>';
	return $retorno;
}

function retorna_codigo_pais($pais){
	$value = "";
    switch($pais){
        case 'AF': $value = "+93"; break;
        case 'ZA': $value = "+27"; break;
        case 'AL': $value = "+355"; break;
        case 'DE': $value = "+49"; break;
        case 'AD': $value = "+376"; break;
        case 'AO': $value = "+244"; break;
        case 'AI': $value = "+01"; break;
        case 'AG': $value = "+01"; break;
        case 'SA': $value = "+966"; break;
        case 'AR': $value = "+54"; break;
        case 'AW': $value = "+297"; break;
        case 'AU': $value = "+61"; break;
        case 'AT': $value = "+43"; break;
        case 'BS': $value = "+01"; break;
        case 'BH': $value = "+973"; break;
        case 'BB': $value = "+01"; break;
        case 'BE': $value = "+32"; break;
        case 'BZ': $value = "+501"; break;
        case 'BM': $value = "+01"; break;
        case 'BO': $value = "+591"; break;
        case 'BW': $value = "+267"; break;
        case 'BR': $value = "+55"; break;
        case 'BN': $value = "+673"; break;
        case 'BG': $value = "+359"; break;        
        case 'BI': $value = "+257"; break;
        case 'CV': $value = "+238"; break;
        case 'KH': $value = "+855"; break;
        case 'CA': $value = "+01"; break;
        case 'TD': $value = "+253"; break;
        case 'CL': $value = "+56"; break;
        case 'CN': $value = "+86"; break;
        case 'CO': $value = "+57"; break;
        case 'DJ': $value = "+253"; break;
        case 'DM': $value = "+01"; break;
        case 'AE': $value = "+971"; break;
        case 'EC': $value = "+593"; break;
        case 'ES': $value = "+34"; break;
        case 'US': $value = "+01"; break;
        case 'FJ': $value = "+679"; break;
        case 'PH': $value = "+63"; break;
        case 'FI': $value = "+358"; break;
        case 'FR': $value = "+33"; break;
        case 'GA': $value = "+241"; break;
        case 'GH': $value = "+233"; break;
        case 'GI': $value = "+350"; break;
        case 'GD': $value = "+01"; break;
        case 'GR': $value = "+30"; break;
        case 'GP': $value = "+590"; break;
        case 'GU': $value = "+671"; break;
        case 'GT': $value = "+502"; break;
        case 'GY': $value = "+592"; break;
        case 'GF': $value = "+594"; break;
        case 'HT': $value = "+501"; break;
        case 'NL': $value = "+31"; break;
        case 'HN': $value = "+504"; break;
        case 'HK': $value = "+852"; break;
        case 'HU': $value = "+36"; break;
        case 'CK': $value = "+682"; break;
        case 'MH': $value = "+692"; break;
        case 'IN': $value = "+91"; break;
        case 'ID': $value = "+62"; break;
        case 'EN': $value = "+44"; break;
        case 'IR': $value = "+98"; break;
        case 'IQ': $value = "+964"; break;
        case 'IE': $value = "+353"; break;
        case 'IS': $value = "+354"; break;
        case 'IL': $value = "+972"; break;
        case 'IT': $value = "+39"; break;
        case 'JM': $value = "+01"; break;
        case 'JP': $value = "+81"; break;
        case 'KI': $value = "+686"; break;
        case 'KW': $value = "+965"; break;
        case 'LA': $value = "+856"; break;
        case 'LS': $value = "+266"; break;
        case 'LB': $value = "+961"; break;
        case 'LY': $value = "+218"; break;
        case 'LI': $value = "+423"; break;
        case 'LU': $value = "+352"; break;
        case 'MT': $value = "+356"; break;
        case 'MA': $value = "+212"; break;
        case 'MR': $value = "+222"; break;
        case 'MU': $value = "+230"; break;
        case 'MX': $value = "+52"; break;
        case 'MZ': $value = "+258"; break;
        case 'MC': $value = "+377"; break;
        case 'MN': $value = "+976"; break;
        case 'NA': $value = "+264"; break;
        case 'NP': $value = "+977"; break;
        case 'NI': $value = "+505"; break;
        case 'NG': $value = "+234"; break;
        case 'NO': $value = "+47"; break;
        case 'NZ': $value = "+64"; break;
        case 'OM': $value = "+968"; break;
        case 'PA': $value = "+507"; break;
        case 'PK': $value = "+92"; break;
        case 'PY': $value = "+595"; break;
        case 'PE': $value = "+51"; break;
        case 'PF': $value = "+689"; break;
        case 'PL': $value = "+48"; break;
        case 'PT': $value = "+351"; break;
        case 'QA': $value = "+974"; break;
        case 'DO': $value = "+01"; break;
        case 'RO': $value = "+40"; break;
        case 'RU': $value = "+07"; break;
        case 'SH': $value = "+290"; break;
        case 'LC': $value = "+01"; break;
        case 'VC': $value = "+01"; break;
        case 'SY': $value = "+963"; break;
        case 'SD': $value = "+249"; break;
        case 'SE': $value = "+46"; break;
        case 'CH': $value = "+41"; break;
        case 'SR': $value = "+597"; break;
        case 'TH': $value = "+66"; break;
        case 'TW': $value = "+886"; break;
        case 'TO': $value = "+676"; break;
        case 'TT': $value = "+01"; break;
        case 'TR': $value = "+90"; break;
        case 'TV': $value = "+688"; break;
        case 'UY': $value = "+598"; break;
        case 'VU': $value = "+678"; break;
        case 'ZM': $value = "+260"; break;
        case 'ZW': $value = "+263"; break;
    }
    
    return $value;
}


$functionsdir = TEMPLATEPATH . '/oop/';
require_once ( $functionsdir . 'Iemi.php' );

