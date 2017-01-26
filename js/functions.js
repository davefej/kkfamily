
function bbsave(){
	var tipus = $('#type').val();
	
	if(tipus == "createProduct"){
		
		var name = $('#new_prod_name').val()
		var category_id = $('#new_prod_cat').val()
		newProduct(name,category_id,0)
		
	}else if(tipus == "createSupplier"){
		
		var name = $('#new_supplier_name').val()
		var address = $('#new_supplier_address').val()
		newSupplier(name,address)
	
	}else if(tipus == "createUser"){
		
		var name = $('#new_user_name').val()
		var pass = $('#new_user_pass').val()
		newUser(name,pass)
	
	}else if(tipus == "createCategory"){
		
		var name = $('#new_category_name').val()		
		
		newCategory(name)
		
	}else if(tipus == "createOutput"){
		var pallet_id = $('#type').attr("id2");
		var amount = $('#output_amount').val()		
		
		newOutput(pallet_id,amount)
		
	}else if(tipus == "createTrash"){
		var pallet_id = $('#type').attr("id2");
		var amount = $('#trash_amount').val()		
		
		newTrash(pallet_id,amount)
		
	}else if(tipus == "editSupplier"){
		
		var name = $('#edit_supplier_name').val()
		var address = $('#edit_supplier_address').val()
		var id = $('#type').attr("id2");
		updateSupplier(id,name,address)
		
	}else if(tipus == "editProduct"){
		
		var name = $('#edit_prod_name').val()
		var category_id = $('#edit_prod_cat').val()
		var id = $('#type').attr("id2");
		updateProduct(id,name,category_id,0)
		
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
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' id='new_prod_name'>";
			str += "</th>";
			str += "<td>";
			str += $('#category_container').html().replace("#_#","new_prod_cat");
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

function createOutput(pallet_id,full){
	var str = '<input type="hidden" id="type" value="createOutput" id2="'+pallet_id+'"/>';
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
				str += "<input type='number' maxlength='50' value='"+full+"' id='output_amount'>";
			str += "</th>";
			str += "<td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
	
}

function createTrash(pallet_id,full){
	var str = '<input type="hidden" id="type" value="createTrash" id2="'+pallet_id+'"/>';
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
			str += "<td>";
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
		str += "</tr>";
	str += "</thead>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' value='"+nev+"' id='edit_prod_name'>";
			str += "</th>";
			str += "<td>";
			str += $('#category_container').html().replace("#_#","edit_prod_cat");
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

