<?php

function mydatepicker($date, $postfix){
	$myarr= explode("-", $date);
	return datepicker($myarr[0],$myarr[2],$myarr[1],$postfix);
}

function datepicker($year,$day, $month, $postfix){

	if($postfix === true || $postfix === false){
		$postfix = "";
	}
	
	$str = '<select class="form-control datepicker" id="date_year'.$postfix.'">';
	for($i=0;$i<10;$i++){
		if($year == 2017+$i){
			$str .= '<option value="'.strval(2017+$i).'" selected>'.strval(2017+$i).'</option>';
		}else{
			$str .= '<option value="'.strval(2017+$i).'">'.strval(2017+$i).'</option>';
		}
	}
	$str .= '</select>';
	
	$str .= '<select class="form-control datepicker" id="date_month'.$postfix.'">';
	
	if($month > 12 || $month < 0){
		$str .= '<option value="" selected>Month</option>';
	}
	else{
		$str .= '<option value="">Month</option>';
	}
	$str .= '<option value="">-----</option>';
	if($month == 1){
		$str .= '<option value="01" selected>January</option>';
	}
	else{
		$str .= '<option value="01">January</option>';
	}
	if($month == 2){
		$str .= '<option value="02" selected>February</option>';
	}
	else{
		$str .= '<option value="02">February</option>';
	}
	if($month == 3){
		$str .= '<option value="03" selected>March</option>';
	}
	else{
		$str .= '<option value="03">March</option>';
	}
	if($month == 4){
		$str .= '<option value="04" selected>April</option>';
	}
	else{
		$str .= '<option value="04">April</option>';
	}
	if($month == 5){
		$str .= '<option value="05" selected>May</option>';
	}
	else{
		$str .= '<option value="05">May</option>';
	}
	if($month == 6){
		$str .= '<option value="06" selected>June</option>';
	}
	else{
		$str .= '<option value="06">June</option>';
	}
	if($month == 7){
		$str .= '<option value="07" selected>July</option>';
	}
	else{
		$str .= '<option value="07">July</option>';
	}
	if($month == 8){
		$str .= '<option value="08" selected>August</option>';
	}
	else{
		$str .= '<option value="08">August</option>';
	}
	if($month == 9){
		$str .= '<option value="09" selected>September</option>';
	}
	else{
		$str .= '<option value="09">September</option>';
	}
	if($month == 10){
		$str .= '<option value="10" selected>October</option>';
	}
	else{
		$str .= '<option value="10">October</option>';
	}
	if($month == 11){
		$str .= '<option value="11" selected>November</option>';
	}
	else{
		$str .= '<option value="11">November</option>';
	}
	if($month == 12){
		$str .= '<option value="12" selected>December</option>';
	}
	else{
		$str .= '<option value="12">December</option>';
	}
		      
	$str .= '</select><select class="form-control datepicker" id="date_day'.$postfix.'">';
	
	if($day > 12 || $day < 0){
		$str .= '<option value="" selected>Day</option>';
	}
	else{
		$str .= '<option value="">Day</option>';
	}
	$str .= '<option value="">-----</option>';
	if($day == 1){
		$str .= '<option value="01" selected>01</option>';
	}
	else{
		$str .= '<option value="01">01</option>';
	}
	if($day == 2){
		$str .= '<option value="02" selected>02</option>';
	}
	else{
		$str .= '<option value="02">02</option>';
	}
	if($day == 3){
		$str .= '<option value="03" selected>03</option>';
	}
	else{
		$str .= '<option value="03">03</option>';
	}
	if($day == 4){
		$str .= '<option value="04" selected>04</option>';
	}
	else{
		$str .= '<option value="04">04</option>';
	}
	if($day == 5){
		$str .= '<option value="05" selected>05</option>';
	}
	else{
		$str .= '<option value="05">05</option>';
	}
	if($day == 6){
		$str .= '<option value="06" selected>06</option>';
	}
	else{
		$str .= '<option value="06">06</option>';
	}
	if($day == 7){
		$str .= '<option value="07" selected>07</option>';
	}
	else{
		$str .= '<option value="07">07</option>';
	}
	if($day == 8){
		$str .= '<option value="08" selected>08</option>';
	}
	else{
		$str .= '<option value="08">08</option>';
	}
	if($day == 9){
		$str .= '<option value="09" selected>09</option>';
	}
	else{
		$str .= '<option value="09">09</option>';
	}
	if($day == 10){
		$str .= '<option value="10" selected>10</option>';
	}
	else{
		$str .= '<option value="10">10</option>';
	}
	if($day == 11){
		$str .= '<option value="11" selected>11</option>';
	}
	else{
		$str .= '<option value="11">11</option>';
	}
	if($day == 12){
		$str .= '<option value="12" selected>12</option>';
	}
	else{
		$str .= '<option value="12">12</option>';
	}
	if($day == 13){
		$str .= '<option value="13" selected>13</option>';
	}
	else{
		$str .= '<option value="13">13</option>';
	}
	if($day == 14){
		$str .= '<option value="14" selected>14</option>';
	}
	else{
		$str .= '<option value="14">14</option>';
	}
	if($day == 15){
		$str .= '<option value="15" selected>15</option>';
	}
	else{
		$str .= '<option value="15">15</option>';
	}
	if($day == 16){
		$str .= '<option value="16" selected>16</option>';
	}
	else{
		$str .= '<option value="16">16</option>';
	}
	if($day == 17){
		$str .= '<option value="17" selected>17</option>';
	}
	else{
		$str .= '<option value="17">17</option>';
	}
	if($day == 18){
		$str .= '<option value="18" selected>18</option>';
	}
	else{
		$str .= '<option value="18">18</option>';
	}
	if($day == 19){
		$str .= '<option value="19" selected>19</option>';
	}
	else{
		$str .= '<option value="19">19</option>';
	}
	if($day == 20){
		$str .= '<option value="20" selected>20</option>';
	}
	else{
		$str .= '<option value="20">20</option>';
	}
	if($day == 21){
		$str .= '<option value="21" selected>21</option>';
	}
	else{
		$str .= '<option value="21">21</option>';
	}
	if($day == 22){
		$str .= '<option value="22" selected>22</option>';
	}
	else{
		$str .= '<option value="22">22</option>';
	}
	if($day == 23){
		$str .= '<option value="23" selected>23</option>';
	}
	else{
		$str .= '<option value="23">23</option>';
	}
	if($day == 24){
		$str .= '<option value="24" selected>24</option>';
	}
	else{
		$str .= '<option value="24">24</option>';
	}
	if($day == 25){
		$str .= '<option value="25" selected>25</option>';
	}
	else{
		$str .= '<option value="25">25</option>';
	}
	if($day == 26){
		$str .= '<option value="26" selected>26</option>';
	}
	else{
		$str .= '<option value="26">26</option>';
	}
	if($day == 27){
		$str .= '<option value="27" selected>27</option>';
	}
	else{
		$str .= '<option value="27">27</option>';
	}
	if($day == 28){
		$str .= '<option value="28" selected>28</option>';
	}
	else{
		$str .= '<option value="28">28</option>';
	}
	if($day == 29){
		$str .= '<option value="29" selected>29</option>';
	}
	else{
		$str .= '<option value="29">29</option>';
	}
	if($day == 30){
		$str .= '<option value="30" selected>30</option>';
	}
	else{
		$str .= '<option value="30">30</option>';
	}
	if($day == 31){
		$str .= '<option value="31" selected>31</option>';
	}
	else{
		$str .= '<option value="31">31</option>';
	}
	$str .='</select>';
	
	return $str;	   
	
}

function monthpicker(){

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
		      <option value="12">December</option>.=	    </select>';
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