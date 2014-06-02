<?php
global $wp_query;	
/*
 * Most functions called in this page can be found in the wpsc_query.php file
 */
?>
<div id="default_products_page_container" class="wrap wpsc_container">
	<?php if(wpsc_display_categories()): ?>
	  <?php if(wpsc_category_grid_view()) :?>
			<div class="wpsc_categories wpsc_category_grid group">
				<?php wpsc_start_category_query(array('category_group'=> get_option('wpsc_default_category'), 'show_thumbnails'=> 1)); ?>
					<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_grid_item  <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>">
						<?php wpsc_print_category_image(get_option('category_image_width'),get_option('category_image_height')); ?>
					</a>
					<?php wpsc_print_subcategory("", ""); ?>
				<?php wpsc_end_category_query(); ?>
				
			</div><!--close wpsc_categories-->
	  <?php else:?>
			<ul class="wpsc_categories">
			
				<?php wpsc_start_category_query(array('category_group'=>get_option('wpsc_default_category'), 'show_thumbnails'=> get_option('show_category_thumbnails'))); ?>
						<li>
							<?php wpsc_print_category_image(get_option('category_image_width'), get_option('category_image_height')); ?>
							
							<a href="<?php wpsc_print_category_url();?>" class="wpsc_category_link <?php wpsc_print_category_classes_section(); ?>" title="<?php wpsc_print_category_name(); ?>"><?php wpsc_print_category_name(); ?></a>
							<?php if(wpsc_show_category_description()) :?>
								<?php wpsc_print_category_description("<div class='wpsc_subcategory'>", "</div>"); ?>				
							<?php endif;?>
							
							<?php wpsc_print_subcategory("<ul>", "</ul>"); ?>
						</li>
				<?php wpsc_end_category_query(); ?>
			</ul>
		<?php endif; ?>
	<?php endif; ?>
	
	<?php if(wpsc_display_products()): ?>
		
		<?php if(wpsc_is_in_category()) : ?>
			<div class="wpsc_category_details">
				<?php if(wpsc_show_category_thumbnails()) : ?>
					<img src="<?php echo wpsc_category_image(); ?>" alt="<?php echo wpsc_category_name(); ?>" />
				<?php endif; ?>
				
				<?php if(wpsc_show_category_description() &&  wpsc_category_description()) : ?>
					<?php echo wpsc_category_description(); ?>
				<?php endif; ?>
			</div><!--close wpsc_category_details-->
		<?php endif; ?>
		<?php if(wpsc_has_pages_top()) : ?>
			<div class="wpsc_page_numbers_top">
				<?php wpsc_pagination(); ?>
			</div><!--close wpsc_page_numbers_top-->
		<?php endif; ?>		
		
	
		<div class="wpsc_default_product_list">
		<?php /** start the product loop here */?>
		<?php while (wpsc_have_products()) :  wpsc_the_product(); ?>
					
			<div class="default_product_display product_view_<?php echo wpsc_the_product_id(); ?> <?php echo wpsc_category_class(); ?> group">   
				<?php if(wpsc_show_thumbnails()) :?>
					<div class="cover" id="covercol_<?php echo wpsc_the_product_id(); ?>">
						<?php if(wpsc_the_product_thumbnail()) : ?>
							<a rel="<?php echo wpsc_the_product_title(); ?>" class="<?php echo wpsc_the_product_image_link_classes(); ?>" href="<?php echo wpsc_the_product_image(); ?>">
								<img class="product_image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="<?php echo wpsc_the_product_title(); ?>" title="<?php echo wpsc_the_product_title(); ?>" src="<?php echo wpsc_the_product_image(); ?>" width="85" />
							</a>
						<?php else: ?>
							<a href="<?php echo wpsc_the_product_permalink(); ?>">
								<img class="no-image" id="product_image_<?php echo wpsc_the_product_id(); ?>" alt="Sem Imagem" title="<?php echo wpsc_the_product_title(); ?>" src="<?php bloginfo( 'template_url' ); ?>/images/noimage.gif" width="85" height="120" />	
							</a>
						<?php endif; ?>
					</div><!--close imagecol-->
				<?php endif; ?>
				
				<div class="insidecol">
					<h2 class="entry-title">
						<a class="wpsc_product_title" href="<?php echo wpsc_the_product_permalink(); ?>"><?php echo wpsc_the_product_title(); ?></a>
					</h2>   				
					<?php							
						do_action('wpsc_product_before_description', wpsc_the_product_id(), $wp_query->post);
						do_action('wpsc_product_addons', wpsc_the_product_id());
					?>
					<?php if(wpsc_the_product_additional_description()) : ?>	
					<p><?php echo wpsc_the_product_additional_description(); ?></p>
					<?php endif; ?>
					<p class="argt"><a class="btn" href="<?php echo wpsc_the_product_permalink(); ?>">Veja Mais</a></p>
					<p class="clr"></p>
				</div><!--close insidecol-->
		</div><!--close default_product_display-->

		<?php endwhile; ?>
		<?php /** end the product loop here */?>
		</div>
		<?php if(wpsc_product_count() == 0):?>
			<h3><?php  _e('There are no products in this group.', 'wpsc'); ?></h3>
		<?php endif ; ?>

		<?php if(wpsc_has_pages_bottom()) : ?>
			<div class="wpsc_page_numbers_bottom">
				<?php wpsc_pagination(); ?>
			</div><!--close wpsc_page_numbers_bottom-->
		<?php endif; ?>
	<?php endif; ?>
</div><!--close default_products_page_container-->
