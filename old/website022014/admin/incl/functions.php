<?php
function conn()
{
	$conn = mysql_connect(HOST,USER,PASX);
	if( $conn ){
		$sdb = mysql_select_db(NAME, $conn);
		if( !$sdb ){
			$conn = false;
		}
	}
	return $conn;
}
function removeBS($str,$arr1,$arr2)
{
	return strtolower(str_replace($arr1, $arr2, $str));
}

function echox($who)
{
	echo "<strong>var:</strong> $who<br />";
}

function echod($who)
{
	die("\$who: $who<br />");
}

function printor($arr)
{
	echo "<pre style='color:#333; background-color:#fff'>";
	print_r($arr);
	echo "</pre>";
}

function headerJS($uri='./')
{
	$fout = "<script type='text/javascript' language='javascript'>";
	$fout.= "window.location='$uri';</script>";
	echo $fout;
}

function cleaning($str, $fcnx=false)
{
	$fout = @mysql_real_escape_string(trim($str), $fcnx);
	return $fout;
}

function makeTitles($arr_titles, $arr_permisos, $arr_align, $arr_width)
{
	$space = '';
	$fout = "\n  <tr class='row_titles'>";
	foreach($arr_titles as $key=>$value)
	{
		if($value == '_check_'){
			$fout .= "\n\t<td width='40' align='center' class='prt'>".$space."<input type='checkbox' id='check0' /></td>";
		}else{
			if( $arr_permisos[$key] == false or in_array($arr_permisos[$key], $_SESSION["permisos"]) )
			{
				$align = ( $arr_align[$key] !== false ) ? " align='".$arr_align[$key]."'" : "";
				$width = ( $arr_width[$key] !== false ) ? " width='".$arr_width[$key]."'" : "";
				$space = ($align == " align='left'") ? "&nbsp; " : "";
	
				$fout .= "\n\t<td".$width.$align.">".$space.$value."</td>";
			}
		}
	}
	$fout .= "</tr>";
	return $fout;
}

function dameCount($fcnx, $tabla, $campo_id='id', $where='', $dbg=false)
{
	$fout = false;
	$fsql = "SELECT COUNT($campo_id) AS cant FROM $tabla $where";
	if($dbg){echo $fsql.'<br />';}
	$fres = mysql_query($fsql);
	if($fres){
		$frow = mysql_fetch_row($fres);
		$fout = $frow[0];
	}
	return $fout;
}

function dame1Campo1Row($fcnx, $tabla, $campo, $w='', $dbg=false)
{
	$fsql = "SELECT $campo FROM $tabla $w LIMIT 1";
	if( $dbg ){ echo $fsql.'<br/>';}
	$fres = @mysql_query($fsql, $fcnx);
	if(!$fres){
		$fout = false;
	}else{
		if( @mysql_num_rows($fres) <= 0 ){
			$fout = false;
		}else{
			$frow = @mysql_fetch_row($fres);
			$fout = $frow[0];
		}
	}
	return $fout;
}

function dame1CampoNRows($cnx, $tabla, $campo, $w='')
{
	$fsql = "SELECT $campo FROM $tabla $w";
	$fres = @mysql_query($fsql, $cnx);
	if(!$fres){
		$fout = false;
	}else{
		if( @mysql_num_rows($fres) <= 0 ){
			$fout = false;
		}else{
			while($frow = @mysql_fetch_row($fres) ){
			$fout[] = $frow[0];
			}
		}
	}
	return $fout;
}

function dameNCampos1Row($fcnx, $tabla, $campos, $w='')
{
	$fsql = "SELECT $campos FROM $tabla $w LIMIT 1";
	//echo $fsql."<br />";
	$fres = @mysql_query($fsql, $fcnx);
	if(!$fres){
		$fout = false;
	}else{
		if( @mysql_num_rows($fres) <= 0 ){
			$fout = false;
		}else{
			$fout = @mysql_fetch_array($fres);
		}
	}
	return $fout;
}

function dameNCamposNRows($fcnx, $tabla, $campos, $w='')
{
	$fsql = "SELECT $campos FROM $tabla $w";
	$fres = @mysql_query($fsql, $fcnx);
	if(!$fres){
		$fout = false;
	}else{
		if( @mysql_num_rows($fres) <= 0 ){
			$fout = false;
		}else{
			while($frow = @mysql_fetch_array($fres) ){
				$fout[] = $frow;
			}
		}
	}
	return $fout;
}

function dameRowsListado($fcnx, $tabla, $arr_titulos, $w='')
{
	foreach($arr_titulos as $valor){
		if($valor !== false){
			$campos .= $valor . ", ";
		}
	}
	$campos = substr($campos, 0, -2);

	$fsql = "SELECT $campos FROM $tabla $w";
	$fres = @mysql_query($fsql, $fcnx);
	if(!$fres){
		$fout = false;
	}else{
		if( @mysql_num_rows($fres) <= 0 ){
			$fout = false;
		}else{
			while($frow = @mysql_fetch_array($fres) ){
				$fout[] = $frow;
			}
		}
	}
	return $fout;
}

function makeRows($sexion, $data_rows, $arr_campos_db, $arr_permisos, $arr_campos_tipos, $arr_align, $show_on_delete, $fcnx=false)
{
# !!!!!		// + Efectivo chequear primero las cols.
	if( is_array($data_rows) )
	{
		foreach($data_rows as $key => $value)
		{ // X Cada Fila de la Tabla armo un row.
			$fout .= "\n  <tr>";
			$fout .= "\n\t<td height='7'></td>";
			$fout .= "\n  </tr>";
			$fout .= "\n  <tr class='row_data'>";
			foreach($arr_campos_db as $clave=>$valor)
			{ // Por cada Campo de la DB meto TDS...
				if( $arr_permisos[$clave] == false or in_array($arr_permisos[$clave], $_SESSION["permisos"]) )
				{
					if( $valor === false )
					{ // NOT DB Maybe Link.
						$id = $value[$valor];
						$string = $value[$show_on_delete];
						$data = dameTipoLink($sexion, $arr_campos_tipos[$clave], $id, $string);
					}else
					{ // Dato directo a parsear por funcion de tipo: date, datetime, arr, etc.
						$id = $value[$valor];
						$data = dameTipoCampo($arr_campos_tipos[$clave], $id, $fcnx);
					}
				
					$align = ( $arr_align[$clave] !== false ) ? " align='".$arr_align[$clave]."'" : "";
					$space = ($align == " align='left'") ? "&nbsp; " : "";
					//$width = ( $arr_width[$clave] !== false ) ? " width='".$arr_width[$clave]."'" : "";
					
					$fout .= "\n\t<td".$align.$width.">".$space.$data."</td>";
				}
				
				
			}
			$fout .= "\n  </tr>";
		}
	}else{
		$fout .= "\n  <tr>";
		$fout .= "\n\t<td height='7'></td>";
		$fout .= "\n  </tr>";
		$fout .= "\n  <tr class='row_data'>";
		$fout .= "\n  <td colspan='20'>&nbsp; No hay registros por el momento.";
		$fout .= "&nbsp;&nbsp;<a href='nuevo.php'>&iquest;Desea crear uno nuevo?</a></td>";
		$fout .= "\n  </tr>";
	}
	return $fout;
}

function dameTipoLink($sexion, $valor, $id, $str)
{
	$arr = explode("_", $valor);
	if($arr[0] == "link"){
	 // Tiene subnivel
		if( $arr[3] == "blank" ){
			$fout = "<a href='".$arr[1].".php?id=$id' target='_blank'>".$arr[2]."</a>";
			//return $arr[0] . "::" . $arr[1] . "::" . $arr[2];
		}elseif( $arr[3] == "js" ){
			$fout = "<a href='../__ink/delete.php?TB_iframe=true&id=$valor' title='{$arr[2]}' rel='sexylightbox'>{$arr[2]}</a>";
		}elseif( $arr[3] == "sexy" ){
			$fout = "<a href='../__ink/{$arr[1]}.php?id=$id&sx=$sexion&st=$str&TB_iframe=true&width=450&height=180' title='' rel='sexylightbox'>{$arr[2]}</a>";
		}		
		else{
			$fout = "<a href='".$arr[1].".php?id=$id'>".$arr[2]."</a>";
		}
		
	}
	else
	{
		$fout = $valor;
	}
	//return $arr[0] . "::" . $arr[1] . "::" . $arr[2];
	return $fout;
}

function dameTipoCampo($valor, $id, $fcnx=false)
{
	$arr = explode("_", $valor);

	if($arr[1] == "arr"){
		eval("global \$arr_".$arr[2].";");
		eval("\$mi_arr = \$arr_".$arr[2].";");
		$fout = $mi_arr[$id];
	}
	elseif($arr[1] == "date"){
		$fout = dameFechaEs($id);
	}
	elseif($arr[1] == "datetime")
	{ // Tiene subnivel
		$fout = dameFechaEs($id);
	}
	elseif( $arr[1] == "db" )
	{ // Busca en otra tabla.
		echo $id;
		$fout = dame1Campo1Row($fcnx, PREF_TABLAS . $arr[2], $arr[3], "WHERE id='$id'");
	}
	else
	{
		$fout = $id;
	}
	//return $arr[0] . "::" . $arr[1] . "::" . $arr[2];
	return $fout;
}

function dameOptionsNaN($ini, $fin, $selected)
{
	$fout = '';
	for($i = $ini; $i <= $fin; $i++)
	{
		$sel = ($selected == $i) ? $sel = SELECTED : $sel = '';
		$fout .= "<option value='$i'$sel>$i</option>";
	}
	
	return $fout;
}

function dameOptionsArray($arr, $key=false, $selected=false)
{
	$fout = '';
	if($key){
		if( is_array($arr)){
			foreach($arr as $clave=>$valor)
			{
				$sel = ($selected == $clave) ? $sel = SELECTED : $sel = '';
				$fout .= "<option value='$clave'$sel>$valor</option>";
			}
		}
	}else{
		if( is_array($arr)){foreach($arr as $valor)
		{
			$sel = ($selected == $valor) ? $sel = SELECTED : $sel = '';
			$fout .= "<option value='$valor'$sel>$valor</option>";
		}}
	}
	return $fout;
}

function dameOptionsOrden($arr_db, $arr_label, $selected)
{
	$fout = '';
	foreach($arr_db as $clave=>$valor)
	{
		$label = $arr_label[$clave];
		$sel = ($selected == $clave) ? $sel = SELECTED : $sel = '';
		$fout .= "<option value='$clave'$sel>$label</option>";
	}
	return $fout;
}

function dameFechaEs($fecha,$h=true,$arrm=false)
{
	$ano = substr($fecha, 0, 4);
	$mes = substr($fecha, 5, 2);
	$dia = substr($fecha, 8, 2);
	
	if($h and strlen($fecha) > 10){
		$hora = substr($fecha, 11);
		if( $arrm ){
			$fout = $dia ." de ". $arrm[intval($mes)] ." de ". $ano ." a las ". $hora;
		}else{
			$fout = $dia ."-". $mes ."-". $ano ." ". $hora;
		}
	}else{
		$fout = $dia ." de ". $arrm[intval($mes)] ." de ". $ano;
	}
	
	return $fout;
}


function eliminar($fcnx, $tabla, $ID, $campo_id='id')
{
	$fsql = "DELETE FROM $tabla WHERE $campo_id='$ID' LIMIT 1";
	$fres = @mysql_query($fsql, $fcnx);
	if(!$fres){
		$fout = false;
	}else{
		$fout = true;
	}
	return $fout;
}
function pas2res($fcnx, $tabla, $campos, $id, $d=0)
{
	$w = "WHERE id=$id LIMIT 1";
	$data = dd($fcnx,$tabla.'_del',$campos,$w);
	if( is_array($data) ){
		//printor($data);
		$nuArr = pasArr2arrPeerStr($data);
		$ins = insertar($fcnx, $tabla, $nuArr['k'], $nuArr['v']);
		if($ins){
			$del = eliminar($fcnx, $tabla.'_del', $id);
			if( $del ){
				$fout = true;
			}else{
				$fout = false;
			}
		}else{
			$fout = false;
		}
	}else{
		$fout = false;
	}
	
	return $fout;
}
function pas2del($fcnx, $tabla, $campos, $id, $d=0)
{
	$w = "WHERE id=$id LIMIT 1";
	$data = dd($fcnx,$tabla,$campos,$w, $d);
	if( is_array($data) ){
		$nuArr = pasArr2arrPeerStr($data);
		$ins = insertar($fcnx, $tabla.'_del', $nuArr['k'], $nuArr['v'], $d);
		if($ins){
			$del = eliminar($fcnx, $tabla, $id);
			if( $del ){
				$fout = true;
			}else{
				$fout = false;
			}
		}else{
			$fout = false;
		}
	}else{
		$fout = false;
	}
	
	return $fout;
}

function pasArr2bi($arr)
{
	$arrnu = array();
	if( is_array($arr[0]) ){
		foreach($arr[0] as $key=>$val){
			$arrnu[$key] = $val;
		}
	}
	return $arrnu;
}
function passArrMultiToSingle($arr, $value, $id='id')
{
	$arrnu = array();
	if( is_array($arr) ){
		foreach($arr as $key=>$val){
			/*if( is_array($arr[0]) ){
				foreach($arr[0] as $key=>$val){*/
					$arrnu[$val[$id]] = $val[$value];
				/*}
			}*/
		}
	}
	return $arrnu;
}
function passArrSingleToMulti($arr)
{
	$nuArr = array();
	$i = 0;
	foreach($arr as $key=>$value)
	{
		$nuArr[$i]['id'] = $key;
		$nuArr[$i]['value'] = $value;
		$i ++;
	}
	return $nuArr;
}

function pasArr2str($arr)
{
	$fout = '';
	if( is_array($arr[0]) ){
		foreach($arr[0] as $key=>$val){
			$fout .= "$key='$val', ";
		}
		}
	$fout = substr($fout, 0, -2);
	return $fout;
}

function pasArr2arrPeer($arr)
{
	$i = 0;
	$arrnu = array();
	if( is_array($arr[0]) ){
		foreach($arr[0] as $key=>$val){
			$arrnu['k'][$i] = $key;
			$arrnu['v'][$i] = $val;
			$i ++;
		}
	}
	return $arrnu;
}

function pasArr2arrPeerStr($arr)
{
	$arrnu = array();
	$keys = $vals = '';
	
	if( is_array($arr[0]) ){
		foreach($arr[0] as $key=>$val){
			$vals .= "'$val',";
			$keys .= $key.',';
		}
		$vals = substr($vals, 0, -1);
		$keys = substr($keys, 0, -1);
		
		$arrnu['k'] = $keys;
		$arrnu['v'] = $vals;
	}
	return $arrnu;
}

function dameCamposTabla($fcnx, $tabla)
{
	$fsql = "SELECT ";
}

function eliminarVarios($fcnx, $tabla, $ID, $campo_id='id')
{
	$fsql = "DELETE FROM $tabla WHERE $campo_id='$ID'";
	$fres = @mysql_query($fsql, $fcnx);
	if(!$fres){
		$fout = false;
	}else{
		$fout = true;
	}
	return $fout;
}

function editar($fcnx, $tabla, $ID, $campos_valores, $campo_id='id', $dbg=false)
{
	$fsql = "UPDATE $tabla SET $campos_valores WHERE $campo_id='$ID' LIMIT 1";
	$fres = @mysql_query($fsql, $fcnx);
	if($dbg){ echo '<span style="background-color:#fff;">XX'.$fsql.'<br />'.mysql_error($fcnx).'</span>';}
	if(!$fres){
		$fout = false;
	}else{
		$fout = true;
	}
	return $fout;
}

function dameValorIdGet($uri='./')
{
	if( isset($_GET["id"]) ){
		$id = trim($_GET["id"]);
		if($id != ""){
			$id = intval($id);
			if( $id != 0 ){
				return $id;
			}
		}
	}
	headerJS($uri);
}

function dameValorIdPost($uri='./')
{
	if( isset($_POST["id"]) ){
		$id = trim($_POST["id"]);
		if($id != ""){
			return intval($id);
		}else{
			headerJS($uri);
		}
	}else{
		headerJS($uri);
	}
}

function checkSess()
{
	$fout = true;
	return $fout;
}

function makeInputText($name, $id, $value='', $class='input_xl')
{
	$fout = "<input type='text' name='$name' id='$id' class='$class'";
	if($value!=''){
		$fout .= " value='$value'";
	}
	$fout .= " />";
	return $fout;	
}

function makeTextArea($name, $id, $value='', $class='')
{
	$fout = "<textarea type='text' name='$name' id='$id' class='$class'>";
	if($value!=''){
		$fout .= $value;
	}
	$fout .= "</textarea>";
	return $fout;	
}

function makeSelect($name, $id, $fill, $selected=false)
{
	eval("global \$arr_".$fill.";");
	eval("\$mi_arr = \$arr_".$fill.";");
	
	$fout = "<select name='$name' id='$id'>";
	$fout .= dameOptionsArray($mi_arr, true, $selected);
	$fout .= "</select>";
	return $fout;	
}

function makeWhereOnly($arr)
{
	if( isset($_GET["VS"]) ){
		$ONLY_KEY = intval($_GET["VS"]);
		$cant_indices = (count($arr)-1);
		if( $ONLY_KEY > $cant_indices or $ONLY_KEY < 0 ){
			$fout = 0;
		}else{
			$fout = $ONLY_KEY;
		}
	}else{
		$fout = 0;
	}	
	return $fout;
}

function dameArrayEvaluadoGlobal($arr_name)
{
	eval("global \$arr_".$arr_name.";");
	eval("\$mi_arr = \$arr_".$arr_name.";");
	
	return $mi_arr;
}

function insertar($fcnx, $tabla, $campos, $valores, $dbg=false, $rid=false)
{
	$fsql = "INSERT INTO $tabla ($campos) VALUES($valores)";
	$fres = mysql_query($fsql);
	if($dbg){ echo '<span style="background-color:#fff;">'.$fsql.'<br />'.mysql_error($fcnx).'</span>';}
	if(!$fres){
		$fout = false;
	}else{
		$fout = true;
		if($rid){
			$fout = mysql_insert_id($fcnx);
		}
	}
	return $fout;
}

function addJsText($str)
{
	global $js_texts;
	$js_texts[] = $str;
}

function addJsFile($file)
{
	global $js_files;
	$js_files[] = $file;
}

function addJsOnLoad($str)
{
	global $js_init;
	$js_init[] = $str;
}

function printJs($arr_files, $arr_texts, $arr_init)
{
	// INCLUDES.
	$fout = '';
	if( is_array($arr_files) ){
		foreach($arr_files as $valor){
			$fout .= "<script languaje='javascript' type='text/javascript' src='../_jss/$valor'></script>\n";
		}
	}
	
	// JsText
	if( (is_array($arr_texts) and count($arr_texts) > 0) or (is_array($arr_init) and count($arr_init) > 0) ){
		$fout .= "<script languaje='javascript' type='text/javascript'>\n";
		
		// Extra
		if( (is_array($arr_texts) and count($arr_texts) > 0) ){
			foreach($arr_texts as $valor){
				$fout .= $valor . "\n";
			}
		}

		// onLoad
		if( is_array($arr_init) and count($arr_init) > 0 ){
			$fout .= "$(document).ready(function(){\n";
			//$fout .= "function init(){\n";
			foreach($arr_init as $valor){
				$fout .= "\t".$valor."\n";
			}
			//$fout .= "}\n";
			$fout .= "});\n";
			//$fout .= "document.addEvent(init);\n";			
		}
		
		$fout .= "</script>\n";
	}
	
	return $fout;
}

function makeSelectFecha($tipo, $name, $id=false, $selected=false)
{
	$arr_meses = array('','enero','febrero','marzo','abril','mayo','junio','julio','agosto');
	array_push($arr_meses, 'septiembre','octubre','noviembre','diciembre');
	
	$fout = "<select name='$name' ";
	if($id){
		$fout .= "id='$id' ";
	}
	$fout .= ">";
	
	if($tipo == 'dia'){
		$ini = 1;
		$fin = 31;
	}elseif($tipo == 'mes'){
		$ini = 1;
		$fin = 12;
	}else{
		$ini = 2009;
		$fin = 2020;
	}
	
	for($i=$ini; $i<=$fin; $i++){
		if($tipo == 'mes'){
			if($selected == $i){
				$sel = " selected='selected'";
			}else{
				$sel = '';
			}
			$options .= "<option value='$i'$sel>{$arr_meses[$i]}</option>\n";
		}else{
			if($selected == $i){
				$sel = " selected='selected'";
			}else{
				$sel = '';
			}
			$options .= "<option value='$i'$sel>$i</option>\n";
		}
	}
	
	$fout .= $options;
	$fout .= "</select>";
	
	return $fout;
}

function makeEmpFotoDef($cnx, $id_emp)
{
	$campos = 'id_emprendimiento,uri,orden,visible,tipo';
	$valores = "$id_emp, 'foto-no-disponible.jpg', 999, 1, 1";
	$fsql = "INSERT INTO ".PREF_TABLAS."fotos ($campos) VALUES($valores)";
	$fres = @mysql_query($fsql, $cnx);
	if(!$fres){
		$fout = false;
	}else{
		$fout = true;
	}
	return $fout;
}

function dameDataSexion($arr_sexiones, $arr_sexiones_gen=false)
{
	//global $arr_sexiones;
	$toSearch = '/'.ADMN.'/';
	$fileName = $_SERVER['SCRIPT_NAME'];
	//echo 'fileName:'.$fileName.'<br />';
	$largo = strlen($toSearch);
	$pos = strpos($fileName, $toSearch);
	$pos_ini_corte = $largo + $pos;
	
	$cadena_ini = substr($fileName, $pos_ini_corte);
	$pos_fin_corte = strpos($cadena_ini, '/');
	$cadena_pre = substr($cadena_ini, 0, $pos_fin_corte);
	
	// SACO EL SINGULAR.
	$last_letters = substr($cadena_pre, -2);
	if( $last_letters == "es")
	{ // PUEDEN SER VARIAS.
		$anteante_letter = substr($cadena_pre, -3, 1);
		
		if($anteante_letter == 'u' OR $anteante_letter == 'i' OR $anteante_letter == 's')
		{ // CORTO 2
			$singular = substr($cadena_pre, 0, -2);
		}else{
			$singular = substr($cadena_pre, 0, -1);
		}
	}else{
		$singular = substr($cadena_pre, 0, -1);
	}
	
	// Busco _
	$pos_guion = strpos($cadena_pre, '_');
	if($pos_guion){
		// Reemplazo por espacios.
		$sin_guiones = str_replace('_', ' ', $cadena_pre);
	}else{
		$sin_guiones = $cadena_pre;
	}
	
	// Plural.
	/*$last_letter = substr($cadena_pre, -1, 1);
	if($last_letter == 'a' or $last_letter == 'e' or $last_letter == 'o'){
		$out[2] = $cadena_pre . 's';
	}else{
		$out[2] = $cadena_pre . 'es';
	}*/
	
	// Nombre default
	$out[0] = $cadena_pre;
	
	// Plural
	$out[1] = $sin_guiones;
	
	// Singular
	$out[2] = $singular;
	
	// ID
	foreach($arr_sexiones as $ki=>$val){
		//echo $ki .'-'.$val.'<br />';
		if( ucfirst($cadena_pre) == $val ){
			$out[3] = $ki;
			break;
		}else{
			$out[3] = 99;
		}
	}
	
	if( $arr_sexiones_gen[$out[3]] == 'f' ){
		$out[4] = 'la';
		$out[5] = 'esta';
		$out[6] = 'las';
	}else{
		$out[4] = 'el';
		$out[5] = 'este';
		$out[6] = 'los';
	}
	
	return $out;
}


/* NU FUNCTIONS */
function p($x)
{
	echo "<pre style='background-color:#333;color:#fff;font-size:11px;'>";print_r($x);echo "</pre>";
}

function e($w)
{
	echo "<pre style='background-color:#333;color:#fff;font-size:11px;'>\$var:</strong> $w</pre>";
}
function d($w)
{
	die("<pre style='background-color:#333;color:#fff;font-size:11px;'>\$var:</strong> $w</pre>");
}


function di($r=0,$u='./')
{
	$i=intval($_GET['id']);
	($r===1) ? header("Location: $u"):$i;
	return $i;
}

function cu($rdr=1)
{
	$f=true;
	if(!$_SESSION['xlogged']){
		if($rdr){
			header('Location: '.P.'login/');
		}else{
			$f = false;
		}
	}
	return $f;
}

function df($f,$h=0,$s='-')
{
	$a = substr($f, 0, 4);
	$m = substr($f, 5, 2);
	$d = substr($f, 8, 2);
	
	if(strlen($f)>10 and $h===1){
		$h = substr($f, 11);
		$f = $d.$s.$m.$s.$a." ".$h;
	}else{
		$f = $d.$s.$m.$s.$a;
	}
	return $f;
}

function hj($u='./')
{
	echo "<script language='javascript'>window.location='$u';</script>";
	exit();
}

function dc($x,$t,$c='id',$w='',$d=0)
{
	$f = false;
	$fs = "SELECT COUNT($c) AS cant FROM ".PX."$t $w";
	if($d){ die('<pre style="background-color:#fff;">'.$fs.'<br/>'.mysql_error($x).'</pre>');}
	$fr = mysql_query($fs, $x);
	if($fr){
		$fw = mysql_fetch_row($fr);
		$f = $fw[0];
	}
	return $f;
}

function ls($x,$s)
{
	$s = addslashes($s);
	$fs = "INSERT INTO ".PX."logsql(`sql`) VALUES('$s')";
	$fr = mysql_query($fs, $x);
}

function esp($n)
{
	return !($n%2); 
}

function gk($q=8)
{
	$a = 'abc3de2fghj4k5mnpqr6stu78vw9xyz';
	$k = '';
	$mx = strlen($a);
	for($i=0;$i<=$q;$i++)
	{
		$n = rand(0, $mx);
		$m = rand(0, 1);
		if($m == 0){
			$k .= $a[$n];
		}else{
			$k .= strtoupper($a[$n]);
		}
	}
	
	return $k;
}

function dd($x,$t,$c,$w='',$d=0)
{
	$fs = "SELECT $c FROM ".PX."$t $w";
	if($d){	echo "C:$x :: F:$fs<br />"; }
	$fr = @mysql_query($fs, $x);
	if(!$fr){
		$f = false;
	}else{
		if( @mysql_num_rows($fr) <= 0 ){
			$f = false;
		}else{
			while($fw = @mysql_fetch_assoc($fr) ){
				$f[] = $fw;
			}
		}
	}
	return $f;
}

// makeOptionsArray.
function mo($a, $t, $v=false, $s=false, $i=0)
{
	/*
	 * $a -> El array del cual tomar los datos
	 * $t -> El Indice Asociativo del Array para llenar los textos del option.
	 * 		 Puede ser un Array con los Indices Asociativos
	 		 que tiene que juntar, y un 'sep' que es el separador.
	 * $v -> Idem anterior pero con el value del option, si es FALSE es igual al texto
	 * $s -> El elemento SELECTED del Select (siempre se le pasa su key).
	 * $i -> El init: -- Seleccione o cobra --
	*/
	$f = '';
	if( $i !== 0 ){
		$f .= '<option value="__null__">'.$i.'</option>';
	}
	
	if(is_array($a) ){ foreach($a as $arrei)
	{
		if( $v === false )
		{ // HAY SOLO TEXT (el value es el mismo ke el text).
			$paso = 0; // Este es un flag para evitar el in_array pase 2 veces.
			
			foreach( $arrei as $key => $val )
			{
				if($key == '__title__'){
					$f .= "<option value='".$arrei[$v]."' disabled='disabled'>$val</option>";
				}
				if( is_array($t) )
				{ // Junto varios labels...
					$valorete = '';
					$arr_last_element = count($t) - 1;
					
					if( in_array($key, $t) )
					{
						$paso += 1;
						foreach( $t as $kk=>$vv ){
							if( $kk != 0){
								$valorete .= $arrei[$vv];
								if( $kk != $arr_last_element){
									$valorete .= $t[0];
								}
							}
						}
						// Continuo...
						if( $paso <= 1 ){
							$f .= "<option value='$valorete'>$valorete</option>";
						}
					}
				}
				else
				{ // Un solo label..
					if( $key == $t ){
						if( $s === $val ){
							$f .= "<option value='$val' selected='selected'>$val</option>";
						}else{
							$f .= "<option value='$val'>$val</option>";
						}
					}
				}
			}
		}
		else
		{ // HAY VALUE Y HAY TEXT.
			$paso = 0;
			
			foreach( $arrei as $key => $val )
			{
				if($key == '__title__'){
					$f .= "<option value='".$arrei[$v]."' disabled='disabled'>$val</option>";
				}
				if( is_array($t) )
				{ // Junto varios labels...
					$valorete = '';
					$arr_last_element = count($t) - 1;

					if( in_array($key, $t) )
					{
						$paso += 1;
						foreach( $t as $kk=>$vv ){
							if( $kk != 0){
								$valorete .= $arrei[$vv];
								if( $kk != $arr_last_element){
									$valorete .= $t[0];
								}
							}
						}
						// Continuo...
						if( $paso <= 1 ){
							$f .= "<option value='$valorete'>$valorete</option>";
						}
					}
				}
				else
				{ // Un solo label..
					if( $key == $t ){
						if( (string)$s === $arrei[$v] ){
							$f .= "<option value='".$arrei[$v]."' selected='selected'>$val</option>";
						}else{
							$f .= "<option value='".$arrei[$v]."'>$val</option>";
						}
					}
				}
			}
		}
	}}
	return $f;
}

function mon($i,$f,$s)
{
	for($x=$i;$x<=$f;$x++)
	{
		$sl=($s==$x)?SELECTED:'';
		$f.="\n<option value='$x'$sl>$x</option>";
	}
	return $f;
}

function addTitleAndSort($arr, $key, $title)
{
	$arr[$key]['__title__'] = $title;
	$fout = sorteArray($arr);
	return $fout;
}

function sorteArray($arr)
{
	$largo_arr = count($arr);
	for($i=0; $i<$largo_arr; $i++){
		ksort($arr[$i]);
	}
	return($arr);
}

function st($x)
{
	$fs = "BEGIN";
	$fr = mysql_query($fs,$x);
	$f=(!$fr)?false:true;
	return $f;
}

function et($x)
{
	$fs = "COMMIT";
	$fr = mysql_query($fs,$x);
	$f=(!$fr)?false:true;
	return $f;
}

function rt($x)
{
	$fs = "ROLLBACK";
	$fr = mysql_query($fs,$x);
	$f=(!$fr)?false:true;
	return $f;
}

function in($x,$t,$c,$v,$d=0)
{
	$fs = "INSERT INTO ".PX."$t ($c) VALUES($v)";
	$fr = mysql_query($fs);
	if($d){ die('<pre style="background-color:#fff;">'.$fs.'<br/>'.mysql_error($x).'</pre>');}
	$f=(!$fr)?false:true;
	return $f;
}

function ed($x,$t,$c,$w,$d=0)
{
	$fs = "UPDATE ".PX."$t SET $c WHERE $w";
	$fr = @mysql_query($fs, $x);
	if($d){ die('<pre style="background-color:#fff;">'.$fs.'<br/>'.mysql_error($x).'</pre>');}
	$f=(!$fr)?false:true;
	return $f;
}

function de($x,$t,$w,$d=0)
{
	$fs = "DELETE FROM ".PX."$t WHERE $w";
	$fr = @mysql_query($fs, $x);
	if($d){ die('<pre style="background-color:#fff;">'.$fs.'<br/>'.mysql_error($x).'</pre>');}
	$f=(!$fr)?false:true;
	return $f;
}

function def()
{ // Function que borra datos en vs tablas.
	
}

function jt($s)
{
	global $JT;
	$JT[] = $s;
}

function jf($s)
{
	global $JF;
	$JF[] = $s;
}

// VER MOOTOOLS O JQUERY ONLOAD.
function jo($s)
{
	global $JI;
	$JI[] = $s;
}
// PERFEZIONARE  (MOOTOOLS O JQUERY ONLOAD).
function jp($af,$at,$ai)
{
	$f='';
	if( is_array($af) ){
		foreach($af as $v){
			$f .= "<script languaje='javascript' type='text/javascript' src='../_jss/$v'></script>\n";
		}
	}
	
	// JsText
	if( is_array($at) and count($at) > 0 ){
		$f .= "<script languaje='javascript' type='text/javascript'>\n";
		
		// Extra
		foreach($at as $v){
			$f.= $v . "\n";
		}

		// onLoad
		if( is_array($ai) and count($$ai) > 0 ){
			$f .= "function init(){\n";
			foreach($ai as $v){
				$f .= "\t".$v."\n";
			}
			$f .= "}\n";
			$f .= "document.addEvent(init);\n";
		}
		
		$f .= "</script>\n";
	}
	
	return $f;
}
// Ver ke onda, cleaning con o sin tinymce.
function kli($s,$x)
{
	$f = @mysql_real_escape_string(trim($s), $x);
	return $f;
}

function delCombos($fcnx, $id_producto)
{
	$fsql = "DELETE FROM productos_combos WHERE id_producto=$id_producto OR id_combo=$id_producto";
	$fres = @mysql_query($fsql, $fcnx);
	if(!$fres){
		$fout = false;
	}else{
		$fout = true;
	}
	return $fout;
}

function dameCatSubProd($x,$id)
{
	$t = 'productos p LEFT JOIN subcategorias s ON s.id=p.id_subcategoria';
	$c = 'p.id_subcategoria,s.id_categoria';
	$d = dd($x,$t,$c,"WHERE p.id=$id");
	if( is_array($d) ){
		$arr[0] = $d[0]['id_categoria'];
		$arr[1] = $d[0]['id_subcategoria'];
		return $arr;
	}else{
		return false;
	}
}

function dameFotosProd($x, $id)
{
	$d = dd($x,'fotos','uri',"WHERE id_tipo=$id AND tipo=3");
	if( is_array($d) ){
		$arr[0] = $d[0]['uri'];
		$arr[1] = $d[1]['uri'];
		return $arr;
	}else{
		return false;
	}
}

function dameGruposPersona($x, $id)
{
	$out = '';
	$t = 'personas_grupos p ';
	$t.= 'LEFT JOIN grupos g ON ';
	$t.= 'g.id=p.id_grupo';
	$d = dd($x, $t, 'g.titulo', 'WHERE p.id_persona='.$id);
	if(is_array($d)){foreach($d as $v){
		$out .= $v['titulo'].', ';
	}}
	$out = substr($out, 0, -2);
	
	return $out;
}
function delAllGruposPersona($x, $id)
{
	$del = de($x,'personas_grupos',"id_persona=$id");
	return $del;
}
function insertGruposPersona($x, $id, $arr_grupos)
{
	$out = false;
	if(is_array($arr_grupos)){foreach($arr_grupos as $v){
		$out = insertar($x, 'personas_grupos', 'id_persona,id_grupo', "$id, $v");
	}}
	return $out;
}

function makeArrayServices($x)
{
	$limit = Q_SERVICES_HOME / 2;
	$D_SERVICIOS = false;
	$s_t = 'servicios s LEFT JOIN servicios s2 ON s.id=s2.padre ';
	$s_c = 's.id padre_id,s.titulo padre,s2.id,s2.titulo';
	$D_SERVICIOS_CAT = dd($x,$s_t,$s_c,'WHERE s.visible=1 AND s.padre=0 ORDER BY s.titulo LIMIT '.$limit,0);
	$D_SERVICIOS_NOCAT = dd($x,'servicios','id,padre,titulo','WHERE visible=1 AND padre=-1 LIMIT '.$limit,0);
	$i = 0;
	$padre_actual = '';
	if(is_array($D_SERVICIOS_CAT)){
		foreach($D_SERVICIOS_CAT as $v){
			$id = $v['id'];
			$padre_id = $v['padre_id'];
			$padre = $v['padre'];
			$titulo = $v['titulo'];
			
			if($padre_actual != $padre)
			{
				$padre_actual = $padre;
				$D_SERVICIOS[$i]['id'] = $padre_id;
				$D_SERVICIOS[$i]['padre'] = true;
				$D_SERVICIOS[$i]['titulo'] = $padre;
				$i ++;
			}
			
			$D_SERVICIOS[$i]['id'] = $id;
			$D_SERVICIOS[$i]['padre'] = false;
			$D_SERVICIOS[$i]['titulo'] = $titulo;
			
			$i ++;
		}
	}
	
	if(is_array($D_SERVICIOS_NOCAT)){
		$padre_actual = $padre;
		$D_SERVICIOS[$i]['id'] = -1;
		$D_SERVICIOS[$i]['padre'] = true;
		$D_SERVICIOS[$i]['titulo'] = 'Otros Servicios';
		$i ++;
		foreach($D_SERVICIOS_NOCAT as $v){
			$D_SERVICIOS[$i]['id'] = $v['id'];
			$D_SERVICIOS[$i]['padre'] = false;
			$D_SERVICIOS[$i]['titulo'] = $v['titulo'];
			$i ++;
		}
	}
	return $D_SERVICIOS;
}


?>