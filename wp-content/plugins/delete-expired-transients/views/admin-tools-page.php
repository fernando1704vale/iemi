<?php
// Tools menu page for plugin

global $wp_version;
?>

<div class='wrap'>
<?php if (version_compare($wp_version, '3.8', '<')) screen_icon(); ?>
<h2><?php _e('Delete Expired Transients', 'delxtrans'); ?></h2>

<?php if ($action == 'delete-expired'): ?>
<div class='updated fade'>
	<p><?php _e('Expired transients deleted.', 'delxtrans'); ?></p>
</div>
<?php endif; ?>

<?php if ($action == 'delete-all'): ?>
<div class='updated fade'>
	<p><?php _e('All transients deleted.', 'delxtrans'); ?></p>
</div>
<?php endif; ?>

<p><?php printf(__('Expired transients: %s', 'delxtrans'), number_format_i18n($counts->expired)); ?></p>
<p><?php printf(__('Total transients: %s', 'delxtrans'), number_format_i18n($counts->total + $counts->never_expire)); ?></p>

<form action="<?php echo admin_url('tools.php'); ?>?page=delxtrans" method="post">

	<table class="form-table">

	<tr valign='top'>
		<th><strong><?php _e('Delete transients', 'delxtrans'); ?></strong></th>
		<td>
			<label><input type="radio" name="delxtrans-action" value="delete-expired" checked="checked" />
				<?php _e('expired transients', 'delxtrans'); ?></label><br />
			<label><input type="radio" name="delxtrans-action" value="delete-all" />
				<?php _e('all transients -- use with caution!', 'delxtrans'); ?></label>
		</td>
	</tr>

	<tr>
		<th>&nbsp;</th>
		<td>
			<input type="submit" name="Submit" class="button-primary" value="<?php _e('Delete', 'delxtrans'); ?>" />
			<?php wp_nonce_field('delete', 'delxtrans_wpnonce', false); ?>
		</td>
	</tr>

	</table>

</form>
