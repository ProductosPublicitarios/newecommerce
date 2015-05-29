<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
    <head>
        <title>G &amp; L &nbsp;e n t e r p r i s e</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/all.css" />
		<link rel="stylesheet" href="css/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/cufon.js"></script>
        <script type="text/javascript" src="js/cufon-fonts.js"></script>
        <script type="text/javascript" src="js/cufon-settings.js"></script>
        <script src="js/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="js/jquery.cycle.all.latest.js"></script>
        <script type="text/javascript" src="js/init.js"></script>
		<script type="text/javascript" language="javascript" src="js/funciones.js"></script>
    </head>
    <body>
    	<div id="wilcommen"><?php if($_SESSION['logged']===true){ echo "Bienvenido ".$_SESSION['user_name']; } ?></div>
        <div class="wrapper">
            <!--wrapper-->
            <?php require('header.php'); ?>
            <div class="content">
                <!--content-->
                <div class="top">
                    <!--top-->
                    <?php require('botonera.php'); ?>
                    <?php require('slider.php'); ?>
                    <div class="box-top">
                        <?php 
							if(	$_SESSION['logged'] == 0){
								require('form-login-search.php'); 
							}else{?>
							   <p align="center"><a href="logout.php"><font color="#660000" size="2" face="Arial, Helvetica, sans-serif">Desconectarme</font></a></p>
							   <p align="center" ><a href="./cambioClave.php" class="iframex" style="width: 400px;height: 124px;"><font color="#660000" size="2" face="Arial, Helvetica, sans-serif">Cambiar Contraseña</font></a></p>
							<?php }
						?>
                        <div class="box-sidebar add" style="margin:0;background-color:#0e492d; border-top: 2px solid #FF9F00;">
                            <ul id="carrito" style="height:40px;">
                                <li style="margin-top:10px;margin-bottom:10px;">
                                    <?php if( count($_SESSION['prods']) <=1 ){ ?>
                                    <strong style="color:#fff; font-size:12px;">Carro Cotizador vacío</strong>
                                    <?php }else{ ?>
                                    <strong style="color:#fff; font-size:12px;"><a href="cotizar.php" class="iframex">Ver Carro Cotizador</a></strong>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>
                        <?php require('social.php'); ?>
                    </div>
                    <!-- end box-top-->
                </div>
                <!-- end top-->
                <div class="bottom">
                    <!--bottom-->
                    <div class="left-bottom">
                    
                      <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FGyl-Enterprise-Productos-Publicitarios%2F106410766095011&amp;width=221&amp;colorscheme=light&amp;show_faces=false&amp;stream=true&amp;header=true&amp;height=537" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:221px; height:530px;" allowTransparency="true"></iframe>
                       
                    </div>
                    <div class="right-bottom">
                        <!-- right-bottom-->
                        <div class="title-bottom">
                            <!-- title-btn--><a href="#" class="btn"><span>COMUN&Iacute;QUESE:</span></a>
                            <ul>
                                <li>
                                    <img src="images/img26.png" alt="" />
                                </li>
                                <li>
                                    <span>
                                        <small>
                                            (011) 
                                        </small>
                                        <small class="last">
                                            4305.1113
                                        </small>
                                    </span>
                                <small>4115.6008</small></li>
                                <li>
                                    <a class="contact" href="#">&#91;L&iacute;neas rotativas&#93;</a>
                                </li>
                            </ul>
                        </div>
                        <!-- end title-bottom-->
                        <?php require('news-cat.php'); ?>
                        <?php require('form-cotizar.php'); ?>
                    </div><!-- end bottom right-->
                </div><!-- end bottom-->
            </div><!-- end content-->
            <?php require('footer.php'); ?>
        </div><!-- end wrapper-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-25585223-1', 'auto');
  ga('send', 'pageview');

</script>
    </body>
</html>