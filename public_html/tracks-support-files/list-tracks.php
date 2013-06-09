<?php ini_set('display_errors','off'); ?><?
if(!$queryArtist) { $queryArtist = $_POST["queryArtist"]; }
if(!$queryDisc) { $queryDisc = $_POST["queryDisc"]; }
if(!$queryTitle) { $queryTitle = $_POST["queryTitle"]; }
if(!$queryManufacturer) { $queryManufacturer = $_POST["queryManufacturer"]; }
if(!$queryFormat) { $queryFormat = $_POST["queryFormat"]; }
if(!$SQL_whereClause) {
	if($queryArtist || $queryDisc || $queryTitle || $queryManufacturer || $queryFormat) {
		$SQL_whereClause = "SELECT * FROM discs WHERE ";
	if ($queryArtist) {
		$SQL_whereClause = $SQL_whereClause."ARTIST like '%$queryArtist%' AND ";
	}
	if ($queryDisc) {
		$SQL_whereClause = $SQL_whereClause."DISC like '%$queryDisc%' AND ";
	}
	if ($queryTitle) {
		$SQL_whereClause = $SQL_whereClause."TITLE like '%$queryTitle%' AND ";
	}
	if ($queryManufacturer) {
		$SQL_whereClause = $SQL_whereClause."MAN like '%$queryManufacturer%' AND ";
	}
	if ($queryFormat) {
		$SQL_whereClause = $SQL_whereClause."FMT = '$queryFormat' ";
	}
	}else{
		$SQL_whereClause = "SELECT * FROM discs";
	}
	if(($queryArtist || $queryDisc || $queryTitle || $queryManufacturer) && !$queryFormat) {
		$SQL_whereClause = substr_replace($SQL_whereClause ,"",-4);
		$SQL_whereClause = $SQL_whereClause." GROUP BY DISC";
	}else{
		$SQL_whereClause = $SQL_whereClause." GROUP BY DISC";
	}
}
?>
<?php require_once('../../Connections/karaoke_db.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
	function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
	$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
	$theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);
	switch ($theType) {
		case "text":
		$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		break;    
		case "long":
		case "int":
		$theValue = ($theValue != "") ? intval($theValue) : "NULL";
		break;
		case "double":
		$theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
		break;
		case "date":
		$theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
		break;
		case "defined":
		$theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
		break;
		}
	return $theValue;
	}
}

session_start();
$PHPSESSID = session_id();

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_query_discs_result = $SQL_whereClause;
$query_discs_result = mysql_query($query_query_discs_result, $karaoke_db) or die(mysql_error());
$row_query_discs_result = mysql_fetch_assoc($query_discs_result);
$totalRows_query_discs_result = mysql_num_rows($query_discs_result);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Untitled Document</title>
	<link rel="stylesheet" href="/frameworks/jPages-master/css/jPages.css">
	<script src="/frameworks/jPages-master/js/jPages.js"></script>
	<script src="/frameworks/jPages-master/js/jquery.lazyload.js"></script>
	<script>
$(".holder").jPages({
    containerID : "itemContainer",
    perPage : 5
});
</script>
<style>
#middle_main_content ul li {
	list-style: none;
}
</style>
<style type="text/css">
.buy_now_button {
	-moz-box-shadow:inset 0px 1px 0px 0px #f29c93;
	-webkit-box-shadow:inset 0px 1px 0px 0px #f29c93;
	box-shadow:inset 0px 1px 0px 0px #f29c93;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #fe1a00), color-stop(1, #ce0100) );
	background:-moz-linear-gradient( center top, #fe1a00 5%, #ce0100 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fe1a00', endColorstr='#ce0100');
	background-color:#fe1a00;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #d83526;
	display:inline-block;
	color:#ffffff;
	font-family:arial;
	font-size:14px;
	font-weight:bold;
	padding:4px 14px;
	text-decoration:none;
	text-shadow:1px 1px 0px #b23e35;
}.buy_now_button:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ce0100), color-stop(1, #fe1a00) );
	background:-moz-linear-gradient( center top, #ce0100 5%, #fe1a00 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ce0100', endColorstr='#fe1a00');
	background-color:#ce0100;
}.buy_now_button:active {
	position:relative;
	top:1px;
}
</style>

</head>

<body>
	<div id="middle_main_content">
	<? $thisDisc = $row_query_discs_result['DISC']; ?>
		<div style="font-size: 12px; margin:-55px 25px 25px 25px">
			<div id="DiscList" style="position: relative; padding: 5px; font-size: 13px;">
				<div class="holder"></div>
				<ul id="itemContainer">
					<? $counter=0; ?>
					<?php do { ?>
						<li>
							<div class="DiscItem" style="position: relative; padding: 20px; width: 885px; margin-bottom: 8px; border: 1px solid #CCCCCC;
							">
							
							<?php 
							if(stristr($row_query_discs_result['MAN'], 'set')) {
							?>
							<script>
							thisSku = "<?php echo $row_query_discs_result['DISC']; ?>";
							discInstance = new discObject(thisSku);
							function discObject(thisSku) {
							discSKU = thisSku.replace("-","").replace("/","").replace("/","");
							//discSKU = discSKU.replace("/","");
							console.info(discSKU);
							preDigits = discSKU.substring(0, discSKU.length-1);
							console.info(preDigits);
							postDigit = discSKU+"_postDigit";
							//return preDigits, postDigit;
							}
							</script>
							<?php 
							}
							?>
								<div style="float: left; text-align: left;">
									<div style="text-align: left;">
									<?
									if($queryDisc) { ?>
										<span style="color: red; text-transform:uppercase;"><?php echo $row_query_discs_result['DISC']; ?></span>
									<? }else{ ?>
										<?php echo $row_query_discs_result['DISC']; ?>
									<? } ?>
									</div>
									<div style="text-align: left; font-size: 15px; margin-top: 5px;">
										<strong><?php echo $row_query_discs_result['MAN']; ?></strong>
									</div>
								</div>
								<div style="float: right; text-align: right;">
									<div style="text-align: right;">
										Format: <?php echo $row_query_discs_result['FMT']; ?>
									</div>
									<div style="text-align: right; width: 250px;">
										<div style="position: relative; height: 4px;"></div>
										<?php
										if(stristr($row_query_discs_result['MAN'], 'set')) {
										?>
											<div style="position: relative; float: right;color: red; margin-top: 2px;">IS DISC SET</div>
												&nbsp;&nbsp;<img name="isSet" src="/images/isSetTick.png" width="15" height="15" alt="Is Box Set Checkbox" style="position: relative; float: right; margin-top: 2px; margin-right: 5px;" alt="Is Disc Set" >
										<?
										}else{
										?>
											<div style="position: relative; float: right;color: #ccc; margin-top: 2px;">(not a set)</div>&nbsp;&nbsp;<img name="isSet" src="/images/isNOTSetTick.png" width="15" height="15" alt="Is Box Set Checkbox" style="position: relative; float: right; margin-top: 2px; margin-right: 5px;" alt="Is NOT Disc Set"  >
										<?
										}
										?>
										</div>
								</div>
								<div style="clear: both;"></div>
								<HR SIZE="1">
								<div style="float: left; text-align: left;">
									<div style="text-align: left; width: 780px; font-size: 15px;">
									<? $counter++; ?>
										<div id="showMoreItem_<? echo $counter; ?>" style="float: left; width: 100%; height: 16px; margin-right: 5px; cursor: pointer;" class="toggleShowIcon">
										<style>
										.toggleShowIcon {
										background-image: url(/images/toggle_expand.png);
										background-repeat: no-repeat;
										padding-left: 20px;
										padding-top: 2px;
										}
										</style>
										<?
										if(!$queryTitle){
										?>
											<div id="listItem_<? echo $counter; ?>" style="float: left;">
												Loading ... <img src="/images/ajax-loader.gif" alt="Loading Icon" >
											</div>
										<script>
										$("#query_spinner").show();
										$("#listItem_<? echo $counter; ?>").load("/tracks-support-files/getQueryArtistTitle.php", {"DISC": "<?php echo $row_query_discs_result['DISC']; ?>", "ARTIST": "<? echo $queryArtist; ?>"},function(){
											<?php
											if($counter == ($totalRows_query_discs_result - 2)) {
											?>
											$("#query_spinner").hide();
											$("#queryArtist").prop('disabled', false);
											$("#queryManufacturer").prop('disabled', false);
											$("#queryTitle").prop('disabled', false);
											$("#queryDisc").prop('disabled', false);
											$("#queryFormat").prop('disabled', false);
											$("#submitButton").prop('disabled', false);
											<?php
											}
											?>
										});
										</script>
										<?
										} elseif(!$queryArtist) {
										?>
											<div id="listItem_<? echo $counter; ?>" style="display:inline;">
												Loading ... <img src="/images/ajax-loader.gif" alt="Loading Icon" >
											</div>
										<script>
										$("#query_spinner").show();
										$("#listItem_<? echo $counter; ?>").load("/tracks-support-files/getQueryArtistTitle.php", {"DISC": "<?php echo $row_query_discs_result['DISC']; ?>", "TITLE": "<? echo $queryTitle; ?>"},function(){
											<?php
											if($counter == ($totalRows_query_discs_result - 2)) {
											?>
											$("#query_spinner").hide();
											$("#queryArtist").prop('disabled', false);
											$("#queryManufacturer").prop('disabled', false);
											$("#queryTitle").prop('disabled', false);
											$("#queryDisc").prop('disabled', false);
											$("#queryFormat").prop('disabled', false);
											$("#submitButton").prop('disabled', false);
											<?php
											}
											?>
										});
										</script>
										<?
										} elseif ($queryArtist && $queryTitle)  {
										?>
											<div id="listItem_<? echo $counter; ?>" style="display:inline;">
												Loading ... <img src="/images/ajax-loader.gif" alt="Loading Icon" >
											</div>
										<script>
										$("#query_spinner").show();
										$("#listItem_<? echo $counter; ?>").load("/tracks-support-files/getQueryArtistTitle.php", {
										"DISC": "<?php echo $row_query_discs_result['DISC']; ?>",
										"TITLE": "<? echo $queryTitle; ?>",
										"ARTIST": "<? echo $queryArtist; ?>",
										},function(){
											<?php
											if($counter == ($totalRows_query_discs_result - 2)) {
											?>
											$("#query_spinner").hide();
											$("#queryArtist").prop('disabled', false);
											$("#queryManufacturer").prop('disabled', false);
											$("#queryTitle").prop('disabled', false);
											$("#queryDisc").prop('disabled', false);
											$("#queryFormat").prop('disabled', false);
											$("#submitButton").prop('disabled', false);
											<?php
											}
											?>
										});
										</script>
										<?
										} elseif (!$queryArtist && !$queryTitle)  {
										?>
											<div id="listItem_<? echo $counter; ?>" style="display:inline;">
												Loading ... <img src="/images/ajax-loader.gif" alt="Loading Icon" >
											</div>
										<script>
										$("#query_spinner").show();
										$("#listItem_<? echo $counter; ?>").load("/tracks-support-files/getQueryArtistTitle.php", {
										"DISC": "<?php echo $row_query_discs_result['DISC']; ?>"
										},function(){
											<?php
											if($counter == ($totalRows_query_discs_result - 2)) {
											?>
											$("#query_spinner").hide();
											$("#queryArtist").prop('disabled', false);
											$("#queryManufacturer").prop('disabled', false);
											$("#queryTitle").prop('disabled', false);
											$("#queryDisc").prop('disabled', false);
											$("#queryFormat").prop('disabled', false);
											$("#submitButton").prop('disabled', false);
											<?php
											}
											?>
										});
										</script>	
										<?
										}
										?>
										</div>
									</div>
								</div>
								<div style="position: relative; float: right; text-align: right;">
									<div style="position: relative; text-align: right;">
									
										<span style="font-size: 18px;">$ <?php echo $row_query_discs_result['PRICE']; ?></span>&nbsp;
										<form action="" method="post" name="buyDisc" id="buyDisc" style="margin-top: 10px;">
										    <input type="hidden" name='quantity' id="quantity" value="1">
										    <input type="hidden" name='isDisc' id="isDisc" value="1">
											<input type="hidden" name="session_id" id="session_id" value="<?php echo $PHPSESSID ?>">
											<input name="product_id" id="product_id" type="hidden" value="<?php echo $row_query_discs_result['ID']; ?>">
											<input type="hidden" name="price" id="price" value="<?php echo $row_query_discs_result['PRICE']; ?>">
											<input type="hidden" name="isDisc" id="isDisc" value="1">
											<input type="submit" value="Buy" name="KT_Insert1" class="buy_now_button" style="box-shadow: 0px 0px 1px 2px rgba(0,0,0,0.2); color: white;" />
										    <!--<a href="#" class="buy_now_button" style="box-shadow: 0px 0px 1px 2px rgba(0,0,0,0.2); color: white;">BUY</a>	-->
										</form>
									</div>
								</div>
								<div style="clear: both;"></div>	
								<div id="trackListItem_<? echo $counter; ?>" style="text-align: left; display: none;">
									Loading ... <img src="/images/ajax-loader.gif" alt="Loading Icon" >
								</div>
								<script>
								var showMoreItem_<? echo $counter; ?> = false;
								$("#showMoreItem_<? echo $counter; ?>").click(function(){
								showMoreItem_<? echo $counter; ?>=!showMoreItem_<? echo $counter; ?>;
								if(showMoreItem_<? echo $counter; ?>==true){
								$("#showMoreItem_<? echo $counter; ?>").css({"background-image":"url(/images/toggle.png)"});
								}else{
								$("#showMoreItem_<? echo $counter; ?>").css({"background-image":"url(/images/toggle_expand.png)"});
								}
								//$("#query_spinner").fadeIn();
								$("#trackListItem_<? echo $counter; ?>").load("/tracks-support-files/getAllArtistTitles.php", {"DISC": "<?php echo $row_query_discs_result['DISC']; ?>"}, function(){});
								$("#trackListItem_<? echo $counter; ?>").slideToggle(80);
								});
								</script>
							</div>
						</li>
						<?php } while ($row_query_discs_result = mysql_fetch_assoc($query_discs_result)); ?>
				</ul>
				<div class="holder" style="margin-top: 25px;"></div>
			</div>	
		</div>
	<?php
	?>
	</div>
	<div style="clear: both;"></div>


</body>
</html>




































