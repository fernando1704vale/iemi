<div id="secondary" class="widget-area" role="complementary">
        
	<div class="red">
        <?php dynamic_sidebar( 'top-sidebar' ); ?>
        <div class="red_top"></div>
        <div class="red_middle">
			
			<?php// PRODUTOS RELACIONADOS ?>
			<?php if(is_array(get_post_custom_values('Relacionados')) && !is_tax('wpsc_product_category')) { ?>
			<?php $related = get_post_custom_values('Relacionados'); ?>
			<li class="widget" id="related-widget">
            <div class="red_title"><h3 class="widget-title">Estudos Relacionados</h3><div class="red_title_r"></div></div>
            	<ul><?php
					//global $wp_query;
					global $post;
					$tmp_post = $post;
					$c = 0;
					foreach ( $related as $value ) {
						
						//setup_postdata( $product );
						
						$post_estudo = get_post(substr(strrchr($value, ' - '), 1));
						setup_postdata($post_estudo);
						$post = $post_estudo;
						if($c==4){break;}
						$c++;
						//wpsc_the_product()
				?>
					<li class="related_product">
					 
						<a href="<?php echo get_permalink( $post_estudo ); ?>" title="<?php echo get_the_title( $post_estudo ); ?>">
							<?php if ( wpsc_the_product_thumbnail ( ) ) : ?>
							 <img class="product_image <?php wpsc_the_product_id(); ?>" id="product_image_<?php echo get_the_title( $post_estudo ); ?>" alt="<?php echo get_the_title( $post_estudo ); ?>" title="<?php echo get_the_title( $post_estudo ); ?>" src="<?php echo wpsc_the_product_image(); ?>" width="60" />
							<?php else: ?>
							 <img class="no-image" id="product_image_<?php echo get_the_title( $post_estudo ); ?>" alt="Sem Imagem" title="<?php echo get_the_title( $post_estudo ); ?>" src="<?php bloginfo( 'template_url' ); ?>/images/noimage.gif" width="60" />
							<?php endif; ?>
							
							<h6><?php echo get_the_title( $post_estudo ); ?></h6>
						</a>
					</li>
					<?php if( $c % 2 === 0 ) { ?>
						<div class="clr"></div>
					<?php } 
					
				} 
				// resetar post;
				$post = $tmp_post;
				?>
                </ul>
			</li>
            <?php } ?>
            
            
            	<?php// CATEGORIAS ?>
			<?php $biblioteca_panel = get_post_custom_values('Biblioteca', get_the_id())?>
			<?php if($biblioteca_panel[0] || is_tax('wpsc_product_category')) { ?>
			<?php dynamic_sidebar( 'middle-sidebar' ); ?>
			<?php } ?>
		
			<?php// ÚLTIMOS POSTS ?>
			<?php $noticias_panel = get_post_custom_values('Últimas Notícias', get_the_id())?>
			<?php if($noticias_panel[0] || is_home() || is_single() || is_archive()) { ?>
            <li class="widget">
            <div class="red_title"><h3 class="widget-title">Últimas Informações</h3><div class="red_title_r"></div></div>
            	<ul>
					<?php
					
						$recent_posts = wp_get_recent_posts(array('numberposts' => 5, 'post_status' => 'publish'));
						foreach( $recent_posts as $post ) {
					?>
					<li>
						<?php echo idate('d', strtotime($post["post_date"])); ?>/<?php echo idate('m', strtotime($post["post_date"])); ?>/<?php echo idate('y', strtotime($post["post_date"])); ?> – <?php $post_cat = get_the_category($post["ID"]); echo $post_cat[0]->cat_name; ?><br />
						<a href="<?php echo get_permalink($post["ID"]); ?>"><?php echo $post["post_title"]; ?></a> 
					</li>
					<?php } ?>
				</ul>
			</li>
            <?php } ?>
            
            
        </div>
        <div class="red_bottom"></div>
	</div>
            
            
            
		</div>


<div id="sidebar">
	
	<div id="primary" class="widget-area" role="complementary">
		<ul class="xoxo">
			
		
		
		
			<?php dynamic_sidebar( 'bottom-sidebar' ); ?>
			
		</ul>
	</div><!-- #primary .widget-area -->
		
</div>
