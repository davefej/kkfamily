
function bbsave(){
	var tipus = $('#type').val();
	
	if(tipus == "reload"){
		location.reload();
	}	
	if(tipus == "createProduct"){
		
		var name = $('#new_prod_name').val()
		var category_id = $('#new_prod_cat').val()
		var min = $('#new_prod_min').val()
		var expire = $('#new_prod_exp').val()
		var unit = $('#new_prod_unit').val()
		
		newProduct(name,category_id,min,expire,unit,0)
		
	}else if(tipus == "createSupplier"){
		
		var name = $('#new_supplier_name').val()
		var address = $('#new_supplier_address').val()
		var code = $('#new_supplier_code').val()
		newSupplier(name,address,code)
	
	}else if(tipus == "createUser"){
		
		var name = $('#new_user_name').val()
		var pass = $('#new_user_pass').val()
		var type = $('#new_user_type').val()
		if(type == "Raktáros"){
			type = 1;
		}
		newUser(name,pass,type)
	
	}else if(tipus == "createCategory"){
		
		var name = $('#new_category_name').val()		
		
		newCategory(name)
		
	}else if(tipus == "createOutput"){
		
		var date = outputDate();
		
		var pallet_id = $('#type').attr("id2");
		var amount = $('#output_amount').val()		
		var max = $('#type').attr("max");
		var old = $('#type').attr("old");
		if(parseInt(max) < parseInt(amount)){
			bootbox.alert("Túl Nagy mennyiség, max:"+max);
		}else{
			bootbox.confirm('<h3>Biztos kiadja?<br>Mennyiség: '+amount+'</h3>',function (yes){
				if(yes){
					newOutput(pallet_id,amount,old,date);			
				}
			});
		}
		
		
	}else if(tipus == "createTrash"){
		var pallet_id = $('#type').attr("id2");
		var amount = $('#trash_amount').val()		
		var max = $('#type').attr("max");
		if(parseInt(max) < parseInt(amount)){
			bootbox.alert("Túl Nagy mennyiség, max:"+max);
		}else{
			newTrash(pallet_id,amount)
		}
	}else if(tipus == "createReverseOutput"){
		var output_id = $('#type').attr("id2");
		var amount = $('#reverse_output_amount').val()		
		var max = $('#type').attr("max");
		
		
		if(parseInt(max) <= parseInt(amount) || amount < 1){
			bootbox.alert("Hibás mennyiség, min:1 max:"+(max-1));
		}else{
			reverseOutputServer(output_id,max-amount)
		}
	} else if(tipus == "editSupplier"){
		
		var name = $('#edit_supplier_name').val()
		var address = $('#edit_supplier_address').val()
		var code = $('#edit_supplier_code').val()
		var id = $('#type').attr("id2");
		updateSupplier(id,name,address, code)
		
	}else if(tipus == "editProduct"){
		
		var name = $('#edit_prod_name').val()
		var category_id = $('#edit_prod_cat').val()
		var min = $('#edit_prod_min').val()
		var expire = $('#edit_prod_exp').val()
		var unit = $('#edit_prod_unit').val()
		var id = $('#type').attr("id2");
		updateProduct(id,name,category_id,min,expire,unit,0)
		
	}else if(tipus == "editUserName"){
		
		var name = $('#edit_user_name').val()		
		var id = $('#type').attr("id2");
		updateUserName(id,name)
		
	}else if(tipus == "editUserPass"){
		
		var password = $('#edit_user_pass').val()		
		var id = $('#type').attr("id2");
		updateUserPass(id,password)
		
	}else if(tipus == "editCategory"){
		
		var name = $('#edit_category_name').val()		
		var id = $('#type').attr("id2");
		updateCategory(id,name)
		
	}else if(tipus == "inventory_update"){
		
		var time = $('#inventory_update_time').val()
		var date = Date.parse(time);
		if(isNaN(date)){
			bootbox.alert("Hibás Dátum mező formátum ÉÉÉÉ-HH-NN ÓÓ:PP:MM")
			return;
		}
		
		var amount = $('#inventory_update_amount').val()		
		var id = $('#type').attr("id2");
		var output_trash = $('#type').attr("output_trash");
		amount = parseInt(amount)
		output_trash = parseInt(output_trash)
		if(isNaN(output_trash) || isNaN(amount)){
			bootbox.alert("HIBA a Mennyiség értékben");
			return;
		}
		amount = parseInt(amount + output_trash)
		
		updateInventory(id,amount.toString(),time)
		
	}
	
}


/////////////CREATE///////////


function createProduct(){
	
	var str = '<input type="hidden" id="type" value="createProduct"/>';
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
			str += "<th>";
				str += "Név";
			str += "</th>";
			str += "<th>";
				str += "Kategória";
			str += "</th>";
			str += "<th>";
				str += "Jelzési Mennyiség";
			str += "</th>";
			str += "<th>";
				str += "Lejárat";
			str += "</th>";
			str += "<th>";
				str += "Egység";
			str += "</th>";
		str += "</th>";	
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' id='new_prod_name'>";
			str += "</th>";
			str += "<td>";
			str += $('#category_container').html().replace("#_#","new_prod_cat");
			str += "</td>";
			str += "<td>";
				str += "<input type='number' style='width:60px;' maxlength='50' id='new_prod_min'>";
			str += "</td>";
			str += "<td>";
				str += "<input type='number' style='width:60px;' maxlength='50' id='new_prod_exp'>";
			str += "</td>";
			str += "<td>";
				str += "<input type='text' value='kg' style='width:60px;' maxlength='50' id='new_prod_unit'>";
			str += "</td>";			
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
}

function createSupplier(){
	var str = '<input type="hidden" id="type" value="createSupplier"/>';
	str += '<table class = "table table-default">';
	str += "<thead>";
		str += "<tr>";
			str += "<th>";
				str += "Ügyfélkód";
			str += "</th>";
			str += "<th>";
				str += "Név";
			str += "</th>";
			str += "<th>";
				str += "Cím";
			str += "</th>";
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' id='new_supplier_code'>";
			str += "</td>";
			str += "<td>";
				str += "<input type='text' maxlength='50' id='new_supplier_name'>";
			str += "</td>";
			str += "<td>";
			str += "<input type='text' maxlength='50' id='new_supplier_address'>";
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
}

function createUser(){
	var str = '<input type="hidden" id="type" value="createUser"/>';
	str += '<table class = "table table-hover" style="width: 100%;">';
	str += "<thead>";
		str += "<tr>";
			str += "<th>";
				str += "Név";
			str += "</th>";
			str += "<th>";
				str += "Jelszó";
			str += "</th>";
			str += "<th>";
				str += "Jogosultság";
			str += "</th>";
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' id='new_user_name'>";
			str += "</th>";
			str += "<td>";
			str += "<input type='name' maxlength='50' id='new_user_pass'>";
			str += "</td>";
			str += "<td>";
				str += "<select id='new_user_type'>";
					str += "<option val='0'>Admin</option>";
					str += "<option val='1'>Raktáros</option>";
				str += "</select>";
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
}

function createCategory(){
	var str = '<input type="hidden" id="type" value="createCategory"/>';
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
			str += "<th>";
				str += "Név";
			str += "</th>";
			
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' id='new_category_name'>";
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
}

function createOutput(pallet_id,full,old){
	var str = '<input type="hidden" id="type" value="createOutput" id2="'+pallet_id+'" max="'+full+'" old="'+old+'"/>';
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
			str += '<th>';
				str += "Mennyiség";
			str += "</th>";			
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='number' maxlength='50' value='"+full+"' id='output_amount' style='font-size: 130%; '>";
			str += "</td>";
		str += "</tr>";
		str += "<tr>";
			str += "<td>";
				str += global_date_str;
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
	
}

function createTrash(pallet_id,full){
	var str = '<input type="hidden" id="type" value="createTrash" id2="'+pallet_id+'" max="'+full+'"/>';
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
			str += "<th>";
				str += "Mennyiség";
			str += "</th>";			
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='number' maxlength='50' value='"+full+"' id='trash_amount'>";
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
	
}

function reverseOutput(outputid,max){
	var str = '<input type="hidden" id="type" value="createReverseOutput" id2="'+outputid+'" max="'+max+'" />';
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
			str += '<th>';
				str += "Vissza vételezési mennyiség minimum 1, maximum "+(max-1)+" ";
			str += "</th>";			
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='number' maxlength='50' value='0' id='reverse_output_amount' style='font-size: 130%; '>";
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
	
}

/////////////EDIT///////////

function editSupplier(id){
	var nev = $('#besznev_'+id).html();
	var cim = $('#beszcim_'+id).html();
	var code = $('#beszkod_'+id).html();
	var str = '<input type="hidden" id="type" value="editSupplier" id2="'+id+'"/>';
	str += '<table class = "table table-default">';
	str += "<thead>";
		str += "<tr>";
			str += "<th>";
				str += "Ügyfélkód";
			str += "</th>";
			str += "<th>";
				str += "Név";
			str += "</th>";
			str += "<th>";
				str += "Cím";
			str += "</th>";
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' value='"+code+"' id='edit_supplier_code'>";
			str += "</td>";
			str += "<td>";
				str += "<input type='text' maxlength='50' value='"+nev+"' id='edit_supplier_name'>";
			str += "</td>";
			str += "<td>";
			str += "<input type='text' maxlength='50' value='"+cim+"' id='edit_supplier_address'>";
			str += "</td>";
		str += "</tr>";
str += "</table>";
	bootbox.alert(str);
	
}

function editProduct(id){
	var nev = $('#alapnev_'+id).html();
	var kat = $('#alapkat_'+id).attr("catid");
	var min = $('#alapmin_'+id).html();
	var exp = $('#alapexp_'+id).html();
	var unit = $('#alapunit_'+id).html();
	
	var str = '<input type="hidden" id="type" value="editProduct" id2="'+id+'"/>';
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
			str += "<th>";
				str += "Név";
			str += "</th>";
			str += "<th>";
				str += "Kategória";
			str += "</th>";
			str += "<th>";
				str += "Jelzési Mennyiség";
			str += "</th>";
			str += "<th>";
				str += "Lejárat";
			str += "</th>";	str += "<th>";
				str += "Egység";
			str += "</th>";				
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' value='"+nev+"' id='edit_prod_name'>";
			str += "</td>";
			str += "<td>";
				str += $('#category_container').html().replace("#_#","edit_prod_cat");
			str += "</td>";
			str += "<td>";
				str += "<input type='number' style='width: 60px;' maxlength='10' value='"+min+"' id='edit_prod_min'>";
			str += "</td>";
			str += "<td>";
				str += "<input type='number' style='width: 60px;' maxlength='10' value='"+exp+"' id='edit_prod_exp'>";
			str += "</td>";
			str += "<td>";
				str += "<input type='text' style='width: 60px;' maxlength='10' value='"+unit+"' id='edit_prod_unit'>";
			str += "</td>";
			
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
	$('#edit_prod_cat').val(kat);

}

function editUserName(id){
	
	var nev = $('#username_'+id).html();
	var str = '<input type="hidden" id="type" value="editUserName" id2="'+id+'"/>';
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
			str += "<th>";
				str += "Név";
			str += "</th>";
			
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' value='"+nev+"' id='edit_user_name'>";
			str += "</td>";
			
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);

}

function editUserPass(id){	
	

	var str = '<input type="hidden" id="type" value="editUserPass" id2="'+id+'"/>';
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
			str += "<th>";
				str += "Jelszó";
			str += "</th>";
	str += "</thead>";		
		str += "</tr>";
	
		str += "<tr>";
			str += "<td>";
				str += "<input type='password' maxlength='50'  id='edit_user_pass'>";
			str += "</td>";
			
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);

}

function editCategory(id){
	var nev = $('#categoryname_'+id).html();
	var str = '<input type="hidden" id="type" value="editCategory" id2="'+id+'"/>';
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
			str += "<th>";
				str += "Név";
			str += "</th>";
			
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' value="+nev+" id='edit_category_name'>";
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
}

function inventory_update(id,amount,time,orig){
	orig = parseInt(orig)
	amount1 = parseInt(amount)
	if(isNaN(orig) || isNaN(amount1)){
		bootbox.alert("HIBA a Mennyiség értékben");
		return;
	}
		var output_trash = orig-amount1;
	var str = '<input type="hidden" id="type" value="inventory_update" output_trash="'+output_trash+'" id2="'+id+'"/>';
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
			str += "<th>";
				str += "Mennyiség";
			str += "</th>";	
			str += "<th>";
				str += "IDŐ";
			str += "</th>";	
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='number' maxlength='50' value="+amount+" id='inventory_update_amount'>";
			str += "</td>";
		str += "<td>";
			str += "<input type='text' maxlength='50' value='"+time+"' id='inventory_update_time'>";
		str += "</td>";
	str += "</tr>";
str += "</table>";
	bootbox.alert(str);
}

///OTHER/////////



function outputfilter(){
	var dates = MyDateParse();
	if($("#detailscb").is(":checked")){
		detail = "true";
	}else{
		detail = "false";
	}
	window.location = "output.php?from="+dates.from+"&to="+dates.to+"&detail="+detail;
}


function inputfilter(){
	var dates = MyDateParse();
	if($("#detailscb").is(":checked")){
		detail = "true";
	}else{
		detail = "false";
	}
	var supp_opt = $('#supp_opt').val()
	window.location = "input.php?from="+dates.from+"&to="+dates.to+"&detail="+detail+"&supp="+supp_opt;
}

function sparefilter(){
	var dates = MyDateParse();
	
	if($("#detailscb").is(":checked")){
		detail = "true";
	}else{
		detail = "false";
	}
	var supp_opt = $('#supp_opt').val()
	window.location = "spare.php?from="+dates.from+"&to="+dates.to+"&detail="+detail+"&supp="+supp_opt;
}

function filterProd(){
	var prod_id = $('#prod_select').val();
	window.location = "storage.php?filter=prod&id="+prod_id;
}

function filterInventoryProd(){
	var prod_id = $('#prod_select').val();
	window.location = "inventory.php?filter=prod&id="+prod_id;	
}

function filterProdOutput(mobile){
	if(mobile){
		var prod_id = $('#prod_select_mobile').val();
		window.location = "kiadas.php?filter=prod&id="+prod_id;
	}
	else{
		var prod_id = $('#prod_select').val();
		window.location = "kiadas.php?filter=prod&id="+prod_id;
	}
}

function filterCategory(){
	var cat_id = $('#cat_select').val();
	window.location = "storage.php?filter=cat&id="+cat_id;
}

function makesound(){	
	 var audio = document.getElementById("audio");
     audio.play();
}

String.prototype.replaceAt=function(index, character) {
    return this.substr(0, index) + character + this.substr(index+character.length);
}

function inputchangeday(){
	var wday = $('#wday').val()
	
	$.ajax({
        url: "../helper/ajaxcontent.php?type=fogyas&wday="+wday,
        type: "get",
        cache: false,
        success: function (response) {        	
        	$("#adminstatisticcontainer").html(response);
        },
        error: function(jqXHR, textStatus, errorThrown) {
        	bootbox.alert("Internet vagy szerver hiba<br/>"+textStatus+"<br/>"+errorThrown)
        }
    });
	
}

function changecolor(i){
	switch(i){
		case 0:
		$('body').css({
		    background: "-webkit-gradient(linear, left top, left bottom, from(#00767F), to(#E3F9FF))",
		    "background-repeat": "no-repeat"
		});
		break;		
		case 1:
			$('body').css({
				background:"url(../img/bg.jpg)",
			    "background-attachment": "fixed"
			});
			break;
		case 2:
			$('body').css({
			    background: "-webkit-gradient(linear, left top, left bottom, from(#4CAF50), to(green))",
			    "background-repeat": "no-repeat"
			});
			break;
		case 3:
			$('body').css({
			    background: "-webkit-gradient(linear, left top, left bottom, from(#FFC107), to(#FFEB3B))",
			    "background-repeat": "no-repeat" 
			});
			break;
		
	}
	localStorage.color = i;
	saveColor({
		"type":"theme",
		"theme":i
	});
}

function reloadMonthlyQuality (){	
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year  = $('#date_year').val()

	if($("#detailscb").is(":checked")){
		detail = "true";
	}else{
		detail = "false";
	}
	
	window.location = "quality.php?type=month&month="+year+"-"+month+"-01&summary="+detail;
}

function reloadDailyQuality (){
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year  = $('#date_year').val()
	var qualityfilter = $('#qualityfilter').val()
	if($("#detailscb").is(":checked")){
		detail = "true";
	}else{
		detail = "false";
	}
	
	window.location = "quality.php?type=day&day="+year+"-"+month+"-"+day+"&filter="+qualityfilter+"&summary="+detail;
}

function loadSupply(){
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year = $('#date_year').val()
	if($("#detailscb").is(":checked")){
		var detail = "true";
	}else{
		var detail = "false";
	}
	window.location = "supply.php?month="+month+"&day="+day+"&year="+year+"&details="+detail;
}

function follow(){
	var id = $('#followpalletid').val()
	window.location = "follow.php?id="+id;
}

function followProd(){
	var dates = MyDateParse()
	var id = $('#follow_prod_select').val()
	var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
	var firstDate = new Date(dates.from);
	var secondDate = new Date(dates.to);
	
	var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
	window.location = "follow.php?prodid="+id+"&from="+dates.from+"&to="+dates.to+"&diff="+diffDays;
}

function startPrint(data,keys,header){
	/*
	 * var supply = [
		{
		       name: 'John Doe',
		       email: 'john@doe.com',
		       phone: '111-111-1111'
		    },
		    {
		       name: 'Barry Allen',
		       email: 'barry@flash.com',
		       phone: '222-222-2222'
		    },
		    {
		       name: 'Cool Dude',
		       email: 'cool@dude.com',
		       phone: '333-333-3333'
		    }
	]
	printJS({
			printable: supply, 
			properties: ['name', 'email', 'phone'], 
			type: 'json',
			header: ""
		})
		*/
	printJS({
			printable: data, 
			properties: keys, 
			type: 'json',
			header: header
		})
	
}

function startCSV(data,keys,header){
	var csv = "";
	for(var i in keys){
		csv += keys[i]+";"; 
	}
	csv += "\n";
	for(var j in data){
		
		for(var i in keys){
			csv += data[j][keys[i]]+";"; 
		}
		csv += "\n";
	}
	
	var uri = 'data:text/csv;charset=utf-8,' + escape(csv);
    
    // Now the little tricky part.
    // you can use either>> window.open(uri);
    // but this will not work in some browsers
    // or you will not get the correct file extension    
    
    //this trick will generate a temp <a /> tag
    var link = document.createElement("a");    
    link.href = uri;
    
    //set the visibility hidden so it will not effect on your web-layout
    link.style = "visibility:hidden";
    link.download = header + ".csv";
    
    //this part will append the anchor tag and remove it after automatic click
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function supplyPrint(){
	
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year = $('#date_year').val()
	$.ajax({
        url: "../helper/ajaxcontent.php?type=supplyprint&day="+day+"&month="+month+"&year="+year,
        type: "get",
        cache: false,
        success: function (response) {        	
        	if(response){
        		startPrint(
        				JSON.parse(response),
        				["terméknév","mennyiség"],
        				"NYITÓ KÉSZLET "+year+"-"+month+"-"+day
        		)	
        	}
        },
        error: function(jqXHR, textStatus, errorThrown) {
        	bootbox.alert("Internet vagy szerver hiba<br/>"+textStatus+"<br/>"+errorThrown)
        }
    });
}

function supplyCSV(){
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year = $('#date_year').val()
	$.ajax({
        url: "../helper/ajaxcontent.php?format=csv&type=supplyprint&day="+day+"&month="+month+"&year="+year,
        type: "get",
        cache: false,
        success: function (response) {        	
        	if(response){
        		startCSV(
        				JSON.parse(response),
        				["terméknév","mennyiség","egység"],
        				"NYITÓ KÉSZLET "+year+"-"+month+"-"+day
        		)        		
        	}
        },
        error: function(jqXHR, textStatus, errorThrown) {
        	bootbox.alert("Internet vagy szerver hiba<br/>"+textStatus+"<br/>"+errorThrown)
        }
    });
}

function statisticsPrint(){
	var today = new Date();
	today.setDate(today.getDate() + 1);
	var tomorrow = today.toISOString().substring(0, 10);
	var arr = [];
	$('.statistic_amountinput').each(function() {
		arr.push({
			"termék":$(this).attr( "prodname" ),
			"mennyiség":$(this).val()+" "+$(this).attr( "unit" )
		})
	   
	});
	
	startPrint(
			arr,
			["termék","mennyiség"],
			"Napi Feladás "+tomorrow
	)	
}


function statisticsCSV(){
	var today = new Date();
	today.setDate(today.getDate() + 1);
	var tomorrow = today.toISOString().substring(0, 10);
	var arr = [];
	$('.statistic_amountinput').each(function() {
		arr.push({
			"termék":$(this).attr("prodname"),
			"mennyiség":$(this).val(),
			"egység":$(this).attr("unit")
		})
	   
	});
	
	startCSV(
			arr,
			["termék","mennyiség","egység"],
			"Napi Feladás "+tomorrow
	)
}

function sparePrint(){
	var data = $('#printhelper_json').html()
	data = JSON.parse(data);
	var details = $('#printhelper_json').attr("detail") == "1";
	var title = $('#printhelper_json').attr("title")
	
	if(details){
		title += " (Részletes)";
		headers = ["termék","mennyiség","bevétel","selejt","beszállító"];
	}else{
		title += " (Összegzett)";
		headers = ["termék","mennyiség"];
	}
	startPrint(
			data,
			headers,
			title
	)
}

function spareCSV(){
	var data = $('#printhelper_json').html()
	data = JSON.parse(data);
	var details = $('#printhelper_json').attr("detail") == "1";
	var title = $('#printhelper_json').attr("title")
	
	if(details){
		title += " (Részletes)";
		headers = ["termék","mennyiség","egység","bevétel","selejt","beszállító"];
	}else{
		title += " (Összegzett)";
		headers = ["termék","mennyiség","egység"];
	}
	startCSV(
			data,
			headers,
			title
	)
}


function outputPrint(){
	var data = $('#printhelper_json').html()
	data = JSON.parse(data);
	var details = $('#printhelper_json').attr("detail") == "1";
	var title = $('#printhelper_json').attr("title")
	
	if(details){
		title += " (Részletes)";
		headers = ["termék","mennyiség","bevétel","kiadás","beszállító"];
	}else{
		title += " (Összegzett)";
		headers = ["termék","mennyiség"];
	}
	startPrint(
			data,
			headers,
			title
	)
}

function outputCSV(){
	var data = $('#printhelper_json').html()
	data = JSON.parse(data);
	var details = $('#printhelper_json').attr("detail") == "1";
	var title = $('#printhelper_json').attr("title")
	
	if(details){
		title += " (Részletes)";
		headers = ["termék","mennyiség","egység","bevétel","kiadás","beszállító"];
	}else{
		title += " (Összegzett)";
		headers = ["termék","mennyiség","egység"];
	}
	startCSV(
			data,
			headers,
			title
	)
}


function inputPrint(){
	
	var data = $('#printhelper_json').html()
	data = JSON.parse(data);
	var details = $('#printhelper_json').attr("detail") == "1";
	var title = $('#printhelper_json').attr("title")
	
	if(details){
		title += " (Részletes)";
		headers = ["termék","mennyiség","bevétel","beszállító"];
	}else{
		title += " (Összegzett)";
		headers = ["termék","mennyiség"];
	}
	startPrint(
			data,
			headers,
			title
	)
}

function inputCSV(){
	
	var data = $('#printhelper_json').html()
	data = JSON.parse(data);
	var details = $('#printhelper_json').attr("detail") == "1";
	var title = $('#printhelper_json').attr("title")
	
	if(details){
		title += " (Részletes)";
		headers = ["termék","mennyiség","egység","bevétel","beszállító"];
	}else{
		title += " (Összegzett)";
		headers = ["termék","mennyiség","egység"];
	}
	startCSV(
			data,
			headers,
			title
	)
}

function qualityPrint(){
	var data = $('#printhelper_json').html()
	data = JSON.parse(data);
	var details = $('#printhelper_json').attr("detail") == "1";
	var title = $('#printhelper_json').attr("title")
	
	if(details){
		title += " (Részletes)";
		headers = ["termék","mennyiség","bevétel","beszállító",
			"megjelenés","állag","illat","szín","tisztaság-hőfok","raklap-minőség","döntés"];
	}else{
		title += " (Összegzett)";
		headers = ["termék","mennyiség","beszállító",
			"megjelenés","állag","illat","szín","tisztaság-hőfok","raklap-minőség","döntés"];
	}
	startPrint(
			data,
			headers,
			title
	)
}


function qualityCSV(){
	var data = $('#printhelper_json').html()
	data = JSON.parse(data);
	var details = $('#printhelper_json').attr("detail") == "1";
	var title = $('#printhelper_json').attr("title")
	
	if(details){
		title += " (Részletes)";
		headers = ["termék","mennyiség","egység","bevétel","beszállító",
			"megjelenés","állag","illat","szín","tisztaság-hőfok","raklap-minőség","döntés"];
	}else{
		title += " (Összegzett)";
		headers = ["termék","mennyiség","egység","beszállító",
			"megjelenés","állag","illat","szín","tisztaság-hőfok","raklap-minőség","döntés"];
	}
	startCSV(
			data,
			headers,
			title
	)
}

function daysInMonth(iMonth, iYear)
{
    return new Date(iYear, iMonth, 0).getDate();
}

function MyDateParse(){
	var day = $('#date_day_from').val()
	var month = $('#date_month_from').val()	
	var year = $('#date_year_from').val()
	var day2 = $('#date_day_to').val()
	var month2 = $('#date_month_to').val()	
	var year2 = $('#date_year_to').val()	
	if(!month){
		bootbox.alert("Nincs hónap kiválasztva!");
		return;
	}
	if(!day){
		day = "01";
		day2 = daysInMonth(parseInt(year),parseInt(day));
		month2 = month;
	}else{
		if(!month2){
			month2 = month;
		}
		if(!day2){
			day2 = day;
		}
	}
	return {
		"from":year+"-"+month+"-"+day,
		"to":year2+"-"+month2+"-"+day2
	};
}