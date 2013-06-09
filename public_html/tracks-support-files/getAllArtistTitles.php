<?php ini_set('display_errors','off'); ?><?php require_once('../../Connections/karaoke_db.php'); ?>
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

$colname_rs_trackListing = "-1";
if (isset($_POST['DISC'])) {
  $colname_rs_trackListing = $_POST['DISC'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_trackListing = sprintf("SELECT * FROM discs WHERE DISC = %s ORDER BY TCK ASC", GetSQLValueString($colname_rs_trackListing, "text"));
$rs_trackListing = mysql_query($query_rs_trackListing, $karaoke_db) or die(mysql_error());
$row_rs_trackListing = mysql_fetch_assoc($rs_trackListing);
$totalRows_rs_trackListing = mysql_num_rows($rs_trackListing);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<div style="position: absolute; margin-top: -20px; margin-left: 7px;"></div>
<div style="padding: 5px;-moz-column-count: 2;
	-moz-column-gap: 5px;
	-webkit-column-count: 2;
	-webkit-column-gap: 5px;
	column-count: 2;
	column-gap: 5px; font-size: 15px; line-height: 18px;">
    
    <?php do { ?>
      <div itemscope itemtype="http://schema.org/MusicGroup"><span itemprop="track"><? echo $row_rs_trackListing['TCK']; ?></span>. <b><span itemprop="name"><?php echo $row_rs_trackListing['ARTIST']; ?></span></b> - <span style="font-style:italic; color: grey;">"<?php echo $row_rs_trackListing['TITLE']; ?>"</span><br /></div>
      <?php } while ($row_rs_trackListing = mysql_fetch_assoc($rs_trackListing)); ?>
</div>
</body>
</html>
<?php
mysql_free_result($rs_trackListing);
?>
