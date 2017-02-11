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
	createOutput(id,mennyiseg,false);
}

function olderOutput(id,amount){
	bootbox.confirm('<h3>Régebbi termék biztos, hogy kiadja?</h3>',function (yes){
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
