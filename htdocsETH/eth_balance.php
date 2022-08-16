<?php
define("_ETH_HOST_","https://ethbook.guarda.co/api/v2/address/");

	function get_balance($address){
		$json = file_get_contents(_ETH_HOST_. $address);
		return json_decode($json);
}

?>