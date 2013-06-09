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

session_start();
$PHPSESSID = session_id();

// Make an update transaction instance
$upd_shoppingcart = new tNG_update($conn_karaoke_db);
$tNGs->addTransaction($upd_shoppingcart);
// Register triggers
$upd_shoppingcart->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "VALUE", "$PHPSESSID");
// Add columns
$upd_shoppingcart->setTable("shoppingcart");
$upd_shoppingcart->addColumn("quantity", "NUMERIC_TYPE", "GET", "qty");
$upd_shoppingcart->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "cart_id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsshoppingcart = $tNGs->getRecordset("shoppingcart");
$row_rsshoppingcart = mysql_fetch_assoc($rsshoppingcart);
$totalRows_rsshoppingcart = mysql_num_rows($rsshoppingcart);

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


$system_id=$_GET['system_id'];
$qty=$_GET['qty'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../includes/common/js/base.js" type="text/javascript"></script>
<script src="../../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../../includes/skins/style.js" type="text/javascript"></script>
</head>

<body>

<?php echo $_GET['cart_id']; ?><br /><br />
<?php
	echo $tNGs->getErrorMsg();
?>
<?php echo $_GET['qty']; ?>
</body>
</html>
<?php
mysql_free_result($rs_this_system);
?>
