<?php require_once('../../../Connections/karaoke_db.php'); ?>
<?php
// Load the common classes
require_once('../../includes/common/KT_common.php');

// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../../");

// Make unified connection variable
$conn_karaoke_db = new KT_connection($karaoke_db, $database_karaoke_db);

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

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

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_Recordset1 = "SELECT sku, id FROM products ORDER BY sku";
$Recordset1 = mysql_query($query_Recordset1, $karaoke_db) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_Recordset2 = "SELECT title, id FROM subcategories ORDER BY title";
$Recordset2 = mysql_query($query_Recordset2, $karaoke_db) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

// Make an insert transaction instance
$ins_products_subcategories = new tNG_multipleInsert($conn_karaoke_db);
$tNGs->addTransaction($ins_products_subcategories);
// Register triggers
$ins_products_subcategories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_products_subcategories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_products_subcategories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
// Add columns
$ins_products_subcategories->setTable("products_subcategories");
$ins_products_subcategories->addColumn("products_id", "NUMERIC_TYPE", "POST", "products_id");
$ins_products_subcategories->addColumn("subcategories_id", "NUMERIC_TYPE", "POST", "subcategories_id");
$ins_products_subcategories->setPrimaryKey("id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_products_subcategories = new tNG_multipleUpdate($conn_karaoke_db);
$tNGs->addTransaction($upd_products_subcategories);
// Register triggers
$upd_products_subcategories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_products_subcategories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_products_subcategories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
// Add columns
$upd_products_subcategories->setTable("products_subcategories");
$upd_products_subcategories->addColumn("products_id", "NUMERIC_TYPE", "POST", "products_id");
$upd_products_subcategories->addColumn("subcategories_id", "NUMERIC_TYPE", "POST", "subcategories_id");
$upd_products_subcategories->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Make an instance of the transaction object
$del_products_subcategories = new tNG_multipleDelete($conn_karaoke_db);
$tNGs->addTransaction($del_products_subcategories);
// Register triggers
$del_products_subcategories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_products_subcategories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
// Add columns
$del_products_subcategories->setTable("products_subcategories");
$del_products_subcategories->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproducts_subcategories = $tNGs->getRecordset("products_subcategories");
$row_rsproducts_subcategories = mysql_fetch_assoc($rsproducts_subcategories);
$totalRows_rsproducts_subcategories = mysql_num_rows($rsproducts_subcategories);
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
<?php echo $tNGs->displayValidationRules();?>
<script src="../../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_FORM_SETTINGS = {
  duplicate_buttons: true,
  show_as_grid: true,
  merge_down_value: true
}
</script>
</head>

<body>
<?php
	echo $tNGs->getErrorMsg();
?>
<div class="KT_tng">
  <h1>
    <?php 
// Show IF Conditional region1 
if (@$_GET['id'] == "") {
?>
      <?php echo NXT_getResource("Insert_FH"); ?>
      <?php 
// else Conditional region1
} else { ?>
      <?php echo NXT_getResource("Update_FH"); ?>
      <?php } 
// endif Conditional region1
?>
    Products_subcategories </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsproducts_subcategories > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="products_id_<?php echo $cnt1; ?>">Products_id:</label></td>
            <td><select name="products_id_<?php echo $cnt1; ?>" id="products_id_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_Recordset1['id']?>"<?php if (!(strcmp($row_Recordset1['id'], $row_rsproducts_subcategories['products_id']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['sku']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("products_subcategories", "products_id", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="subcategories_id_<?php echo $cnt1; ?>">Subcategories_id:</label></td>
            <td><select name="subcategories_id_<?php echo $cnt1; ?>" id="subcategories_id_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_Recordset2['id']?>"<?php if (!(strcmp($row_Recordset2['id'], $row_rsproducts_subcategories['subcategories_id']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['title']?></option>
              <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("products_subcategories", "subcategories_id", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_products_subcategories_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsproducts_subcategories['kt_pk_products_subcategories']); ?>" />
        <?php } while ($row_rsproducts_subcategories = mysql_fetch_assoc($rsproducts_subcategories)); ?>
      <div class="KT_bottombuttons">
        <div>
          <?php 
      // Show IF Conditional region1
      if (@$_GET['id'] == "") {
      ?>
            <input type="submit" name="KT_Insert1" id="KT_Insert1" value="<?php echo NXT_getResource("Insert_FB"); ?>" />
            <?php 
      // else Conditional region1
      } else { ?>
            <div class="KT_operations">
              <input type="submit" name="KT_Insert1" value="<?php echo NXT_getResource("Insert as new_FB"); ?>" onclick="nxt_form_insertasnew(this, 'id')" />
            </div>
            <input type="submit" name="KT_Update1" value="<?php echo NXT_getResource("Update_FB"); ?>" />
            <input type="submit" name="KT_Delete1" value="<?php echo NXT_getResource("Delete_FB"); ?>" onclick="return confirm('<?php echo NXT_getResource("Are you sure?"); ?>');" />
            <?php }
      // endif Conditional region1
      ?>
          <input type="button" name="KT_Cancel1" value="<?php echo NXT_getResource("Cancel_FB"); ?>" onclick="return UNI_navigateCancel(event, '../../../includes/nxt/back.php')" />
        </div>
      </div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($Recordset2);
?>
