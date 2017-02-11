function goTo(url){
	location.href = url;
}

function input(){
	var supplier = $('#besz').val()
	var product = $('#alap').val()
	var amount = $('#suly').val()
	
	var sumDifference = $('#sumDifference').val()
	var appearance = $('#appearance').val()
	var consistency = $('#consistency').val()
	var smell = $('#smell').val()
	var color = $('#color').val()
	var clearness = $('#clearness').val()
	var palletQuality = $('#palletQuality').val()
	var decision = $('#decision').val()
	
	newQualityForm(sumDifference, appearance, consistency, smell, color, clearness, palletQuality, decision)
	
	newPallet(product,supplier,amount)
}

function output(id,mennyiseg){	
	createOutput(id,mennyiseg);
}

function trash(id,mennyiseg){
	createTrash(id,mennyiseg);
}
