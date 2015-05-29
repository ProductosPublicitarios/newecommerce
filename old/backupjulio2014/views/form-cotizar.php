						<div class="buy">
                            <!--buy-->
                            <form action="" class="bottom-form">
                                <fieldset>
                                    <legend>
                                        CONTACTO
                                    </legend>
                                    <div class="row">
                                        <label for="name">
                                            Nombre y Apellido
                                        </label>
                                        <span class="input-bottom"><input class="name" id="name" type="text" /></span>
                                    </div>
                                    <div class="row">
                                        <label for="email">
                                            Email
                                        </label>
                                        <span class="input-bottom"><input name="email" id="email" type="text" /></span>
                                    </div>
                                    <div class="row">
                                        <label for="empresa">
                                            Empresa
                                        </label>
                                        <span class="input-bottom"><input name="empresa" id="empresa" type="text" /></span>
                                    </div>
                                    <div class="row">
                                        <label for="tel">
                                            Tel&eacute;fono
                                        </label>
                                        <span class="input-bottom"><input name="tel" id="tel" type="text" /></span>
                                    </div>
                                    <div class="row">
                                        <label id="excp" for="como">
                                            Como nos conoci&oacute; 
                                        </label>
                                        <span class="input-bottom sub"><input id="como" name="como" type="text" /></span>
                                    </div>
                                    <div class="row">
                                        <label for="consulta">
                                            Consulta
                                        </label>
                                        <span class="textarea-bottom">
                                            <textarea name="consulta" id="consulta" rows="" cols=""></textarea>
                                        </span>
                                    </div>
                                    <!--div class="row sub">
                                        <label for="examinar">
                                            Adjuntar Archivo
                                        </label>
                                        <span class="submit2"><input type="submit" value="Examinar..."/></span>
                                    </div-->
                                    <label id="opt" for="si">
                                        Desea suscribirse a nuestro newsletter
                                    </label>
                                    <div class="radio">
                                        <!--radio--><span>Si</span><!--radio--><input class="radio" type="radio" name="newsletter" id="news_1" value="1" checked="checked"  /><span>No</span><input class="radio" type="radio" id="news_1" name="newsletter" value="0" />
                                    </div><!-- end radio-->
                                    
                                    <label id="opt2" for="si">
									¿Usted ya es cliente de nuestra empresa?
									</label>
									<div class="radio">
										<!--radio--><span>Si</span><!--radio--><input class="radio" type="radio" name="escliente" id="cliente_1" value="1"  /><span>No</span><input class="radio" type="radio" id="cliente_2" name="escliente" value="0" checked="checked" />
									</div>
									<div id="labelon" class="radio">
										<!--radio--><input class="radio" type="checkbox" name="terms" id="terms" value="1" /> 
										<a class="iframe" id="termsx" href="politicas.php">Es obligatorio leer y aceptar las políticas de privacidad</a>
										<div style="clear:both;">&nbsp;</div>                  
									</div>
									<div style="clear:both;">&nbsp;</div>  
									<!-- Script for ReCapcha -->
										 <script type="text/javascript" src="http://www.google.com/recaptcha/api/js/recaptcha_ajax.js"></script>
										 <script type="text/javascript">
										function showRecaptcha(element) {
										Recaptcha.create("6LfCb-MSAAAAAJXH9voJMcY98LZXWpWv9GxiwGh1", element, {
										theme: "red",
										callback: Recaptcha.focus_response_field});
										}
										</script>
									<!-- Script for ReCapcha -->
									<!--Recaptcha-->	
									<div id="recaptcha_div"></div>
									<input type="button" value="Show reCAPTCHA" onclick="showRecaptcha('recaptcha_div');"></input>
									<!--Recaptcha-->	
                                    <input type="button" class="submit3" name="envio_cotizar" id="envio_cotizar" value="Enviar" />
                                </fieldset>
                            </form>
                        </div><!-- end buy-->