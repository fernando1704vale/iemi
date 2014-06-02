<?php

require_once "CustomTaxonomies.php";

require_once "CustomPostTypes.php";

require_once "custom_taxonomies/SetorCT.php";

require_once "post_types/PatrocinadorCPT.php";

require_once "wordpress/WordpressTheme.php";

require_once "post_types/wpsc_product/WPSCProductDAO.php";
require_once "post_types/wpsc_product/WPSCProductView.php";

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of iemi
 *
 * @author USUARIO
 */
class Iemi extends WordpressTheme{
    //put your code here
    
    public function addCustomPostTypes() {
        parent::addCustomPostTypes();        
        $patrocinadorCPT = new PatrocinadorCPT(CustomPostTypes::PATROCINADOR);        
    }
    
    public function loadFrontEndJsAndCSS() {
        //parent::loadFrontEndJsAndCSS();
        
        
        
                
        wp_register_script( 'cycle_js', get_template_directory_uri().'/js/jquery.cycle.lite.js',array('jquery'));
	wp_enqueue_script( 'cycle_js' );
        
        wp_register_script( 'iemi_js', get_template_directory_uri().'/js/iemi.js',array('jquery'));
	wp_enqueue_script( 'iemi_js' );
        
        /*wp_register_style( 'cariocaap_css', get_template_directory_uri() . '/css/cariocaap.css',array(get_template_directory_uri().'/style.css'));
	wp_register_style( 'cariocaap_css', get_template_directory_uri() . '/css/cariocaap.css',array());
	wp_enqueue_style( 'cariocaap_css' );*/
        
        wp_register_style( 'iemi_css', get_template_directory_uri() . '/css/iemi.css',array());	
	wp_enqueue_style( 'iemi_css' );
        
        //wp_register_style( 'cariocaap_css', get_template_directory_uri() . '/css/cariocaap.css',array(get_template_directory_uri().'/style.css'));
	/*wp_register_style( 'cariocaap_css', get_template_directory_uri() . '/css/cariocaap.css',array());
	wp_enqueue_style( 'cariocaap_css' );*/
        
        /*wp_deregister_script('jquery');        
        wp_register_script('jquery', get_template_directory_uri() . '/js/jquery.min.js');
        wp_enqueue_script('jquery');*/
        
        /*wp_register_script( 'jquery_tools_js', get_template_directory_uri().'/js/jquery.tools.min.js',array('jquery'));
	wp_enqueue_script( 'jquery_tools_js' );
                
        wp_register_script( 'maskedInput_js', get_template_directory_uri().'/js/jquery.maskedinput-1.3.min.js',array('jquery'));
	wp_enqueue_script( 'maskedInput_js' );       
        
	wp_register_script( 'cariocaap_js', get_template_directory_uri().'/js/cariocaap.js',array('jquery','jquery_tools_js','maskedInput_js'));
	wp_enqueue_script( 'cariocaap_js' );*/
        
        
        
    }
    
    public function addCustomTaxonomies() {
        parent::addCustomTaxonomies();
        $setorCT = new SetorCT(CustomTaxonomies::SETOR,array(CustomPostTypes::PATROCINADOR));
    }
    
    public function removeMenuPages() {
        //parent::removeMenuPages();
    }
}

$iemi = new Iemi();
?>
