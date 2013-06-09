<?php require_once('../../Connections/karaoke_db.php'); ?>
<?php
// Load the common classes
require_once('../../includes/common/KT_common.php');

// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_karaoke_db = new KT_connection($karaoke_db, $database_karaoke_db);


if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

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
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
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

$colname_rs_features = "-1";
if (isset($_POST['product_id'])) {
  $colname_rs_features = $_POST['product_id'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_features = sprintf("SELECT * FROM v_singleproduct WHERE products_id = %s", GetSQLValueString($colname_rs_features, "int"));
$rs_features = mysql_query($query_rs_features, $karaoke_db) or die(mysql_error());
$row_rs_features = mysql_fetch_assoc($rs_features);
$totalRows_rs_features = mysql_num_rows($rs_features);




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>

<style>

#tabs p {
	margin-bottom: 9px;
	line-height: 21px;
}
#tabs-2 ul li {
	font-size: 14px;
}
#features ul li {
	font-size: 12px;
	margin-left: 25px;
	line-height: 21px;
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
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../includes/common/js/base.js" type="text/javascript"></script>
<script src="../../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../../includes/skins/style.js" type="text/javascript"></script>
</head>

<body>

<div id="tabs" style="position: relative; top: 25px; width: 626px; margin-left: 9px; font-size: 14px;">
	
	<?
	if($row_rs_features['products_rating']>0){
	?>
	<div id="review_button" style="position: absolute; z-index: 1000; margin-left: 320px; margin-top: 3px; cursor: pointer;"><img src="/images/review_button.png" /></div>
<script>
	$("#review_button").click(function(){
		alert("Reviews Coming Soon ...");
	});
	</script>
	<?
	}
	?>
	<div id="buy_now" style="position: absolute; z-index: 1000; right: 15px; top: 8px;" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    <div style="position: relative; display: inline; font-size: 19px; font-weight: bold;top: 2px; right: 5px;" itemprop="price">$<?php echo $row_rs_features['products_regularPrice']; ?></div>
    <form action="" method="post" style="display: inline;">
    <input type="hidden" name='quantity' value="1"> 
	<input type="hidden" name="session_id" value="<?php echo $PHPSESSID; ?>">
	<input name="product_id" type="hidden" value="<?php echo $row_rs_features['products_id']; ?>">
	<input type="hidden" name="price" value="<?php echo $row_rs_features['products_regularPrice']; ?>">
	<input type="submit" value="Buy" name="KT_Insert1" class="buy_now_button" style="box-shadow: 0px 0px 1px 2px rgba(0,0,0,0.2); color: white;" />
    <!--<a href="#" class="buy_now_button" style="box-shadow: 0px 0px 1px 2px rgba(0,0,0,0.2); color: white;">BUY</a>	-->
    </form>
</div>
      <ul>
        <li><a href="#tabs-1">Overview</a></li>
        <li><a href="#tabs-2">Features</a></li>
        <li><a href="#tabs-3">Multimedia</a></li>
      </ul>
      <div id="tabs-1">
        <div id="description" style="font-size: 14px;"><?php echo $row_rs_features['products_description']; ?></div>
      </div>
      <div id="tabs-2">
        <div id="features">
        <style>
			#features a {
				color: red;
			}
			#features a:link {
				color: red;
			}
			#features a:visited {
				color: red;
			}
			#features a:hover {
				color: red;
			}
		</style>
        <p><?php echo $row_rs_features['products_features']; ?></p>
        <?php 
// Show IF Conditional region1 
if ($row_rs_features['products_specsURL']) {
?>
        <p>Visit <a href="<?php echo $row_rs_features['products_specsURL']; ?>" target="_blank"><?php echo $row_rs_features['manufacturers_title']; ?>'s product page</a> for further information.</p>
          <?php } 
// endif Conditional region1
?>
        </div>
      </div>
      <div id="tabs-3" style="font-size: 14px;">
        <p>MultiMedia Coming Soon.</p>
      </div>
</div>
<div style="height: 25px;"></div>
<?php
	echo $tNGs->getErrorMsg();
?>
<script>
	// TABS <base> reset
	$.fn.__tabs = $.fn.tabs;$.fn.tabs = function (a, b, c, d, e, f) {
	var base = location.href.replace(/#.*$/, '');
	$('ul>li>a[href^="#"]', this).each(function () {
	    var href = $(this).attr('href');
	    $(this).attr('href', base + href);
	});
	$(this).__tabs(a, b, c, d, e, f);
	};
</script>
</body>
</html>
<?php
mysql_free_result($rs_features);
?>
