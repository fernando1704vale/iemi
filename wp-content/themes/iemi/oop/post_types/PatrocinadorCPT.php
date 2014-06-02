<?php

require_once (dirname(__FILE__).'/../wordpress/CustomPostType.php');
require_once (dirname(__FILE__).'/../CustomPostTypes.php');
require_once (dirname(__FILE__).'/../CustomMetas.php');
require_once ('patrocinador/PatrocinadorDAO.php');
require_once ('patrocinador/PatrocinadorView.php');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatrocinadorCPT
 *
 * @author USUARIO
 */
class PatrocinadorCPT extends CustomPostType{
    //put your code here
    
    public function __construct($postTypeName) {
        parent::__construct($postTypeName);
        $this->addCustomPostType();
    }
    
    public function manageColumns() {
        //parent::manageColumns();
        
        add_action("manage_posts_custom_column",  array($this,"patrocinador_custom_columns"));
        add_filter("manage_edit-".$this->getName()."_columns", array($this,"patrocinador_edit_columns")); 
        add_filter( 'manage_edit-'.$this->getName().'_sortable_columns', array($this,'patrocinador_column_register_sortable'));
        //add_filter( 'request', array($this,'fakeid_column_orderby'));
    }
    
    /*public function fakeid_column_orderby( $vars){
        if ( isset( $vars['orderby'] ) && 'fake_id' == $vars['orderby'] ) {
            $vars = array_merge( $vars, array(
                'meta_key' => '_apt_fake_id',
                'orderby' => 'meta_value_num'
            ) );
        }      

        return $vars;
    }*/
    
    public function patrocinador_column_register_sortable(){
        //$columns['fake_id'] = 'fake_id';
        
        $columns['setor']='Setor';
        
        
        
        return $columns;
    }
    
    public function patrocinador_custom_columns($column){
        global $post;
 
        switch ($column) {
            case "setor":
                $term_list = wp_get_post_terms($post->ID, CustomTaxonomies::SETOR, array("fields" => "names"));
                echo implode(',',$term_list);
                //explode($term_list, ',');
                /*foreach ($array as $key => $value) {
                    
                }*/
                //print_r($term_list);
                //$postFakeID = get_post_meta( $post->ID, CustomPostMetas::APARTMENT_FAKE_ID, true );     
                //echo $postFakeID;
            break;
            /*case "thumb":
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
                $thumbURL = $thumb['0'];
                $finalImgSrc = Links::getMediaDispatcherURL().'?src='.$thumbURL.'&w=70&h=70&zc=1';
                $postImgSrc = '<img src="'.$finalImgSrc.'" />'; 
                echo $postImgSrc;
            break;
            case "highlight":
                $highlight = get_post_meta( $post->ID, CustomPostMetas::APARTMENT_IS_HIGHLIGHT, true );
                $outputStr='';
                if($highlight==1){
                    $outputStr="Sim";
                }
                echo $outputStr;
            break;
            case "show_at_home":
                $isHome = get_post_meta( $post->ID, CustomPostMetas::APARTMENT_IS_HOME, true );
                $homeOutputStr='';
                if($isHome==1){
                    $homeOutputStr="Sim";
                }
                echo $homeOutputStr;
            break;*/
        }
    }
    
    public function patrocinador_edit_columns($columns){
        $new_columns = array(
            'setor' => __('Setor', 'Cariocaap'),            
	);
        //unset($columns['author']);
        return array_merge($columns, $new_columns);

        return $columns;
    }
    
    public function addCustomPostType() {
        //parent::addCustomPostType();
        
         $labels = array(
            'name' => 'Patrocinadores',
            'singular_name' => 'Patrocinador',
            'add_new' => 'Adicionar novo',
            'add_new_item' => 'Adicionar novo Patrocinador',
            'edit_item' => 'Editar Patrocinador',
            'new_item' => 'Novo Patrocinador',
            'all_items' => 'Todos os Patrocinadores',
            'view_item' => 'Ver Patrocinador',
            'search_items' => 'Buscar Patrocinadores',
            'not_found' =>  'Nenhum patrocinador encontrado',
            'not_found_in_trash' => 'Nada encontrado na lixeira', 
            'parent_item_colon' => '',
            'menu_name' => 'Patrocinadores'
        );

        $args = array(
            'labels' => $labels,
            'public' => true,
            'publicly_queryable' => false,
            'show_ui' => true, 
            'show_in_menu' => true, 
            'query_var' => true,
            //'rewrite' => array( 'slug' => 'post-type' ),
            'capability_type' => 'post',
            'has_archive' => true, 
            'hierarchical' => false,
            'menu_position' => null,
            'supports' => array( 'title', 'thumbnail')
        );

        register_post_type( $this->getName(), $args );
    }
    
    
}

?>
