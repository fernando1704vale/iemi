
<?php get_header(); ?>
<?php $endereco = $_SERVER ['REQUEST_URI']; ?>
	
	<div id="content" class="entry <? if(is_page(5)) { echo 'no-sidebar'; } ?>">	
		<?php while ( have_posts() ) : the_post(); ?>
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			
			<?php if (strpos($endereco,"estudos-do-mercado-potencial")) $id_video = 17;
				  elseif (strpos($endereco,"estudos-do-comportamento-de-compra")) $id_video = 19;
				  elseif (strpos($endereco,"estudos-dos-canais-do-varejo")) $id_video = 15;
				  elseif (strpos($endereco,"cobertura-mercadologica")) $id_video = 16;
				  elseif (strpos($endereco,"termometro-iemi")) $id_video = 18;
				  
				  if(!strcmp($endereco,"/biblioteca/estudos-do-mercado-potencial/") 
				    || !strcmp($endereco,"/biblioteca/estudos-do-comportamento-de-compra/")
				    || !strcmp($endereco,"/biblioteca/estudos-dos-canais-do-varejo/")
				    || !strcmp($endereco,"/inteligencia-de-mercado/cobertura-mercadologica/")
				    || !strcmp($endereco,"/biblioteca/termometro-iemi/")){
						$biblioteca = true;
					}
				 
				  if (!empty($id_video)) {?>
					<a class="btn_video <?php if(isset($biblioteca) && ($biblioteca == true)) echo "biblioteca_btn_video"; else echo "btn_video_pagina" ?>" href="/videos-iemi/?video=<?php echo $id_video ?>" ><span>Assista o Vídeo</span> <img alt="" src="http://www.iemi.com.br/wp-content/themes/iemi/images/video_icone.png" width="30" height="24" /></a>
				   <?php } ?>
			<div class="entry-content">
				<?php if(is_page(9705)) echo '<div id="nova_vaga">
						<b>Vagas disponíveis:</b><br>
						<p>Coordenador de Pesquisa <a id="vaga_veja_mais" class="btn" href="http://www.iemi.com.br/perfil-de-cargo-coordenador-de-pesquisas-de-mercado/"> Veja Mais </a></p>
					</div>'; ?>
				<?php the_content();
				
				if (strpos($endereco,"biblioteca")){ 	// So exibe as redes sociais embaixo para os produtos
					?>			
				</div>
				
				<div class="social">
					<div class="nw nw_linkedin">
						<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
						<script type="IN/Share" data-url="<?php the_permalink(); ?>" data-counter="right"></script>
					</div>
					<div class="nw nw_twitter">
						<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php the_permalink(); ?>" data-text="IEMI | <?php the_title(); ?>" data-count="horizontal">Tweet</a>
						<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
					</div>
					<!--<div class="nw nw_orkut">
						<div id="orkut_share" style="width:100%;"></div>
						<script src="http://www.google.com/jsapi" type="text/javascript"></script>
						<script type="text/javascript">google.load('orkut.share', '1');google.setOnLoadCallback(function(){new google.orkut.share.Button({style:'regular', title:'IEMI | <?php the_title(); ?>', destination:'<?php the_permalink(); ?>'}).draw('orkut_share');}, true);</script>
					</div>-->
					<div class="nw nw_facebook">
						<div id="fb-root"></div>
						<script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) {return;}js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/pt_BR/all.js#xfbml=1";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
						<div class="fb-like" data-href="<?php the_permalink(); ?>" data-send="true" data-layout="button_count" data-width="180" data-show-faces="false"></div>
					</div>
					<div class="nw nw_google">
						<div class="g-plusone" data-size="medium"></div>
						<script type="text/javascript">
						  (function() {
							var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
							po.src = 'https://apis.google.com/js/plusone.js';
							var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
						  })();
						</script>
					</div>
				<?php } ?>
			</div>
		<?php endwhile; ?>
	</div><?php // #content .entry ? ?>

<? if(!is_page(5)) { get_sidebar(); } ?>
<?php get_footer(); ?>
