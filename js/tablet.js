function goTo(url){
	location.href = url;
}

function input(){
	var supplier = $('#besz').val()
	var product = $('#alap').val()
	var amount = $('#suly').val()
	newPallet(product,supplier,amount)
}

function output(id,mennyiseg){	
	createOutput(id,mennyiseg);
}

function trash(id,mennyiseg){
	createTrash(id,mennyiseg);
}
