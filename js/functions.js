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
			str += "<option value='zöldség'>zöldség</option>";
			str += "<option value='káposzta'>káposzta</option>";
			str += "<option value='gyümölcs'>gyümölcs</option>";
			str += "<option value='saláta'>saláta</option>";
			str += "<option value='egyéb'>egyéb</option>";
			str += "</select>";
			str += "</td>";
		str += "</tr>";
	str += "</table>";
	bootbox.alert(str);
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
		var nev = $('#ujalapnev').val()
		var kat = $('#ujalapkat').val()
		ujalapment(nev,kat)
		
	}else if(tipus == "ujbesz"){
		var nev = $('#ujbesznev').val()
		var cim = $('#ujbeszcim').val()
		ujbeszment(nev,cim)
	
	}else if(tipus == "editbesz"){
		var nev = $('#editbesznev').val()
		var cim = $('#editbeszcim').val()
		var id = $('#type').attr("id2");
		editbeszment(id,nev,cim)
	}else if(tipus == "editalap"){
		var nev = $('#editalapnev').val()
		var kat = $('#editalapkat').val()
		var id = $('#type').attr("id2");
		editalapment(id,nev,kat)
		
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
				str += "<option value='zöldség'"
				if(kat == 'zöldség'){
					str += 'selected';
				}
				str+= ">zöldség</option>";
				str += "<option value='káposzta'"
				if(kat == 'káposzta'){
					str += 'selected';
				}
				str += ">káposzta</option>";
				str += "<option value='gyümölcs'"
				if(kat == 'gyümölcs'){
					str += 'selected';
				}
				str += ">gyümölcs</option>";
				str += "<option value='saláta'"
					if(kat == 'saláta'){
						str += 'selected';
					}
					str += ">saláta</option>";
				str += "<option value='egyéb'"
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

