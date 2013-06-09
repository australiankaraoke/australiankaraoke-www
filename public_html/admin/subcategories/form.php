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
  $deleteObj->setFolder("../../../public_html/uploads-admin/");
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
  $uploadObj->setFolder("../../../public_html/uploads-admin/");
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
$query_Recordset1 = "SELECT title, id FROM subcategorygroups ORDER BY title";
$Recordset1 = mysql_query($query_Recordset1, $karaoke_db) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

// Make an insert transaction instance
$ins_subcategories = new tNG_multipleInsert($conn_karaoke_db);
$tNGs->addTransaction($ins_subcategories);
// Register triggers
$ins_subcategories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_subcategories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_subcategories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$ins_subcategories->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
$ins_subcategories->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_subcategories->setTable("subcategories");
$ins_subcategories->addColumn("subcategorygroup_id", "NUMERIC_TYPE", "POST", "subcategorygroup_id");
$ins_subcategories->addColumn("title", "STRING_TYPE", "POST", "title");
$ins_subcategories->addColumn("description", "STRING_TYPE", "POST", "description");
$ins_subcategories->addColumn("filename", "FILE_TYPE", "FILES", "filename");
$ins_subcategories->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified", "{NOW}");
$ins_subcategories->setPrimaryKey("id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_subcategories = new tNG_multipleUpdate($conn_karaoke_db);
$tNGs->addTransaction($upd_subcategories);
// Register triggers
$upd_subcategories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_subcategories->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_subcategories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$upd_subcategories->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_subcategories->setTable("subcategories");
$upd_subcategories->addColumn("subcategorygroup_id", "NUMERIC_TYPE", "POST", "subcategorygroup_id");
$upd_subcategories->addColumn("title", "STRING_TYPE", "POST", "title");
$upd_subcategories->addColumn("description", "STRING_TYPE", "POST", "description");
$upd_subcategories->addColumn("filename", "FILE_TYPE", "FILES", "filename");
$upd_subcategories->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified");
$upd_subcategories->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Make an instance of the transaction object
$del_subcategories = new tNG_multipleDelete($conn_karaoke_db);
$tNGs->addTransaction($del_subcategories);
// Register triggers
$del_subcategories->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_subcategories->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$del_subcategories->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_subcategories->setTable("subcategories");
$del_subcategories->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rssubcategories = $tNGs->getRecordset("subcategories");
$row_rssubcategories = mysql_fetch_assoc($rssubcategories);
$totalRows_rssubcategories = mysql_num_rows($rssubcategories);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../../../public_html/uploads-admin/");
$objDynamicThumb1->setRenameRule("{rssubcategories.filename}");
$objDynamicThumb1->setResize(200, 200, true);
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
    Subcategories </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rssubcategories > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="subcategorygroup_id_<?php echo $cnt1; ?>">Subcategorygroup_id:</label></td>
            <td><select name="subcategorygroup_id_<?php echo $cnt1; ?>" id="subcategorygroup_id_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_Recordset1['id']?>"<?php if (!(strcmp($row_Recordset1['id'], $row_rssubcategories['subcategorygroup_id']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['title']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("subcategories", "subcategorygroup_id", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="title_<?php echo $cnt1; ?>">Title:</label></td>
            <td><input type="text" name="title_<?php echo $cnt1; ?>" id="title_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rssubcategories['title']); ?>" size="32" maxlength="60" />
              <?php echo $tNGs->displayFieldHint("title");?> <?php echo $tNGs->displayFieldError("subcategories", "title", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="description_<?php echo $cnt1; ?>">Description:</label></td>
            <td><textarea name="description_<?php echo $cnt1; ?>" id="description_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rssubcategories['description']); ?></textarea>
              <?php echo $tNGs->displayFieldHint("description");?> <?php echo $tNGs->displayFieldError("subcategories", "description", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="filename_<?php echo $cnt1; ?>">Filename:</label></td>
            <td>Current: <br />
<br />
<a href="<?php echo $objDynamicThumb1->getPopupLink(); ?>" onclick="<?php echo $objDynamicThumb1->getPopupAction(); ?>" target="_blank"><img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" /></a><br /><br />
<input type="file" name="filename_<?php echo $cnt1; ?>" id="filename_<?php echo $cnt1; ?>" size="32" /><br /><br />
              <?php echo $tNGs->displayFieldError("subcategories", "filename", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_subcategories_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rssubcategories['kt_pk_subcategories']); ?>" />
        <input type="hidden" name="date_modified_<?php echo $cnt1; ?>" id="date_modified_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rssubcategories['date_modified']); ?>" />
        <?php } while ($row_rssubcategories = mysql_fetch_assoc($rssubcategories)); ?>
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
?>
