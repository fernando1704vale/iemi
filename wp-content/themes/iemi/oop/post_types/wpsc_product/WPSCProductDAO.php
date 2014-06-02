<?php

require_once dirname(__FILE__).'/../../CustomPostTypes.php';
require_once dirname(__FILE__)."/../../CustomTaxonomies.php";
require_once 'WPSCProductView.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WPSCProductDAO
 *
 * @author USUARIO
 */
class WPSCProductDAO {
    //put your code here
    
    public static function getWPSCProducts($args=null){
        
        $args['post_type']=CustomPostTypes::WPSC_PRODUCT;
        $args['post_parent']=0;        
        $args['post_status']='publish';
        return get_posts($args);
    }
    
    public static function getLancamentoWPSCProducts($args=null,$numberPosts=4){
        $args = array(
            'tax_query' => array(
                array(
                    'taxonomy' => CustomTaxonomies::WPSC_PRODUCT_CATEGORY,
                    'field' => 'slug',
                    'terms' => 'lancamentos'
                )
            )
        );
        
        $args['numberposts']=$numberPosts;
        $args['order']='DESC';
        $args['orderby']='modified';
        
        
        //$args['orderby']='rand';
        $posts = self::getWPSCProducts($args);
        shuffle($posts);
        
        return $posts;
    }
    
}

?>
