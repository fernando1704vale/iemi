<?php/* Template Name: Login */ ?>
<?php if(is_user_logged_in()) { header('location: /'); } ?>
<?php get_header(); ?>
<?php 

    $siteURL = get_site_url(); 

?>

	<div id="content" class="no-sidebar">	
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php pg_login_form(array('redirect_to' => $siteURL)) ?>
			</div>
			
		<?php endwhile; ?>
	</div><?php // #content .entry ? ?>

<?php get_footer(); ?>
