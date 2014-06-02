<?php

require_once (dirname(__FILE__).'/../../CustomPostTypes.php');

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatrocinadorDAO
 *
 * @author USUARIO
 */



class PatrocinadorDAO {
    //put your code here
    
    public static function getPatrocinadores($args=null){
        $args['post_type']=CustomPostTypes::PATROCINADOR;
        $args['post_status']='publish';
        return get_posts($args);
    }
    
    /**
     * Pega 1 patrocinador de acordo com o slug do setor passado por parametro.
     * @param type $taxonomySetorTermSlug
     * @return type 
     */
    public static function getPatrocinadorBySetor($taxonomySetorTermSlug='calcados'){
        $args = array(
            'tax_query' => array(
                array(
                    'taxonomy' => CustomTaxonomies::SETOR,
                    'field' => 'slug',
                    'terms' => $taxonomySetorTermSlug
                )
            )
        );
        
        $args['numberposts']=1;
        $args['orderby']='rand';
        $posts = self::getPatrocinadores($args);
        return $posts;
    }
    
    /**
     * Pega os patrocinadores de forma a listar 1 aleatóriamente de cada setor. Os setores também são exibidos aleatoriamente, mas todos são exibidos
     * @return string 
     */
    public static function getHomePatrocinadores($randomizeSetores=true){
        /*$setores = get_terms(CustomTaxonomies::SETOR);
        if($randomizeSetores){
            shuffle($setores);
        }
        
        $posts=array();
        foreach ($setores as $key => $setor) {            
            $patrocinador = PatrocinadorDAO::getPatrocinadorBySetor($setor->slug);            
            $posts[] = $patrocinador;
        }  */
        
        $setores = array('textil','moveis','calcados');
        
        foreach ($setores as $key => $setorSlug) {            
            $patrocinador = PatrocinadorDAO::getPatrocinadorBySetor($setorSlug);            
            $posts[] = $patrocinador;
        }
        
        return $posts;
    }
    
    /*public static function getHomePatrocinadores(){
        $args['orderby'] = 'rand';
        $args['numberposts'] = '-1';
        
        $posts = self::getPatrocinadores($args);
        return $posts;
    }*/
}

?>
