<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">
    <head>
        <title>G &amp; L &nbsp;e n t e r p r i s e</title>
		
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="css/all3.css" />
		<link rel="stylesheet" href="css/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
        <script type="text/javascript" src="js/cufon.js"></script>
        <script type="text/javascript" src="js/cufon-fonts.js"></script>
        <script type="text/javascript" src="js/cufon-settings.js"></script>
        <script src="js/jquery.fancybox-1.3.4.pack.js"></script>
        <script type="text/javascript" src="http://cloud.github.com/downloads/malsup/cycle/jquery.cycle.all.latest.js"></script>
        <script type="text/javascript" src="js/init.js"></script>
		<script type="text/javascript" language="javascript" src="js/funciones.js"></script>
    </head>
    <body>
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
                        <?php require('form-login-search.php'); ?>
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
                    
                      <iframe src="http://www.facebook.com/plugins/likebox.php?href=http%3A%2F%2Fwww.facebook.com%2Fpages%2FGyl-Enterprise-Productos-Publicitarios%2F106410766095011&amp;width=221&amp;colorscheme=light&amp;show_faces=false&amp;stream=true&amp;header=true&amp;height=427" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:221px; height:427px;" allowTransparency="true"></iframe>
                       
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
                                            (011) 4115.6008
                                        </small>
                                        <small class="last">
                                            7305.1113
                                        </small>
                                    </span>
                                </li>
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
    </body>
</html>