<?php require_once('../../Connections/karaoke_db.php'); ?>
<?php
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

$colname_rs_category = "-1";
if (isset($_GET['category_id'])) {
  $colname_rs_category = $_GET['category_id'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_category = sprintf("SELECT * FROM v_products_all_categories WHERE id = %s", GetSQLValueString($colname_rs_category, "int"));
$rs_category = mysql_query($query_rs_category, $karaoke_db) or die(mysql_error());
$row_rs_category = mysql_fetch_assoc($rs_category);
$totalRows_rs_category = mysql_num_rows($rs_category);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<?
		$rs = array();
        while($rs[] = mysql_fetch_assoc($rs_category)) {
           // you don´t really need to do anything here.
        }
		echo $rs;
        //$json_category = json_encode($rs);
		//echo $json_category;
?>

<?
mysql_free_result($rs_category);
?>
