<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomTaxonomy
 *
 * @author USUARIO
 */
class CustomTaxonomy {
    //put your code here
    
    protected $name="taxonomy";
    protected $objectType=array();
    
    public function __construct($taxonomyName="taxonomy",$objectType=array('post')) {
        $this->setName($taxonomyName);
        $this->setObjectType($objectType);
    }
    
    public function addCustomTaxonomy($taxonomyName="taxonomy",$objectType=array('post')){
        $this->setName($taxonomyName);
        $this->setObjectType($objectType);
        
        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array(
            'name' => _x( 'Taxonomies', 'taxonomy general name' ),
            'singular_name' => _x( 'Taxonomy', 'taxonomy singular name' ),
            'search_items' =>  __( 'Search Taxonomies' ),
            'all_items' => __( 'All Taxonomies' ),
            'parent_item' => __( 'Parent Taxonomy' ),
            'parent_item_colon' => __( 'Parent Taxonomy:' ),
            'edit_item' => __( 'Edit Taxonomy' ), 
            'update_item' => __( 'Update Taxonomy' ),
            'add_new_item' => __( 'Add New Taxonomy' ),
            'new_item_name' => __( 'New Taxonomy Name' ),
            'menu_name' => __( 'Taxonomy' )
        ); 	

        $args = array(           
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'taxonomy' )
        );
        
        register_taxonomy($taxonomyName,$objectType,$args);
    }
    
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
    
    						
    /**
    * Gets the objectType
    */
    public function getObjectType() {
            return $this->objectType;
    }
    /**
    * Sets the objectType
    * 
    * $val	mixed	Sets the property
    */
    public function setObjectType($val) {
            $this->objectType = $val;
    }


}

?>
