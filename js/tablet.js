function goTo(url){
	location.href = url;
}

function input(e){
	e.preventDefault();     // stops default button action, e.g. submitting a form
    e.stopPropagation();
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
	  
	newQualityForm(sumDifference, appearance, consistency, smell, color,
			clearness, palletQuality, decision,product,supplier,amount)
	
	return false;
}

function output(id,mennyiseg){	
	createOutput(id,mennyiseg,false);
}

function olderOutput(id,amount){
	bootbox.confirm('<h3>Újabb termék biztos, hogy kiadja?</h3>',function (yes){
		if(yes){
			createOutput(id,amount,true);			
		}else{
			
		}

	});
	
}

function trash(id,mennyiseg){
	bootbox.confirm('<h3>Biztos, hogy selejtbe rakja?</h3>',function (yes){
		if(yes){
			createTrash(id,mennyiseg);			
		}else{
			
		}
	});	
}
