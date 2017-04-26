function goTo(url){
	location.href = url;
}

function input(e){
	var amount = $('#suly').val()
	var sumDifference = $('#sumDifference').val()
	if(sumDifference == ""){
		sumDifference = "0";
	}
	var sumdiffint = parseInt(sumDifference);
	if(!amount || (parseInt(amount)+sumdiffint) <=0){
		bootbox.alert("Csak 0-nál nagyobb súlyút vételezhet be")
		return false;
	}else{
		amount = parseInt(amount)+sumdiffint;
		amount = amount+"";
	}
	
	e.preventDefault();     // stops default button action, e.g. submitting a form
    e.stopPropagation();
	var supplier = $('#besz').val()
	var product = $('#alap').val()
	
	
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year = $('#date_year').val()
	var day_exp = $('#date_day-expire').val()
	var month_exp = $('#date_month-expire').val()
	var year_exp = $('#date_year-expire').val()
	
	if(!expireOK(year_exp,month_exp,day_exp)){
		bootbox.alert("Hibás Lejárat!")
		return;
	}
	
	
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
			clearness, palletQuality, decision,product,supplier,amount,
			parseMyDate(year,month,day),
			parseMyDate(year_exp,month_exp,day_exp))
	
	return false;
}

function inputMobile(e){
	var amount = $('#suly-mobile').val()
	var sumDifference = $('#sumDifference-mobile').val()
	if(sumDifference == ""){
		sumDifference = "0";
	}
	var sumdiffint = parseInt(sumDifference);
	
	if(!amount || (parseInt(amount)+sumdiffint) <=0){
		bootbox.alert("Csak 0-nál nagyobb súlyút vételezhet be")
		return false;
	}else{
		amount = parseInt(amount)+sumdiffint;
		amount = amount+"";
	}
	
	
	e.preventDefault();     // stops default button action, e.g. submitting a form
    e.stopPropagation();
	var supplier = $('#besz-mobile').val()
	var product = $('#alap-mobile').val()
	
	
	var day = $('#date_day-mobile').val()
	var month = $('#date_month-mobile').val()
	var year = $('#date_year-expire-mobile').val()
	var day_exp = $('#date_day-expire-mobile').val()
	var month_exp = $('#date_month-expire-mobile').val()
	var year_exp = $('#date_year-expire-mobile').val()
	
	if(!expireOK(year_exp,month_exp,day_exp)){
		bootbox.alert("Hibás Lejárat!")
		return;
	}
	
	
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
			clearness, palletQuality, decision,product,supplier,amount,
			parseMyDate(year,month,day),
			parseMyDate(year_exp,month_exp,day_exp))
	
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

if (typeof String.prototype.startsWith != 'function') {
	  // see below for better implementation!
	  String.prototype.startsWith = function (str){
	    return this.indexOf(str) === 0;
	  };
}

function parseMyDate(year,month,day){
	if(year == "" || month == "" || day == ""){
		return "NULL";
	}else{
		
		var today = new Date();
		var otherDate = new Date(year+"-"+month+"-"+day);
		var isToday = (today.toDateString() == otherDate.toDateString());
		if(isToday){
			return "NULL";
		}else{
			return year+"-"+month+"-"+day
		}
	}
}

function expireOK(year,month,day){
	if(year == "" || month == "" || day == ""){
		
	}else{
		var today = new Date();
		var otherDate = new Date(year+"-"+month+"-"+day);
		if(today.getTime() > otherDate.getTime()){
			return false;
		}
	}
	return true;
}

function outputDate(){
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year = $('#date_year').val()
	return parseMyDate(year,month,day);
}