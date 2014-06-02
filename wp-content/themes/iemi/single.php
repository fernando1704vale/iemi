<?php get_header(); ?>
	<div id="content" class="entry">

		<?php while ( have_posts() ) : the_post(); ?>

			<p class="entry-date"><?php echo get_the_date(); ?></p>
			<h1 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> <?php echo have_comments(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>

		<?php endwhile; ?>
			<hr />

			<?php
			if(is_user_logged_in()) {
				global $current_user;
				get_currentuserinfo();

				$commenter['comment_author'] = $current_user->user_firstname.' '.$current_user->user_lastname;
				$commenter['comment_author_email'] = $current_user->user_email;
				$commenter['comment_author_url'] = '';

				$coupon_id = get_user_meta($current_user->ID, 'coupon', true);

			} else {
				$commenter = wp_get_current_commenter();
			}
			?>
			<?php if( get_comments_number() ) { ?>

			<div id="comentarios">
				<h3 id="comments-title">Comentários</h3>
				<ol class="commentlist">

				<?php $args = array('post_id' => get_the_ID(), 'order' => 'DESC', 'status' => 'approve'); ?>
				<?php $comments = get_comments($args); ?>
				<?php foreach($comments as $comment) : ?>
					<li id="comment-<?php echo $comment->comment_ID; ?>">
						<p class="meta">
							<strong class="author"><?php echo $comment->comment_author; ?></strong> -
							<em class="date"><?php echo human_time_diff( get_comment_time('U'), current_time('timestamp') ) . ' atrás'; ?></em>
						</p>
						<div class="content"><?php echo wpautop($comment->comment_content); ?></div>
					</li>
				<?php endforeach; ?>

				<?php if(is_array($commenter)) { ?>
				<?php $args = array('post_id' => get_the_ID(), 'order' => 'ASC', 'status' => 'hold', 'author_email' => $commenter['comment_author_email']); ?>
				<?php $comments = get_comments($args); ?>
				<?php foreach($comments as $comment) : ?>
					<li id="comment-<?php echo $comment->comment_ID; ?>">
						<p class="meta">
							<strong class="author"><?php echo $comment->comment_author; ?></strong> -
							<em>aguardando liberação</em>
						</p>
						<div class="content"><?php echo wpautop($comment->comment_content); ?></div>
					</li>
					<?php endforeach; ?>
				<?php } ?>

				</ol>
			</div>

			<?php } elseif( !comments_open() && !is_page()) { ?>

			<div id="comentarios">
				<p class="nocomments">Comentários fechados</p>
			</div>

			<?php } ?>

			<?php if( comments_open() ) { ?>


			<div id="respond">
				<h3 id="reply-title">Deixe um comentário</h3>
				<table class="simpleinfo" border="0" cellspacing="0" cellpadding="0">
					<form action="http://iemi.com.br/wp-comments-post.php" method="post" id="commentform">

						<td class="comment-notes" colspan="2"><p class="description">O seu endereço de email não será publicado. Os comentários são sujeitos a moderação antes de serem publicados. Campos obrigatórios são marcados com *.</p></td>
						<tr class="comment-form-author">
							<th><label for="author">Nome*</label></th>
							<td><input id="author" name="author" type="text" value="<?php echo $commenter['comment_author']; ?>" size="30" aria-required='true' class="txt" /></td>
						</tr>
						<tr class="comment-form-email">
							<th><label for="email">Email*</label></th>
							<td><input id="email" name="email" type="text" value="" size="30" aria-required='true' class="txt" /></td>
						</tr>
						<tr class="comment-form-url">
							<th><label for="url">Site</label></th>
							<td><input id="url" name="url" type="text" value="<?php echo $commenter['comment_author_url']; ?>" size="30" class="txt" /></td>
						</tr>
						<tr class="comment-form-comment">
							<th><label for="comment">Comentário</label></th>
							<td><textarea id="comment" name="comment" cols="55" rows="8" aria-required="true" class="txt"></textarea></td>
						</tr>
						<tr class="form-submit">
							<th></th>
							<td><input name="submit" type="submit" id="submit" class="btn" value="Publicar comentário" /></td>
						</tr>
						<?php $id_post = get_the_ID(); ?>
						<input type='hidden' name='comment_post_ID' value='<?php echo $id_post ?>' id='comment_post_ID' />
						<input type='hidden' name='comment_parent' id='comment_parent' value='0' />
					</form>
				</table>
			</div><!-- #respond -->
			<script type="text/javascript">
				jQuery(document).ready(function() {
					jQuery('#commentform').submit(function() {
						_gaq.push( ['_setAccount','UA-23672182-1'], ['_trackEvent','comment'] );
					});
				});
			</script>

			<?php } ?>



			<?php if( comments_open() ) { ?>

			<?php
				/*$fields =  array(
					'author' => '<tr class="comment-form-author"><th><label for="author">Nome*</label></th><td><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" class="txt" ' . $aria_req . ' /></td></tr>',
					'email' => '<tr class="comment-form-email"><th><label for="email">Email*</label></th><td><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" class="txt" ' . $aria_req . ' /><p class="description">O e-mail não será exibido</p></td></tr>',
					'url' => '<tr class="comment-form-url"><th><label for="url">Site</label></th><td><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" class="txt" /></td></tr>',
					'submit' => 'xxx'
				);

				$args=array(
					'fields' => $fields,
					'comment_field' => '<tr class="comment-form-comment"><th><label for="comment">Comentário*</label></th><td><textarea id="comment" name="comment" class="txt" cols="55" rows="5" aria-required="true"></textarea></td></tr>',
					'comment_field' => '<tr><th class="comment-form-comment"><label for="comment">Comentário*</label></th><td><textarea id="comment" name="comment" class="txt" cols="55" rows="5" aria-required="true"></textarea></td></tr>',
					'comment_notes_before' => '',
					'comment_notes_after' => '',

				);*/

				//comment_form();

			?>


				</table>

			<?php } ?>


	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
