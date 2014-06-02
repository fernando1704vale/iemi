<?php

require_once "CustomPostType.php";

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomPagePostType
 *
 * @author USUARIO
 */
class CustomPagePostType extends CustomPostType{
    //put your code here
    
    public function __construct($templateFileName="modelo_xxxxx.php") {
        //parent::__construct($postTypeName);
        
        $this->setName($templateFileName);
        $this->addCustomPostType();
    }
    
    public function addActions() {
        parent::addActions(false);
    }
    
    public function saveCustomPostType($post_id) {
        parent::saveCustomPostType($post_id);
    }
    
    /**
     * Função criada apenas para saber se o post pode ser salvo. Qualquer restrição deve ser colocada aqui
     * @param type $post_id
     * @param type $post
     * @return boolean 
     */
    public function canSavePost($post_id) {
        //parent::canSavePost($post_id);
        
        if($post->post_status == 'trash' or $post->post_status == 'auto-draft'){
            return false;
        }
        
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return false;
        
        if ( !current_user_can( 'edit_page', $post_id ) )
            return false;       
        
        $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);        
        if ($template_file != $this->getName()) {
            return false;
        }
        
        return true;
    }
    
    
    
    public function addCustomPostType() {        
        global $post;
        //parent::addCustomPostType(); 
        //_log('asdasdasdasdasdasdasdasdsd');
        $post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
        if($post_id==null || $post_id==''){
            $post_id = $post->ID;
        }
        
        $template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
        // check for a template type
        if ($template_file == $this->getName()) {
            $this->addActions();            
            $this->manageColumns();            
            //add_meta_box("faq_meta", "Texto de Apresentação", array($this,"faq_meta"), "page", "normal", "low");
        }        
    }
    
    
}

?>
