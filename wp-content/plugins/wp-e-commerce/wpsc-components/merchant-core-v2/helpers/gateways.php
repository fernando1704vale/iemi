<?php

/**
 * The WPSC Gateway functions
 */

/**
 * @todo Needs desription adding, and return value clarifying.
 * @return bool [description]
 */
function wpsc_have_gateways() {
	global $wpsc_gateway;
	return $wpsc_gateway->have_gateways();
}

/**
 * @todo Needs desription adding, and return value clarifying.
 * @return [type] [description]
 */
function wpsc_the_gateway() {
	global $wpsc_gateway;
	return $wpsc_gateway->the_gateway();
}

/**
 * Indicate if the current gateway has an image provided.
 * @return bool True if the gateway has an image, false if not.
 */
function wpsc_show_gateway_image(){
	global $wpsc_gateway;
	if( isset($wpsc_gateway->gateway['image']) && !empty($wpsc_gateway->gateway['image']) )
		return true;
	else
		return false;
}

/**
 * Return the current gateway's image url if there is one.
 * @return string|bool Returns the URL of the gateway image, or false if none set.
 */
function wpsc_gateway_image_url(){
	global $wpsc_gateway;
	if( wpsc_show_gateway_image() )
		return $wpsc_gateway->gateway['image'];
	else
		return false;
}

/**
 * Return the current gateway's name.
 * @return string The current gateway's name.
 */
function wpsc_gateway_name() {
	global $wpsc_gateway;
	$display_name = '';

	$payment_gateway_names = get_option( 'payment_gateway_names' );

	if ( isset( $payment_gateway_names[$wpsc_gateway->gateway['internalname']] ) && ( $payment_gateway_names[$wpsc_gateway->gateway['internalname']] != '' || wpsc_show_gateway_image() ) ) {
		$display_name = $payment_gateway_names[$wpsc_gateway->gateway['internalname']];
	} elseif ( isset( $wpsc_gateway->gateway['payment_type'] ) ) {
		switch ( $wpsc_gateway->gateway['payment_type'] ) {
			case "paypal":
			case "paypal_pro":
			case "wpsc_merchant_paypal_pro";
				$display_name = __( 'PayPal', 'wpsc' );
				break;

			case "manual_payment":
				$display_name =  __( 'Manual Payment', 'wpsc' );
				break;

			case "google_checkout":
				$display_name = __( 'Google Wallet', 'wpsc' );
				break;

			case "credit_card":
			default:
				$display_name = __( 'Credit Card', 'wpsc' );
				break;
		}
	}
	if ( $display_name == '' && !wpsc_show_gateway_image() ) {
		$display_name = __( 'Credit Card', 'wpsc' );
	}
	return $display_name;
}


/**
 * Return the current gateway's internal name
 * @return string The current gateway's internal name.
 */
function wpsc_gateway_internal_name() {
	global $wpsc_gateway;
	return $wpsc_gateway->gateway['internalname'];
}

/**
 * Return HTML to check a radio button if the current gateway is the currently selected gateway.
 * @return string HTML checked attribute if the current gateway is selectedd. Empty string otherwise.
 */
function wpsc_gateway_is_checked() {
	global $wpsc_gateway;
	$is_checked = false;
	$selected_gateway = wpsc_get_customer_meta( 'selected_gateway' );

	if ( $selected_gateway ) {
		if ( $wpsc_gateway->gateway['internalname'] == $selected_gateway ) {
			$is_checked = true;
		}
	} else {
		if ( $wpsc_gateway->current_gateway == 0 ) {
			$is_checked = true;
		}
	}
	if ( $is_checked == true ) {
		$output = 'checked="checked"';
	} else {
		$output = '';
	}
	return $output;
}

/**
 * Return the HTML output for the current gateway's checkout fields.
 * @return string The HTML of the current gateway's checkout fields.
 * @uses apply_filters() Filters output through wpsc_gateway_checkout_form_{gateway_internal_name}
 */
function wpsc_gateway_form_fields() {
	global $wpsc_gateway, $gateway_checkout_form_fields, $wpsc_gateway_error_messages;

	$messages = is_array( $wpsc_gateway_error_messages ) ? $wpsc_gateway_error_messages : array();

	$error = array(
		'card_number' => empty( $messages['card_number'] ) ? '' : $messages['card_number'],
		'expdate' => empty( $messages['expdate'] ) ? '' : $messages['expdate'],
		'card_code' => empty( $messages['card_code'] ) ? '' : $messages['card_code'],
		'cctype' => empty( $messages['cctype'] ) ? '' : $messages['cctype'],
	);

	$output = '';

	// Match fields to gateway
	switch ( $wpsc_gateway->gateway['internalname'] ) {

		case 'paypal_pro' : // legacy
		case 'wpsc_merchant_paypal_pro' :
			$output = sprintf( $gateway_checkout_form_fields[$wpsc_gateway->gateway['internalname']], wpsc_the_checkout_CC_validation_class(), $error['card_number'],
				wpsc_the_checkout_CCexpiry_validation_class(), $error['expdate'],
				wpsc_the_checkout_CCcvv_validation_class(), $error['card_code'],
				wpsc_the_checkout_CCtype_validation_class(), $error['cctype']
			);
			break;

		case 'authorize' :
		case 'paypal_payflow' :
			$output = @sprintf( $gateway_checkout_form_fields[$wpsc_gateway->gateway['internalname']], wpsc_the_checkout_CC_validation_class(), $error['card_number'],
				wpsc_the_checkout_CCexpiry_validation_class(), $error['expdate'],
				wpsc_the_checkout_CCcvv_validation_class(), $error['card_code']
			);
			break;

		case 'eway' :
		case 'bluepay' :
			$output = sprintf( $gateway_checkout_form_fields[$wpsc_gateway->gateway['internalname']], wpsc_the_checkout_CC_validation_class(), $error['card_number'],
				wpsc_the_checkout_CCexpiry_validation_class(), $error['expdate']
			);
			break;
		case 'linkpoint' :
			$output = sprintf( $gateway_checkout_form_fields[$wpsc_gateway->gateway['internalname']], wpsc_the_checkout_CC_validation_class(), $error['card_number'],
				wpsc_the_checkout_CCexpiry_validation_class(), $error['expdate']
			);
			break;

	}

	if ( empty( $output ) && isset( $gateway_checkout_form_fields[$wpsc_gateway->gateway['internalname']] ) ) {
		$output = $gateway_checkout_form_fields[$wpsc_gateway->gateway['internalname']];
	}

	return apply_filters ( 'wpsc_gateway_checkout_form_' . $wpsc_gateway->gateway['internalname'], $output );

}

/**
 * Return HTML class to be added to a checkout field to indicate if thi field belongs to the
 * currently selected gateway.
 * @return string HTML class
 */
function wpsc_gateway_form_field_style() {
	global $wpsc_gateway;
	$is_checked = false;
	$selected_gateway = wpsc_get_customer_meta( 'selected_gateway' );
	if ( $selected_gateway ) {
		if ( $wpsc_gateway->gateway['internalname'] == $selected_gateway ) {
			$is_checked = true;
		}
	} else {
		if ( $wpsc_gateway->current_gateway == 0 ) {
			$is_checked = true;
		}
	}
	if ( $is_checked == true ) {
		$output = 'checkout_forms';
	} else {
		$output = 'checkout_forms_hidden';
	}
	return $output;
}

add_action(
	'wpsc_before_shopping_cart_page',
	'_wpsc_merchant_v2_before_shopping_cart'
);

/**
 * @todo Clarify what this is doing
 */
function _wpsc_merchant_v2_before_shopping_cart() {
	$GLOBALS['wpsc_gateway'] = new wpsc_gateways();
}
