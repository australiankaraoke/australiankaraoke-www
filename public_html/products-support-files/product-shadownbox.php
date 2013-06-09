<?php require_once('../../Connections/karaoke_db.php'); ?>
<?php
// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

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

$colname_rs_shadowbox = "-1";
if (isset($_GET['image'])) {
  $colname_rs_shadowbox = $_GET['image'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_shadowbox = sprintf("SELECT * FROM v_singleproduct WHERE products_filename LIKE %s", GetSQLValueString($colname_rs_shadowbox, "text"));
$rs_shadowbox = mysql_query($query_rs_shadowbox, $karaoke_db) or die(mysql_error());
$row_rs_shadowbox = mysql_fetch_assoc($rs_shadowbox);
$totalRows_rs_shadowbox = mysql_num_rows($rs_shadowbox);

$colname_rs_shadowbox_productimages_filename = "-1";
if (isset($_GET['image'])) {
  $colname_rs_shadowbox_productimages_filename = $_GET['image'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_shadowbox_productimages_filename = sprintf("SELECT * FROM v_singleproduct WHERE productimages_filename = %s", GetSQLValueString($colname_rs_shadowbox_productimages_filename, "text"));
$rs_shadowbox_productimages_filename = mysql_query($query_rs_shadowbox_productimages_filename, $karaoke_db) or die(mysql_error());
$row_rs_shadowbox_productimages_filename = mysql_fetch_assoc($rs_shadowbox_productimages_filename);
$totalRows_rs_shadowbox_productimages_filename = mysql_num_rows($rs_shadowbox_productimages_filename);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rs_shadowbox.products_filename}");
$objDynamicThumb1->setResize(980, 620, true);
$objDynamicThumb1->setWatermark(false);

// Show Dynamic Thumbnail
$objDynamicThumb2 = new tNG_DynamicThumbnail("../../", "KT_thumbnail2");
$objDynamicThumb2->setFolder("../uploads-admin/");
$objDynamicThumb2->setRenameRule("{rs_shadowbox_productimages_filename.productimages_filename}");
$objDynamicThumb2->setResize(980, 620, true);
$objDynamicThumb2->setWatermark(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body style="width: 980px; height: 620px; padding: 0; margin: 0 auto; text-align:center;display:-webkit-box; 
                    -webkit-box-flex:1; 
                    -webkit-box-align: center; 
                    -webkit-box-pack: center; 
                    -webkit-box-orient:vertical;
                    display:box; 
                    box-flex:1; 
                    box-align: center; 
                    box-pack: center; 
                    box-orient:vertical;
                    background-color: white;">
<?
if($_GET["isPosterImage"]==1) {
?>
<img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" />
<?
} else {
?>
<img src="<?php echo $objDynamicThumb2->Execute(); ?>" border="0" />
<?
}
?>

</body>
</html>
<?php
mysql_free_result($rs_shadowbox);

mysql_free_result($rs_shadowbox_productimages_filename);
?>
