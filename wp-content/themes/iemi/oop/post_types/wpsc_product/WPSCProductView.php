<?php

require_once dirname(__FILE__)."/../../links.php";
require_once dirname(__FILE__).'/../../CustomPostTypes.php';
require_once dirname(__FILE__)."/../../CustomTaxonomies.php";
require_once 'WPSCProductDAO.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WPSCProductView
 *
 * @author USUARIO
 */
class WPSCProductView {
    //put your code here
    
    public static function getLancamentoWPSCProducts($args=null,$numberPosts=4){
        $posts = WPSCProductDAO::getLancamentoWPSCProducts($args, $numberPosts);
        
        //array_shift($posts);
        
        //_log('--------------TESTE: '.print_r($posts,true).'-----------');
        
        
        $outputStr='';
        $outputStr.='<li class="widget widget_meta"><div class="gray_title"><h3 class="widget-title">Lançamentos IEMI</h3></div>';
     
        $outputStr.=
        '
            <div class="panes">
        ';
        foreach ($posts as $key => $post) {
            
            $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
            $thumbURL = $thumb['0'];
            $finalImgSrc = Links::getMediaDispatcherURL().'?src='.$thumbURL.'&w=90&h=114&zc=1';
            $postImgSrc = '<img src="'.$finalImgSrc.'" />';
            
            $charactersLimit = 170;
            
            
            $postContent = $post->post_excerpt;
            if(strlen($post->post_excerpt)>$charactersLimit){                
                $postContent = substr(strip_tags($post->post_excerpt), 0, $charactersLimit);
                $postContent.='...';
            }
            
            
            $post_name = $post->post_title;
            $outputStr.='
                <div class="two_col pane">
                        <div style="color: rgb(244, 170, 91); font-weight: bold">'.$post_name.'</div>
                        <div class="t_c_l" style="padding-right:2px;"><span class="content">'.$postContent.'</span><a href="'.get_permalink($post->ID).'" style="text-align:justify"><br/>&gt;saiba mais</a></div>
                        <div class="t_c_r">'.$postImgSrc.'</div>
                </div>
            ';
            
           
        }
         $outputStr.=
        '      
            </div>
        ';
        /*$outputStr.=
        '       </div>
            </div>
        ';*/
        $outputStr.='</li>';
        return $outputStr;
        
    }
    
}

?>
