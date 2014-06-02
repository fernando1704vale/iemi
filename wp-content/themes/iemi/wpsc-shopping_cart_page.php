<?php
global $wpsc_cart, $wpdb, $wpsc_checkout, $wpsc_gateway, $wpsc_coupons, $current_user;
$wpsc_checkout = new wpsc_checkout();
$wpsc_gateway = new wpsc_gateways();
$alt = 0;

if (isset($_SESSION['user_coupon'])) {
    $wpsc_coupons = new wpsc_coupons($_SESSION['user_coupon']['coupon_code']);
    $price = calculate_price(wpsc_cart_total_widget(false, false, false));
} else {
    $price = calculate_price(wpsc_cart_total_widget(false, false, false));
}


//Verifica se o usuário é estrangeiro e seta um produto de taxa internacional em seu carrinho
$current_user = wp_get_current_user();
$country = get_user_meta($current_user->ID, "shippingcountry");
$country = $country[0];

//Se for usuario estrangeiro e a taxa já não estiver incluída (em caso de atualização)
if ($country != "BR" && !empty($country)) {
    $possui = false;
    while (wpsc_have_cart_items()) : wpsc_the_cart_item();
        if (wpsc_cart_item_product_id() == 14353) {
            $possui = true;
        }
    endwhile;
    if (!$possui) {
        $parameters['quantity'] = 1;
        $wpsc_cart->set_item(14353, $parameters);
    }
}
?>
<?php //session_destroy();       ?>

<?php
if (wpsc_cart_item_count() < 1) :
    _e('Oops, there is nothing in your cart.', 'wpsc') . "<a href=" . get_option("product_list_url") . ">" . __('Please visit our shop', 'wpsc') . "</a>";
    return;
endif;

/*
  echo '<strong>coupon_numbers - session</strong><br />'; print_r($_SESSION['user_coupon']);
  echo '<br /><br /><strong>wpsc_coupon</strong><br />'; print_r($wpsc_coupons);
  echo '<br /><br /><strong>total</strong><br />'; $xzs = wpsc_cart_total(); echo $xzs;
  echo '<br /><br /><strong>price</strong><br />'; print_r($price);
 */
?>

<div id="checkout_page_container">
    <?php
/////////////////////////////////////////////////////////////////////////// 
/////////////////////////////////////////////////////////////////////////////////
// INÍCIO ETAPA 1 - PEDIDO
/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////// 
    ?>

    <h3 class="clr">1. Pedido</h3>
    <table class="checkout_cart purchase">
        <tr class="header">
            <th><?php _e('Publicação', 'iemi'); ?></th>
            <th></th>
            <th><?php _e('Quantidade', 'iemi'); ?></th>
            <th><?php _e('Preço', 'iemi'); ?></th>
            <th><?php _e('Total', 'iemi'); ?></th>
            <th></th>
        </tr>
        <?php while (wpsc_have_cart_items()) : wpsc_the_cart_item(); ?>
            <?php
            //Não exibe o produto de taxa internacional
            if (wpsc_cart_item_product_id() != 14353) {
                $alt++;
                if ($alt % 2 == 1) {
                    $alt_class = 'alt';
                } else {
                    $alt_class = '';
                }
                ?>

                <tr class="product_row product_row_<?php echo wpsc_the_cart_item_key(); ?> <?php echo $alt_class; ?>">

                    <td colspan="2" class="wpsc_product_name wpsc_product_name_<?php echo wpsc_the_cart_item_key(); ?>">
                        <a href="<?php echo wpsc_cart_item_url(); ?>"><?php echo wpsc_cart_item_name(); ?></a>
                    </td>
                    <td class="wpsc_product_quantity wpsc_product_quantity_<?php echo wpsc_the_cart_item_key(); ?>">
                        <form action="<?php echo get_option('shopping_cart_url'); ?>" method="post" class="adjustform qty">
                            <input type="text" name="quantity" size="2" class="txt" style="width:20px; text-align:right;" value="<?php echo wpsc_cart_item_quantity(); ?>" />
                            <input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>" />
                            <input type="hidden" name="wpsc_update_quantity" value="true" />
                            <input type="submit" value="<?php _e('Update', 'wpsc'); ?>" name="submit" class="btn" />
                        </form>
                    </td>

                    <td class="currency"><?php echo wpsc_cart_single_item_price(); ?></td>
                    <td class="currency wpsc_product_price wpsc_product_price_<?php echo wpsc_the_cart_item_key(); ?>"><span class="pricedisplay"><?php echo wpsc_cart_item_price(); ?></span></td>
                    <td class="wpsc_product_remove wpsc_product_remove_<?php echo wpsc_the_cart_item_key(); ?>">
                        <form action="<?php echo get_option('shopping_cart_url'); ?>" method="post" class="adjustform remove">
                            <input type="hidden" name="quantity" value="0" />
                            <input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>" />
                            <input type="hidden" name="wpsc_update_quantity" value="true" />
                            <input type="submit" class="btn" value="<?php _e('Remove', 'wpsc'); ?>" name="submit" />
                        </form>
                    </td>
                </tr>
                <?php if($country != "BR" && !empty($country)){ ?>
                <tr>
                    <td colspan="2" style="color:red">Frete (Taxa Internacional): R$ 60,00</td>
                </tr>
                <?php } ?>
            <?php } ?>
        <?php endwhile; ?>
                
        <tr>
            <th colspan="4" class="argt">
                <?php if ($_SESSION['user_coupon']) { ?>
                    <?php _e('Preço Total', 'iemi'); ?>
                <?php } else { ?>
                    <?php _e('Preço Final', 'iemi'); ?>
                <?php } ?>
            </th>
            <td class="currency">
                <span id='checkout_total' class="pricedisplay checkout-total"><?php echo wpsc_cart_total_widget(false, false, false); ?></span>
            </td>
            <td></td>
        </tr>
        

        <?php if ($_SESSION['user_coupon']) { ?>
            <tr>
                <th colspan="4" class="argt">
                    <?php _e('Desconto', 'iemi'); ?> - 
                    <?php echo $_SESSION['user_coupon']['coupon_code'] ?>
            <form  method="post" action="<?php echo get_option('shopping_cart_url'); ?>">
                <input type="hidden" name="coupon_num" id="coupon_num" value="<?php echo $_SESSION['user_coupon']['coupon_code']; ?>" />
                <!-- <input type="submit" value="<?php _e('Update', 'wpsc') ?>" /> -->
            </form>
            </th>
            <td class="currency">
                <span id="coupons_amount" class="pricedisplay"><?php echo $price['discount']; ?></span>
            </td>
            <td></td>
            </tr>

            <tr>
                <th colspan="4" class="argt">
                    <?php _e('Preço Final', 'iemi'); ?>
                </th>
                <td class="currency">
                    <span class="pricedisplay"><?php echo $price['new_price']; ?></span>
                </td>
                <td></td>
            </tr>
        <?php } ?>

        <?php
        global $price_iemi;
        $price_iemi = $price['iemi_price'];
        ?>

    </table> <!-- cart contents table close -->



<?php /////////////////////////////////////////////////////////////////////////// 
/////////////////////////////////////////////////////////////////////////////////
// FIM ETAPA 1 - PEDIDOS
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////// 
/////////////////////////////////////////////////////////////////////////////////
// INÍCIO ETAPA 2 - CADASTRO
/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////// ?>

  	<?php do_action('wpsc_before_form_of_shopping_cart'); ?>

	<h3 class="clr">2. Cadastro</h3>
	
	<?php if(!empty($_SESSION['wpsc_checkout_user_error_messages'])): ?>
		<p class="alert alert-error">
		<?php
			foreach($_SESSION['wpsc_checkout_user_error_messages'] as $user_error )
				echo $user_error."<br />\n";
			$_SESSION['wpsc_checkout_user_error_messages'] = array();
		?>
		</p>
	<?php endif; ?>
	
	<?php
		if ($_SESSION['cart_alert_register']) { 
			foreach ($_SESSION['cart_alert_register'] as $value) {
				echo $value;
			}
			$_SESSION['cart_alert_register'] = array();
		}
	?>
		
	

	<?php if ( wpsc_show_user_login_form() && !is_user_logged_in() ): ?>
			<p><?php _e('You must sign in or register with us to continue with your purchase', 'wpsc');?></p>
			<p>
				<a href="/conta/login/?carrinho/" title="Login" class="action-login-panel btn">Faça seu Login</a>
				<a href="/conta/novo-cadastro/?carrinho" title="Cadastre-se" class="action-fullregister-panel btn">Cadastre-se</a>
			</p>
	<?php endif; ?>	
	
	<form class='wpsc_checkout_forms' action='<?php echo get_option('shopping_cart_url'); ?>' method='post' enctype="multipart/form-data">
				
	<?php 
		if(is_user_logged_in()){ 
			
			global $current_user;
			get_currentuserinfo();
			
			
			while (wpsc_have_checkout_items()) { 
				wpsc_the_checkout_item();
				
				if(wpsc_checkout_form_is_header() != true) {
					
					switch ($wpsc_checkout->checkout_item->unique_name) {
						case 'billingfirstname';
						case 'shippingfirstname';
							$wpsc_checkout_form_value = $current_user->user_firstname;
						break;
					
					
						case 'billinglastname';
						case 'shippinglastname';
							$wpsc_checkout_form_value = $current_user->user_lastname;
						break;
					
					
						case 'billingemail';
						case 'shippingemail';
							$wpsc_checkout_form_value = $current_user->user_email;
						break;
					
					
						case 'billingphone';
							$wpsc_checkout_form_value = "";
							if($t = get_user_meta($current_user->ID, "phone_home", true)){ $wpsc_checkout_form_value .= "[ Res: ".$t ." ] "; }
							if($t = get_user_meta($current_user->ID, "phone_work", true)){ $wpsc_checkout_form_value .= "[ Com: ".$t ." ] "; }
							if($t = get_user_meta($current_user->ID, "phone_cell", true)){ $wpsc_checkout_form_value .= "[ Cel: ".$t ." ]"; }
						break;
					
					
	 					default;
							$wpsc_checkout_form_value = get_user_meta($current_user->ID, $wpsc_checkout->checkout_item->unique_name, true);
						break;
					}
					
					$wpsc_checkout_form_name = str_replace('wpsc_checkout_form_', 'collected_data[', wpsc_checkout_form_element_id()).']';
					
					$wpsc_checkout_data[$wpsc_checkout->checkout_item->unique_name] = $wpsc_checkout_form_value;
	?>

					<!-- <label for='<?php echo wpsc_checkout_form_element_id(); ?>'>
											<?php echo wpsc_checkout_form_name();?> - 
										</label><?php echo $wpsc_checkout->checkout_item->unique_name; ?><br /> -->
					<input type="hidden" name="<?php echo $wpsc_checkout_form_name; ?>" value="<?php echo $wpsc_checkout_form_value;  ?>" />
					<?php //echo wpsc_checkout_form_field();?>
			
	<?php 		}
			}
		} 
		if(!$wpsc_checkout_data['billingfirstname'] || !$wpsc_checkout_data['billingemail'] || !$wpsc_checkout_data['billingaddress'] || !$wpsc_checkout_data['billingcity'] || !$wpsc_checkout_data['billingstate'] || !$wpsc_checkout_data['billingpostcode'] || !$wpsc_checkout_data['shippingfirstname'] || !$wpsc_checkout_data['shippingaddress'] || !$wpsc_checkout_data['shippingcity'] || !$wpsc_checkout_data['shippingstate'] || !$wpsc_checkout_data['shippingpostcode']) { 
			if(is_user_logged_in()){ 
				echo '<p class="alert alert-error">Para finalizar a compra é necessário preencher todos os campos do cadastro.</p>';
			}else{
				echo '<p class="alert alert-error">Para finalizar a compra é necessário preencher todos os campos do cadastro.<br/>
				Caso já possua cadastro em nosso site clique <a href="http://www.iemi.com.br/contas/login/">aqui</a> para se logar, ou clique <a href="http://www.iemi.com.br/conta/novo-cadastro/">aqui</a> para se cadastrar.</p>';
			}
		} 
		/*
		if(isset($_POST['submit'])){
			gateway_cielo("|", '2346666623464');
		}
		*/
	?>
	
	<?php if(is_user_logged_in()){ ?>
		<div class="checkout_data">	
			<div class="checkout_user">
				<h4>Informações Gerais <a href="/conta/cadastro/?carrinho"  class="description action-fullregister-panel">[editar]</a></h4>
				<ul>
					<p>
						<strong>Nome:</strong> <?php echo $wpsc_checkout_data['billingfirstname'] . ' ' . $wpsc_checkout_data['billinglastname'] ?><br />
						<strong>Email:</strong> <?php echo $wpsc_checkout_data['billingemail']; ?>
					</p>
					<?php if(get_user_meta($current_user->ID, "type", true)=='pf') { ?>
					<p>
						<strong>CPF:</strong> <?php if(get_user_meta($current_user->ID, "cpf", true)) { echo get_user_meta($current_user->ID, "cpf", true); } else { echo '<span class="no-data">não informado.</span>'; } ?>
					</p>
					<p>
						<strong>Telefone Residencial:</strong> <?php if(get_user_meta($current_user->ID, "phone_home", true)) { echo get_user_meta($current_user->ID, "phone_home", true); } else { echo '<span class="no-data">não informado.</span>'; } ?>
						<br /><strong>Telefone Celular:</strong> <?php if(get_user_meta($current_user->ID, "phone_cel", true)) { echo get_user_meta($current_user->ID, "phone_cel", true); } else { echo '<span class="no-data">não informado.</span>'; } ?>
					</p>
					<?php } elseif(get_user_meta($current_user->ID, "type", true)=='pj') { ?>
					<p>
						<strong>Empresa:</strong> <?php if(get_user_meta($current_user->ID, "company", true)) { echo get_user_meta($current_user->ID, "company", true); } else { echo '<span class="no-data">não informado.</span>'; } ?>
						<br /><strong>CNPJ:</strong> <?php if(get_user_meta($current_user->ID, "cnpj", true)) { echo get_user_meta($current_user->ID, "cnpj", true); } else { echo '<span class="no-data">não informado.</span>'; } ?>
					</p>
					<p>
						<strong>Telefone Comercial:</strong> <?php if(get_user_meta($current_user->ID, "phone_work", true)) { echo get_user_meta($current_user->ID, "phone_work", true); } else { echo '<span class="no-data">não informado.</span>'; } ?>
						<br /><strong>Telefone Celular:</strong> <?php if(get_user_meta($current_user->ID, "phone_cel", true)) { echo get_user_meta($current_user->ID, "phone_cel", true); } else { echo '<span class="no-data">não informado.</span>'; } ?>
					</p>
					<?php } ?>
					
				</ul>
			</div>
			<div class="checkout_user">
				<h4>Endereço de Cobrança <a href="/conta/cadastro/?carrinho" class="description action-fullregister-panel">[editar]</a></h4>
				<?php if($wpsc_checkout_data['billingaddress'] && $wpsc_checkout_data['billingpostcode'] && $wpsc_checkout_data['billingcity'] && $wpsc_checkout_data['billingstate']) { ?>
					<p>
						<?php echo $wpsc_checkout_data['billingaddress']?><br /> 
						<?php echo $wpsc_checkout_data['billingpostcode']?> - <?php echo $wpsc_checkout_data['billingcity']?> - <?php echo $wpsc_checkout_data['billingstate']?>
					</p>
				<?php } else { ?>
					<p class="no-data">Não cadastrado.</p>
				<?php } ?>
				
				<h4>Endereço de Entrega <a href="/conta/cadastro/?carrinho" class="description action-fullregister-panel">[editar]</a></h4>
				<?php if($wpsc_checkout_data['shippingaddress'] && $wpsc_checkout_data['shippingpostcode'] && $wpsc_checkout_data['shippingcity'] && $wpsc_checkout_data['shippingstate']) { ?>
					<p>
						<?php echo $wpsc_checkout_data['shippingaddress']?><br /> 
						<?php echo $wpsc_checkout_data['shippingpostcode']?> - <?php echo $wpsc_checkout_data['shippingcity']?> - <?php echo $wpsc_checkout_data['shippingstate']?>
					</p>
				<?php } else { ?>
					<p style="color:red;">Não cadastrado.</p>
				<?php } ?>
			</div>
			<div class="clr"></div>
		</div>
		
	<?php } ?>

	<?php do_action('wpsc_inside_shopping_cart'); ?>
		
<?php /////////////////////////////////////////////////////////////////////////// 
/////////////////////////////////////////////////////////////////////////////////
// FIM ETAPA 2
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////// 
/////////////////////////////////////////////////////////////////////////////////
// INÍCIO ETAPA 3 - FORMA DE PAGAMENTO
/////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////// ?>
		<?php 	if(!$wpsc_checkout_data['billingfirstname'] || !$wpsc_checkout_data['billingemail'] || !$wpsc_checkout_data['billingaddress'] || !$wpsc_checkout_data['billingcity'] || !$wpsc_checkout_data['billingstate'] || !$wpsc_checkout_data['billingpostcode'] || !$wpsc_checkout_data['shippingfirstname'] || !$wpsc_checkout_data['shippingaddress'] || !$wpsc_checkout_data['shippingcity'] || !$wpsc_checkout_data['shippingstate'] || !$wpsc_checkout_data['shippingpostcode']) { 
					
					return;
				}
		?>
		<h3 class="clr">3. Forma de Pagamento</h3>

		<?php //print_r($_SESSION); ?>
		
		<?php if(isset($_SESSION['WpscGatewayErrorMessage']) && $_SESSION['WpscGatewayErrorMessage'] != '') :?>
			<p class="alert alert-error"><?php echo $_SESSION['WpscGatewayErrorMessage']; ?></p>
		<?php endif; ?>
		
		<?php
			if ($_SESSION['cart_alert_payment']) { 
				foreach ($_SESSION['cart_alert_payment'] as $value) {
					echo $value;
				}
				$_SESSION['cart_alert_payment'] = array();
			}
		?>
		
		<div class='wpsc_payment'>
						<?php 
						 ?>

			<?php
			 /*while (wpsc_have_gateways()) : wpsc_the_gateway(); ?>
				<div class="link_gateway">
					<p>
						<a href="#<?php echo sanitize_title(wpsc_gateway_name());?>">
							<?php if( wpsc_show_gateway_image() ): ?>
								<img src="<?php echo wpsc_gateway_image_url(); ?>" alt="<?php echo wpsc_gateway_name(); ?>" />
							<?php endif; ?>
							<span><?php echo wpsc_gateway_name(); ?></span>
						</a>
					</p>
				</div>
			<?php endwhile; */?>
			<?php while (wpsc_have_gateways()) : wpsc_the_gateway(); 		?>
					
				<div id="<?php echo sanitize_title(wpsc_gateway_name());?>" >
					<label class="gateway_name "><input type="radio" value="<?php echo wpsc_gateway_internal_name();?>" name="custom_gateway" class="<?php echo sanitize_title(wpsc_gateway_name());?>" /> <?php echo wpsc_gateway_name(); ?></label>
					<div class="custom_gateway_options">
					<?php 
					
						if(wpsc_gateway_internal_name()=='gateway_cielo') { 
							echo form_field_cielo(); 
						}
						if(wpsc_gateway_internal_name()=='gateway_iemi') { 
							echo form_field_iemi(); 
						}
						
						if(wpsc_gateway_internal_name()=="wpsc_merchant_paypal_standard"){ ?>
							<div class="link_gateway">
								<p>
									<a href="#<?php echo sanitize_title(wpsc_gateway_name());?>">
										<?php if( wpsc_show_gateway_image() ): ?>
											<!-- PayPal Logo --> <img src="https://www.paypalobjects.com/webstatic/mktg/br/compra_segura_vertical.png" border="0" alt="CompraSegura"> <!-- PayPal Logo -->
										<?php endif; ?>
									</a>
								</p>
							</div>
										
							
					<?php }				?>
					</div>
				</div>
				
			<?php endwhile; ?>

		</div>

	
		<?php if(wpsc_has_tnc()) : ?>
		<div class="tnc">
	              <p><label for="agree"><input id="agree" type='checkbox' value='yes' name='agree' /> <?php printf(__("Eu concordo com os <a class='thickbox' target='_blank' href='%s' class='termsandconds'>Termos e Condições</a>", "iemi"), site_url("?termsandconds=true&amp;width=360&amp;height=400'")); ?></label></p>
		</div>
		<?php endif; ?>
		<div class='wpsc_make_purchase'>
			<span>
				<?php if(!wpsc_has_tnc()) : ?>
					<input type='hidden' value='yes' name='agree' />
				<?php endif; ?>
					<input type='hidden' value='submit_checkout' name='wpsc_action' />
					<input type="hidden" name="coupon_num" id="coupon_num" value="<?php echo $_SESSION['user_coupon']['coupon_code']; ?>" />
					<?php if(is_user_logged_in()){ ?><input type='submit' value='<?php _e('Finalizar Compra', 'iemi');?>' name='submit' class='make_purchase wpsc_buy_button btn' /><?php } ?>
			</span>
		</div>

<div class='clear'></div>
</form>

</div><!--close checkout_page_container-->
<script type="text/javascript">
//Máscaras ER
function mascara(o,f){
    v_obj=o;
    v_fun=f;
    setTimeout("execmascara()",1);
}
function execmascara(){
    v_obj.value=v_fun(v_obj.value);
}
function mtel(v){
    v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
    v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
    v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
    return v;
}
function id( el ){
	return document.getElementById( el );
}
</script>
<?php
do_action('wpsc_bottom_of_shopping_cart');

?>
