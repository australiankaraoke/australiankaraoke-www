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

// Make an instance of the transaction object
$del_shoppingcart = new tNG_delete($conn_karaoke_db);
$tNGs->addTransaction($del_shoppingcart);
// Register triggers
$del_shoppingcart->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "GET", "cart_id");
// Add columns
$del_shoppingcart->setTable("shoppingcart");
$del_shoppingcart->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "cart_id");

// Execute all the registered transactions
$tNGs->executeTransactions();
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
<?php
	echo $tNGs->getErrorMsg();
?>
<script>

</script>
</body>
</html>