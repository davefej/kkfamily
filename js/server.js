
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

function newSupplier(name,address,code){
	insert({
    	"name":name,
    	"address":address,
    	"code":code,
    	"type":"supplier"
    },reload);
	
}

function newProduct(name,category_id,min,expire,unit,product_type){	
	insert({
    	"name":name,
    	"category_id":category_id,
    	"product_type":product_type,
    	"min":min,
    	"expire":expire,
    	"unit":unit,
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
	},clearAmount);
}

function clearAmount(){
	bootbox.alert("Bevétel Sikeres!")
	$("#suly").val(0);
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
		bootbox.confirm('<h3>Biztosan el akarja menteni?</h3>',function (yes){
		if(yes){
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
	});
}

function palletcallback(json,response){
	
	if(json.decision  == "accept"){//ÁTVÉVE
		newPallet(json.product,json.supplier,json.amount,response)
	}else{
		//TODO
		newAlert("input",response,JSON.stringify(json))
	}
	
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
	
	$.ajax({
        url: "../helper/insert.php",
        type: "post",
        data: JSON.stringify(json) ,
        cache: false,
        success: function (response) {
        	
        	if(callback && typeof callback === "function"){
        		if(callback.name == "reload"){
        			bootbox.alert("Létrehozás Sikeres! OK"+"<input type='hidden' id='type' value='reload'/>")
        		}else{
        			callback(json,response);
        		}
        		
        	}else{
        		bootbox.alert("Létrehozás Sikeres! OK")
        	}
        	          
        },
        error: function(jqXHR, textStatus, errorThrown) {
        	bootbox.alert("Internet vagy szerver hiba<br/>"+textStatus+"<br/>"+errorThrown)
        }
    });
	return false;
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

function updateSupplier(id,name,address,code){
	update({
		"id":id,
		"name":name,
		"address":address,
		"code":code,
		"type":"supplier"
	});
}

function updateProduct(id,name,category_id,min,expire,unit,product_type){
	update({
		"id":id,
		"name":name,
		"category_id":category_id,
		"product_type":product_type,
		"min":min,
		"expire":expire,
		"unit":unit,
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

function updateInventory(id,amount,time){
	update({
		"id":id,
		"amount":amount,
		"time":time,
		"type":"inventory"
	});
}

function updatePrinted(id){
	update({
		"id":id,
		"type":"printing"
	});
}

function update(json){
	
	$.ajax({
        url: "../helper/update.php",
        type: "post",
        data: JSON.stringify(json) ,
        cache: false,
        success: function (response) {
        	bootbox.alert("Sikeres frissítés", function(){
        		location.reload();
        	})
        	        
        },
        error: function(jqXHR, textStatus, errorThrown) {
        	bootbox.alert("Internet vagy szerver hiba<br/>"+textStatus+"<br/>"+errorThrown)
        }
    });
	return false;
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
        	bootbox.alert("Sikeres törlés", function(){
        		location.reload();
        	})         
        },
        error: function(jqXHR, textStatus, errorThrown) {
        	bootbox.alert("Internet vagy szerver hiba<br/>"+textStatus+"<br/>"+errorThrown)
        }
    });
	return false;
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
        			
        			$('#alerta').html(  "Jelzés "+"<span class='hasalert label label-danger'>"+response+"</span>" );
        			
        			if(alertnum != -1 && window.location.href.indexOf("alert.php") > -1){
        				location.reload();
					}
        			alertnum = response;
        		}else{
        			alertnum = 0;
        			$('#alerta').html("Jelzés") 
        		}        		
        	} 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            
        }
    });
	return false;
}

function saveColor(json){
	$.ajax({
        url: "../helper/update.php",
        type: "post",
        data: JSON.stringify(json) ,
        cache: false,
        success: function (response) {           
        	          
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
    });
	return false;
}

