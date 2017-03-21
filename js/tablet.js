function goTo(url){
	location.href = url;
}

function input(e){
	var amount = $('#suly').val()
	
	if(!amount || parseInt(amount) <=0){
		bootbox.alert("Csak 0-nál nagyobb súlyút vételezhet be")
		return false;
	}
	
	e.preventDefault();     // stops default button action, e.g. submitting a form
    e.stopPropagation();
	var supplier = $('#besz').val()
	var product = $('#alap').val()
	
	
	var sumDifference = $('#sumDifference').val()
	var appearance = $('#appearance').val()
	var consistency = $('#consistency').val()
	var smell = $('#smell').val()
	var color = $('#color').val()
	var clearness = $('#clearness').val()
	var palletQuality = $('#palletQuality').val()
	var decision = $('#decision').val()
	  
	/*
	localStorage.supplier = supplier;
	localStorage.product = product;
	*/
	newQualityForm(sumDifference, appearance, consistency, smell, color,
			clearness, palletQuality, decision,product,supplier,amount)
	
	return false;
}

function inputMobile(e){
	var amount = $('#suly-mobile').val()
	if(!amount || parseInt(amount) <=0){
		bootbox.alert("Csak 0-nál nagyobb súlyút vételezhet be")
		return false;
	}
	
	e.preventDefault();     // stops default button action, e.g. submitting a form
    e.stopPropagation();
	var supplier = $('#besz-mobile').val()
	var product = $('#alap-mobile').val()
	
	
	var sumDifference = $('#sumDifference-mobile').val()
	var appearance = $('#appearance-mobile').val()
	var consistency = $('#consistency-mobile').val()
	var smell = $('#smell-mobile').val()
	var color = $('#color-mobile').val()
	var clearness = $('#clearness-mobile').val()
	var palletQuality = $('#palletQuality-mobile').val()
	var decision = $('#decision-mobile').val()
	  
	/*
	localStorage.supplier = supplier;
	localStorage.product = product;
	*/
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

function idkiadas(){
	var id = $("#idkiadasnum").val()
	window.location = "loadpallet.php?id="+id;
}
