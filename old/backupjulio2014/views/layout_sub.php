<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
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
        <script type="text/javascript" src="js/init_prod.js"></script>
        <script type="text/javascript" src="js/funciones.js"></script>
</head>
    <body class="second">
    	<div id="wilcommen"><?php if($_SESSION['logged']===true){ echo "Bienvenido ".$_SESSION['user_name']; } ?></div>
        <div class="wrapper">
            <!--wrapper-->
            <?php require('header.php'); ?>
            <div class="content sub">
                <!--content-->
                <div class="top sub">
                    <!--top-->
                    <div class="options-wrapper">
                    <?php require('botonera.php'); ?>
                    <?php require('social_int.php'); ?>
                    </div>
                    <?php require($PROD_TEMP); ?>
                </div>
                <!-- end top-->
                <div class="bottom sub">
                    <!--bottom-->
                    <?php require('novedades_box.php'); ?>
                    <div class="right-bottom sub">
                        <!-- right-bottom-->
                        <?php require('form-consultas_int.php'); ?>
                    </div><!-- end bottom right-->
                </div><!-- end bottom-->
            </div><!-- end content-->
            <div class="sidebar">
                <div class="box-sidebar">
                    <h4><?php echo $cat; ?></h4>
                    <!--h5>Colores</h5>
                    <img src="images/img21.jpg" alt="" />
                    <p>
                        Lorem upsum dolor sit amet, consectetur adipiscing elit.SUspendisse nec various nisl. Vestibulum ante ipsum.
                    </p-->
                </div>
                <?php require('carrito.php'); ?>
                <div class="box-sidebar contact">
                    <div class="text">
                        <ul>
                            <li>
                                (011) 4115.6008
                            </li>
                            <li class="last">
                                4305.1113
                            </li>
                        </ul>
                        <a class="contact" href="#">&#91;L&iacute;neas rotativas&#93;</a>
                        <a href="ubicacion.php" class="btn-contact" id="map"></a>
                    </div>
                </div>
                <div class="box-sidebar last">
                    <?php require('form-login-search_int.php'); ?>
                </div>
            </div>
           <?php require('footer.php'); ?>
        </div><!-- end wrapper-->
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-25585223-1']);
_gaq.push(['_trackPageview']);

(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
    </body>
</html>