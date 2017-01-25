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
	newOutput(id,mennyiseg,1);
}

function trash(){
	newTrash(id,mennyiseg,1);
}
