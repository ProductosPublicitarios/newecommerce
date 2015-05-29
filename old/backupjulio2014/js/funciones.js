var val_srch_str = 'Buscar...';
var val_login_usuario = 'Usuario...';
var val_login_clave = 'Contraseña';

var p_q = null;
var p_id = null;
var pr_id = null;
var p_name = null;

function addCart(id,q, name,xmin)
{
	p_q = q;
	p_id = id;
	p_name = name;
	p_min = xmin;
	
	var data = 'id='+id+'&q='+q+'&na='+name+'&xmin='+p_min;
	var msj_added = 'El producto ha sido agregado.';
	post(data,'',msj_added,'', 'add_cart','refreshCart');
}
function refreshCart(e)
{
	var arr = e.split(',');
	//alert(arr[0]+arr[1]);
	$('#p_0').hide();
	$('#btn-cotizar').show();
	if(arr[0]=='existe'){
		if( $('#p_'+p_id) ){
			//var act = parseInt($('#pp_'+p_id).val());
			//var tot = parseInt( parseInt(p_q) + parseInt(act));
			var tot = arr[1];
			$('#p_'+p_id).html(p_name+': '+tot+'<a href="#" onclick="removeProd('+p_id+')">[X]</a>');
			Cufon.replace('#carrito' , {fontFamily: 'trebu', hover: true});
		}
	}else{
		htm = '<li id="p_'+p_id+'">'+p_name+': '+p_q+'<a href="#" onclick="removeProd('+p_id+')">[X]</a>';
		htm += '<input type="hidden" id="pp_'+p_id+'" value="'+p_q+'"></li>';
		$('#carrito').append(htm);
		Cufon.replace('#carrito' , {fontFamily: 'trebu', hover: true});
	}
	showMessage('El producto ha sido agregado a su carro de cotizaciones.');
	//window.parent.location.href = window.parent.location.href;
}

function isValidEmail(str){
	var regex = /^[^@]+@[^@]+.[a-z]{2,}$/i;
	if(str.search(regex) == -1){
		return false;
	}
	return true; 
}
function removeProd(id)
{
	pr_id = id;
	var data = 'id='+id;
	post(data,'','','', 'remove_cart','removeRefreshCart');
}
function removeRefreshCart(e)
{
	$('#p_'+pr_id).remove();
	checkHayItems();
}
function checkHayItems()
{
	var cant = $('#carrito li').size();
	if(cant == 2){
		$('#p_0').show();
		$('#btn-cotizar').hide();
	}
}

function showMessage(s)
{
	alert(s);
}


function addFav()
{
	var title = String(document.title);
	var url = String(window.location);
	
	if (window.sidebar) // firefox
		window.sidebar.addPanel(title, url, '');
	else if(window.opera && window.print){ // opera
		var elem = document.createElement('a');
		elem.setAttribute('href',href);
		elem.setAttribute('title',title);
		elem.setAttribute('rel','sidebar');
		elem.click();
	} 
	else if(document.all)// ie
		window.external.AddFavorite(url, title);
		else {// otros web Browsers
		alert ('Presione Crtl+D para agregarnos a sus favoritos');  
	}
}

function validBuscar()
{
	var val = jQuery.trim($('#srch_str').val());
	if( val!='' && val !=val_srch_str ){
		buscar(val);
	}else{
		alert('Ingrese un texto para buscar.');
	}
}
function buscar(v)
{
	window.location = 'buscador.php?w='+v;
}

function emptyInput(e)
{
	valor = $(this).attr('value');
	if( valor == eval('val_'+$(this).attr('id'))){
		$(this).css('color', '#6870aa');
		$(this).attr('value', '');
	}
}

function validContact()
{
	var data;
	var nombre = jQuery.trim($('#name').val());
	var empresa = jQuery.trim($('#empresa').val());
	var email = jQuery.trim($('#email').val());
	var telefono = jQuery.trim($('#tel').val());
	var como = jQuery.trim($('#como').val());
	var news = $('#news_1').is(':checked')?1:0;
	var terms = $('#terms').is(':checked')?1:0;
	var consulta = jQuery.trim($('#consulta').val());
	
	data = 'nombre='+nombre+'&email='+email+'&empresa='+empresa+'&telefono='+telefono+'&como='+como+'&news='+news+'&consulta='+consulta;
	
	if( nombre!='' && email!='' && isValidEmail(email) && consulta!='' && terms ){
		post(data,'','','', 'contactar');
	}else{
		alert('Por favor complete al menos nombre, email y consulta y acepte la política de privacidad.');
	}
}
function validContactInt()
{
	var nombre = jQuery.trim($('#name').val());
	var empresa = jQuery.trim($('#empresa').val());
	var email = jQuery.trim($('#email').val());
	var telefono = jQuery.trim($('#tel').val());
	var como = jQuery.trim($('#como').val());
	var consulta = jQuery.trim($('#consulta').val());
	var terms = $('#terms').is(':checked')?1:0;
	
	if( nombre!='' && email!='' && isValidEmail(email) && consulta!='' && terms ){
		$('#form_consultas_int').submit();
	}else{
		alert('Por favor complete al menos nombre, email y consulta y acepte la política de privacidad.');
	}
}
function validLogin()
{
	var data;
	var usuario = jQuery.trim($('#login_usuario').val());
	var clave = jQuery.trim($('#login_clave').val());
	data = 'usuario='+usuario+'&clave='+clave;
	
	if( usuario!='' && clave!='' && isValidEmail(usuario) ){
		post(data,'','','', 'login','responseLogin');
	}else{
		alert('Por favor complete usuario y clave.');
	}
}


// AJAX
function post(_data,_msg_send,_msg_ok,_msg_error,_fun,_cbk,_file)
{
	var file = './controlls/ajax.php';
	var fun = '';
	var msg_ok = 'Los datos han sido recibidos, muchas gracias.';
	var msg_send = 'Procesando... aguarde un momento.';
	var msg_error = 'Ha ocurrido un error, por favor intente nuevamente';
	if( _msg_ok ){ msg_ok=_msg_ok; }
	if( _msg_send ){ msg_send=_msg_send; }
	if( _msg_error ){ msg_error=_msg_error; }
	if( _file ){ file=_file; }
	if( _fun ){ fun=_fun; }

	$.ajax({
		type: "POST",
		url: file,
		data: '_f='+fun+'&'+_data,
		//beforeSend: function(){ showMessage(msg_send, false, war); },
		error: function(){ showMessage(msg_error, false, false); },
		success: function(r){
			if(r){
				if(_cbk){
					valu = '("'+r+'");';
					eval(_cbk+valu);
				}else{
					showMessage(msg_ok, false, false);
				}
			}else{
				showMessage(msg_error, false, false);
			}
		}
	});
}

function on_enter(event)
{
	if (event.which == '13') {
		event.preventDefault();
		validLogin();
   }
}
function on_enter_search(event)
{
	if (event.which == '13') {
     event.preventDefault();
	 buscar($('#srch_str').val());
   }
}

function responseLogin(s)
{
	if(s=='0r'){
		alert('Datos incorrectos');
	}else{
		alert('Bienvenido '+s);
	}
}

function cotizar(e)
{
	e.preventDefault();
	alert('cotizando...');
}