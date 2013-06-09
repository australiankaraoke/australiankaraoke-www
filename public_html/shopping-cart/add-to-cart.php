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

// Make an insert transaction instance
$ins_shoppingcart = new tNG_insert($conn_karaoke_db);
$tNGs->addTransaction($ins_shoppingcart);
// Register triggers
$ins_shoppingcart->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_shoppingcart->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../shopping-cart/index.php");
// Add columns
$ins_shoppingcart->setTable("shoppingcart");
$ins_shoppingcart->addColumn("session_id", "STRING_TYPE", "POST", "session_id");
$ins_shoppingcart->addColumn("product_id", "STRING_TYPE", "POST", "product_id");
$ins_shoppingcart->addColumn("quantity", "STRING_TYPE", "POST", "quantity");
$ins_shoppingcart->addColumn("price", "STRING_TYPE", "POST", "price");
$ins_shoppingcart->setPrimaryKey("id", "NUMERIC_TYPE");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsshoppingcart = $tNGs->getRecordset("shoppingcart");
$row_rsshoppingcart = mysql_fetch_assoc($rsshoppingcart);
$totalRows_rsshoppingcart = mysql_num_rows($rsshoppingcart);
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
<form action="" method="post" style="display: inline;">
    <?php
	echo $tNGs->getErrorMsg();
?>
    <input type="hidden" name='quantity' value="1"> 
	<input type="hidden" name="session_id" value="sessid">
	<input name="product_id" type="hidden" value="prod_id">
	<input type="hidden" name="price" value="999">
	<input type="submit" value="Buy" name="KT_Insert1" class="buy_now_button" style="box-shadow: 0px 0px 1px 2px rgba(0,0,0,0.2); color: white;" />
    <!--<a href="#" class="buy_now_button" style="box-shadow: 0px 0px 1px 2px rgba(0,0,0,0.2); color: white;">BUY</a>	-->
    
</form>
</body>
</html>