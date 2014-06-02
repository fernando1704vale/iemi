<?php /* Template Name: No Sidebar */ ?>
<?php get_header(); ?>

	<div id="content" class="entry no-sidebar">	
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
			
		<?php endwhile; ?>
	</div><?php // #content .entry ? ?>

<?php get_footer(); ?>
