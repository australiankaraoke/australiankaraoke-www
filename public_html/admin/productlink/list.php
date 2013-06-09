<?php require_once('../../../Connections/karaoke_db.php'); ?>
<?php
// Load the common classes
require_once('../../includes/common/KT_common.php');

// Load the required classes
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

// Filter
$tfi_listproducts_subcategories1 = new TFI_TableFilter($conn_karaoke_db, "tfi_listproducts_subcategories1");
$tfi_listproducts_subcategories1->addColumn("products.id", "NUMERIC_TYPE", "products_id", "=");
$tfi_listproducts_subcategories1->addColumn("subcategories.id", "NUMERIC_TYPE", "subcategories_id", "=");
$tfi_listproducts_subcategories1->Execute();

// Sorter
$tso_listproducts_subcategories1 = new TSO_TableSorter("rsproducts_subcategories1", "tso_listproducts_subcategories1");
$tso_listproducts_subcategories1->addColumn("products.sku");
$tso_listproducts_subcategories1->addColumn("subcategories.title");
$tso_listproducts_subcategories1->setDefault("products_subcategories.products_id");
$tso_listproducts_subcategories1->Execute();

// Navigation
$nav_listproducts_subcategories1 = new NAV_Regular("nav_listproducts_subcategories1", "rsproducts_subcategories1", "../../../", $_SERVER['PHP_SELF'], 10);

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

//NeXTenesio3 Special List Recordset
$maxRows_rsproducts_subcategories1 = $_SESSION['max_rows_nav_listproducts_subcategories1'];
$pageNum_rsproducts_subcategories1 = 0;
if (isset($_GET['pageNum_rsproducts_subcategories1'])) {
  $pageNum_rsproducts_subcategories1 = $_GET['pageNum_rsproducts_subcategories1'];
}
$startRow_rsproducts_subcategories1 = $pageNum_rsproducts_subcategories1 * $maxRows_rsproducts_subcategories1;

// Defining List Recordset variable
$NXTFilter_rsproducts_subcategories1 = "1=1";
if (isset($_SESSION['filter_tfi_listproducts_subcategories1'])) {
  $NXTFilter_rsproducts_subcategories1 = $_SESSION['filter_tfi_listproducts_subcategories1'];
}
// Defining List Recordset variable
$NXTSort_rsproducts_subcategories1 = "products_subcategories.products_id";
if (isset($_SESSION['sorter_tso_listproducts_subcategories1'])) {
  $NXTSort_rsproducts_subcategories1 = $_SESSION['sorter_tso_listproducts_subcategories1'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);

$query_rsproducts_subcategories1 = "SELECT products.sku AS products_id, subcategories.title AS subcategories_id, products_subcategories.id FROM (products_subcategories LEFT JOIN products ON products_subcategories.products_id = products.id) LEFT JOIN subcategories ON products_subcategories.subcategories_id = subcategories.id WHERE {$NXTFilter_rsproducts_subcategories1} ORDER BY {$NXTSort_rsproducts_subcategories1}";
$query_limit_rsproducts_subcategories1 = sprintf("%s LIMIT %d, %d", $query_rsproducts_subcategories1, $startRow_rsproducts_subcategories1, $maxRows_rsproducts_subcategories1);
$rsproducts_subcategories1 = mysql_query($query_limit_rsproducts_subcategories1, $karaoke_db) or die(mysql_error());
$row_rsproducts_subcategories1 = mysql_fetch_assoc($rsproducts_subcategories1);

if (isset($_GET['totalRows_rsproducts_subcategories1'])) {
  $totalRows_rsproducts_subcategories1 = $_GET['totalRows_rsproducts_subcategories1'];
} else {
  $all_rsproducts_subcategories1 = mysql_query($query_rsproducts_subcategories1);
  $totalRows_rsproducts_subcategories1 = mysql_num_rows($all_rsproducts_subcategories1);
}
$totalPages_rsproducts_subcategories1 = ceil($totalRows_rsproducts_subcategories1/$maxRows_rsproducts_subcategories1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listproducts_subcategories1->checkBoundries();
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
  .KT_col_products_id {width:210px; overflow:hidden;}
  .KT_col_subcategories_id {width:210px; overflow:hidden;}
</style>
</head>

<body>
<div class="KT_tng" id="listproducts_subcategories1">
  <h1> Products_subcategories
    <?php
  $nav_listproducts_subcategories1->Prepare();
  require("../../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listproducts_subcategories1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listproducts_subcategories1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listproducts_subcategories1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listproducts_subcategories1'] == 1) {
?>
          <a href="<?php echo $tfi_listproducts_subcategories1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
          <?php 
  // else Conditional region2
  } else { ?>
          <a href="<?php echo $tfi_listproducts_subcategories1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
          <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="products_id" class="KT_sorter KT_col_products_id <?php echo $tso_listproducts_subcategories1->getSortIcon('products.sku'); ?>"> <a href="<?php echo $tso_listproducts_subcategories1->getSortLink('products.sku'); ?>">Products_id</a></th>
            <th id="subcategories_id" class="KT_sorter KT_col_subcategories_id <?php echo $tso_listproducts_subcategories1->getSortIcon('subcategories.title'); ?>"> <a href="<?php echo $tso_listproducts_subcategories1->getSortLink('subcategories.title'); ?>">Subcategories_id</a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listproducts_subcategories1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><select name="tfi_listproducts_subcategories1_products_id" id="tfi_listproducts_subcategories1_products_id">
                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listproducts_subcategories1_products_id']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset1['id']?>"<?php if (!(strcmp($row_Recordset1['id'], @$_SESSION['tfi_listproducts_subcategories1_products_id']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['sku']?></option>
                <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
              </select></td>
              <td><select name="tfi_listproducts_subcategories1_subcategories_id" id="tfi_listproducts_subcategories1_subcategories_id">
                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listproducts_subcategories1_subcategories_id']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset2['id']?>"<?php if (!(strcmp($row_Recordset2['id'], @$_SESSION['tfi_listproducts_subcategories1_subcategories_id']))) {echo "SELECTED";} ?>><?php echo $row_Recordset2['title']?></option>
                <?php
} while ($row_Recordset2 = mysql_fetch_assoc($Recordset2));
  $rows = mysql_num_rows($Recordset2);
  if($rows > 0) {
      mysql_data_seek($Recordset2, 0);
	  $row_Recordset2 = mysql_fetch_assoc($Recordset2);
  }
?>
              </select></td>
              <td><input type="submit" name="tfi_listproducts_subcategories1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsproducts_subcategories1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="4"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsproducts_subcategories1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_products_subcategories" class="id_checkbox" value="<?php echo $row_rsproducts_subcategories1['id']; ?>" />
                  <input type="hidden" name="id" class="id_field" value="<?php echo $row_rsproducts_subcategories1['id']; ?>" /></td>
                <td><div class="KT_col_products_id"><?php echo KT_FormatForList($row_rsproducts_subcategories1['products_id'], 30); ?></div></td>
                <td><div class="KT_col_subcategories_id"><?php echo KT_FormatForList($row_rsproducts_subcategories1['subcategories_id'], 30); ?></div></td>
                <td><a class="KT_edit_link" href="form.php?id=<?php echo $row_rsproducts_subcategories1['id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
              </tr>
              <?php } while ($row_rsproducts_subcategories1 = mysql_fetch_assoc($rsproducts_subcategories1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listproducts_subcategories1->Prepare();
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

mysql_free_result($Recordset2);

mysql_free_result($rsproducts_subcategories1);
?>
