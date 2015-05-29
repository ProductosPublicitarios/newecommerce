$(function(){

	initCufon();

});

function initCufon(){

	//cooper

	Cufon.replace('.nav ul li a, .header-left a.add, .header .title h2, #carrito, ul.options, .products-wrapper h5, a.product, form.bottom-form label,  form.bottom-form legend, .footer p, a.add, .box-sidebar h4, .box-sidebar h5, .box-sidebar p,.box-sidebar.add ul li, .box-sidebar.contact .text ul li,  form.sidebar label' , {fontFamily: 'trebu', hover: true});

	//helvetica regular



	//helvetica Neue Bold

	Cufon.replace(' .title-bottom a.btn span, .title-bottom ul li, h1, .a-btn-text', {fontFamily: 'trebu2'});

	Cufon.replace('#titulo, form.search input, form.search a, .social span, #opt, .product-sub a.prev-light, .product-sub a.next-light', {fontFamily: 'trebu3'});

	Cufon.replace('#caract, #texto, .texto_tit, #texto_dest, ul.options li .right-option p, .footer ul li a',{fontFamily: 'trebu4', hover: true});

}