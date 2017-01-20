function goTo(url){
	location.href = url;
}

function bevetel(){
	var beszallito = $('#besz').val()
	var alapanyag = $('#alap').val()
	var suly = $('#suly').val()
	bevetelsave(beszallito,alapanyag,suly)
}

