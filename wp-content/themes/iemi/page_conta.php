<?php/* Template Name: Conta */ ?>
<?php if(!is_user_logged_in()){ 'header: /'; } ?>
<?php get_header(); ?>

<?php 

    $siteURL = get_site_url(); 

?>

	<div id="content" class="no-sidebar">	
			
			<?php the_title('<h1 class="entry-title">', '</h1>'); ?>
			<div class="entry-content">
				<?php the_content(); ?>
				<?php 
					global $current_user;
					get_currentuserinfo();
				?>
				<?php $tipo = get_user_meta($current_user->ID, "type", true);  ?>
						
				<h2 style="margin-top:15px;">Informações Pessoais <a href="<?php echo $siteURL;?>/conta/cadastro/"  class="description action-fullregister-panel">[editar]</a></h2>
				<p>
					<strong>Nome:</strong> <?php echo $current_user->user_firstname.' '.$current_user->user_lastname; ?><br />
					<strong>Email:</strong> <?php echo $current_user->user_email; ?><br />
					<!--<?php if($tipo=="pf") { ?>
					<strong>CPF:</strong> <?php echo get_user_meta($current_user->ID, "cpf", true); ?><br />
					<strong>Atividade:</strong> <?php echo get_user_meta($current_user->ID, "activity", true); ?><br />
					<?php } ?>-->
				</p>
				
				<h2 style="margin-top:15px;">Informações de Acesso <a href="<?php echo $siteURL;?>/conta/senha/"  class="description action-fullregister-panel">[editar]</a></h2>
				<p>
					<strong>Login:</strong> <?php echo $current_user->user_email; ?><br />
					<strong>Senha:</strong> ********
				</p>
				
				<h2 style="margin-top:15px;">Informações de Contato <a href="<?php echo $siteURL;?>/conta/cadastro/"  class="description action-fullregister-panel">[editar]</a></h2>
				<p>
					<!--<strong>Telefone Residencial:</strong> <?php //echo get_user_meta($current_user->ID, "phone_home", true); ?><br />
					<strong>Telefone Celular:</strong> <?php //echo get_user_meta($current_user->ID, "phone_celular", true); ?><br />
					<strong>Telefone Comercial:</strong> <?php //echo get_user_meta($current_user->ID, "phone_comercial", true); ?><br />-->
					<?php if (($tipo=="estudante") ||( $tipo == "jornalista")) { ?>
						<strong>Telefone:</strong> <?php echo get_user_meta($current_user->ID, "phone", true); ?><br />
					<?php }else { ?>
						<strong>Telefone:</strong> <?php echo get_user_meta($current_user->ID, "phone_work", true); ?><br />
					<?php } ?>
				</p>
				
				<?php if($tipo=="pj") { ?>
				<h2 style="margin-top:15px;">Informações Comerciais <a href="<?php echo $siteURL;?>/conta/cadastro/"  class="description action-fullregister-panel">[editar]</a></h2>
				<p>
					<strong>Cargo:</strong> <?php echo get_user_meta($current_user->ID, "title", true); ?><br />
					<strong>Empresa:</strong> <?php echo get_user_meta($current_user->ID, "company", true); ?><br />
					<strong>CNPJ:</strong> <?php echo get_user_meta($current_user->ID, "cnpj", true); ?>
				</p>
				<?php } ?>
				
				<h2 style="margin-top:15px;">Informações de Compra <a href="<?php echo $siteURL;?>/conta/cadastro/?full"  class="description action-fullregister-panel">[editar]</a></h2>
				
					<?php if(get_user_meta($current_user->ID, "billingaddress", true) && get_user_meta($current_user->ID, "billingcity", true) && get_user_meta($current_user->ID, "billingstate", true) && get_user_meta($current_user->ID, "billingpostcode", true)) { ?>
						<p>
							<strong>Endereço de Cobrança</strong><br />
							<?php echo get_user_meta($current_user->ID, "billingaddress", true); ?><br /> 
							<?php echo get_user_meta($current_user->ID, "billingpostcode", true); ?> - <?php echo get_user_meta($current_user->ID, "billingcity", true); ?> - <?php echo get_user_meta($current_user->ID, "billingstate", true); ?>
						</p>
					<?php } else { ?>
						<p>
							<strong>Endereço de Cobrança</strong><br />
							Não cadastrado.
						</p>
					<?php } ?>
					
					
					<?php if(get_user_meta($current_user->ID, "shippingaddress", true) && get_user_meta($current_user->ID, "shippingcity", true) && get_user_meta($current_user->ID, "shippingstate", true) && get_user_meta($current_user->ID, "shippingpostcode", true)) { ?>
						<p>
							<strong>Endereço de Entrega</strong><br />
							<?php echo get_user_meta($current_user->ID, "shippingaddress", true) ?><br /> 
							<?php echo get_user_meta($current_user->ID, "shippingpostcode", true) ?> - <?php echo get_user_meta($current_user->ID, "shippingcity", true) ?> - <?php echo get_user_meta($current_user->ID, "shippingstate", true) ?>
						</p>
					<?php } else { ?>
						<p>
							<strong>Endereço de Cobrança</strong><br />
							Não cadastrado.
						</p>
					<?php } ?>
					
			</div>
			
	</div><?php // #content .entry ? ?>

<?php get_footer(); ?>
