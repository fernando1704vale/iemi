<?php
/*
Template Name: Parceiros
*/
get_header(); ?>

		<div class="conteudo parceiros">
			<div class="texto">
				
				<header class="entry-header">
					<h1 class="entry-title"><?php the_title(); ?></h1>
				</header>
				
				<div class="prelista">
					<div class="lista">						
							
						<?php
							$args = array( 
								'posts_per_page' => 20, 
								'post_type' => 'parceiros', 
								'meta_key' => 'ordem', 
								'orderby' => 'meta_value_num', 
								'order' => 'ASC'
							);
							$loop = new WP_Query( $args );
							while ( $loop->have_posts() ) : $loop->the_post();
								$custom = get_post_custom($post->ID);
								$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
								$thumbURL = $thumb['0'];
								$url = $custom["url"][0];
								$titulo = get_the_title($post->ID);
								echo '<div class="parceiro"><a href="'.$url.'"><img src="'.$thumbURL.'" title="'.$titulo.'" alt="Parceiro: '.$titulo.'" /></a>';
								//echo the_content().'</div>';
								echo '</div>';
							endwhile;

						?>
					</div>
				</div>
			
				<div class="clear"></div>
				
			</div>
			
		</div><!-- #primary -->
		

<?php get_footer(); ?>
