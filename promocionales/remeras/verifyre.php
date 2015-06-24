 <?php
 	
		$EmailFrom = "landingremeras@example.com";
		$EmailFromRe = "noreply@gylenterprise.com.ar";
		$EmailTo = "ventas@gylenterprise.com.ar";
		$Subject = "Contacto por remeras";
		$SubjectRe= "Gracias por contactarse con GYL Enterprise";
		$Name = Trim(stripslashes($_POST['name'])); 
		$Tel = Trim(stripslashes($_POST['tel'])); 
		$Email = Trim(stripslashes($_POST['email'])); 
		$Message = Trim(stripslashes($_POST['mensaje'])); 
		if(isset($_POST['newsletter'])==false){
					// Si la función devuelve false, esta variable no existe,
					// por lo que no se tildó "Newsletter" en el otro archivo.
					$newsletter = "No quiere newsletter :(";
					} else {
					$newsletter = "El cliente si quiere suscribirse al newsletter. \n mail enviado desde http://www.gylenterprise.com.ar/promocionales/remeras ";
					// para insertar query agregar los datos de conexion en el encabezado.
					}
		// validation
		$validationOK=true;
		if (!$validationOK) {
		  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.htm\">";
		  exit;
		}

		// prepare email body text
		$Body = "";
		$Body .= "Nombre: ";
		$Body .= $Name;
		$Body .= "\r\n";
		$Body .= "Tel: ";
		$Body .= $Tel;
		$Body .= "\r\n";
		$Body .= "Email: ";
		$Body .= $Email;
		$Body .= "\r\n";
		$Body .= $newsletter;
		$Body .= "\r\n";
		$Body .= "Mensaje: ";
		$Body .= $Message;
		$Body .= "\r\n";
		
		// email body para el cliente
		$BodyRe ="Gracias por contactarnos \r\n Alguien de nuestro equipo estará respondiendo su consulta. 
					\r\n No dude en llamarnos al 4115-6008
					\r\n Atentamente:
					\r\n G&L Enterprise
					\r\n Av. Caseros 2056, Ciudad Autónoma de Buenos Aires";
		
		//headers para el mail que llega a la empresa
		$headers = 'From: ' . $EmailFrom  . "\r\n" .
				'Content-Type: text/plain; charset=UTF-8' .  "\r\n" .
				'Reply-To: ' . $EmailFrom  . "\r\n" .
				'X-Mailer: PHP/' . phpversion();
		
		//headers para el mail que llega al cliente
		$headersRe = 'From: ' . $EmailFromRe  . "\r\n" .
				'Content-Type: text/plain; charset=UTF-8' .  "\r\n" .
				'Reply-To: ' . $EmailFromRe  . "\r\n" .
				'X-Mailer: PHP/' . phpversion();		

		// send email 
		$success = mail($EmailTo, $Subject, $Body, $headers);

		// redirect to success page y enviar mail al cliente
		if ($success){
		  print "<meta http-equiv=\"refresh\" content=\"0;URL=gracias.html\">";
		  mail($Email, $SubjectRe, $BodyRe, $headersRe);
		}
		else{
		  print "<meta http-equiv=\"refresh\" content=\"0;URL=error.htm\">";
		}
  ?>