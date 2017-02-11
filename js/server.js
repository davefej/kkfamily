
//////////////////////////////
/***********INSERT***********/
//////////////////////////////

function newCategory(name){
	insert({
    	"name":name,
    	"type":"category"
    },reload);
}

function newUser(name,password,user_type){
	insert({
    	"name":name,
    	"password":password,
    	"user_type":user_type,
    	"type":"user"
    },reload);
}

function newSupplier(name,address){
	insert({
    	"name":name,
    	"address":address,
    	"type":"supplier"
    },reload);
	
}

function newProduct(name,category_id,product_type){	
	insert({
    	"name":name,
    	"category_id":category_id,
    	"product_type":product_type,
    	"type":"product"
	},reload);
}


function newTrash(pallet_id,amount){	
	insert({
    	"pallet_id":pallet_id,
    	"amount":amount,   	
    	"type":"trash"
	},alertcallback);
}

function newPallet(product_id,supplier_id,amount,qualityForm){	
	insert({
    	"product_id":product_id,
    	"supplier_id":supplier_id,
    	"amount":amount,
    	"quality_form":qualityForm,
    	"type":"pallet"
	},reload);
}


function newOutput(pallet_id,amount,alert){	

	insert({
    	"pallet_id":pallet_id,
    	"amount":amount,    	
    	"type":"output"
	},alertcallback);
}

function alertcallback(json,response){
	newAlert(
			json.type,response,json.pallet_id							
	);
}

function newQualityForm(sumDifference, appearance, consistency, smell, color,
		clearness, palletQuality, decision,product,supplier,amount){
	insert({
		"sum_difference":sumDifference,
		"appearance":appearance,
		"consistency":consistency,
		"smell":smell,
		"color":color,
		"clearness":clearness,
		"pallet_quality":palletQuality,
		"decision":decision,
		"type":"quality_form",
		"product":product,
		"supplier":supplier,
		"amount":amount
	},palletcallback);
}

function palletcallback(json,response){
	newPallet(json.product,json.supplier,json.amount,response)
}

function reload(){
	location.reload();
}

function newAlert(alert_type,param,param2){
	insert({
    	"alert_type":alert_type,
    	"param2":param2,
    	"param":param,
    	"type":"alert"
    },reload);

}

function insert(json,callback){
	alert = (alert == 'true');
	$.ajax({
        url: "../helper/insert.php",
        type: "post",
        data: JSON.stringify(json) ,
        cache: false,
        success: function (response) {        	
        	if(callback && typeof callback === "function"){        		
        		callback(json,response);
        	}
        	          
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert.show(hiba);
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

function updateUserName(id,name){
	update({
		"id":id,
		"name":name,
		"type":"user_name"
	});
}


function updateUserPass(id,password){
	update({
		"id":id,
		"password":password,
		"type":"user_password"
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

function updateAlert(id){
	update({
		"id":id,
		"type":"alert"
	});
}

function update(json){
	
	$.ajax({
        url: "../helper/update.php",
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

function deleteAlert(id){
	Delete({
		"id":id,
		"type":"alert"
	});
}


function Delete(json){
	
	$.ajax({
        url: "../helper/delete.php",
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

var alertnum = -1;

function alertcheck(){
	$.ajax({
        url: "../helper/alertcheck.php",
        type: "get",        
        cache: false,
        success: function (response) {           
        	if(!isNaN(response)){
        		response = parseInt(response);
        		if(response > 0){
        			if(alertnum != response && alertnum != -1){
        				makesound();
        			}
        			alertnum = response;
        			$('#alerta').html(  "Jelzés "+"<span class='hasalert label label-danger'>"+response+"</span>" );
        				
        		}else{
        			alertnum = 0;
        			$('#alerta').html("Jelzés") 
        		}        		
        	} 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            //TODO
        }
    });
}

