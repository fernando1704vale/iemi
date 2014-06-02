<?php
	// Setup globals
	// @todo: Get these out of template
	global $wp_query;

	// Setup image width and height variables
	// @todo: Investigate if these are still needed here
	$image_width  = get_option( 'single_view_image_width' );
	$image_height = get_option( 'single_view_image_height' );
?>
<div id="single_product_page_container">
	
	<div class="single_product_display group">
<?php while ( wpsc_have_products() ) : wpsc_the_product(); ?>
		
		<?php if((get_option('hide_addtocart_button') == 0) &&  (get_option('addtocart_or_buynow') !='1')) : ?>
		<table border="0" cellspacing="0" cellpadding="0" class="ecommerce_nav">
			<tr>
				<?php if(is_user_logged_in() && isset($_SESSION['user_coupon'])) { ?>
				<?php
					$wpsc_coupons = new wpsc_coupons($_SESSION['user_coupon']['coupon_code']);
					// transforma valor cheio em número
					$price = calculate_price(wpsc_the_product_price());
				?>
				<td class="ecommerce_nav_lft">
					<p class="from_price">De: <?php echo $price['from_price']; ?></p>
					<p class="price new_price">Por: <?php echo $price['new_price']; ?></p>
					<p class="discount"><?php echo $_SESSION['user_coupon']['coupon_code'].' economiza '.$price['discount']; ?></p>
				</td>
				<?php } else {?>
					<?php if (wpsc_the_product_id() == 6597 || wpsc_the_product_id() == 6600 || wpsc_the_product_id() == 6599 ||
					         wpsc_the_product_id() == 12440 ){ ?>
								 
								<td class="ecommerce_nav_lft_termometro">
					
									<p class="price">Avulso: <?php echo wpsc_the_product_price(); ?></p>
									<p class="price">Assinatura anual: R$ 149,00 mensais</p>
								</td>
							<?php }else{ ?>
								<td class="ecommerce_nav_lft">
									<p class="price">Por: <?php echo wpsc_the_product_price(); ?></p>
								</td>
							<?php } ?>
				
				<?php } ?>
				<td class="ecommerce_nav_rgt">
					<form class="product_form" enctype="multipart/form-data" action="<?php echo wpsc_this_page_url(); ?>" method="post" name="1" id="product_<?php echo wpsc_the_product_id(); ?>">
						<input type="hidden" value="add_to_cart" name="wpsc_ajax_action" />
						<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id" />
							<?php if(wpsc_product_has_stock()) : ?>
								<div class="wpsc_buy_button_container">
										<?php if(wpsc_product_external_link(wpsc_the_product_id()) != '') :
											 ?>
										<?php $action = wpsc_product_external_link( wpsc_the_product_id() ); ?>
										<input class="wpsc_buy_button btn" type="submit" value="<?php echo wpsc_product_external_link_text( wpsc_the_product_id(), __( 'Buy Now', 'wpsc' ) ); ?>" onclick="return gotoexternallink('<?php echo $action; ?>', '<?php echo wpsc_product_external_link_target( wpsc_the_product_id() ); ?>')">
										<?php else:  ?>
									<input type="submit" value="<?php _e('Add To Cart', 'wpsc'); ?>" name="Buy" class="wpsc_buy_button btn" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button"/>
										<?php endif; ?>
									<div class="wpsc_loading_animation">
										<img title="Loading" alt="Loading" src="<?php echo wpsc_loading_animation_url(); ?>" />
										<?php _e('Updating cart...', 'wpsc'); ?>
									</div><!--close wpsc_loading_animation-->
								</div><!--close wpsc_buy_button_container-->
							<?php else : ?>
								<p class="soldout"><?php _e('Produto Esgotado.', 'wpsc'); ?><a id="vaga_veja_mais" class="btn" href="http://www.iemi.com.br/quem-somos/fale-conosco/"> Reserve já a edição 2014! </a></p>
								
							<?php endif ; ?>
					</form><!--close product_form-->
				</td>
			</tr>
		</table>
		<?php else : ?>
			<table border="0" cellspacing="0" cellpadding="0" class="ecommerce_nav">
				<tr>
					<td class="ecommerce_nav_lft"></td>
					<td class="ecommerce_nav_rgt"></td>
				</tr>
			</table>
		<?php endif ; ?>
		
		<div class="tab-box-container">
			
			<?php /* if(get_post_custom_values('Índice') ||  get_post_custom_values('Teaser')) : */ ?>
				<ul class="tab-box-title">
					<li class="tab-descricao"><a href="#descricao">Descrição</a></li>
					<?php if(get_post_custom_values('Índice')) : ?>
						<li class="tab-indice"><a href="#indice">Índice</a></li>
					<?php endif; ?>
					<?php if(get_post_custom_values('Teaser')) : ?>
						<li class="tab-mercado"><a href="#mercado">Mercado</a></li>
					<?php endif; ?>
				</ul>
			<?php /* endif; */ 
			$width = get_option('product_image_width');
			$height = get_option('product_image_height');?>
			
			<div id="descricao" class="tab-box-content tab-descricao active">
				<div class="imagecol cover">
					<?php if ( wpsc_the_product_thumbnail() ) : ?>
						<a rel="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" href="<?php echo wpsc_the_product_image(); ?>">
							<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_thumbnail(get_option('product_image_width'),get_option('product_image_height'),'','single'); ?>"/>
						</a>
					<?php else: ?>
						<a href="<?php echo wpsc_the_product_permalink(); ?>">
							<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="Sem Imagem" title="<?php echo wpsc_the_product_title(); ?>" src="<?php bloginfo( 'template_url' ); ?>/images/noimage.gif" width="119" height="168" />	
						</a>
					<?php endif; ?>
				</div><!--close imagecol-->

				<h3 class="screen-reader-text">Descrição</h3>
				<?php echo wpsc_the_product_description(); ?>
			
			</div>
		
			<?php if(get_post_custom_values('Índice')) : ?>
				<div id="indice" class="tab-box-content tab-indice active">
					<h3 class="screen-reader-text">Índice</h3>
					<?php $indice = get_post_custom_values('Índice');?>
					<?php echo $indice[0]; ?>
				</div>				
			<?php endif; ?>
			<?php if(get_post_custom_values('Teaser')) : ?>
				<div id="mercado" class="tab-box-content tab-mercado active">
					<h3 class="screen-reader-text">Mercado</h3>
					<?php 
						if(is_user_logged_in()) { 
							$mercado = get_post_custom_values('Teaser');
							echo $mercado[0]; 
						} else {
					?>
						<p>O IEMI disponibiliza conteúdo exclusivo sobre este estudo apenas para usuários cadastrados. Efetue login ou <a href="/conta/novo-cadastro/" title="Cadastre-se">cadastre-se</a> para acessá-lo.</p>
						
						<?php pg_login_form(array('action'=>get_permalink().'#mercado','redirect_to'=>get_permalink().'#mercado')); ?>
												
					<?php } ?>
				</div> 		
			<?php endif; ?>

		</div>
		
<?php endwhile; ?> 	
	</div><!--close single_product_display-->
	
</div><!--close single_product_page_container-->


