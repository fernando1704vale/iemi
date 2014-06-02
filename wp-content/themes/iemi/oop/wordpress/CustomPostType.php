<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomPostType
 *
 * @author USUARIO
 */

require_once ('custom_post_type/PostTypeLabel.php');
class CustomPostType {
    //put your code here
    
    protected $name="post-type";
    
    public function __construct($postTypeName) {
        $this->setName($postTypeName);
        $this->addActions();
        //$this->addCustomMetaBoxes();
        $this->manageColumns();
        //$this->addCustomPostType();
    }
    
    public function addCustomPostType(){
        
        //$labels = $label->getLabels();
        $labels = array(
            'name' => 'Post Types',
            'singular_name' => 'Post Type',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Post Type',
            'edit_item' => 'Edit Post Type',
            'new_item' => 'New Post Type',
            'all_items' => 'All Post Types',
            'view_item' => 'View Post Type',
            'search_items' => 'Search Post Types',
            'not_found' =>  'No Post Types found',
            'not_found_in_trash' => 'No Post Types found in Trash', 
            'parent_item_colon' => '',
            'menu_name' => 'Post Types'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true, 
            'show_in_menu' => true, 
            'query_var' => true,
            'rewrite' => array( 'slug' => 'post-type' ),
            'capability_type' => 'post',
            'has_archive' => true, 
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        ); 

        register_post_type( $this->getName(), $args );
    }
    
    public function addActions($verifyPostType=true){
        if($verifyPostType){
            if(get_post_type()==$this->getName()){
                add_action( 'admin_menu', array($this,'addCustomMetaBoxes' ));
                add_action('save_post', array($this,"saveCustomPostType"));
                add_action('delete_post',array($this,"deleteCustomPostType"));
            }
        }else{
            add_action( 'admin_menu', array($this,'addCustomMetaBoxes' ));
            add_action('save_post', array($this,"saveCustomPostType"));
            add_action('delete_post',array($this,"deleteCustomPostType"));
        }        
    }
    
    public function deleteCustomPostType(){
        
    }
    
    public function manageColumns(){
        
    }
    
    public function canSavePost($post_id){
        $post = get_post($post_id);
        if($post->post_status == 'trash' or $post->post_status == 'auto-draft'){
            return false;
        }
        
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
            return false;
        
        if ( !current_user_can( 'edit_page', $post_id ) )
            return false;
        
        if(!get_post_type()==$this->getName())
            return false;
        
        return true;
    }
    
    public function saveCustomPostType($post_id){        
        if(!$this->canSavePost($post_id)){
            return false;
        }
    }
    
    public function addCustomMetaBoxes(){
        
    }
    
    /*public function addCustomMetaBoxes2(){
        add_meta_box("highlight_meta_box", "Destaque asd as d", array($this,"show_highlight_meta_box2"), $this->getName(), "normal", "high");      
    }*/
    
    /*public function show_highlight_meta_box2(){
        echo 'asdadasdasdasd';
    }*/
    
    /*public function addCustomMetaBox(){
        
    }*/
    
    /**
    * Gets the name
    */
    public function getName() {
            return $this->name;
    }
    /**
    * Sets the name
    * 
    * $val	mixed	Sets the property
    */
    public function setName($val) {
            $this->name = $val;
    }
    
}

?>
