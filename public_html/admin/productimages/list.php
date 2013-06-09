<?php require_once('../../../Connections/karaoke_db.php'); ?>
<?php
// Load the common classes
require_once('../../includes/common/KT_common.php');

// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

// Load the required classes
require_once('../../includes/tor/TOR.php');
require_once('../../includes/tfi/TFI.php');
require_once('../../includes/tso/TSO.php');
require_once('../../includes/nav/NAV.php');

// Make unified connection variable
$conn_karaoke_db = new KT_connection($karaoke_db, $database_karaoke_db);

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

// Order
$tor_listproductimages1 = new TOR_SetOrder($conn_karaoke_db, 'productimages', 'id', 'NUMERIC_TYPE', 'cardinality', 'listproductimages1_cardinality_order');
$tor_listproductimages1->Execute();

// Filter
$tfi_listproductimages1 = new TFI_TableFilter($conn_karaoke_db, "tfi_listproductimages1");
$tfi_listproductimages1->addColumn("products.id", "NUMERIC_TYPE", "product_id", "=");
$tfi_listproductimages1->addColumn("productimages.title", "STRING_TYPE", "title", "%");
$tfi_listproductimages1->addColumn("productimages.filename", "STRING_TYPE", "filename", "%");
$tfi_listproductimages1->Execute();

// Sorter
$tso_listproductimages1 = new TSO_TableSorter("rsproductimages1", "tso_listproductimages1");
$tso_listproductimages1->addColumn("productimages.cardinality"); // Order column
$tso_listproductimages1->setDefault("productimages.cardinality");
$tso_listproductimages1->Execute();

// Navigation
$nav_listproductimages1 = new NAV_Regular("nav_listproductimages1", "rsproductimages1", "../../../", $_SERVER['PHP_SELF'], 10);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_Recordset1 = "SELECT sku, id FROM products ORDER BY sku";
$Recordset1 = mysql_query($query_Recordset1, $karaoke_db) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//NeXTenesio3 Special List Recordset
$maxRows_rsproductimages1 = $_SESSION['max_rows_nav_listproductimages1'];
$pageNum_rsproductimages1 = 0;
if (isset($_GET['pageNum_rsproductimages1'])) {
  $pageNum_rsproductimages1 = $_GET['pageNum_rsproductimages1'];
}
$startRow_rsproductimages1 = $pageNum_rsproductimages1 * $maxRows_rsproductimages1;

// Defining List Recordset variable
$NXTFilter_rsproductimages1 = "1=1";
if (isset($_SESSION['filter_tfi_listproductimages1'])) {
  $NXTFilter_rsproductimages1 = $_SESSION['filter_tfi_listproductimages1'];
}
// Defining List Recordset variable
$NXTSort_rsproductimages1 = "productimages.cardinality";
if (isset($_SESSION['sorter_tso_listproductimages1'])) {
  $NXTSort_rsproductimages1 = $_SESSION['sorter_tso_listproductimages1'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);

$query_rsproductimages1 = "SELECT products.sku AS product_id, productimages.title, productimages.filename, productimages.id, productimages.cardinality FROM productimages LEFT JOIN products ON productimages.product_id = products.id WHERE {$NXTFilter_rsproductimages1} ORDER BY {$NXTSort_rsproductimages1}";
$query_limit_rsproductimages1 = sprintf("%s LIMIT %d, %d", $query_rsproductimages1, $startRow_rsproductimages1, $maxRows_rsproductimages1);
$rsproductimages1 = mysql_query($query_limit_rsproductimages1, $karaoke_db) or die(mysql_error());
$row_rsproductimages1 = mysql_fetch_assoc($rsproductimages1);

if (isset($_GET['totalRows_rsproductimages1'])) {
  $totalRows_rsproductimages1 = $_GET['totalRows_rsproductimages1'];
} else {
  $all_rsproductimages1 = mysql_query($query_rsproductimages1);
  $totalRows_rsproductimages1 = mysql_num_rows($all_rsproductimages1);
}
$totalPages_rsproductimages1 = ceil($totalRows_rsproductimages1/$maxRows_rsproductimages1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listproductimages1->checkBoundries();

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rsproductimages1.filename}");
$objDynamicThumb1->setResize(180, 180, true);
$objDynamicThumb1->setWatermark(false);
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
<script src="../../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
<script type="text/javascript">
$NXT_LIST_SETTINGS = {
  duplicate_buttons: true,
  duplicate_navigation: true,
  row_effects: true,
  show_as_buttons: true,
  record_counter: true
}
</script>
<style type="text/css">
  /* Dynamic List row settings */
  .KT_col_product_id {width:105px; overflow:hidden;}
  .KT_col_title {width:140px; overflow:hidden;}
  .KT_col_filename {width:175px; overflow:hidden;}
</style>
<?php echo $tor_listproductimages1->scriptDefinition(); ?>
</head>

<body>
<div class="KT_tng" id="listproductimages1">
  <h1> Productimages
    <?php
  $nav_listproductimages1->Prepare();
  require("../../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listproductimages1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listproductimages1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listproductimages1']; ?>
          <?php 
  // else Conditional region1
  } else { ?>
          <?php echo NXT_getResource("all"); ?>
          <?php } 
  // endif Conditional region1
?>
<?php echo NXT_getResource("records"); ?></a> &nbsp;
        &nbsp;
        <?php 
  // Show IF Conditional region2
  if (@$_SESSION['has_filter_tfi_listproductimages1'] == 1) {
?>
          <a href="<?php echo $tfi_listproductimages1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
          <?php 
  // else Conditional region2
  } else { ?>
          <a href="<?php echo $tfi_listproductimages1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
          <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="product_id" class="KT_col_product_id">Product_id</th>
            <th id="title" class="KT_col_title">Title</th>
            <th id="filename" class="KT_col_filename">Filename</th>
            <th id="cardinality" class="KT_sorter <?php echo $tso_listproductimages1->getSortIcon('productimages.cardinality'); ?> KT_order"> <a href="<?php echo $tso_listproductimages1->getSortLink('productimages.cardinality'); ?>"><?php echo NXT_getResource("Order"); ?></a> <a class="KT_move_op_link" href="#" onclick="nxt_list_move_link_form(this); return false;"><?php echo NXT_getResource("save"); ?></a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listproductimages1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><select name="tfi_listproductimages1_product_id" id="tfi_listproductimages1_product_id">
                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listproductimages1_product_id']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset1['id']?>"<?php if (!(strcmp($row_Recordset1['id'], @$_SESSION['tfi_listproductimages1_product_id']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['sku']?></option>
                <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
              </select></td>
              <td><input type="text" name="tfi_listproductimages1_title" id="tfi_listproductimages1_title" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listproductimages1_title']); ?>" size="20" maxlength="60" /></td>
              <td><input type="text" name="tfi_listproductimages1_filename" id="tfi_listproductimages1_filename" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listproductimages1_filename']); ?>" size="25" maxlength="250" /></td>
              <td>&nbsp;</td>
              <td><input type="submit" name="tfi_listproductimages1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsproductimages1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="6"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsproductimages1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_productimages" class="id_checkbox" value="<?php echo $row_rsproductimages1['id']; ?>" />
                  <input type="hidden" name="id" class="id_field" value="<?php echo $row_rsproductimages1['id']; ?>" /></td>
                <td><div class="KT_col_product_id"><?php echo KT_FormatForList($row_rsproductimages1['product_id'], 15); ?></div></td>
                <td><div class="KT_col_title"><?php echo KT_FormatForList($row_rsproductimages1['title'], 20); ?></div></td>
                <td><div class="KT_col_filename"><img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" /></div></td>
                <td class="KT_order"><input type="hidden" class="KT_orderhidden" name="<?php echo $tor_listproductimages1->getOrderFieldName() ?>" value="<?php echo $tor_listproductimages1->getOrderFieldValue($row_rsproductimages1) ?>" />
                  <a class="KT_movedown_link" href="#move_down">v</a> <a class="KT_moveup_link" href="#move_up">^</a></td>
                <td><a class="KT_edit_link" href="form.php?id=<?php echo $row_rsproductimages1['id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
              </tr>
              <?php } while ($row_rsproductimages1 = mysql_fetch_assoc($rsproductimages1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listproductimages1->Prepare();
            require("../../includes/nav/NAV_Text_Navigation.inc.php");
          ?>
        </div>
      </div>
      <div class="KT_bottombuttons">
        <div class="KT_operations"> <a class="KT_edit_op_link" href="#" onclick="nxt_list_edit_link_form(this); return false;"><?php echo NXT_getResource("edit_all"); ?></a> <a class="KT_delete_op_link" href="#" onclick="nxt_list_delete_link_form(this); return false;"><?php echo NXT_getResource("delete_all"); ?></a></div>
        <span>&nbsp;</span>
        <select name="no_new" id="no_new">
          <option value="1">1</option>
          <option value="3">3</option>
          <option value="6">6</option>
        </select>
        <a class="KT_additem_op_link" href="form.php?KT_back=1" onclick="return nxt_list_additem(this)"><?php echo NXT_getResource("add new"); ?></a></div>
    </form>
  </div>
  <br class="clearfixplain" />
</div>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($rsproductimages1);
?>
