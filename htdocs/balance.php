<?php
define("_BTC_HOST_","https://btcbook.guarda.co/api/v2/address/");

	function get_balance($address){
		$json = file_get_contents(_BTC_HOST_. $address);
		return json_decode($json);
}

?>