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
  $mtm->setTable("products_subcategories");
  $mtm->setPkName("products_id");
  $mtm->setFkName("subcategories_id");
  $mtm->setFkReference("mtm");
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
  $tblDelObj->setTable("products_subcategories");
  $tblDelObj->setFieldName("products_id");
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
$query_rsManufacturers = "SELECT * FROM manufacturers";
$rsManufacturers = mysql_query($query_rsManufacturers, $karaoke_db) or die(mysql_error());
$row_rsManufacturers = mysql_fetch_assoc($rsManufacturers);
$totalRows_rsManufacturers = mysql_num_rows($rsManufacturers);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rsCategories = "SELECT * FROM categories";
$rsCategories = mysql_query($query_rsCategories, $karaoke_db) or die(mysql_error());
$row_rsCategories = mysql_fetch_assoc($rsCategories);
$totalRows_rsCategories = mysql_num_rows($rsCategories);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rssubcategories = "SELECT subcategories.id, subcategories.title, subcategories.description, subcategorygroups.id AS subcategorygroups_id, subcategorygroups.title AS subcategorygroups_title, subcategorygroups.description AS subcategorygroups_description , products_subcategories.products_id FROM subcategories LEFT JOIN products_subcategories ON (products_subcategories.subcategories_id=subcategories.id AND products_subcategories.products_id=0123456789) LEFT JOIN subcategorygroups ON (subcategories.subcategorygroup_id = subcategorygroups.id) ORDER BY subcategorygroups.title";
$rssubcategories = mysql_query($query_rssubcategories, $karaoke_db) or die(mysql_error());
$row_rssubcategories = mysql_fetch_assoc($rssubcategories);
$totalRows_rssubcategories = mysql_num_rows($rssubcategories);

// Make an insert transaction instance
$ins_products = new tNG_multipleInsert($conn_karaoke_db);
$tNGs->addTransaction($ins_products);
// Register triggers
$ins_products->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Insert1");
$ins_products->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$ins_products->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$ins_products->registerTrigger("BEFORE", "Trigger_SetOrderColumn", 50);
$ins_products->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
$ins_products->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$ins_products->setTable("products");
$ins_products->addColumn("manufacturer_id", "NUMERIC_TYPE", "POST", "manufacturer_id");
$ins_products->addColumn("category_id", "NUMERIC_TYPE", "POST", "category_id");
$ins_products->addColumn("sku", "STRING_TYPE", "POST", "sku");
$ins_products->addColumn("title", "STRING_TYPE", "POST", "title");
$ins_products->addColumn("miniDescription", "STRING_TYPE", "POST", "miniDescription");
$ins_products->addColumn("description", "STRING_TYPE", "POST", "description");
$ins_products->addColumn("features", "STRING_TYPE", "POST", "features");
$ins_products->addColumn("productCondition", "STRING_TYPE", "POST", "productCondition");
$ins_products->addColumn("recommendedRetailPrice", "NUMERIC_TYPE", "POST", "recommendedRetailPrice");
$ins_products->addColumn("regularPrice", "STRING_TYPE", "POST", "regularPrice");
$ins_products->addColumn("discountedPrice", "NUMERIC_TYPE", "POST", "discountedPrice");
$ins_products->addColumn("specsURL", "STRING_TYPE", "POST", "specsURL");
$ins_products->addColumn("filename", "FILE_TYPE", "FILES", "filename");
$ins_products->addColumn("rating", "NUMERIC_TYPE", "POST", "rating");
$ins_products->addColumn("stock", "NUMERIC_TYPE", "POST", "stock");
$ins_products->addColumn("featured", "CHECKBOX_1_0_TYPE", "POST", "featured", "0");
$ins_products->addColumn("online", "CHECKBOX_1_0_TYPE", "POST", "online", "0");
$ins_products->addColumn("isOnSale", "CHECKBOX_1_0_TYPE", "POST", "isOnSale", "0");
$ins_products->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified", "{NOW}");
$ins_products->setPrimaryKey("id", "NUMERIC_TYPE");

// Make an update transaction instance
$upd_products = new tNG_multipleUpdate($conn_karaoke_db);
$tNGs->addTransaction($upd_products);
// Register triggers
$upd_products->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Update1");
$upd_products->registerTrigger("BEFORE", "Trigger_Default_FormValidation", 10, $formValidation);
$upd_products->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$upd_products->registerTrigger("AFTER", "Trigger_Default_ManyToMany", 50);
$upd_products->registerTrigger("AFTER", "Trigger_ImageUpload", 97);
// Add columns
$upd_products->setTable("products");
$upd_products->addColumn("manufacturer_id", "NUMERIC_TYPE", "POST", "manufacturer_id");
$upd_products->addColumn("category_id", "NUMERIC_TYPE", "POST", "category_id");
$upd_products->addColumn("sku", "STRING_TYPE", "POST", "sku");
$upd_products->addColumn("title", "STRING_TYPE", "POST", "title");
$upd_products->addColumn("miniDescription", "STRING_TYPE", "POST", "miniDescription");
$upd_products->addColumn("description", "STRING_TYPE", "POST", "description");
$upd_products->addColumn("features", "STRING_TYPE", "POST", "features");
$upd_products->addColumn("productCondition", "STRING_TYPE", "POST", "productCondition");
$upd_products->addColumn("recommendedRetailPrice", "NUMERIC_TYPE", "POST", "recommendedRetailPrice");
$upd_products->addColumn("regularPrice", "STRING_TYPE", "POST", "regularPrice");
$upd_products->addColumn("discountedPrice", "NUMERIC_TYPE", "POST", "discountedPrice");
$upd_products->addColumn("specsURL", "STRING_TYPE", "POST", "specsURL");
$upd_products->addColumn("filename", "FILE_TYPE", "FILES", "filename");
$upd_products->addColumn("rating", "NUMERIC_TYPE", "POST", "rating");
$upd_products->addColumn("stock", "NUMERIC_TYPE", "POST", "stock");
$upd_products->addColumn("featured", "CHECKBOX_1_0_TYPE", "POST", "featured");
$upd_products->addColumn("online", "CHECKBOX_1_0_TYPE", "POST", "online");
$upd_products->addColumn("isOnSale", "CHECKBOX_1_0_TYPE", "POST", "isOnSale");
$upd_products->addColumn("date_modified", "DATE_TYPE", "POST", "date_modified");
$upd_products->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Make an instance of the transaction object
$del_products = new tNG_multipleDelete($conn_karaoke_db);
$tNGs->addTransaction($del_products);
// Register triggers
$del_products->registerTrigger("STARTER", "Trigger_Default_Starter", 1, "POST", "KT_Delete1");
$del_products->registerTrigger("END", "Trigger_Default_Redirect", 99, "../../../includes/nxt/back.php");
$del_products->registerTrigger("BEFORE", "Trigger_DeleteDetail", 99);
$del_products->registerTrigger("AFTER", "Trigger_FileDelete", 98);
// Add columns
$del_products->setTable("products");
$del_products->setPrimaryKey("id", "NUMERIC_TYPE", "GET", "id");

// Execute all the registered transactions
$tNGs->executeTransactions();

// Get the transaction recordset
$rsproducts = $tNGs->getRecordset("products");
$row_rsproducts = mysql_fetch_assoc($rsproducts);
$totalRows_rsproducts = mysql_num_rows($rsproducts);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rsproducts.filename}");
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

<link href="../../frameworks/ckeditor/contents.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../frameworks/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="../../frameworks/ckeditor/styles.js" type="text/javascript"></script>

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
    Products </h1>
  <div class="KT_tngform">
    <form method="post" id="form1" action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" enctype="multipart/form-data">
      <?php $cnt1 = 0; ?>
      <?php do { ?>
        <?php $cnt1++; ?>
        <?php 
// Show IF Conditional region1 
if (@$totalRows_rsproducts > 1) {
?>
          <h2><?php echo NXT_getResource("Record_FH"); ?> <?php echo $cnt1; ?></h2>
          <?php } 
// endif Conditional region1
?>
        <table cellpadding="2" cellspacing="0" class="KT_tngtable">
          <tr>
            <td class="KT_th"><label for="manufacturer_id_<?php echo $cnt1; ?>">Manufacturer_id:</label></td>
            <td><select name="manufacturer_id_<?php echo $cnt1; ?>" id="manufacturer_id_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsManufacturers['id']?>"<?php if (!(strcmp($row_rsManufacturers['id'], $row_rsproducts['manufacturer_id']))) {echo "SELECTED";} ?>><?php echo $row_rsManufacturers['title']?></option>
              <?php
} while ($row_rsManufacturers = mysql_fetch_assoc($rsManufacturers));
  $rows = mysql_num_rows($rsManufacturers);
  if($rows > 0) {
      mysql_data_seek($rsManufacturers, 0);
	  $row_rsManufacturers = mysql_fetch_assoc($rsManufacturers);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("products", "manufacturer_id", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="category_id_<?php echo $cnt1; ?>">Category_id:</label></td>
            <td><select name="category_id_<?php echo $cnt1; ?>" id="category_id_<?php echo $cnt1; ?>">
              <option value=""><?php echo NXT_getResource("Select one..."); ?></option>
              <?php 
do {  
?>
              <option value="<?php echo $row_rsCategories['id']?>"<?php if (!(strcmp($row_rsCategories['id'], $row_rsproducts['category_id']))) {echo "SELECTED";} ?>><?php echo $row_rsCategories['title']?></option>
              <?php
} while ($row_rsCategories = mysql_fetch_assoc($rsCategories));
  $rows = mysql_num_rows($rsCategories);
  if($rows > 0) {
      mysql_data_seek($rsCategories, 0);
	  $row_rsCategories = mysql_fetch_assoc($rsCategories);
  }
?>
            </select>
              <?php echo $tNGs->displayFieldError("products", "category_id", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="sku_<?php echo $cnt1; ?>">Sku:</label></td>
            <td><input type="text" name="sku_<?php echo $cnt1; ?>" id="sku_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproducts['sku']); ?>" size="32" maxlength="50" />
              <?php echo $tNGs->displayFieldHint("sku");?> <?php echo $tNGs->displayFieldError("products", "sku", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="title_<?php echo $cnt1; ?>">Title:</label></td>
            <td><input type="text" name="title_<?php echo $cnt1; ?>" id="title_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproducts['title']); ?>" size="32" maxlength="255" />
              <?php echo $tNGs->displayFieldHint("title");?> <?php echo $tNGs->displayFieldError("products", "title", $cnt1); ?></td>
          </tr>
          <tr>
          	<td class="KT_th"><label for="description_<?php echo $cnt1; ?>">Mini Description:</label></td>
            <td><textarea name="miniDescription_<?php echo $cnt1; ?>" id="miniDescription_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsproducts['miniDescription']); ?></textarea>
            <script>
				CKEDITOR.replace( 'miniDescription_<?php echo $cnt1; ?>', {
					width :650,
					height: 300
				});
				</script>
              <?php echo $tNGs->displayFieldHint("miniDescription");?> <?php echo $tNGs->displayFieldError("products", "miniDescription", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="description_<?php echo $cnt1; ?>">Description:</label></td>
            <td><textarea name="description_<?php echo $cnt1; ?>" id="description_<?php echo $cnt1; ?>" cols="50" rows="5"><?php echo KT_escapeAttribute($row_rsproducts['description']); ?></textarea>
            <script>
				CKEDITOR.replace( 'description_<?php echo $cnt1; ?>', {
					width :650,
					height: 300
				});
				</script>
              <?php echo $tNGs->displayFieldHint("description");?> <?php echo $tNGs->displayFieldError("products", "description", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="features_<?php echo $cnt1; ?>">Features:</label></td>
            <td><textarea name="features_<?php echo $cnt1; ?>" id="features_<?php echo $cnt1; ?>" cols="35" rows="5"><?php echo KT_escapeAttribute($row_rsproducts['features']); ?></textarea>
            <script>
				CKEDITOR.replace( 'features_<?php echo $cnt1; ?>', {
					width :650,
					height: 300
				});
				</script>
              <?php echo $tNGs->displayFieldHint("features");?> <?php echo $tNGs->displayFieldError("products", "features", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="productCondition_<?php echo $cnt1; ?>">productCondition:</label></td>
            <td><select name="productCondition_<?php echo $cnt1; ?>" id="productCondition_<?php echo $cnt1; ?>">
              <option value="new" <?php if (!(strcmp("new", KT_escapeAttribute($row_rsproducts['productCondition'])))) {echo "SELECTED";} ?>>NEW</option>
              <option value="used" <?php if (!(strcmp("used", KT_escapeAttribute($row_rsproducts['productCondition'])))) {echo "SELECTED";} ?>>USED</option>
              <option value="pos" <?php if (!(strcmp("pos", KT_escapeAttribute($row_rsproducts['productCondition'])))) {echo "SELECTED";} ?>>POINT OF SALE</option>
              <option value="misc" <?php if (!(strcmp("misc", KT_escapeAttribute($row_rsproducts['productCondition'])))) {echo "SELECTED";} ?>>MISC</option>
            </select>
              <?php echo $tNGs->displayFieldError("products", "productCondition", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="recommendedRetailPrice_<?php echo $cnt1; ?>">recommendedRetailPrice:</label></td>
            <td><input type="text" name="recommendedRetailPrice_<?php echo $cnt1; ?>" id="recommendedRetailPrice_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproducts['recommendedRetailPrice']); ?>" size="7" />
              <?php echo $tNGs->displayFieldHint("recommendedRetailPrice");?> <?php echo $tNGs->displayFieldError("products", "recommendedRetailPrice", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="regularPrice_<?php echo $cnt1; ?>">regularPrice:</label></td>
            <td><input type="text" name="regularPrice_<?php echo $cnt1; ?>" id="regularPrice_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproducts['regularPrice']); ?>" size="32" maxlength="255" />
              <?php echo $tNGs->displayFieldHint("regularPrice");?> <?php echo $tNGs->displayFieldError("products", "regularPrice", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="discountedPrice_<?php echo $cnt1; ?>">discountedPrice:</label></td>
            <td><input type="text" name="discountedPrice_<?php echo $cnt1; ?>" id="discountedPrice_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproducts['discountedPrice']); ?>" size="7" />
              <?php echo $tNGs->displayFieldHint("discountedPrice");?> <?php echo $tNGs->displayFieldError("products", "discountedPrice", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="specsURL_<?php echo $cnt1; ?>">specsURL:</label></td>
            <td><input type="text" name="specsURL_<?php echo $cnt1; ?>" id="specsURL_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproducts['specsURL']); ?>" size="32" maxlength="255" />
              <?php echo $tNGs->displayFieldHint("specsURL");?> <?php echo $tNGs->displayFieldError("products", "specsURL", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="filename_<?php echo $cnt1; ?>">Filename:</label></td>
            <td>Current:<br />
<br />
<a href="<?php echo $objDynamicThumb1->getPopupLink(); ?>" onclick="<?php echo $objDynamicThumb1->getPopupAction(); ?>" target="_blank"><img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" /></a><br /><br />
<input type="file" name="filename_<?php echo $cnt1; ?>" id="filename_<?php echo $cnt1; ?>" size="32" />
              <?php echo $tNGs->displayFieldError("products", "filename", $cnt1); ?><br />
<br />
</td>
          </tr>
          <tr>
            <td class="KT_th"><label for="rating_<?php echo $cnt1; ?>">Rating:</label></td>
            <td><select name="rating_<?php echo $cnt1; ?>" id="rating_<?php echo $cnt1; ?>">
              <option value="1" <?php if (!(strcmp(1, KT_escapeAttribute($row_rsproducts['rating'])))) {echo "SELECTED";} ?>>*</option>
              <option value="2" <?php if (!(strcmp(2, KT_escapeAttribute($row_rsproducts['rating'])))) {echo "SELECTED";} ?>>**</option>
              <option value="3" <?php if (!(strcmp(3, KT_escapeAttribute($row_rsproducts['rating'])))) {echo "SELECTED";} ?>>***</option>
              <option value="4" <?php if (!(strcmp(4, KT_escapeAttribute($row_rsproducts['rating'])))) {echo "SELECTED";} ?>>****</option>
              <option value="5" <?php if (!(strcmp(5, KT_escapeAttribute($row_rsproducts['rating'])))) {echo "SELECTED";} ?>>*****</option>
            </select>
              <?php echo $tNGs->displayFieldError("products", "rating", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="stock_<?php echo $cnt1; ?>">Stock:</label></td>
            <td><input type="text" name="stock_<?php echo $cnt1; ?>" id="stock_<?php echo $cnt1; ?>" value="<?php echo KT_escapeAttribute($row_rsproducts['stock']); ?>" size="7" />
              <?php echo $tNGs->displayFieldHint("stock");?> <?php echo $tNGs->displayFieldError("products", "stock", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="featured_<?php echo $cnt1; ?>">Featured:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsproducts['featured']),"1"))) {echo "checked";} ?> type="checkbox" name="featured_<?php echo $cnt1; ?>" id="featured_<?php echo $cnt1; ?>" value="1" />
              <?php echo $tNGs->displayFieldError("products", "featured", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="online_<?php echo $cnt1; ?>">Online:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsproducts['online']),"1"))) {echo "checked";} ?> type="checkbox" name="online_<?php echo $cnt1; ?>" id="online_<?php echo $cnt1; ?>" value="1" />
              <?php echo $tNGs->displayFieldError("products", "online", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label for="isOnSale_<?php echo $cnt1; ?>">isOnSale:</label></td>
            <td><input  <?php if (!(strcmp(KT_escapeAttribute($row_rsproducts['isOnSale']),"1"))) {echo "checked";} ?> type="checkbox" name="isOnSale_<?php echo $cnt1; ?>" id="isOnSale_<?php echo $cnt1; ?>" value="1" />
              <?php echo $tNGs->displayFieldError("products", "isOnSale", $cnt1); ?></td>
          </tr>
          <tr>
            <td class="KT_th"><label>Subcategories:</label></td>
            <td><table border="0" class="KT_mtm">
              <tr>
                <?php
  $cnt2 = 0;
?>
                <?php
  if ($totalRows_rsproducts>0) {
    $nested_query_rssubcategories = str_replace("123456789", $row_rsproducts['id'], $query_rssubcategories);
    mysql_select_db($database_karaoke_db);
    $rssubcategories = mysql_query($nested_query_rssubcategories, $karaoke_db) or die(mysql_error());
    $row_rssubcategories = mysql_fetch_assoc($rssubcategories);
    $totalRows_rssubcategories = mysql_num_rows($rssubcategories);
    $nested_sw = false;
    if (isset($row_rssubcategories) && is_array($row_rssubcategories)) {
      do { //Nested repeat
?>
		
                <td><input id="mtm_<?php echo $row_rssubcategories['id']; ?>_<?php echo $cnt1; ?>" name="mtm_<?php echo $row_rssubcategories['id']; ?>_<?php echo $cnt1; ?>" type="checkbox" value="1" <?php if ($row_rssubcategories['products_id'] != "") {?> checked<?php }?> /></td>
                <td><label for="mtm_<?php echo $row_rssubcategories['id']; ?>_<?php echo $cnt1; ?>">(<strong><?php echo $row_rssubcategories['subcategorygroups_title']; ?></strong>) <?php echo $row_rssubcategories['title']; ?></label></td>
        
                <?php
	$cnt2++;
	if ($cnt2%3 == 0) {
		echo "</tr><tr>";
	}
?>
                <?php
      } while ($row_rssubcategories = mysql_fetch_assoc($rssubcategories)); //Nested move next
    }
  }
?>
              </tr>
            </table></td>
          </tr>
        </table>
        <input type="hidden" name="kt_pk_products_<?php echo $cnt1; ?>" class="id_field" value="<?php echo KT_escapeAttribute($row_rsproducts['kt_pk_products']); ?>" />
        <input type="hidden" name="date_modified_<?php echo $cnt1; ?>" id="date_modified_<?php echo $cnt1; ?>" value="<?php echo KT_formatDate($row_rsproducts['date_modified']); ?>" />
        <?php } while ($row_rsproducts = mysql_fetch_assoc($rsproducts)); ?>
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
mysql_free_result($rsManufacturers);

mysql_free_result($rsCategories);

mysql_free_result($rssubcategories);
?>
