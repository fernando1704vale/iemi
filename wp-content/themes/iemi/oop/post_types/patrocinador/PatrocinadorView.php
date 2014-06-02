<?php

require_once dirname(__FILE__)."/../../links.php";

require_once "PatrocinadorDAO.php";

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PatrocinadorView
 *
 * @author USUARIO
 */
class PatrocinadorView {
    //put your code here
    
    /**
     * Exibe os patrocinadores de forma a listar 1 aleatóriamente de cada setor. Os setores também são exibidos aleatoriamente, mas todos são exibidos
     * @return string 
     */
    public static function getHomePatrocinadores(){
        $posts = PatrocinadorDAO::getHomePatrocinadores();       
        
        $outputStr='<ul class="ads patrocinadores">';
        
        foreach ($posts as $key => $postArray) {
            $post = $postArray[0];
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large' );
            $thumbURL = $thumb['0'];
            $finalImgSrc = Links::getMediaDispatcherURL().'?src='.$thumbURL.'&w=185&h=60&zc=2';
            $postImgSrc = '<img src="'.$finalImgSrc.'" />';
            $outputStr.='<li style="text-align:center"><a href="#">'.$postImgSrc.'</a></li>';
        }
        $outputStr.='</ul>';
        return $outputStr;
    }
    
}

?>
