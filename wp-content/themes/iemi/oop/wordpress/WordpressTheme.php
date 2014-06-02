<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WordpressTheme
 *
 * @author USUARIO
 */
class WordpressTheme {
        //put your code here
    
    public function __construct() {        
        $this->addWPActions();
        $this->addWPFilters();       
    }
    
    
    
    protected function addWPActions(){        
        add_action('init', array($this, "init"));
        add_action('wp_enqueue_scripts', array($this,'loadFrontEndJsAndCSS'));
        add_action('admin_enqueue_scripts', array($this,'loadAdminJsAndCSS'));       
        add_action("admin_init", array($this,"admin_init"));
        add_action( 'admin_menu', array($this,'admin_menu' ));
        add_action('save_post', array($this,"save_post"));
        add_action("manage_posts_custom_column",  array($this,"manage_posts_custom_column"));
        add_action( 'wp_login_failed', array($this,'my_front_end_login_fail') );  // hook failed login
        add_action( 'wp_print_scripts', array($this,'wpPrintScripts') );
    }
    
    public function wpPrintScripts(){
         
    }
    
    /**
     * Carrega javascript e CSS no frontEnd 
     */
    public function loadFrontEndJsAndCSS(){
        
    }    
    
    /**
     * Carrega javascirpt e CSS no admin 
     */
    public function loadAdminJsAndCSS(){
        
    }
    
    public function addWPFilters(){
        add_filter( 'comments_template', array($this,'comments_template'));
    }    
    
    public function comments_template($file){
        /*if ( is_page() )
        $file = STYLESHEETPATH . '/no-comments-please.php';
        return $file;*/       
    }   
    
    public function init(){       
        $this->addCustomPostTypes();
        $this->addCustomTaxonomies();
       // $this->removeMenuPages();
    }
    
    public function removeMenuPages(){       
        remove_menu_page('link-manager.php');
        remove_menu_page('tools.php');
        remove_menu_page('users.php');
        remove_menu_page('edit.php');
        remove_menu_page('edit.php?post_type=post');
        remove_menu_page('themes.php');
        remove_menu_page('plugins.php');
        remove_menu_page('options-general.php');
        remove_menu_page('upload.php');
        remove_menu_page('update-core.php');
        remove_menu_page('index.php');
    }
    
    public function addCustomTaxonomies(){
        
    }
    
    public function addCustomPostTypes(){
        
    }
    
    public function admin_init(){
        $this->removeMenuPages();
    }
    
    public function addCustomPostTypeMetaBoxes(){
        
    }
    
    public function admin_menu(){
        $this->addCustomPostTypeMetaBoxes();
    }
    
    public function save_post(){
        
    }
    
    public function manage_posts_custom_column(){
        
    }
    
    public function my_front_end_login_fail(){
        
    }
    
    
}

if(!function_exists('_log')){
    function _log( $message ) {
        if( WP_DEBUG === true ){
            if( is_array( $message ) || is_object( $message ) ){
                error_log( print_r( $message, true ) );
            } else {
                error_log( $message );
            }
        }
    }
}


?>
