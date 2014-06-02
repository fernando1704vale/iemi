<?php/* Template Name: Assistir Palestras */ ?>
<style type="text/css">
    .login-palestra  {
	background-color:   #D3D3D3;
    font-size: 14px;
    line-height: 25px;
    overflow-x: auto;
    padding: 0 20px;
    width: 547px;
    }
    
</style>    
<?php get_header(); ?>
<h2 style="margin-bottom:20px">Palestras</h2>
<?php if(is_user_logged_in()) { 
       if(isset($_GET['r'])){
          $resenha = $_GET['r'];
            if($resenha == 2981){ ?>
                <iframe id="view-palestras" width="568" height="500" src="http://slideonline.com/embed/2981/" scrollbars=no scrolling=no webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
           <?php }elseif($resenha == 2979){ ?>               
                <iframe id="view-palestras" width="568" height="500" src="http://slideonline.com/embed/2979/" scrollbars=no scrolling=no webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
            <?php }elseif($resenha == 3119) { ?>
				<iframe id="view-palestras" width="568" height="500" src="http://slideonline.com/embed/3119/" scrollbars=no scrolling=no webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
            <?php }elseif($resenha == 5119){ ?>
				<iframe id="view-palestras" width="568" height="500" src="http://slideonline.com/embed/5119/" scrollbars=no scrolling=no webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			
		<?php }else{ ?>
				<iframe id="view-palestras" width="568" height="500" src="http://slideonline.com/embed/7016/" scrollbars=no scrolling=no webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
			<?php }
       }
       
}else{ ?>
                <div style="margin-left: 100px" class="login-palestra">
        <p>O IEMI disponibiliza conteúdo exclusivo sobre esta palestra apenas para usuários cadastrados. Efetue login 
            ou <a href="http://127.0.0.1/iemi/?page_id=4787">Cadastre-se</a> para acessá-lo</p>
        <?php 
            if(isset($_GET['r'])){
				$server = $_SERVER['SERVER_NAME'];
				$endereco = $_SERVER ['REQUEST_URI'];
				$pagina = $server . $endereco;
			}else{
				$pagina = $_SERVER['HTTP_REFERER'];
			}
			pg_login_form(array('redirect_to' => $pagina)) ?>
    </div>         
<?php } ?>
                
            
<?php get_footer(); ?>
