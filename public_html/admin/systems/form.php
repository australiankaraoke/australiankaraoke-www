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

//start Trigger_Default_ManyToMany trigger
//remove this line if you want to edit the code by hand 
function Trigger_Default_ManyToMany(&$tNG) {
  $mtm = new tNG_ManyToMany($tNG);
  $mtm->setTable("systems_products");
  $mtm->setPkName("system_id");
  $mtm->setFkName("product_id");
  $mtm->setFkReference("mtm");
  $mtm->addField("quantity", "NUMERIC_TYPE", "POST", "quantity");
  return $mtm->Execute();
}
//end Trigger_Default_ManyToMany trigger

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

//start Trigger_DeleteDetail trigger
//remove this line if you want to edit the code by hand
function Trigger_DeleteDetail(&$tNG) {
  $tblDelObj = new tNG_DeleteDetailRec($tNG);
  $tblDelObj->setTable("systems_products");
  $tblDelObj->setFieldName("system_id");
  return $tblDelObj->Execute();
}
//end Trigger_DeleteDetail trigger

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
$query_rsproducts = "SELECT products.id, products.sku, systems_products.system_id, systems_products.quantity FROM products LEFT JOIN systems_products ON (systems_products.product_id=products.id AND systems_products.system_id=0123456789)";
$rsproducts = mysql_query($query_rsproducts, $karaoke_db) or die(mysql_error());
$row_rsproducts = mysql_fetch_assoc($rsproducts);
$totalRows_rsproducts = mysql_num_rows($rsproducts);

// Make an insert transaction instance
$ins_systems = new tNG_multipleInsert($conn_karaoke_db);
$tNGs->addTransaction($ins_systems);
// Register triggers
$ins_systems->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_systems->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_systems->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$ins_systems->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
$ins_systems->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
$ins_systems->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_systems->setTable("systems");
$ins_systems->addColumn("title", "STRING_TYPE", "POST", "title");
$ins_systems->addColumn("regularPrice", "STRING_TYPE", "POST", "regularPrice");
$ins_systems->addColumn("discountedPrice", "STRING_TYPE", "POST", "discountedPrice");
$ins_systems->addColumn("isOnSale", "STRING_TYPE", "POST", "isOnSale");
$ins_systems->addColumn("description", "STRING_TYPE", "POST", "description");
$ins_systems->addColumn("filename", "FILE_TYPE", "FILES", "filename");
$ins_systems->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified", "{now}");
$ins_systems->setPrimaryKey("id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_systems = new tNG_multipleUpdate($conn_karaoke_db);
$tNGs->addTransaction($upd_systems);
// Register triggers
$upd_systems->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_systems->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_systems->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$upd_systems->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
$upd_systems->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_systems->setTable("systems");
$upd_systems->addColumn("title", "STRING_TYPE", "POST", "title");
$upd_systems->addColumn("regularPrice", "STRING_TYPE", "POST", "regularPrice");
$upd_systems->addColumn("discountedPrice", "STRING_TYPE", "POST", "discountedPrice");
$upd_systems->addColumn("isOnSale", "STRING_TYPE", "POST", "isOnSale");
$upd_systems->addColumn("description", "STRING_TYPE", "POST", "description");
$upd_systems->addColumn("filename", "FILE_TYPE", "FILES", "filename");
$upd_systems->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified");
$upd_systems->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Make an instance of the transaction object
$del_systems = new tNG_multipleDelete($conn_karaoke_db);
$tNGs->addTransaction($del_systems);
// Register triggers
$del_systems->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_systems->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$del_systems->registerTrigger("BEFORE", "Trigger_DeleteDetail", 99);
$del_systems->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_systems->setTable("systems");
$del_systems->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rssystems = $tNGs->getRecordset("systems");
$row_rssystems = mysql_fetch_assoc($rssystems);
$totalRows_rssystems = mysql_num_rows($rssystems);

// Many to Many Fake RS object
$mtmHelper = new tNG_MtmFakeRs($conn_karaoke_db, "mtm");
$mtmHelper->addField("quantity", "NUMERIC_TYPE");


// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rssystems.filename}");
$objDynamicThumb1->setResize(350, 350, true);
$objDynamicThumb1->setWatermark(false);
$objDynamicThumb1->setPopupSize(1024, 768, true);
$objDynamicThumb1->setPopupNavigation(false);
$objDynamicThumb1->setPopupWatermark(false);?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="../../frameworks/ckeditor/contents.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../frameworks/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="../../frameworks/ckeditor/styles.js" type="text/javascript"></script>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../../includes/common/js/base.js" type="text/javascript"></script>
<script src="../../../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../../../includes/skins/style.js" type="text/javascript"></script>
<?php echo $tNGs->displayValidationRules();?>
<script src="../../../includes/nxt/scripts/form.js" type="text/javascript"></script>
<script src="../../../includes/nxt/scripts/form.js.php" type="text/javascript"></script>
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
    Systems </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rssystems > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="title_<?php echo $cnt1; ?>">Title:</label></td>
            <td><input type="text" name="title_<?php echo $cnt1; ?>" id="title_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rssystems['title']); ?>" size="32" maxlength="60" />
              <?php echo $tNGs->displayFieldHint("title");?> <?php echo $tNGs->displayFieldError("systems", "title", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="regularPrice_<?php echo $cnt1; ?>">regularPrice:</label></td>
            <td><input type="text" name="regularPrice_<?php echo $cnt1; ?>" id="regularPrice_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rssystems['regularPrice']); ?>" size="32" />
              <?php echo $tNGs->displayFieldHint("regularPrice");?> <?php echo $tNGs->displayFieldError("systems", "regularPrice", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="discountedPrice_<?php echo $cnt1; ?>">discountedPrice:</label></td>
            <td><input type="text" name="discountedPrice_<?php echo $cnt1; ?>" id="discountedPrice_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rssystems['discountedPrice']); ?>" size="32" />
              <?php echo $tNGs->displayFieldHint("discountedPrice");?> <?php echo $tNGs->displayFieldError("systems", "discountedPrice", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="isOnSale_<?php echo $cnt1; ?>">isOnSale:</label></td>
            <td><select name="isOnSale_<?php echo $cnt1; ?>" id="isOnSale_<?php echo $cnt1; ?>">
              <option value="0" <?php if (!(strcmp(0, KT_escapeAttribute($row_rssystems['isOnSale'])))) {echo "SELECTED";} ?>>NO</option>
              <option value="1" <?php if (!(strcmp(1, KT_escapeAttribute($row_rssystems['isOnSale'])))) {echo "SELECTED";} ?>>YES</option>
            </select>
              <?php echo $tNGs->displayFieldError("systems", "isOnSale", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="description_<?php echo $cnt1; ?>">Description:</label></td>
            <td><textarea name="description_<?php echo $cnt1; ?>" id="description_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rssystems['description']); ?></textarea>
              <?php echo $tNGs->displayFieldHint("description");?> <?php echo $tNGs->displayFieldError("systems", "description", $cnt1); ?>
              <script>
				CKEDITOR.replace( 'description_<?php echo $cnt1; ?>', {
					width :650,
					height: 300
				});
				</script>
              </td>
          </tr>
          <tr>
            <td class="KT_th"><label for="filename_<?php echo $cnt1; ?>">Filename:</label></td>
            <td> Current:<br />
              <a href="<?php echo $objDynamicThumb1->getPopupLink(); ?>" onclick="<?php echo $objDynamicThumb1->getPopupAction(); ?>" target="_blank"><img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" /></a><br />
              <br />
              <input type="file" name="filename_<?php echo $cnt1; ?>" id="filename_<?php echo $cnt1; ?>" size="32" />
              <?php echo $tNGs->displayFieldError("systems", "filename", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label>Products:</label></td>
            <td><table border="0" class="KT_mtm">
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Quantity</td>
              </tr>
              <tr>
                <?php
  $cnt2 = 0;
?>
                <?php
  if ($totalRows_rssystems>0) {
    $nested_query_rsproducts = str_replace("123456789", $row_rssystems['id'], $query_rsproducts);
    mysql_select_db($database_karaoke_db);
    $rsproducts = mysql_query($nested_query_rsproducts, $karaoke_db) or die(mysql_error());
    $row_rsproducts = mysql_fetch_assoc($rsproducts);
    $totalRows_rsproducts = mysql_num_rows($rsproducts);
    $nested_sw = false;
    if (isset($row_rsproducts) && is_array($row_rsproducts)) {
      do { //Nested repeat
?>
                <?php
  // Many To Many recordset overwrite
  if ($cnt2 == 0) {
    $rsproducts = $mtmHelper->Execute("id", $cnt1, "system_id", $rsproducts);
    $row_rsproducts = mysql_fetch_assoc($rsproducts);
  }
?>
                <td><label for="mtm_<?php echo $row_rsproducts['id']; ?>_<?php echo $cnt1; ?>"><?php echo $row_rsproducts['sku']; ?></label></td>
                <td><input id="mtm_<?php echo $row_rsproducts['id']; ?>_<?php echo $cnt1; ?>" name="mtm_<?php echo $row_rsproducts['id']; ?>_<?php echo $cnt1; ?>" type="checkbox" value="1" <?php if ($row_rsproducts['system_id'] != "") {?> checked<?php }?> /></td>
                <td><input type="text" name="mtm_quantity_<?php echo $row_rsproducts['id']; ?>_<?php echo $cnt1; ?>" id="mtm_quantity_<?php echo $row_rsproducts['id']; ?>_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproducts['quantity']); ?>" size="32" /></td>
                <?php
	$cnt2++;
	if ($cnt2%1 == 0) {
		echo "</tr><tr>";
	}
?>
                <?php
      } while ($row_rsproducts = mysql_fetch_assoc($rsproducts)); //Nested move next
    }
  }
?>
              </tr>
            </table></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_systems_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rssystems['kt_pk_systems']); ?>" />
        <input type="hidden" name="date_modified_<?php echo $cnt1; ?>" id="date_modified_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rssystems['date_modified']); ?>" />
        <?php } while ($row_rssystems = mysql_fetch_assoc($rssystems)); ?>
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
mysql_free_result($rsproducts);
?>
