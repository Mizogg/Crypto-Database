<?php
include_once  'eth_balance.php';
?>
<?php
	$conn = mysqli_connect("localhost", "root", "", "ethereum");	
	$with_any_one_of = "";
	$with_the_exact_of = "";
	$without = "";
	$starts_with = "";
	$search_in = "";
	$advance_search_submit = "";
	
	$queryCondition = "";
	if(!empty($_POST["search"])) {
		$advance_search_submit = $_POST["advance_search_submit"];
		foreach($_POST["search"] as $k=>$v){
			if(!empty($v)) {

				$queryCases = array("with_any_one_of","with_the_exact_of","without","starts_with");
				if(in_array($k,$queryCases)) {
					if(!empty($queryCondition)) {
						$queryCondition .= " AND ";
					} else {
						$queryCondition .= " WHERE ";
					}
				}
				switch($k) {
					case "with_any_one_of":
						$with_any_one_of = $v;
						$wordsAry = explode(" ", $v);
						$wordsCount = count($wordsAry);
						for($i=0;$i<$wordsCount;$i++) {
							if(!empty($_POST["search"]["search_in"])) {
								$queryCondition .= $_POST["search"]["search_in"] . " LIKE '%" . $wordsAry[$i] . "%'";
							} else {
								$queryCondition .= "Address LIKE '" . $wordsAry[$i] . "%' OR Privatekey LIKE '" . $wordsAry[$i] . "%'";
							}
							if($i!=$wordsCount-1) {
								$queryCondition .= " OR ";
							}
						}
						break;
					case "with_the_exact_of":
						$with_the_exact_of = $v;
						if(!empty($_POST["search"]["search_in"])) {
							$queryCondition .= $_POST["search"]["search_in"] . " LIKE '%" . $v . "%' OR Privatekey LIKE '%" . $v . "%'";
						} else {
							$queryCondition .= "Address LIKE '%" . $v . "%'";
						}
						break;
					case "without":
						$without = $v;
						if(!empty($_POST["search"]["search_in"])) {
							$queryCondition .= $_POST["search"]["search_in"] . " NOT LIKE '%" . $v . "%'";
						} else {
							$queryCondition .= "Address NOT LIKE '%" . $v . "%' AND Privatekey NOT LIKE '%" . $v . "%'";
						}
						break;
					case "starts_with":
						$starts_with = $v;
						if(!empty($_POST["search"]["search_in"])) {
							$queryCondition .= $_POST["search"]["search_in"] . " LIKE '" . $v . "%'";
						} else {
							$queryCondition .= "Address LIKE '" . $v . "%' OR Privatekey LIKE '" . $v . "%'";
						}
						break;
					case "search_in":
						$search_in = $_POST["search"]["search_in"];
						break;
				}
			}
		}
	}
	$orderby = " ORDER BY id desc"; 
	$sql = "SELECT * FROM addresses " . $queryCondition . "LIMIT 5";
	$result = mysqli_query($conn,$sql);
	
?>
<html>
	<head>
	<link rel="shortcut icon" type="image/jpg" href="https://i1.wp.com/mizogg.co.uk/wp-content/uploads/2021/02/MizoggFace.png?resize=768%2C680&ssl=1"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<body style="background-color:white;">
			<div id="content">
				<div id="cont">
					<div id="terminal">
					  <div id="terminal2">
						<div>
								<div id="headtext">
									<h1 style="text-align:center; color:black; font-size:25px;"><img src="https://www.mizogg.co.uk/Images/btcimage.png" width="50" height="50" alt=""/>Advanced Search using Ethereum Address<img src="https://www.mizogg.co.uk/Images/btcimage.png" width="50" height="50" alt=""/></h1>
										<div id="MizLogo" style="text-align:center; color:black; font-size:16px;">
										<div>Total Ethereum Wallets Included ??????????. Good Luck Hunting From</div>
										<img src="https://www.mizogg.co.uk/Images/mizogg.png" alt="" width="298" height="47" title="Mizogg.com"/>
										<img src="cog.gif" id="RunningImage" alt="Running"align="right">
	<style>
		body{
			width: 1200px;
			font-family: "Segoe UI",Optima,Helvetica,Arial,sans-serif;
			line-height: 25px;
		}
		.search-box {
			padding: 30px;
			background-color:#88EAFD;
		}
		.search-label{
			margin:2px;
		}
		.EthereumInputBox {    
			padding: 10px;
			border: 0;
			border-radius: 4px;
			margin: 0px 5px 15px;
			width: 700px;
		}
		.btnSearch{    
			padding: 10px;
			background: #14D2A7;
			border: 0;
			border-radius: 4px;
			margin: 0px 5px;
			color: #FFF;
			width: 350px;
		}
		#advance_search_link {
			color: #001FFF;
			cursor: pointer;
		}
		.result-privatekey{
			margin: 5px 0px 15px;
		}
		.result-address{
			margin: 5px 0px 15px;
		}
	</style>
	<script>
		function showHideAdvanceSearch() {
			if(document.getElementById("advanced-search-box").style.display=="none") {
				document.getElementById("advanced-search-box").style.display = "block";
				document.getElementById("advance_search_submit").value= "1";
			} else {
				document.getElementById("advanced-search-box").style.display = "none";
				document.getElementById("with_the_exact_of").value= "";
				document.getElementById("without").value= "";
				document.getElementById("starts_with").value= "";
				document.getElementById("search_in").value= "";
				document.getElementById("advance_search_submit").value= "";
			}
		}
	</script>
	</head>
	<body>
		<h1>CryptoCrackers Advanced ETH Search</h1>
    <div>      
			<form name="frmSearch" method="post" action="indexeth.php">
			<input type="hidden" id="advance_search_submit" name="advance_search_submit" value="<?php echo $advance_search_submit; ?>">
			<div class="search-box">
				<label class="search-label">Search Address Here:</label>
				<div>
					<input type="text" name="search[with_any_one_of]" class="EthereumInputBox" value="<?php echo $with_any_one_of; ?>"	/>
					<span id="advance_search_link" onClick="showHideAdvanceSearch()">Advance Search</span>
				</div>				
				<div id="advanced-search-box" <?php if(empty($advance_search_submit)) { ?>style="display:none;"<?php } ?>>
					<label class="search-label">With the Exact String:</label>
					<div>
						<input type="text" name="search[with_the_exact_of]" id="with_the_exact_of" class="EthereumInputBox" value="<?php echo $with_the_exact_of; ?>"	/>
					</div>
					<label class="search-label">Without:</label>
					<div>
						<input type="text" name="search[without]" id="without" class="EthereumInputBox" value="<?php echo $without; ?>"	/>
					</div>
					<label class="search-label">Starts With:</label>
					<div>
						<input type="text" name="search[starts_with]" id="starts_with" class="EthereumInputBox" value="<?php echo $starts_with; ?>"	/>
					</div>
					<label class="search-label">Search Keywords in:</label>
					<div>
						<select name="search[search_in]" id="search_in" class="EthereumInputBox">
							<option value="">Select Column</option>
							<option value="address" <?php if($search_in=="Address") { echo "selected"; } ?>>address</option>
							<option value="privatekey" <?php if($search_in=="Privatekey") { echo "selected"; } ?>>privatekey</option>
						</select>
					</div>
				</div>
				
				<div>
					<input type="submit" name="go" class="btnSearch" value="Search">
				</div>
			</div>
			</form>	
<?php 
while($row = mysqli_fetch_assoc($result)) {
				
	$address = $row["Address"];
	
	$privatekey = $row["Privatekey"];
				
?>
<?php

$a= $address;

$r= get_balance($a);


?>
<div></br>
				<div><strong>Privatekey HEX : <?php echo $row["Privatekey"]; ?></strong></div>
				<div><strong>address : <?php echo $address; ?></strong> <strong><div style="color:green"><?php echo ' Balance : '. $r->balance; ?> Wei</strong><strong><?php echo ' Transactions : '. $r->txs; ?></strong></div>
				
				<strong><div style="color:red"><?php
					if(is_null($r->nonTokenTxs)) {
						echo 'No Tokens : ';
					}
					else {
						echo ' Number of Tokens : '. $r->nonTokenTxs;
						echo "<br />";
						echo ' Tokens List : '. var_dump($r->tokens);
					}?></strong>
				</br>
			</div>
			<?php } ?>
		</div>

	</body>
</html>