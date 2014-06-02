<?php

require_once dirname(__FILE__)."/../wordpress/CustomTaxonomy.php";

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SetorCT
 *
 * @author USUARIO
 */
class SetorCT extends CustomTaxonomy{
    //put your code here
    
    public function __construct($taxonomyName = "taxonomy", $objectType = array()) {
        parent::__construct($taxonomyName, $objectType);
        $this->addCustomTaxonomy($taxonomyName, $objectType);
    }
    
    public function addCustomTaxonomy($taxonomyName = "taxonomy", $objectType = array()) {
        //parent::addCustomTaxonomy($taxonomyName, $objectType);
        
        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array(
            'name' => _x( 'Setores', 'taxonomy general name' ),
            'singular_name' => _x( 'Setor', 'taxonomy singular name' ),
            'search_items' =>  __( 'Buscar setores' ),
            'all_items' => __( 'Todos os setores' ),
            'parent_item' => __( 'Setor pai' ),
            'parent_item_colon' => __( 'Setor pai:' ),
            'edit_item' => __( 'Editar Setor' ), 
            'update_item' => __( 'Atualizar Setor' ),
            'add_new_item' => __( 'Adicionar novo Setor' ),
            'new_item_name' => __( 'Novo nome de Setor' ),
            'menu_name' => __( 'Setor' )
        ); 	

        $args = array(           
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'show_admin_column' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'setor' )
        );
        
        register_taxonomy($taxonomyName,$objectType,$args);        
    }
}

?>
