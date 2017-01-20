function ujbeszment(nev,cim){
	
	$.ajax({
        url: "helper/new.php",
        type: "post",
        data: JSON.stringify({
        	"nev":nev,
        	"cim":cim,
        	"type":"besz"
        }) ,
        cache: false,
        success: function (response) {           
        	location.reload();          
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //TODO
        }

    });
}

function ujalapment(nev,kategoria){
	
	$.ajax({
        url: "helper/new.php",
        type: "post",
        data: JSON.stringify({
        	"nev":nev,
        	"kategoria":kategoria,
        	"type":"alap"
        }) ,
        cache: false,
        success: function (response) {           
        	location.reload();       
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //TODO
        }

    });
}

function editbeszment(id,nev,cim){
	
	$.ajax({
        url: "helper/update.php",
        type: "post",
        data: JSON.stringify({
        	"id":id,
        	"nev":nev,
        	"cim":cim,
        	"type":"besz"
        }) ,
        cache: false,
        success: function (response) {           
        	location.reload();          
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //TODO
        }

    });

}

function editalapment(id,nev,kategoria){
	
	$.ajax({
        url: "helper/update.php",
        type: "post",
        data: JSON.stringify({
        	"id":id,
        	"nev":nev,
        	"kategoria":kategoria,
        	"type":"alap"
        }) ,
        cache: false,
        success: function (response) {           
        	location.reload();       
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //TODO
        }

    });
}

function bevetelsave(beszallito,alapanyag,suly){
	$.ajax({
        url: "../helper/new.php",
        type: "post",
        data: JSON.stringify({
        	"besz":beszallito,
        	"alap":alapanyag,
        	"suly":suly,
        	"type":"raktar"
        }) ,
        cache: false,
        success: function (response) {           
        	
        	location.reload();       
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //TODO
        }

    });
}

function kiad(id){
	$.ajax({
        url: "../helper/update.php",
        type: "post",
        data: JSON.stringify({
        	"id":id,
        	"type":"raktar"
        }) ,
        cache: false,
        success: function (response) {           
        	
        	location.reload();       
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //TODO
        }

    });
}


