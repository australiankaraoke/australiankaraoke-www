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
$query_Recordset1 = "SELECT title, id FROM categories ORDER BY title";
$Recordset1 = mysql_query($query_Recordset1, $karaoke_db) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

// Make an insert transaction instance
$ins_subcategorygroups = new tNG_multipleInsert($conn_karaoke_db);
$tNGs->addTransaction($ins_subcategorygroups);
// Register triggers
$ins_subcategorygroups->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_subcategorygroups->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_subcategorygroups->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$ins_subcategorygroups->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
// Add columns
$ins_subcategorygroups->setTable("subcategorygroups");
$ins_subcategorygroups->addColumn("category_id", "NUMERIC_TYPE", "POST", "category_id");
$ins_subcategorygroups->addColumn("title", "STRING_TYPE", "POST", "title");
$ins_subcategorygroups->addColumn("description", "STRING_TYPE", "POST", "description");
$ins_subcategorygroups->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified", "{NOW}");
$ins_subcategorygroups->setPrimaryKey("id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_subcategorygroups = new tNG_multipleUpdate($conn_karaoke_db);
$tNGs->addTransaction($upd_subcategorygroups);
// Register triggers
$upd_subcategorygroups->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_subcategorygroups->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_subcategorygroups->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
// Add columns
$upd_subcategorygroups->setTable("subcategorygroups");
$upd_subcategorygroups->addColumn("category_id", "NUMERIC_TYPE", "POST", "category_id");
$upd_subcategorygroups->addColumn("title", "STRING_TYPE", "POST", "title");
$upd_subcategorygroups->addColumn("description", "STRING_TYPE", "POST", "description");
$upd_subcategorygroups->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified");
$upd_subcategorygroups->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Make an instance of the transaction object
$del_subcategorygroups = new tNG_multipleDelete($conn_karaoke_db);
$tNGs->addTransaction($del_subcategorygroups);
// Register triggers
$del_subcategorygroups->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_subcategorygroups->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
// Add columns
$del_subcategorygroups->setTable("subcategorygroups");
$del_subcategorygroups->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rssubcategorygroups = $tNGs->getRecordset("subcategorygroups");
$row_rssubcategorygroups = mysql_fetch_assoc($rssubcategorygroups);
$totalRows_rssubcategorygroups = mysql_num_rows($rssubcategorygroups);
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
    Subcategorygroups </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rssubcategorygroups > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="category_id_<?php echo $cnt1; ?>">Category_id:</label></td>
            <td><select name="category_id_<?php echo $cnt1; ?>" id="category_id_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_Recordset1['id']?>"<?php if (!(strcmp($row_Recordset1['id'], $row_rssubcategorygroups['category_id']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['title']?></option>
              <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("subcategorygroups", "category_id", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="title_<?php echo $cnt1; ?>">Title:</label></td>
            <td><input type="text" name="title_<?php echo $cnt1; ?>" id="title_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rssubcategorygroups['title']); ?>" size="32" maxlength="60" />
              <?php echo $tNGs->displayFieldHint("title");?> <?php echo $tNGs->displayFieldError("subcategorygroups", "title", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="description_<?php echo $cnt1; ?>">Description:</label></td>
            <td><textarea name="description_<?php echo $cnt1; ?>" id="description_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rssubcategorygroups['description']); ?></textarea>
              <?php echo $tNGs->displayFieldHint("description");?> <?php echo $tNGs->displayFieldError("subcategorygroups", "description", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_subcategorygroups_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rssubcategorygroups['kt_pk_subcategorygroups']); ?>" />
        <input type="hidden" name="date_modified_<?php echo $cnt1; ?>" id="date_modified_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rssubcategorygroups['date_modified']); ?>" />
        <?php } while ($row_rssubcategorygroups = mysql_fetch_assoc($rssubcategorygroups)); ?>
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
