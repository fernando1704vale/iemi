jQuery(document).ready(function($) {
	
	/**
	 * Menu Mercados IEMI
	 */
	$('#nav_menu-4 .sub-menu li.has_sub-menu > ul').hide();
	$('#nav_menu-4 .sub-menu li.has_sub-menu > a').click(function(){
		$(this).next('ul').slideToggle();
		return false;
	});
	

	/* RETRACTABLE BOXES - pages
	================================================================================= */	
	// init
	jQuery('.ret-box-content').hide();	
	// click
	jQuery('.ret-box-title').bind('click', function() {
		jQuery(this).parents('.ret-box').children('.ret-box-content').slideToggle("fast");
		return false;
	});

	/* TABULAR BOXES - Single Product
	================================================================================= */	
	// init	
	jQuery('.tab-box-title li').removeClass('active');
	jQuery('.tab-box-content').removeClass('active');
	//verifica se existe hash no url e abre a aba
	if(window.location.hash!='') {
		var target = window.location.hash;
		jQuery(target.replace("#", ".tab-")).addClass("active"); // li?
		jQuery(target).addClass("active");
		//alert(target);
	// ou abre a primeira aba (descricao)
	} else {
		jQuery('li.tab-descricao').addClass('active');
		jQuery('#descricao').addClass('active');
	}
	
	// click
	jQuery('.tab-box-title a').bind('click', function() {
		jQuery('.tab-box-title li').removeClass('active');
		jQuery('.tab-box-content').removeClass('active');
		var target = jQuery(this).attr("href");
		jQuery(this).parents('li').addClass("active");
		jQuery(target.substr(target.indexOf("#"))).addClass("active");
		return false;
	});	
	
	/* GATEWAY SELECT - Shopping Cart
	================================================================================= */	
	// init	
	jQuery('.wpsc_payment .custom_gateway').hide();
	jQuery('#'+jQuery('input[name="custom_gateway"]:checked').attr('class')).show();
	//verifica se existe hash no url e abre a aba
	if(window.location.hash!='') {
		var target = window.location.hash;
		jQuery(target).show();
		jQuery('input.'+target.substring(1)).attr('checked', 'checked');
	}
	
	// click
	jQuery('.link_gateway a').bind('click', function() {
		jQuery('.wpsc_payment .custom_gateway').hide();
		var target = jQuery(this).attr("href");
		target = target.substr(target.indexOf("#"));
		jQuery(target).show();
		jQuery('input.'+target.substring(1)).attr('checked', 'checked');
		return false;
	});
	
	/* BANNER SLIDER - Home Page
	================================================================================= */	
	
	jQuery('#slider').after('<div id="slider-nav">');
	jQuery('#slider').cycle({
		fx: 'scrollLeft',
		speed: 1000, 
		timeout: 6000, // choose your transition type, ex: fade, scrollUp, shuffle, etc...
		pause: 1,
		pager:  '#slider-nav'
	});


	/* BOLETINS SLIDER - Home Page
	================================================================================= */	
	
	jQuery('.post-box-animation').cycle({
		fx: 'scrollUp',
		speed: 1000, 
		timeout: 5000 // choose your transition type, ex: fade, scrollUp, shuffle, etc...
	});
	
	
	/* MÁSCARAS DE VALIDAÇÃO
	================================================================================= */	
	
	// init
	jQuery('.vphone').mask('(99) 9999-9999');
	jQuery('.vcnpj').mask('99.999.999/9999-99');
	jQuery('.vcpf').mask('999.999.999-99');
	jQuery('.vcep').mask('99999-999');

	//jQuery('#contato_telefone').css({'background':'#333'});
	//alert('.');


	/* MESMO ENDEREÇO
	================================================================================= */
	// init
	jQuery('#repeat').text('[repetir endereço de cobrança]');
	
	// change
	jQuery('#repeat').bind('click', function() {
		jQuery('#shippingaddress').val(jQuery('#billingaddress').val());
		jQuery('#shippingcity').val(jQuery('#billingcity').val());
		jQuery('#shippingstate').val(jQuery('#billingstate').val());
		jQuery('#shippingpostcode').val(jQuery('#billingpostcode').val());
		jQuery('#shippingcountry').val(jQuery('#billingcountry').val());
		return false;
	});
	
	
	/* GATEWAY IEMI
	================================================================================= */
	// click
	jQuery('#formaPagamentoIEMI').live('change', function() {
		if(jQuery(this).val() > 1) {
			jQuery('#price_iemi').hide();
		} else {
			jQuery('#price_iemi').show();
		}
		return false;
	});
	
	
	/* COLORBOX LOGIN - GLobal
	================================================================================= */	
/*
	// init
	jQuery('#login-panel .login-group').hide();
	jQuery('#login-panel .register-group').hide();
	jQuery('#login-panel .registered-group').hide();
	// auto open
	if(jQuery('#login-panel').hasClass('actived')) {
		if(jQuery('#login-panel').hasClass('login-actived')) {
			jQuery('#login-panel .register-group').hide();
			jQuery('#login-panel .login-group').show();
			jQuery('#login-panel .registered-group').hide();
			jQuery.fn.colorbox({width:"550px", inline:true, href:"#login-panel", open:true });
		}
		if(jQuery('#login-panel').hasClass('register-actived')) {
			jQuery('#login-panel .login-group').hide();
			jQuery('#login-panel .register-group').show();
			jQuery('#login-panel .registered-group').hide();
			jQuery('#login-panel .ecommerce').hide();
			jQuery('#full').val("0");
			jQuery.fn.colorbox({width:"920px", inline:true, href:"#login-panel", open:true });
		}
		if(jQuery('#login-panel').hasClass('fullregister-actived')) {
			jQuery('#login-panel .login-group').hide();
			jQuery('#login-panel .register-group').show();
			jQuery('#login-panel .registered-group').hide();
			jQuery('#login-panel .ecommerce').show();
			jQuery('#full').val("1");
			jQuery.fn.colorbox({width:"920px", inline:true, href:"#login-panel", open:true });
		}
		if(jQuery('#login-panel').hasClass('registered-actived')) {
			jQuery('#login-panel .login-group').hide();
			jQuery('#login-panel .register-group').hide();
			jQuery('#login-panel .registered-group').show();
			jQuery.fn.colorbox({width:"550px", inline:true, href:"#login-panel", open:true });
		}

		
	}
	// click to open login
	jQuery('.action-login-panel').bind('click', function() {
		jQuery('#login-panel .register-group').hide();
		jQuery('#login-panel .login-group').show();
		jQuery('#login-panel .newsletter-group').hide();
		jQuery.fn.colorbox({width:"528px", inline:true, href:"#login-panel"});
		return false;	
	});
	// click to open register
	jQuery('.action-register-panel').bind('click', function() {
		jQuery('#login-panel .login-group').hide();
		jQuery('#login-panel .register-group').show();
		jQuery('#login-panel .newsletter-group').hide();
		jQuery('#login-panel .ecommerce').hide();
		jQuery('#full').val("0");
		jQuery.fn.colorbox({width:"920px", inline:true, href:"#login-panel"});
		return false;	
	});
	// click to open full register
	jQuery('.action-fullregister-panel').bind('click', function() {
		jQuery('#login-panel .login-group').hide();
		jQuery('#login-panel .register-group').show();
		jQuery('#login-panel .newsletter-group').hide();
		jQuery('#login-panel .ecommerce').show();
		jQuery('#full').val("1");
		jQuery.fn.colorbox({width:"920px", inline:true, href:"#login-panel"});
		return false;	
	});
	// click to open newsletter
	jQuery('.action-newsletter-panel').bind('click', function() {
		jQuery('#login-panel .login-group').hide();
		jQuery('#login-panel .register-group').hide();
		jQuery('#login-panel .newsletter-group').show();
		jQuery.fn.colorbox({width:"528px", inline:true, href:"#login-panel"});
		return false;	
	});

*/
	/* TIPO DE CADASTRO - Global
	================================================================================= */
/*	// init
		jQuery('#login-panel.npf .npf').hide();
		jQuery('#login-panel.npj .npj').hide();
		
	// select change
	jQuery('.register_type').change(function() {
		
		if(jQuery(this).val()=='pf') {
			jQuery('.npf').hide();
			jQuery('.npj').show();
		}
		
		if(jQuery(this).val()=='pj') {
			jQuery('.npf').show();
			jQuery('.npj').hide();
		}
		
//		jQuery.fn.colorbox({width:"528px", inline:true, href:"#login-panel"});
		
	});
	
*/	
});



