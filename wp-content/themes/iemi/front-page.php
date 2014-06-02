<?php /*  Template Name: Home Page */ ?>
<?php get_header(); ?>
<style>
	.widget ul {
		float: left !important;
	}
</style>
<script type="text/javascript" src="http://alojasites.com/downloads/facebookpopup/jquery.min.js"></script> 
<script src="http://alojasites.com/downloads/facebookpopup/colorbox-min.js"></script> 
<script type="text/javascript"> 
jQuery(document).ready(function(){ 
	if (document.cookie.indexOf('visited=true') == -1) { 
		var threeDays = 28800000; 
		var expires = new Date((new Date()).valueOf() + threeDays); 
		document.cookie = "visited=true;expires=" + expires.toUTCString(); 
		$.colorbox({width:"400px", inline:true, href:"#mdfb"});
	}
}); 
</script> 
<style type="text/css">
	#colorbox{
			padding-bottom:0px !important;
			height:332px !important;
	}
	#cboxWrapper{
			height:332px !important;		
	}
	#cboxMiddleLeft{
		height: 332px !important;
	}
	#cboxContent{
		height:332px !important;
	}
	#cboxMiddleRight{
		height:332px !important;
	}
</style>
<div style='display:none'> 

<div id='mdfb' style='padding:10px; background:#fff;'> 
	<center> 
		<iframe src="//www.facebook.com/plugins/likebox.php?href=https://www.facebook.com/iemi.inteligencia&amp;width=300&amp;colorscheme=light&amp;show_faces=true&amp;border_color=%23ffffff&amp;stream=false&amp;header=false&amp;height=258" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:258px;" allowtransparency="true"></iframe> 
    </center>
</div>
<!--
<div id='mdfb' style='padding:0px; background:#fff;'> 
	<center> 
		<a href="http://www.iemi.com.br/biblioteca/estudos-dos-canais-do-varejo/moveis/" ><img src="<?php bloginfo( 'template_url' ); ?>/images/banner_varejo_moveis" style="width:350px; height: 399px"/></a>
    </center>
</div>-->
</div>
	<div id="content" class="home">
		<div class="homepage_slider">
    		<?php echo do_shortcode('[image-slider-desc setting="1" group="1"]') ?>
    	</div>

        <div class="left_sidebar">
        	<?php widget_area('home-left'); ?>

            <div class="left_gray">
            <div class="left_gray_top"></div>
            <div class="left_gray_middle">
            	<li class="widget widget_meta">
                	<div class="gray_title"><h3 class="widget-title">Blog IEMI</h3></div>
                    	<ul>
                        	<a href="/blog/"><img src="<?php echo get_template_directory_uri(); ?>/images/destaqueblog.jpg" width="290" height="100" /></a>
                            <p>Informações consolidadas de mercado e clipping  das notícias mais relevantes, enviados mensalmente para seu email.</p>
                        </ul>
				</li>
          	</div>
            <div class="left_gray_bottom"></div>
            </div>
            
            <div class="left_gray artigos">
            <div class="left_gray_top"></div>
            <div class="left_gray_middle">
            	<li class="widget widget_meta">
                	<div class="gray_title"><h3 class="widget-title">Artigos</h3></div>
                    	<ul>
							
						<?php query_posts("cat=74&showposts=1"); ?>
						<?php while (have_posts()) : the_post(); ?>
							<h4><?php the_title() ?></h4>
						<li>
							<?php the_excerpt(); ?>
							<a href="http://www.iemi.com.br/category/artigos" class="mais">&gt; leia mais</a>
						</li>
						<?php endwhile; ?>
					</ul>
				</li>
          	</div>
            <div class="left_gray_bottom"></div>
            </div>

			<div class="left_gray">
				<div class="left_gray_top"></div>
				<div class="left_gray_middle">
					<div id="iemi-midia" class="widget widget_meta">
					<div class="gray_title"><h3 class="widget-title">IEMI na Mídia</h3></div>
					<ul>
						<?php query_posts("cat=32&showposts=3"); ?>
						<?php while (have_posts()) : the_post(); ?>
						<li>
							<span class="date"><?php
							$date = get_the_date('d/m/y'); echo $date;//the_date('d/m/y'); ?>: </span>
							<?php the_title(); ?>
							<a href="<?php the_permalink() ?>"><span class="more">Leia Mais</span></a>
						</li>
						<?php endwhile; ?>
					</ul>
					</div>
				</div>
				<div class="left_gray_bottom"></div>
			</div>

		</div>

        <div id="middle_bar">
        	<?php widget_area('home-center'); ?>

			<!-- Lançamentos IEMI -->
			<div class="left_gray">
				<div class="left_gray_top"></div>
				<div class="left_gray_middle">
                                    
                                       <?php echo WPSCProductView::getLancamentoWPSCProducts(); ?>
					<!--<li class="widget widget_meta"><div class="gray_title"><h3 class="widget-title">Lançamentos IEMI</h3></div>
						<div class="two_col">
							<div class="t_c_l" style="padding-right:2px;"><?php //echo wpsc_category_description(67); ?><a href="<?php //echo wpsc_category_url(67); ?>" style="text-align:justify"><br/>&gt; saiba mais</a></div>
							<div class="t_c_r"><img src="<?php //echo wpsc_category_image(67); ?>" width="90" height="110"></div>
						</div>
					</li>-->
				</div>
				<div class="left_gray_bottom"></div>
			</div>

                        
                        
			<!-- Newsletter -->
			<div class="left_gray">
				<div class="left_gray_top"></div>
				<div class="left_gray_middle">
					<li class="widget widget_meta"><div class="gray_title"><h3 class="widget-title">Newsletter IEMI</h3></div>
						<div class="two_col">
							<p>Informações consolidadas de mercado e clipping das noticias mais relevantes, enviados mensalmente para seu email. Assine já. É grátis.</p>
							<form method="post" action="" name="newsletterform"><table class="simpleinfo" cellspacing="0" cellpadding="0" border="0"><tbody><tr><th></th><td><input style="width:200px" id="email" class="txt txt360" type="text" tabindex="155" size="20" value="" name="email"></input><input id="wp-submit" class="button-primary btn ok_btn" type="submit" tabindex="160" value="ok" placeholder="@ informe seu e-mail" name="wp-submit"></input></td></tr><input type="hidden" value="" name="redirect_to"></input></tbody></table></form>
						</div>
					</li>
				</div>
				<div class="left_gray_bottom"></div>
			</div>
                        <?php
                            $newsletterMailOK=false;                            
                            if(isset($_POST['email'])){    
                                $email_remetente='faleconosco@iemi.com.br';
                                $headers = "From: $email_remetente\n";
                                $headers .= "Reply-To: $to\n";
                                $headers .= "Return-Path: $email_remetente\n";
                                $email = $_POST['email'];
                                $to = 'faleconosco@iemi.com.br';
                                $subject = 'Assinatura de Newsletter';
                                $newsletterMailOK = mail($to, $subject, $email,$headers,"-f$email_remetente");   
                                //_log('!!ENVIO OK: '.$newsletterMailOK);        
                            }
                             
                            //_log('!!!!!!!!!!!!!: '.print_r($_POST,true));
                        ?>
                        <?php if($newsletterMailOK){ ?> 
                            <script>
                                alert('Assinatura de Newsletter realizada com sucesso.');
                                jQuery('.simpleinfo #email').attr('value','');
                            </script>
                        <?php } ?>
                            

			<!-- Termômetro IEMI -->
			<div class="left_gray">
				<div class="left_gray_top"></div>
				<div class="left_gray_middle">
					<li class="widget widget_meta"><div class="gray_title"><h3 class="widget-title">Termômetro IEMI</h3></div>
						<div class="two_col">
							<div class="t_c_l"><?php echo wpsc_category_description(52); ?><a href="<?php echo wpsc_category_url(52); ?>"><br/>&gt; saiba mais</a></div>
							<div class="t_c_r"><img src="<?php echo wpsc_category_image(52); ?>" width="90" height="114"></div>
						</div>
					</li>
				</div>
				<div class="left_gray_bottom"></div>
			</div>

			<!-- Publicações IEMI -->
			<div class="left_gray">
				<div class="left_gray_top"></div>
				<div class="left_gray_middle">
					<li class="widget widget_meta"><div class="gray_title"><h3 class="widget-title">Publicações IEMI</h3></div>
						<div class="two_col">
							<div class="t_c_l">
								<?php echo wpsc_category_description(20); ?>
								<a href="#"><br/>&gt; patrocine</a><br />
								<a href="<?php echo wpsc_category_url(20); ?>">&gt; saiba mais</a>
							</div>
							<div class="t_c_r">
								<img src="<?php echo wpsc_category_image(20); ?>" width="90" height="114">
							</div>
						</div>
					</li>
				</div>
				<div class="left_gray_bottom"></div>
			</div>

			<!-- Palestras IEMI -->
			<div class="left_gray">
				<div class="left_gray_top"></div>
				<div class="left_gray_middle">
					<li class="widget widget_meta"><div class="gray_title"><h3 class="widget-title">Palestras IEMI</h3></div>
						<div class="two_col">
							<div class="t_c_l">
								<?php echo wpsc_category_description(68); ?>
								<a href="http://www.iemi.com.br/inteligencia-de-mercado/palestras/"><br/>&gt; saiba mais</a>
							</div>
							<div class="t_c_r">
								<img src="<?php echo wpsc_category_image(68); ?>" width="90" height="114">
							</div>
						</div>
					</li>
				</div>
				<div class="left_gray_bottom"></div>
			</div>

			<div class="left_gray">
				<div class="left_gray_top"></div>
				<div class="left_gray_middle">
					<li class="widget widget_meta"><div class="gray_title"><h3 class="widget-title">Canal IEMI - videos</h3></div>
						<div class="two_col_video">
							<?php //Alteração temporaria da consulta para adicionar o video da globo
									//$busca_videos = mysql_query("SELECT * FROM galeria ORDER BY RAND() LIMIT 1") or die(mysql_error());
								  $busca_videos = mysql_query("SELECT * FROM galeria WHERE id=20") or die(mysql_error());
							      while($video = mysql_fetch_object($busca_videos)){
							?>
							<div class="t_c_l"><a href="/videos-iemi/?video=<?php echo $video->id; ?>" target="_blank"><img src="<?php echo $video->foto ?>" width="130" height="90" /></a></div>
							
							<div class="t_c_r">
								<?php echo $video->titulo ?> 
								<a href="http://www.iemi.com.br/videos-iemi"><br/>&gt; assistir</a>
							</div>
							<?php } ?>
						</div>
					</li>
				</div>
				<div class="left_gray_bottom"></div>
			</div>

        </div>


        <div id="secondary" class="widget-area" role="complementary">

        <div class="red">
        <div class="red_top"></div>
        <div class="red_middle">
			<li class="widget">
            <div class="red_title"><h3 class="widget-title">TÊXTIL</h3><div class="red_title_r"></div></div>
            	<ul>
					<?php
                       // The Query
                       query_posts('cat=58&posts_per_page=1');

                       // The Loop
                       while ( have_posts() ) : the_post();
                    ?>
                    <li>
                    <a href="?cat=58" class="title-1">Mercado:</a>
                    <p><a href="<?php the_permalink(); ?>"><?php $str = get_the_title(); ?>
					<?php echo $str;
							//string_limit_words($str, 14) . "..."; ?></a></p>
                    </li>
                    <?php
					endwhile;
					wp_reset_query();
					?>


                <li>
                <?php
                       // The Query
                       query_posts('cat=59&posts_per_page=1');

                       // The Loop
                       while ( have_posts() ) : the_post();
                    ?>
                <a href="?cat=59" class="title-1">Notícias:</a>
                <p><a href="<?php the_permalink(); ?>"><?php $str = get_the_title(); ?>
					<?php echo $str;
					//string_limit_words($str, 14) . "..."; ?></a></p>
                </li>
                	<?php
					endwhile;
					wp_reset_query();
					?>

                </ul>
			</li>

            <li class="widget">
            <div class="red_title"><h3 class="widget-title">MÓVEIS</h3><div class="red_title_r"></div></div>
            	<ul>
                <?php
                       // The Query
                       query_posts('cat=60&posts_per_page=1');

                       // The Loop
                       while ( have_posts() ) : the_post();
                    ?>
                <li>
                <a href="?cat=60" class="title-1">Mercado:</a>
                <p><a href="<?php the_permalink(); ?>"><?php $str = get_the_title(); ?>
					<?php echo $str;
					//string_limit_words($str, 14) . "..."; ?></a></p>
                </li>
                <?php
				endwhile;
				wp_reset_query();
					?>

                <?php
                       // The Query
                       query_posts('cat=61&posts_per_page=1');

                       // The Loop
                       while ( have_posts() ) : the_post();
                    ?>
                <li>
                <a href="?cat=61" class="title-1">Notícias:</a>
                <p><a href="<?php the_permalink(); ?>"><?php $str = get_the_title(); ?>
					<?php echo $str;
					//string_limit_words($str, 14) . "..."; ?></a></p>
                </li>
                <?php
				endwhile;
				wp_reset_query();
					?>

                </ul>
			</li>
            <li class="widget">
            <div class="red_title"><h3 class="widget-title">CALÇADOS</h3><div class="red_title_r"></div></div>
            	<ul>

                <?php
                       // The Query
                       query_posts('cat=56&posts_per_page=1');

                       // The Loop
                       while ( have_posts() ) : the_post();
                    ?>
                <li>
                <a href="?cat=56" class="title-1">Mercado:</a>
                <p><a href="<?php the_permalink(); ?>"><?php $str = get_the_title(); ?>
					<?php echo $str;
					//string_limit_words($str, 14) . "..."; ?></a></p>
                </li>
                <?php
				endwhile;
				wp_reset_query();
					?>


                <?php
                       // The Query
                       query_posts('cat=57&posts_per_page=1');

                       // The Loop
                       while ( have_posts() ) : the_post();
                    ?>
                <li>
                <a href="?cat=57" class="title-1">Notícias:</a>
                <p><a href="<?php the_permalink(); ?>"><?php $str = get_the_title(); ?>
					<?php echo $str;						
					//string_limit_words($str, 14) . "..."; ?></a></p>
                </li>
                <?php
				endwhile;
				wp_reset_query();
					?>
                </ul>
			</li>


        </div>
        <div class="red_bottom"></div>
        </div>

			<!-- Infográficos IEMI -->
			<div class="gray">
				<div class="gray_top"></div>
				<div class="gray_middle">
					<li class="widget widget_meta"><div class="gray_title"><h3 class="widget-title">Infográficos IEMI</h3></div>
						<div class="two_col">
							<div class="t_c_l">
								<?php echo wpsc_category_description(69); ?>
								<a href="<?php echo wpsc_category_url(69); ?>"><br/>&gt; saiba mais</a>
							</div>
							<div class="t_c_r">
								<img src="<?php echo wpsc_category_image(69); ?>" width="90" height="110">
							</div>
						</div>
					</li>
				</div>
				<div class="gray_bottom"></div>
			</div>

            <div class="gray">
            <div class="gray_top"></div>
            <div class="gray_middle">
            		<li class="widget widget_recent_entries patrocinadores"><div class="gray_title"><h3 class="widget-title">Patrocinadores</h3><div class="gray_title_r"></div></div>
                            <?php echo PatrocinadorView::getHomePatrocinadores() ?>
                    	<!--<ul class="ads">
                            <li style="text-align:center"><a href="#"><br/>BRASIL CALÇADOS</a></li>
                            <li style="text-align:center"><a href="#"><img src="<?php //echo get_template_directory_uri(); ?>/images/patrocinadores/moveis/logo_abipa.jpg"></a></li>
                            <li style="text-align:center"><a href="#"><img src="<?php //echo get_template_directory_uri(); ?>/images/patrocinadores/textil/logo_abit.jpg"></a></li>
                        </ul>-->
					</li>
            </div>
            <div class="gray_bottom"></div>
            <div class="gray_top"></div>
            <div class="gray_middle">
            		<li style="list-style:none" ><div class="gray_title"><h3 class="widget-title">Facebook</h3><div class="gray_title_r"></div></div>
                            <script type="text/javascript">
                                //<![CDATA[
                                document.write("<div class='fb-like-box' data-href='http://www.facebook.com/iemi.inteligencia\' data-width='232' data-height='329' data-show-faces='true' data-stream='false' data-show-border='false' data-header='false'></div>");
                                //]]>               
                             </script>
                  </li>
            </div>
            <div class="gray_bottom"></div>
           </div>

		</div>



	</div><?php // #content .entry ?>

<?php // get_sidebar(); ?>

<?php get_footer(); ?>
