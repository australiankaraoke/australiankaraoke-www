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

$colname_rs_description = "-1";
if (isset($_GET['system_id'])) {
  $colname_rs_description = $_GET['system_id'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_description = sprintf("SELECT * FROM v_systems_complete WHERE systems_id = %s", GetSQLValueString($colname_rs_description, "int"));
$rs_description = mysql_query($query_rs_description, $karaoke_db) or die(mysql_error());
$row_rs_description = mysql_fetch_assoc($rs_description);
$totalRows_rs_description = mysql_num_rows($rs_description);
?>
<link href='http://fonts.googleapis.com/css?family=Scada:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
<div style="font-family: 'Scada', sans-serif; color: #666;font-size: 14px; padding:0; margin:0; width: 370px;">
<?php echo $row_rs_description['systems_description']; ?>
</div>

<?php
mysql_free_result($rs_description);
?>
