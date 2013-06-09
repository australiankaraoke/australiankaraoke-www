<?php require_once('../../../Connections/karaoke_db.php'); ?>
<?php
// Load the common classes
require_once('../../../includes/common/KT_common.php');

// Load the tNG classes
require_once('../../../includes/tng/tNG.inc.php');

// Load the KT_back class
require_once('../../../includes/nxt/KT_back.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../../");

// Make unified connection variable
$conn_karaoke_db = new KT_connection($karaoke_db, $database_karaoke_db);

// Start trigger
$formValidation = new tNG_FormValidation();
$tNGs->prepareValidation($formValidation);
// End trigger

//start Trigger_SetOrderColumn trigger
//remove this line if you want to edit the code by hand 
function Trigger_SetOrderColumn(&$tNG) {
  $orderFieldObj = new tNG_SetOrderField($tNG);
  $orderFieldObj->setFieldName("cardinality");
  return $orderFieldObj->Execute();
}
//end Trigger_SetOrderColumn trigger

//start Trigger_FileDelete trigger
//remove this line if you want to edit the code by hand 
function Trigger_FileDelete(&$tNG) {
  $deleteObj = new tNG_FileDelete($tNG);
  $deleteObj->setFolder("../../uploads-admin/");
  $deleteObj->setDbFieldName("filename");
  return $deleteObj->Execute();
}
//end Trigger_FileDelete trigger

//start Trigger_ImageUpload trigger
//remove this line if you want to edit the code by hand 
function Trigger_ImageUpload(&$tNG) {
  $uploadObj = new tNG_ImageUpload($tNG);
  $uploadObj->setFormFieldName("filename");
  $uploadObj->setDbFieldName("filename");
  $uploadObj->setFolder("../../uploads-admin/");
  $uploadObj->setMaxSize(8000);
  $uploadObj->setAllowedExtensions("gif, jpg, jpe, jpeg, png");
  $uploadObj->setRename("auto");
  return $uploadObj->Execute();
}
//end Trigger_ImageUpload trigger

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
$query_Recordset2 = "SELECT sku, id FROM products ORDER BY sku";
$Recordset2 = mysql_query($query_Recordset2, $karaoke_db) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

// Make an insert transaction instance
$ins_productimages = new tNG_multipleInsert($conn_karaoke_db);
$tNGs->addTransaction($ins_productimages);
// Register triggers
$ins_productimages->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_productimages->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_productimages->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$ins_productimages->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
$ins_productimages->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_productimages->setTable("productimages");
$ins_productimages->addColumn("product_id", "NUMERIC_TYPE", "POST", "product_id");
$ins_productimages->addColumn("filename", "FILE_TYPE", "FILES", "filename");
$ins_productimages->addColumn("title", "STRING_TYPE", "POST", "title");
$ins_productimages->addColumn("description", "STRING_TYPE", "POST", "description");
$ins_productimages->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified", "{NOW}");
$ins_productimages->setPrimaryKey("id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_productimages = new tNG_multipleUpdate($conn_karaoke_db);
$tNGs->addTransaction($upd_productimages);
// Register triggers
$upd_productimages->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_productimages->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_productimages->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$upd_productimages->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_productimages->setTable("productimages");
$upd_productimages->addColumn("product_id", "NUMERIC_TYPE", "POST", "product_id");
$upd_productimages->addColumn("filename", "FILE_TYPE", "FILES", "filename");
$upd_productimages->addColumn("title", "STRING_TYPE", "POST", "title");
$upd_productimages->addColumn("description", "STRING_TYPE", "POST", "description");
$upd_productimages->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified");
$upd_productimages->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Make an instance of the transaction object
$del_productimages = new tNG_multipleDelete($conn_karaoke_db);
$tNGs->addTransaction($del_productimages);
// Register triggers
$del_productimages->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_productimages->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$del_productimages->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_productimages->setTable("productimages");
$del_productimages->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproductimages = $tNGs->getRecordset("productimages");
$row_rsproductimages = mysql_fetch_assoc($rsproductimages);
$totalRows_rsproductimages = mysql_num_rows($rsproductimages);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rsproductimages.filename}");
$objDynamicThumb1->setResize(300, 300, true);
$objDynamicThumb1->setWatermark(false);
$objDynamicThumb1->setPopupSize(980, 800, true);
$objDynamicThumb1->setPopupNavigation(false);
$objDynamicThumb1->setPopupWatermark(false);
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
    Productimages </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsproductimages > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="product_id_<?php echo $cnt1; ?>">Product_id:</label></td>
            <td><select name="product_id_<?php echo $cnt1; ?>" id="product_id_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_Recordset2['id']?>"<?php if (!(strcmp($row_Recordset2['id'], $row_rsproductimages['product_id']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['sku']?></option>
              <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("productimages", "product_id", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="filename_<?php echo $cnt1; ?>">Filename:</label></td>
            <td>Current: <br /><br />
              <a href="<?php echo $objDynamicThumb1->getPopupLink(); ?>" onclick="<?php echo $objDynamicThumb1->getPopupAction(); ?>" target="_blank"><img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" /></a><br /><br /><input type="file" name="filename_<?php echo $cnt1; ?>" id="filename_<?php echo $cnt1; ?>" size="32" /><br /><br />
              <?php echo $tNGs->displayFieldError("productimages", "filename", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="title_<?php echo $cnt1; ?>">Title:</label></td>
            <td><input type="text" name="title_<?php echo $cnt1; ?>" id="title_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproductimages['title']); ?>" size="32" maxlength="60" />
              <?php echo $tNGs->displayFieldHint("title");?> <?php echo $tNGs->displayFieldError("productimages", "title", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="description_<?php echo $cnt1; ?>">Description:</label></td>
            <td><textarea name="description_<?php echo $cnt1; ?>" id="description_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsproductimages['description']); ?></textarea>
              <?php echo $tNGs->displayFieldHint("description");?> <?php echo $tNGs->displayFieldError("productimages", "description", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_productimages_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsproductimages['kt_pk_productimages']); ?>" />
        <input type="hidden" name="date_modified_<?php echo $cnt1; ?>" id="date_modified_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rsproductimages['date_modified']); ?>" />
        <?php } while ($row_rsproductimages = mysql_fetch_assoc($rsproductimages)); ?>
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
