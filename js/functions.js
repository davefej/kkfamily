
function bbsave(){
	var tipus = $('#type').val();
	
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
		newSupplier(name,address)
	
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
		var pallet_id = $('#type').attr("id2");
		var amount = $('#output_amount').val()		
		var max = $('#type').attr("max");
		var old = $('#type').attr("old");
		if(parseInt(max) < parseInt(amount)){
			bootbox.alert("Túl Nagy mennyiség, max:"+max);
		}else{
			newOutput(pallet_id,amount,old)
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
	}else if(tipus == "editSupplier"){
		
		var name = $('#edit_supplier_name').val()
		var address = $('#edit_supplier_address').val()
		var id = $('#type').attr("id2");
		updateSupplier(id,name,address)
		
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
		
		var name = $('#inventory_update_amount').val()		
		var id = $('#type').attr("id2");
		updateInventory(id,name)
		
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
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
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
				str += "<input type='text' maxlength='50' id='new_supplier_name'>";
			str += "</th>";
			str += "<td>";
			str += "<input type='text' maxlength='50' id='new_supplier_address'>";
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
}

function createUser(){
	var str = '<input type="hidden" id="type" value="createUser"/>';
	str += '<table class = "table table-hover">';
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
			str += "</th>";
			str += "<td>";
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
			str += "</th>";
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
			str += "</th>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
	
}

/////////////EDIT///////////

function editSupplier(id){
	var nev = $('#besznev_'+id).html();
	var cim = $('#beszcim_'+id).html();
	var str = '<input type="hidden" id="type" value="editSupplier" id2="'+id+'"/>';
	str += '<table class = "table table-hover">';
	str += "<thead>";
		str += "<tr>";
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
				str += "<input type='text' maxlength='50' value='"+nev+"' id='edit_supplier_name'>";
			str += "</th>";
			str += "<td>";
			str += "<input type='text' maxlength='50' value='"+cim+"' id='edit_supplier_address'>";
			str += "</td>";
		str += "</tr>";
str += "</table>";
	bootbox.alert(str);
	
}

function editProduct(id){
	var nev = $('#alapnev_'+id).html();
	var kat = $('#alapkat_'+id).html();
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
			str += "</th>";
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
			str += "</th>";
			
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
			str += "</th>";
			
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
			str += "</th>";
			str += "<td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
}

function inventory_update(id,amount){
	var str = '<input type="hidden" id="type" value="inventory_update" id2="'+id+'"/>';
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
				str += "<input type='text' maxlength='50' value="+amount+" id='inventory_update_amount'>";
			str += "<td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
}

///OTEHR/////////



function dailyOutput(){
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year  = new Date().getFullYear();
	if($("#detailscb").is(":checked")){
		detail = "true";
	}else{
		detail = "false";
	}
	window.location = "output.php?type=day&day="+year+"-"+month+"-"+day+"&detail="+detail;
}


function dailyInput(){
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year  = new Date().getFullYear();
	if($("#detailscb").is(":checked")){
		detail = "true";
	}else{
		detail = "false";
	}
	window.location = "input.php?type=day&day="+year+"-"+month+"-"+day+"&detail="+detail;
}

function dailySpare(){
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year  = new Date().getFullYear();
	if($("#detailscb").is(":checked")){
		detail = "true";
	}else{
		detail = "false";
	}
	window.location = "spare.php?type=day&day="+year+"-"+month+"-"+day+"&detail="+detail;
}

function monthlyOutput(){
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year  = new Date().getFullYear();
	if($("#detailscb").is(":checked")){
		detail = "true";
	}else{
		detail = "false";
	}
	window.location = "output.php?type=month&month="+year+"-"+month+"-01"+"&detail="+detail;
}


function monthlyInput(){
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year  = new Date().getFullYear();
	if($("#detailscb").is(":checked")){
		detail = "true";
	}else{
		detail = "false";
	}
	window.location = "input.php?type=month&month="+year+"-"+month+"-01"+"&detail="+detail;
}

function monthlySpare(){
	var day = $('#date_day').val()
	var month = $('#date_month').val()
	var year  = new Date().getFullYear();
	if($("#detailscb").is(":checked")){
		detail = "true";
	}else{
		detail = "false";
	}
	window.location = "spare.php?type=month&month="+year+"-"+month+"-01"+"&detail="+detail;
}

function filterProd(){
	var prod_id = $('#prod_select').val();
	window.location = "storage.php?filter=prod&id="+prod_id;
	
}

function filterProdOutput(){
	var prod_id = $('#prod_select').val();
	window.location = "kiadas.php?filter=prod&id="+prod_id;
	
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

function reloadQuality (){	
	var month = $('#date_month').val()
	var year  = new Date().getFullYear();
	window.location = "quality.php?date="+year+"-"+month+"-01";
}

