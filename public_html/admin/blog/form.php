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

// Make an insert transaction instance
$ins_blog = new tNG_multipleInsert($conn_karaoke_db);
$tNGs->addTransaction($ins_blog);
// Register triggers
$ins_blog->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_blog->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_blog->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
// Add columns
$ins_blog->setTable("blog");
$ins_blog->addColumn("title", "STRING_TYPE", "POST", "title");
$ins_blog->addColumn("description", "STRING_TYPE", "POST", "description");
$ins_blog->addColumn("filename", "FILE_TYPE", "FILES", "filename");
$ins_blog->addColumn("isOnline", "STRING_TYPE", "POST", "isOnline");
$ins_blog->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified", "{now}");
$ins_blog->setPrimaryKey("id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_blog = new tNG_multipleUpdate($conn_karaoke_db);
$tNGs->addTransaction($upd_blog);
// Register triggers
$upd_blog->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_blog->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_blog->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
// Add columns
$upd_blog->setTable("blog");
$upd_blog->addColumn("title", "STRING_TYPE", "POST", "title");
$upd_blog->addColumn("description", "STRING_TYPE", "POST", "description");
$upd_blog->addColumn("filename", "FILE_TYPE", "FILES", "filename");
$upd_blog->addColumn("isOnline", "STRING_TYPE", "POST", "isOnline");
$upd_blog->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified");
$upd_blog->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Make an instance of the transaction object
$del_blog = new tNG_multipleDelete($conn_karaoke_db);
$tNGs->addTransaction($del_blog);
// Register triggers
$del_blog->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_blog->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
// Add columns
$del_blog->setTable("blog");
$del_blog->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsblog = $tNGs->getRecordset("blog");
$row_rsblog = mysql_fetch_assoc($rsblog);
$totalRows_rsblog = mysql_num_rows($rsblog);
?>
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
    Blog </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsblog > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="title_<?php echo $cnt1; ?>">Title:</label></td>
            <td><input type="text" name="title_<?php echo $cnt1; ?>" id="title_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsblog['title']); ?>" size="80" maxlength="250" />
              <?php echo $tNGs->displayFieldHint("title");?> <?php echo $tNGs->displayFieldError("blog", "title", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="description_<?php echo $cnt1; ?>">Description:</label></td>
            <td><textarea name="description_<?php echo $cnt1; ?>" id="description_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsblog['description']); ?></textarea>
              <?php echo $tNGs->displayFieldHint("description");?> <?php echo $tNGs->displayFieldError("blog", "description", $cnt1); ?>
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
            <td><input type="file" name="filename_<?php echo $cnt1; ?>" id="filename_<?php echo $cnt1; ?>" size="32" />
              <?php echo $tNGs->displayFieldError("blog", "filename", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="isOnline_<?php echo $cnt1; ?>">isOnline:</label></td>
            <td><select name="isOnline_<?php echo $cnt1; ?>" id="isOnline_<?php echo $cnt1; ?>">
              <option value="0" <?php if (!(strcmp(0, KT_escapeAttribute($row_rsblog['isOnline'])))) {echo "SELECTED";} ?>>NO</option>
              <option value="1" <?php if (!(strcmp(1, KT_escapeAttribute($row_rsblog['isOnline'])))) {echo "SELECTED";} ?>>YES</option>
            </select>
              <?php echo $tNGs->displayFieldError("blog", "isOnline", $cnt1); ?></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_blog_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsblog['kt_pk_blog']); ?>" />
        <input type="hidden" name="date_modified_<?php echo $cnt1; ?>" id="date_modified_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rsblog['date_modified']); ?>" />
        <?php } while ($row_rsblog = mysql_fetch_assoc($rsblog)); ?>
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