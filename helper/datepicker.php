<?php

function datepicker($bool){


	
	return '<select class="form-control" id="date_month">
		      <option value="">Month</option>
		      <option value="">-----</option>
		      <option value="01">January</option>
		      <option value="02">February</option>
		      <option value="03">March</option>
		      <option value="04">April</option>
		      <option value="05">May</option>
		      <option value="06">June</option>
		      <option value="07">July</option>
		      <option value="08">August</option>
		      <option value="09">September</option>
		      <option value="10">October</option>
		      <option value="11">November</option>
		      <option value="12">December</option>
		    </select>
			<select class="form-control" id="date_day">
		      <option value="">Day</option>
		      <option value="">---</option>
		      <option value="01">01</option>
		      <option value="02">02</option>
		      <option value="03">03</option>
		      <option value="04">04</option>
		      <option value="05">05</option>
		      <option value="06">06</option>
		      <option value="07">07</option>
		      <option value="08">08</option>
		      <option value="09">09</option>
		      <option value="10">10</option>
		      <option value="11">11</option>
		      <option value="12">12</option>
		      <option value="13">13</option>
		      <option value="14">14</option>
		      <option value="15">15</option>
		      <option value="16">16</option>
		      <option value="17">17</option>
		      <option value="18">18</option>
		      <option value="19">19</option>
		      <option value="20">20</option>
		      <option value="21">21</option>
		      <option value="22">22</option>
		      <option value="23">23</option>
		      <option value="24">24</option>
		      <option value="25">25</option>
		      <option value="26">26</option>
		      <option value="27">27</option>
		      <option value="28">28</option>
		      <option value="29">29</option>
		      <option value="30">30</option>
		      <option value="31">31</option>
		    </select>	';	   
	
}

function daypicker($day){
	$returnValue = '<select onchange="inputchangeday()" class="form-control" id="wday">';
	if($day > 6){	$returnValue .= '<option value="" selected>Nap</option>';}
	else{ $returnValue .= '<option value="">Nap</option>';}
	
	$returnValue .= '<option value="">-----</option>';
	
	if($day == 0){	$returnValue .= '<option value="0" selected>Hétfő</option>';}
	else{ $returnValue .= '<option value="0">Hétfő</option>';}
	
	if($day == 1){	$returnValue .= '<option value="1" selected>Kedd</option>';}
	else{ $returnValue .= '<option value="1">Kedd</option>';}
	
	if($day == 2){	$returnValue .= '<option value="2" selected>Szerda</option>';}
	else{ $returnValue .= '<option value="2">Szerda</option>';}
	
	if($day == 3){	$returnValue .= '<option value="3" selected>Csütörtök</option>';}
	else{ $returnValue .= '<option value="3">Csütörtök</option>';}
	
	if($day == 4){	$returnValue .= '<option value="4" selected>Péntek</option>';}
	else{ $returnValue .= '<option value="4">Péntek</option>';}
	
	if($day == 5){	$returnValue .= '<option value="5" selected>Szombat</option>';}
	else{ $returnValue .= '<option value="5">Szombat</option>';}
	
	if($day == 6){	$returnValue .= '<option value="6" selected>Vasárnap</option>';}
	else{ $returnValue .= '<option value="6">Vasárnap</option>';}
	
	$returnValue .= '</selected>';
	return $returnValue;
}
?>