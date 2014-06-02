
<?php
        
              

	// redireciona a partir do campo URL Redirect de cada página
	if($urlredirect = get_post_custom_values('URL Redirect', get_the_id())) {
		header('Location: '.$urlredirect[0]);
	}
	if( wpsc_product_count() == 1 && !is_singular('wpsc-product') && !is_single() && !is_page() ) {
		wpsc_the_product();
		header('location:'.wpsc_the_product_permalink());
		wp_reset_query();
		//exit();
	}
	//verifica se é login recente
/*	if ( $_SESSION['login_ok'] ) {
		//$login_panel_class = 'actived login-actived';
		$_SESSION['login_ok'] = false;
	}
	if ( $_SESSION['register_ok'] ) {
		$login_panel_class = 'actived register-actived';
		$_SESSION['register_ok'] = false;
	}
*/	// executa login
	pg_login_action();
	// cria ou atualiza usuario
	if(pg_update_action()) {
		$login_panel_class = 'actived registered-actived';
		$registered = true;
	};
	//verifica se existem erros nos formularios
//	global $pg_user;
//	global $login_alert;
//	global $register_alert;
	global $newsletter_alert;
	if ( is_wp_error($pg_user) || $login_alert || isset($_GET['login']) || isset($_GET['ativado'])) { $login_panel_class = 'actived login-actived'; }
	if ( count($newsletter_alert) ) { $login_panel_class = 'actived newsletter_alert'; }
	if ( count($register_alert) ) {
		$login_panel_class = 'actived register-actived';
		if ( $_POST['type']=='pf' ) { $login_panel_class = 'actived register-actived npf'; }
		if ( $_POST['type']=='pj' ) { $login_panel_class = 'actived register-actived npj'; }
		if ( $_POST['full'] ) { $login_panel_class .= ' fullregister-actived'; }
	}




	// verifica se esta logado e se existe um cupom cadastrado
	if(is_user_logged_in()) {
		global $current_user, $wpdb;
		$coupon_id = get_user_meta($current_user->ID, 'coupon', true);
		$coupon = $wpdb->get_results("SELECT * FROM wp_test_wpsc_coupon_codes WHERE id = '$coupon_id'", ARRAY_A);
		$_SESSION['user_coupon'] = $coupon[0];
	} else {
		$_SESSION['user_coupon'] = null;
	}

	// ativa o cupom cadastrado
	global $wpsc_cart, $wpdb, $wpsc_checkout, $wpsc_gateway, $wpsc_coupons;
	if(is_user_logged_in() && isset($_SESSION['user_coupon'])) {
	   $wpsc_coupons = new wpsc_coupons($_SESSION['user_coupon']);
	} else {
		$wpsc_coupons = null;
	}


?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="utf-8" />
	<title><?php
		global $page, $paged;
		wp_title( '', true, 'right' );
		bloginfo( 'name' );
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) )
			echo "  $site_description";
		if ( $paged >= 2 || $page >= 2 )
			echo '  ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );
		?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9">
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="stylesheet" type="text/css" media="all" href="http://www.iemi.com.br/wp-content/themes/iemi/fontface/stylesheet.css" />
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?><?php nc(); ?>" />
	<link rel="stylesheet" href="http://www.iemi.com.br/wp-content/themes/iemi/colorbox/colorbox.css" type="text/css" media="screen" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php
	/* troca se background a partir do custom field
	if(get_post_custom_values('Background', get_the_id()) && is_single()) {
		$bg = get_post_custom_values('Background', get_the_id());
		echo '<style type="text/css" media="screen"> body { background: url("'.$bg[0].'") no-repeat fixed top left; } </style>';
	// background para o blocg 
	} if(is_home() || is_single() && get_post_type()=='post') {
		echo '<style type="text/css" media="screen"> body { background: url("'.get_bloginfo( 'template_url' ).'/images/bg_body/blog.jpg") no-repeat fixed top left; } </style>';
	}*/


	?>

	<?php wp_head(); ?>

	 <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	<script src="http://www.iemi.com.br/wp-content/themes/iemi/jquery.cycle.all.js" type="text/javascript"></script>
	<script src="http://www.iemi.com.br/wp-content/themes/iemi/colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
	<script src="http://www.iemi.com.br/wp-content/themes/iemi/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
	<script src="http://www.iemi.com.br/wp-content/themes/iemi/script.js<?php nc(); ?>" type="text/javascript"></script>
	<script src="http://www.iemi.com.br/wp-content/themes/iemi/tradutor.js<?php nc(); ?>" type="text/javascript"></script>
	<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
 
  ga('create', 'UA-31131519-22', 'iemi.com.br');
  ga('send', 'pageview');
 
</script>
	<!--[if IE]>
   <style type="text/css">
       .red_title_r{
       display:none;
   }
    </style>
<![endif]-->
</head>
<body <?php body_class(); ?>>
        
<div id="container">
	<div id="google_translate_element"></div>
            <div id="traducao_google">
                <ul class="nav">
                    <li><a href="javascript:;" class="pt" onclick="ChangeLang('pt');" title="Traduzir para portugu&ecirc;s"><img src="http://www.iemi.com.br/wp-content/themes/iemi/images/pt.png"  /></a></li>
                    <li><a href="javascript:;" class="en" onclick="ChangeLang('en');" title="Translate to English"><img src="http://www.iemi.com.br/wp-content/themes/iemi/images/en.png"  /></a></li>
                    <li><a href="javascript:;" class="es" onclick="ChangeLang('es');" title="Traducir al espa&ntilde;ol"><img src="http://www.iemi.com.br/wp-content/themes/iemi/images/es.png"  /></a></li>
                </ul>
            </div>
	<!--
		<?php
			if( wpsc_product_count() == 1 && !is_singular( 'wpsc-product' ) ) {
				//wpsc_the_product();
				//echo wpsc_the_product_permalink();
			}
		?>
	-->
	
	<div id="header"> 

			<div id="grupo_titulo">
				<h1 id="site-title"><span><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img src="http://www.iemi.com.br/wp-content/themes/iemi/images/logo_iemi.gif" width="79" height="120" /></a></span></h1>
			</div>
            <div class="header_right">
				
            	<div class="hr_1">
					
						
					
                	<ul>
						
                	<?php
						// MENU LOGADO
						if(is_user_logged_in()) {
							global $user_identity;
							get_currentuserinfo();
					?>
						<?php
							if(get_user_meta($current_user->ID, 'gender', true )=='female'){
								$greetings = 'Seja bem-vinda, ';
							} else {
								$greetings = 'Seja bem-vindo, ';
							}
						?>
						<li class="welcome"><?php echo $greetings . $user_identity; ?>.</li>
						<?php
							wp_nav_menu(array(
								'menu'            => 'Conta (logado)',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'echo'            => true,
								'before'          => '',
								'after'           => '',
								'items_wrap'      => '%3$s',
							));
						// MENU DESLOGADO
						} else {
							wp_nav_menu(array(
								'menu'            => 'Conta',
								'container'       => '',
								'container_class' => '',
								'container_id'    => '',
								'echo'            => true,
								'before'          => '',
								'after'           => '',
								'items_wrap'      => '%3$s',
							));
						}
					?>
                    </ul>
                </div>
                <div class="hr_2">
                	<div class="hr_search"><?php get_search_form(); ?></div>
                    <ul>
                    	<li><a target="_blank" href="http://twitter.com/IEMIpesquisas" title="Twitter"><img src="http://www.iemi.com.br/wp-content/themes/iemi/images/twit_icon.png" width="16" height="17" /></a></li>
                        <li><a target="_blank" href="http://www.facebook.com/iemi.inteligencia" title="Facebook"><img src="http://www.iemi.com.br/wp-content/themes/iemi/images/fb_icon.png" width="16" height="17" /></a></li>
                        <li><a target="_blank" href="http://www.linkedin.com/profile/view?id=106910593" title="LinkeIn"><img src="http://www.iemi.com.br/wp-content/themes/iemi/images/in_icon.png" width="16" height="17" /></a></li>
                        <li><a target="_blank" href="http://www.youtube.com/iemipesquisas" title="YouTube"><img src="http://www.iemi.com.br/wp-content/themes/iemi/images/youtube_icon.png" width="16" height="17" /></a></li>
                        <li><a target="_blank" href="http://iemi.com.br/blog/?feed=atom" title="Feed RSS"><img src="http://www.iemi.com.br/wp-content/themes/iemi/images/rss_icon.png" width="16" height="17" /></a></li>
                    </ul>
                </div>
                <div class="hr_3">
                	<nav id="access" role="navigation">
						<?php wp_nav_menu( array( 'container_class' => 'extra-nav', 'theme_location' => 'extra-nav' ) ); ?>
                    </nav>
                </div>
                <div class="hr_4">
                	<nav id="secondary-nav" role="navigation">
                		<?php wp_nav_menu( array( 'container_class' => 'main-nav', 'theme_location' => 'main-nav' ) ); ?>
                   	</nav>
                </div>
            </div>




<!--

		<div class="hide">
			<div id="login-panel" class="<?php echo $login_panel_class; ?>">
				<div class="login-group">

					<?php if(is_user_logged_in()) { // FORM LOGIN - LOGADO ?>
						<?php global $user_identity; get_currentuserinfo(); ?>
						<h4>Seja bem-vindo</h4>
						<?php if(isset($_GET['ativado'])) { ?>
							<p>Seu cadastro foi ativado com sucesso.</p>
							<p>Agora você terá acesso a conteúdos exclusivos e aquisição de estudos.</p>
							<p>Navegue por nossa <a href="/biblioteca/">Biblioteca</a> para conhecer nossos estudos.</p>
						<?php } else { ?>
						<p>
							Você está logado como <?php echo $user_identity; ?>
							| <a href="/cadastro/editar" class="action-register-panel" title="<?php _e('Edite seu Cadastro'); ?>">Editar Cadastro</a>
							| <a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="<?php _e('Desconectar'); ?>"><?php _e('Desconectar'); ?></a></p>
						<?php } ?>

					<?php } else { // FORM LOGIN - DESLOGADO ?>

						<h4>Acesse sua Conta</h4>
						<div class="register-instructions">
							<?php if(isset($_GET['login'])) { ?>
								<p>Digite seu login e senha para ativar seu cadastro.</p>
							<?php } else { ?>
								<p>Se você não possui uma conta, <a href="/cadastro" title="Faça seu cadastro no site IEMI" class="register-login action-register-panel">cadastre-se</a> gratuitamente.</p>
							<?php } ?>
						</div>
						<?php if(isset($_GET['login'])) { ?>
							<?php pg_login_form(array('redirect_to'=>get_permalink().'?ativado')); ?>
						<?php } else { ?>
							<?php pg_login_form(); ?>
						<?php } ?>

					<?php } ?>
				</div>
				<div class="register-group">
					<?php if(is_user_logged_in()) { // FORM CADASTRO- LOGADO ?>
						<?php global $user_identity; get_currentuserinfo(); ?>
						<h4>Suas Informações</h4>
						<?php pg_register_form(array('id' => $current_user->ID)); ?>
					<?php } else {  // FORM CADASTRO- DESLOGADO ?>
						<h4>Cadastre-se</h4>
						<p>Preencha o formulário abaixo e cadastre-se para ter acesso a informações exclusivas. Se você já possui cadastro faça o acesso através do <a href="/login" class="action-login-panel" title="Faça seu Login">formulário de login</a></p>
						<?php pg_register_form(); ?>

					<?php } ?>
				</div>
				<div class="registered-group">
					<?php global $user_email; ?>
					<?php if($user_email) { ?>
						<h4>Cadastro</h4>
						<p>O seu cadastro foi preenchido corretamente. Enviamos uma mensagem para o email <?php echo $user_email; ?> com instruções para a validação do seu cadastro.</p>
					<?php } ?>
				</div>
			</div>
		</div>

-->
	</div><?php // #header ?>

	<?php// print_r($_SESSION); ?>

	<?php if(is_home() || is_single() && get_post_type()=='post') { ?>
	<div id="blog_header">
		<h1>Blog</h1>
	</div>

	<?php } ?>

	<div id="wrapper">
