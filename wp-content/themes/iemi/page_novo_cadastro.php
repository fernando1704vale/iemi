<?php/* Template Name: Novo Cadastro */ ?>
<?php get_header(); ?>

	<div id="content" class="no-sidebar">	
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php pg_register_form(); ?>
			</div>
			
		<?php endwhile; ?>
	</div><?php // #content .entry ? ?>
<script type="text/javascript">
jQuery(document).ready(function(){  
  jQuery("#abitop").change(function () {
    if(jQuery("#abitop-msg").is(':visible')){
       jQuery("#abitop-msg").hide('fast');
    }else{
       jQuery("#abitop-msg").show('fast');
    }
  });
});
</script>
<?php get_footer(); ?>
