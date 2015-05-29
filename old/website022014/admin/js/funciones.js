function changeVer(u)
{
	var k = document.getElementById('ver').value;
	window.location = u+'.php?k='+k;
}
function changePage(u)
{
	var p = document.getElementById('page').value;
	window.location = u+'.php?p='+p;
}
function changePageAll(u)
{
	var p = document.getElementById('page').value;
	var k = document.getElementById('ver').value;
	window.location = u+'.php?p='+p+'&k='+k;
}

function changePageF(u)
{
	var p = document.getElementById('page').value;
	var k = document.getElementById('idk').value;
	window.location = u+'.php?p='+p+'&idk='+k;
}
function changePageF2(u)
{
	var p = document.getElementById('page').value;
	var k = document.getElementById('idk').value;
	window.location = u+'.php?idk='+k;
}