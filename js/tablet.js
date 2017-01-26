function goTo(url){
	location.href = url;
}

function input(){
	var beszallito = $('#besz').val()
	var alapanyag = $('#alap').val()
	var suly = $('#suly').val()
	newPallet(beszallito,alapanyag,suly,1)
}

function output(id,mennyiseg){	
	createOutput(id,mennyiseg);
}

function trash(id,mennyiseg){
	createTrash(id,mennyiseg);
}
