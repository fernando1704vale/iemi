<?php/* Template Name: Vídeos */ ?>
<?php get_header(); ?>
<?php
                    if(!isset($_GET['video'])){
                        $selUltimo = mysql_query("select * from galeria order by id DESC LIMIT 1");
                        $qr = mysql_fetch_object($selUltimo);
                    }elseif(isset($_GET['video'])){
                        $get = $_GET['video'];
                        $selVideo = mysql_query("select * from galeria WHERE id ='".$get."' LIMIT 1");
                        $qr = mysql_fetch_object($selVideo);
                    }
?>
<h2>Vídeos IEMI</h2>
<div id="container-videos">
    
    <div id="box">
            <div id="descricao_video">
                <div id="titulo_video">
                    <h4><?php echo $qr->titulo  ?></h4>

                </div>
            <?php 
                    echo "<p>".$qr->descricao."</p>"; 
              ?>
        </div>
            <div id="videos">
                <?php
                    if(!isset($_GET['video'])){ 
						echo '<iframe title="'.$qr->titulo.'" title="false" width="600" height="450" src="http://www.youtube.com/embed/'.$qr->embed.'" frameborder="0" allowfullscreen></iframe>';
                    }elseif(isset($_GET['video'])){
                        echo '<iframe title="'.$qr->titulo.'" width="600" height="450" src="http://www.youtube.com/embed/'.$qr->embed.'" frameborder="0" allowfullscreen></iframe>';
                    }
                ?>
            </div>
        
    </div>
    
        <div id="mais_videos">
            + vídeos
        </div>
        <div id="wrap">
            <div class="categoria_videos">
                <h6>Produtos e Serviços IEMI</h6>
            </div>
            <div id="carrosel">
                <?php 
                    $selThumb = mysql_query("select * from galeria WHERE category = 'produtos_servicos' order by id DESC"); ?>
                    <ul id="mycarousel" class="jcarousel-skin-tango">
                    <?php 
                    while ($lnThumb = mysql_fetch_array($selThumb)){ ?>
                        <li> <div id="exibe_foto_video"><a href="?video=<?php echo $lnThumb['id'] ?>"><img src="<?php echo $lnThumb['foto']; ?>"/></a>
                                  <div><span><?php echo $lnThumb["titulo"]?></span><div><div></li>
                 <?php   } ?>
                    </ul>
            </div>
        </div>
                                      
        <div id="wrap">
            <div  class="categoria_videos">
                <h6>Palestras e Entrevistas IEMI</h6>
            </div>
            <div id="carrosel">
                <?php 
                    $selThumb = mysql_query("select * from galeria WHERE category = 'palestras_entrevistas' order by id DESC"); ?>
                    <ul id="mycarousel" class="jcarousel-skin-tango">
                    <?php 
                    while ($lnThumb = mysql_fetch_array($selThumb)){ ?>
                        <li> <div id="exibe_foto_video"><a href="?video=<?php echo $lnThumb['id'] ?>"><img src="<?php echo $lnThumb['foto']; ?>"/></a>
                                  <div><span><?php echo $lnThumb["titulo"]?></span><div><div></li>
                 <?php   } ?>
                    </ul>
            </div>
        </div>
    </div>
    
<?php get_footer(); ?>
