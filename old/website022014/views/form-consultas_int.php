							<?php
							function br2nl($s)
							{
								$code = 'x83sxX983X';
									$str = str_replace("\r\n", $code, $s);
									$str = str_replace("\n\r", $code, $str);
									$str = str_replace("\r", $code, $str);
									$str = str_replace("\n", $code, $str);
									
									$str = str_replace("<br/>", $code, $str);
									$str = str_replace("<br />", $code, $str);
									$str = str_replace("<br >", $code, $str);
									$str = str_replace("<br>", $code, $str);

								return $str;
							}
							
							function code2br($s)
							{
								$code = 'x83sxX983X';
								$str = str_replace($code, "<br>", $s);
								return $str;
							}
							function code2nl($s)
							{
								$code = 'x83sxX983X';
								$str = str_replace($code, "\n", $s);
								return $str;
							}

							
							$F_MSJ = '';
							if( isset($_POST['nombre'])){
								$conn = conn();
								$fecha = date('d-m-Y H:i:s');
								$fechax = date('Y-m-d H:i:s');
								$ip = $_SERVER['REMOTE_ADDR'];	
								$nombre = mysql_real_escape_string($_POST['nombre'], $conn);
								$empresa = mysql_real_escape_string($_POST['empresa'], $conn);
								$email = mysql_real_escape_string($_POST['email'], $conn);
								$telefono = mysql_real_escape_string($_POST['telefono'], $conn);
								$como = mysql_real_escape_string($_POST['como'], $conn);
								$consulta = $_POST['consulta'];
								$consulta_code = br2nl($consulta);
								$consulta_nl = utf8_decode($consulta_code);
								$consulta_br = utf8_decode($consulta_code);
								$consulta_db = code2br(mysql_real_escape_string($consulta_br, $conn));
								
								$news = $_POST['news']=='1'?'Si':'No';
								$pre_clave = genClave($arr_char);
								$clave = md5(md5($pre_clave));
								
								$escli = $_POST['escliente']=='1'?'Si':'No';
								$escliente = mysql_real_escape_string($_POST['escliente'], $conn);
								
								if($news == 'Si'){
									$campos = "f_creacion,nombre,email,xusuariox,xclavex,empresa,telefono,detalles,newsletter,visible,escliente";
									$valores = "'$fechax','$nombre','$email','$email','$clave','$empresa','$telefono','$consulta_db',1,0,'$escliente'";
									
									$sql = "INSERT INTO usuariosx ($campos) VALUES($valores)";
									$res = mysql_query($sql);
								}
								$attach = '';
								if( isset($_FILES['form_file']) and $_FILES['form_file']['tmp_name']!='' ){
									$attach = $_FILES['form_file']['tmp_name'];
									$attach_name = "archivo.".substr($_FILES['form_file']['name'], -3);
								}
								
								
								
								
								require('controlls/class.phpmailer.php');
							
								$asunto = "Formulario de Contacto GyL Enterprise.";
								$msg_alt = "Datos completados por el Usuario: \n";
								$msg_alt .= "Nombre: ".utf8_decode($nombre)." \n";
								$msg_alt .= "Email: ".utf8_decode($email)." \n";
								$msg_alt .= "Empresa: ".utf8_decode($empresa)." \n";
								$msg_alt .= "Telefono: ".utf8_decode($telefono)." \n";
								$msg_alt .= "Como nos conocio: ".utf8_decode($como)." \n";
								$msg_alt .= "Suscribirse al newsletter: $news \n";
								$msg_alt .= "Es cliente: $escli \n";
								$msg_alt .= "Consulta: ".code2nl(mysql_real_escape_string($consulta_nl, $conn))." \n";
								
								$msg = "Datos completados por el Usuario: <br />";
								$msg .= "Nombre: ".utf8_decode($nombre)." <br />";
								$msg .= "Email: ".utf8_decode($email)." <br />";
								$msg .= "Empresa: ".utf8_decode($empresa)." <br />";
								$msg .= "Telefono: ".utf8_decode($telefono)." <br />";
								$msg .= "Como nos conocio: ".utf8_decode($como)." <br />";
								$msg .= "Suscribirse al newsletter: $news <br />";
								$msg .= "Es cliente: $escli <br />";
								$msg .= "Consulta: ".$consulta_db." <br />";
	
								$msg .= "Este email ha sido enviado el $fecha desde el IP: $ip <br />";
								$msg_alt .= "Este email ha sido enviado el $fecha desde el IP: $ip \n";
							
								$envio = nuMail2(utf8_decode($nombre), $email, MAIL_SITE, '', '', $asunto, $msg, $msg_alt, $attach, $attach_name);
								if($envio){
									$F_MSJ = 'Su mensaje ha sido enviado. Nos contactaremos a la brevedad, muchas gracias.';
								}else{
									$F_MSJ = 'Ha ocurrido un error, por favor intente nuevamente.';
								}
								?>
                                <!-- Google Code for GyL Conversion Page -->
								<script type="text/javascript">
                                /* <![CDATA[ */
                                var google_conversion_id = 1050703025;
                                var google_conversion_language = "es";
                                var google_conversion_format = "2";
                                var google_conversion_color = "ffffff";
                                var google_conversion_label = "9K4vCIOW6gEQsemB9QM";
                                var google_conversion_value = 0;
                                /* ]]> */
                                </script>
                                <script type="text/javascript"
                                src="http://www.googleadservices.com/pagead/conversion.js">
                                </script>
                                <noscript>
                                <div style="display:inline;">
                                <img height="1" width="1" style="border-style:none;" alt=""
                                src="http://www.googleadservices.com/pagead/conversion/1050703025/?label=9K4
                                vCIOW6gEQsemB9QM&amp;guid=ON&amp;script=0"/>
                                </div>
                                </noscript>
                                <?php
							}
							?>
                            <form id="form_consultas_int" action="<?php echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']; ?>" class="bottom-form sub" method="post" enctype="multipart/form-data">
                                <fieldset>
                                    <legend>
                                        CONSULTAS
                                    </legend>
                                    <div class="row">
                                        <label for="name">
                                            Nombre y Apellido
                                        </label>
                                        <span class="input-bottom"><input class="name" type="text" name="nombre" id="name" /></span>
                                    </div>
                                    <div class="row">
                                        <label for="empresa">
                                            Empresa
                                        </label>
                                        <span class="input-bottom"><input type="text" name="empresa" id="empresa" /></span>
                                    </div>
                                    <div class="row">
                                        <label for="telefono">
                                            Tel&eacute;fono
                                        </label>
                                        <span class="input-bottom"><input type="text" name="telefono" id="tel" /></span>
                                    </div>
                                    <div class="row">
                                        <label for="email">
                                            Email
                                        </label>
                                        <span class="input-bottom"><input type="text" name="email" id="email" /></span>
                                    </div>
                                    <div class="row">
                                        <label id="excp" for="como">
                                            Como nos conoci&oacute; 
                                        </label>
                                        <span class="input-bottom sub"><input type="text" name="como" id="como" /></span>
                                    </div>
                                    <div class="row">
                                        <label for="consulta">
                                            Consulta
                                        </label>
                                        <span class="textarea-bottom">
                                            <textarea name="consulta" id="consulta" rows="" cols=""></textarea>
                                        </span>
                                    </div>
                                    <div class="row sub">
                                    	<label for="form_file">Adjuntar Archivo</label>
                                        <div class="upload"><input type="file" name="form_file" id="form_file" /></div>
                                    </div>
                                    <div>
                                    	<span style="position:relative; left:14px;margin-left:10px;">
                                        	<p style="font-weight:bold; font-size:12px;"><?php echo $F_MSJ; ?></p>
                                        </span>
                                    </div>
                                    <label id="ot" for="si">
                                        Desea suscribirse a nuestro newsletter
                                    </label>
                                    <div class="radio" id="otx1">
                                        <!--radio--><span>Si</span><!--radio--><input class="radio" type="radio" name="news" id="news_1" value="1" checked="checked"  /><span>No</span><input class="radio" id="news_2" type="radio" name="news" value="0" />
                                    </div> <!-- end radio-->
                                    
                                    <label id="ot2" for="si">
                ¿Usted ya es cliente de nuestra empresa?
            </label>
            <div class="radio">
                <!--radio--><span>Si</span><!--radio--><input class="radio" type="radio" name="escliente" id="cliente_1" value="1"  /><span>No</span><input class="radio" type="radio" id="cliente_2" name="escliente" value="0" checked="checked" />
            </div>
            <div style="clear:both">&nbsp;</div>
            <div style="clear:both">&nbsp;</div>
            <div style="clear:both">&nbsp;</div>
            <div id="labelon" class="radio int" style="float:left;">
                <!--radio--><input class="radio" type="checkbox" name="terms" id="terms" value="1" /> 
                <a class="iframe" id="termsx" href="politicas.php">Es obligatorio leer y aceptar las políticas de privacidad</a>
                <div style="clear:both;">&nbsp;</div>                  
            </div>
                  <div style="clear:both;"></div>    
                                    
                                    <input type="button" class="submit3" value="Enviar" name="envio_form_int" id="envio_form_int" />
                                </fieldset>
                            </form>