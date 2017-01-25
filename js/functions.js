function ujalap(){
	
	var str = '<input type="hidden" id="type" value="ujalap"/>';
	str += "<table align='center'>";
		str += "<tr>";
			str += "<th>";
				str += "Név";
			str += "</th>";
			str += "<th>";
				str += "Kategória";
			str += "</th>";
		str += "</tr>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' id='ujalapnev'>";
			str += "</th>";
			str += "<td>";
			str += "<select id='ujalapkat'>";
			str += "<option value='1'>zöldség</option>";
			str += "<option value='2'>káposzta</option>";
			str += "<option value='3'>gyümölcs</option>";
			str += "<option value='4'>saláta</option>";
			str += "<option value='5'>egyéb</option>";
			str += "</select>";
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert("Hello");
}


function ujbesz(){
	var str = '<input type="hidden" id="type" value="ujbesz"/>';
	str += "<table align='center'>";
		str += "<tr>";
			str += "<th>";
				str += "Név";
			str += "</th>";
			str += "<th>";
				str += "Cím";
			str += "</th>";
		str += "</tr>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' id='ujbesznev'>";
			str += "</th>";
			str += "<td>";
			str += "<input type='text' maxlength='50' id='ujbeszcim'>";
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
}

function bbsave(){
	var tipus = $('#type').val();
	if(tipus == "ujalap"){
		var name = $('#ujalapnev').val()
		var category_id = $('#ujalapkat').val()
		newProduct(name,category_id,0)
		
	}else if(tipus == "ujbesz"){
		var name = $('#ujbesznev').val()
		var address = $('#ujbeszcim').val()
		newSupplier(name,address)
	
	}else if(tipus == "editbesz"){
		var name = $('#editbesznev').val()
		var address = $('#editbeszcim').val()
		var id = $('#type').attr("id2");
		updateSupplier(id,name,address)
	}else if(tipus == "editalap"){
		var name = $('#editalapnev').val()
		var category_id = $('#editalapkat').val()
		var id = $('#type').attr("id2");
		updateProduct(id,name,category_id,0)
		
	}
	
	
	
}


function editbeszallito(id){
	var nev = $('#besznev_'+id).html();
	var cim = $('#beszcim_'+id).html();
	var str = '<input type="hidden" id="type" value="editbesz" id2="'+id+'"/>';
	str += "<table align='center'>";
	str += "<tr>";
		str += "<th>";
			str += "Név";
		str += "</th>";
		str += "<th>";
			str += "Cím";
		str += "</th>";
	str += "</tr>";
	str += "<tr>";
		str += "<td>";
			str += "<input type='text' maxlength='50' value='"+nev+"' id='editbesznev'>";
		str += "</th>";
		str += "<td>";
		str += "<input type='text' maxlength='50' value='"+cim+"' id='editbeszcim'>";
		str += "</td>";
	str += "</tr>";
str += "</table>";
	bootbox.alert(str);
	
}

function editalap(id){
	var nev = $('#alapnev_'+id).html();
	var kat = $('#alapkat_'+id).html();
	var str = '<input type="hidden" id="type" value="editalap" id2="'+id+'"/>';
	str += "<table align='center'>";
		str += "<tr>";
			str += "<th>";
				str += "Név";
			str += "</th>";
			str += "<th>";
				str += "Kategória";
			str += "</th>";
		str += "</tr>";
		str += "<tr>";
			str += "<td>";
				str += "<input type='text' maxlength='50' value='"+nev+"' id='editalapnev'>";
			str += "</th>";
			str += "<td>";
			str += "<select id='editalapkat'>";
				str += "<option value='1'"
				if(kat == 'zöldség'){
					str += 'selected';
				}
				str+= ">zöldség</option>";
				str += "<option value='2'"
				if(kat == 'káposzta'){
					str += 'selected';
				}
				str += ">káposzta</option>";
				str += "<option value='3'"
				if(kat == 'gyümölcs'){
					str += 'selected';
				}
				str += ">gyümölcs</option>";
				str += "<option value='4'"
					if(kat == 'saláta'){
						str += 'selected';
					}
					str += ">saláta</option>";
				str += "<option value='5'"
				if(kat == 'egyéb'){
					str += 'selected';
				}
				str += ">egyéb</option>";				
			str += "</select>";
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
	
}

