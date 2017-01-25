
//////////////////////////////
/***********INSERT***********/
//////////////////////////////

function newCategory(name){
	insert({
    	"name":name,
    	"type":"category"
    });
}


function newUser(name){
	insert({
    	"name":name,
    	"type":"user"
    });
}

function newSupplier(name,address){
	insert({
    	"name":name,
    	"address":address,
    	"type":"supplier"
    });
	
}

function newProduct(name,category_id,product_type){	
	insert({
    	"name":name,
    	"category_id":category_id,
    	"product_type":product_type,
    	"type":"product"
	});
}


function newTrash(pallet_id,amount,user_id){	
	insert({
    	"pallet_id":pallet_id,
    	"amount":amount,
    	"user_id":user_id,
    	"type":"trash"
	},true);
}

function newPallet(product_id,supplier_id,amount,user_id){	
	insert({
    	"product_id":product_id,
    	"supplier_id":supplier_id,
    	"amount":amount,
    	"user_id":user_id,
    	"type":"pallet"
	},true);
}

function newOutput(pallet_id,amount,user_id){	
	insert({
    	"pallet_id":pallet_id,
    	"amount":amount,
    	"user_id":user_id,
    	"type":"output"
	},true);
}


function insert(json,tablet){
	if(tablet){
		var url= "../helper/insert.php";
	}else{
		var url= "/helper/insert.php";
	}
	$.ajax({
        url: url,
        type: "post",
        data: JSON.stringify(json) ,
        cache: false,
        success: function (response) {           
        	location.reload();          
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //TODO
        }
    });
}

//////////////////////////////
/***********UPDATE***********/
//////////////////////////////

function updateCategory(id,name){
	update({
		"id":id,
		"name":name,
		"type":"category"
	});
}

function updateUser(id,name){
	update({
		"id":id,
		"name":name,
		"type":"user"
	});
}

function updateSupplier(id,name,address){
	update({
		"id":id,
		"name":name,
		"address":address,
		"type":"supplier"
	});
}

function updateProduct(id,name,category_id,product_type){
	update({
		"id":id,
		"name":name,
		"category_id":category_id,
		"product_type":product_type,
		"type":"product"
	});
}

function updateTrash(id,pallet_id,amount,time,user_id){
	update({
		"id":id,
		"pallet_id":pallet_id,
		"amount":amount,
		"time":time,
		"user_id":user_id,
		"type":"trash"
	});
}

function updatePallet(id,product_id,supplier_id,time,amount,user_id){
	update({
		"id":id,
		"product_id":product_id,
		"supplier_id":supplier_id,
		"time":time,
		"amount":amount,
		"user_id":user_id,
		"type":"pallet"
	});
}


function updateOutput(id,pallet_id,amount,time,user_id){
	update({
		"id":id,
		"pallet_id":pallet_id,
		"amount":amount,
		"time":time,
		"user_id":user_id,
		"type":"output"
	});
}

function update(json){
	
	$.ajax({
        url: "/helper/update.php",
        type: "post",
        data: JSON.stringify(json) ,
        cache: false,
        success: function (response) {           
        	location.reload();          
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //TODO
        }
    });
}

//////////////////////////////
/***********DELETE***********/
//////////////////////////////

function deleteCategory(id){
	Delete({
		"id":id,
		"type":"category"
	});
}

function deleteUser(id){
	Delete({
		"id":id,
		"type":"user"
	});
}
function deleteSupplier(id){
	Delete({
		"id":id,
		"type":"supplier"
	});
}
function deleteProduct(id){
	Delete({
		"id":id,
		"type":"product"
	});
}
function deleteTrash(id){
	Delete({
		"id":id,
		"type":"trash"
	});
}
function deletePallet(id){
	Delete({
		"id":id,
		"type":"pallet"
	});
}
function deleteOutput(id){
	Delete({
		"id":id,
		"type":"output"
	});
}

function Delete(json){
	
	$.ajax({
        url: "/helper/delete.php",
        type: "post",
        data: JSON.stringify(json) ,
        cache: false,
        success: function (response) {           
        	location.reload();          
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //TODO
        }
    });
}
