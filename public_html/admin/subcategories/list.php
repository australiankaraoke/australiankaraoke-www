<?php require_once('../../../Connections/karaoke_db.php'); ?>
<?php
// Load the common classes
require_once('../../includes/common/KT_common.php');

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
$tor_listsubcategories1 = new TOR_SetOrder($conn_karaoke_db, 'subcategories', 'id', 'NUMERIC_TYPE', 'cardinality', 'listsubcategories1_cardinality_order');
$tor_listsubcategories1->Execute();

// Filter
$tfi_listsubcategories1 = new TFI_TableFilter($conn_karaoke_db, "tfi_listsubcategories1");
$tfi_listsubcategories1->addColumn("subcategorygroups.id", "NUMERIC_TYPE", "subcategorygroup_id", "=");
$tfi_listsubcategories1->addColumn("subcategories.title", "STRING_TYPE", "title", "%");
$tfi_listsubcategories1->Execute();

// Sorter
$tso_listsubcategories1 = new TSO_TableSorter("rssubcategories1", "tso_listsubcategories1");
$tso_listsubcategories1->addColumn("subcategories.cardinality"); // Order column
$tso_listsubcategories1->setDefault("subcategories.cardinality");
$tso_listsubcategories1->Execute();

// Navigation
$nav_listsubcategories1 = new NAV_Regular("nav_listsubcategories1", "rssubcategories1", "../../../", $_SERVER['PHP_SELF'], 10);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_Recordset1 = "SELECT title, id FROM subcategorygroups ORDER BY title";
$Recordset1 = mysql_query($query_Recordset1, $karaoke_db) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//NeXTenesio3 Special List Recordset
$maxRows_rssubcategories1 = $_SESSION['max_rows_nav_listsubcategories1'];
$pageNum_rssubcategories1 = 0;
if (isset($_GET['pageNum_rssubcategories1'])) {
  $pageNum_rssubcategories1 = $_GET['pageNum_rssubcategories1'];
}
$startRow_rssubcategories1 = $pageNum_rssubcategories1 * $maxRows_rssubcategories1;

// Defining List Recordset variable
$NXTFilter_rssubcategories1 = "1=1";
if (isset($_SESSION['filter_tfi_listsubcategories1'])) {
  $NXTFilter_rssubcategories1 = $_SESSION['filter_tfi_listsubcategories1'];
}
// Defining List Recordset variable
$NXTSort_rssubcategories1 = "subcategories.cardinality";
if (isset($_SESSION['sorter_tso_listsubcategories1'])) {
  $NXTSort_rssubcategories1 = $_SESSION['sorter_tso_listsubcategories1'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);

$query_rssubcategories1 = "SELECT subcategorygroups.title AS subcategorygroup_id, subcategories.title, subcategories.id, subcategories.cardinality FROM subcategories LEFT JOIN subcategorygroups ON subcategories.subcategorygroup_id = subcategorygroups.id WHERE {$NXTFilter_rssubcategories1} ORDER BY {$NXTSort_rssubcategories1}";
$query_limit_rssubcategories1 = sprintf("%s LIMIT %d, %d", $query_rssubcategories1, $startRow_rssubcategories1, $maxRows_rssubcategories1);
$rssubcategories1 = mysql_query($query_limit_rssubcategories1, $karaoke_db) or die(mysql_error());
$row_rssubcategories1 = mysql_fetch_assoc($rssubcategories1);

if (isset($_GET['totalRows_rssubcategories1'])) {
  $totalRows_rssubcategories1 = $_GET['totalRows_rssubcategories1'];
} else {
  $all_rssubcategories1 = mysql_query($query_rssubcategories1);
  $totalRows_rssubcategories1 = mysql_num_rows($all_rssubcategories1);
}
$totalPages_rssubcategories1 = ceil($totalRows_rssubcategories1/$maxRows_rssubcategories1)-1;
//End NeXTenesio3 Special List Recordset

$nav_listsubcategories1->checkBoundries();
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
  .KT_col_subcategorygroup_id {width:245px; overflow:hidden;}
  .KT_col_title {width:140px; overflow:hidden;}
</style>
<?php echo $tor_listsubcategories1->scriptDefinition(); ?>
</head>

<body>
<div class="KT_tng" id="listsubcategories1">
  <h1> Subcategories
    <?php
  $nav_listsubcategories1->Prepare();
  require("../../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listsubcategories1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listsubcategories1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listsubcategories1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listsubcategories1'] == 1) {
?>
          <a href="<?php echo $tfi_listsubcategories1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
          <?php 
  // else Conditional region2
  } else { ?>
          <a href="<?php echo $tfi_listsubcategories1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
          <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="subcategorygroup_id" class="KT_col_subcategorygroup_id">Subcategorygroup_id</th>
            <th id="title" class="KT_col_title">Title</th>
            <th id="cardinality" class="KT_sorter <?php echo $tso_listsubcategories1->getSortIcon('subcategories.cardinality'); ?> KT_order"> <a href="<?php echo $tso_listsubcategories1->getSortLink('subcategories.cardinality'); ?>"><?php echo NXT_getResource("Order"); ?></a> <a class="KT_move_op_link" href="#" onclick="nxt_list_move_link_form(this); return false;"><?php echo NXT_getResource("save"); ?></a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listsubcategories1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><select name="tfi_listsubcategories1_subcategorygroup_id" id="tfi_listsubcategories1_subcategorygroup_id">
                <option value="" <?php if (!(strcmp("", @$_SESSION['tfi_listsubcategories1_subcategorygroup_id']))) {echo "SELECTED";} ?>><?php echo NXT_getResource("None"); ?></option>
                <?php
do {  
?>
                <option value="<?php echo $row_Recordset1['id']?>"<?php if (!(strcmp($row_Recordset1['id'], @$_SESSION['tfi_listsubcategories1_subcategorygroup_id']))) {echo "SELECTED";} ?>><?php echo $row_Recordset1['title']?></option>
                <?php
} while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
  $rows = mysql_num_rows($Recordset1);
  if($rows > 0) {
      mysql_data_seek($Recordset1, 0);
	  $row_Recordset1 = mysql_fetch_assoc($Recordset1);
  }
?>
              </select></td>
              <td><input type="text" name="tfi_listsubcategories1_title" id="tfi_listsubcategories1_title" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listsubcategories1_title']); ?>" size="20" maxlength="60" /></td>
              <td>&nbsp;</td>
              <td><input type="submit" name="tfi_listsubcategories1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rssubcategories1 == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="5"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rssubcategories1 > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_subcategories" class="id_checkbox" value="<?php echo $row_rssubcategories1['id']; ?>" />
                  <input type="hidden" name="id" class="id_field" value="<?php echo $row_rssubcategories1['id']; ?>" /></td>
                <td><div class="KT_col_subcategorygroup_id"><?php echo KT_FormatForList($row_rssubcategories1['subcategorygroup_id'], 35); ?></div></td>
                <td><div class="KT_col_title"><?php echo KT_FormatForList($row_rssubcategories1['title'], 20); ?></div></td>
                <td class="KT_order"><input type="hidden" class="KT_orderhidden" name="<?php echo $tor_listsubcategories1->getOrderFieldName() ?>" value="<?php echo $tor_listsubcategories1->getOrderFieldValue($row_rssubcategories1) ?>" />
                  <a class="KT_movedown_link" href="#move_down">v</a> <a class="KT_moveup_link" href="#move_up">^</a></td>
                <td><a class="KT_edit_link" href="form.php?id=<?php echo $row_rssubcategories1['id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
              </tr>
              <?php } while ($row_rssubcategories1 = mysql_fetch_assoc($rssubcategories1)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listsubcategories1->Prepare();
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

mysql_free_result($rssubcategories1);
?>
