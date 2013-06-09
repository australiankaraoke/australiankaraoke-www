<?php require_once('../../../Connections/karaoke_db.php'); ?>
<?php
// Load the common classes
require_once('../../../includes/common/KT_common.php');

// Load the required classes
require_once('../../../includes/tor/TOR.php');
require_once('../../../includes/tfi/TFI.php');
require_once('../../../includes/tso/TSO.php');
require_once('../../../includes/nav/NAV.php');

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
$tor_listrsblog1 = new TOR_SetOrder($conn_karaoke_db, 'blog', 'id', 'NUMERIC_TYPE', 'cardinality', 'listrsblog1_cardinality_order');
$tor_listrsblog1->Execute();

// Filter
$tfi_listrsblog1 = new TFI_TableFilter($conn_karaoke_db, "tfi_listrsblog1");
$tfi_listrsblog1->addColumn("title", "STRING_TYPE", "title", "%");
$tfi_listrsblog1->addColumn("date_modified", "DATE_TYPE", "date_modified", "=");
$tfi_listrsblog1->addColumn("isOnline", "STRING_TYPE", "isOnline", "%");
$tfi_listrsblog1->Execute();

// Sorter
$tso_listrsblog1 = new TSO_TableSorter("rsblog", "tso_listrsblog1");
$tso_listrsblog1->addColumn("cardinality"); // Order column
$tso_listrsblog1->setDefault("cardinality");
$tso_listrsblog1->Execute();

// Navigation
$nav_listrsblog1 = new NAV_Regular("nav_listrsblog1", "rsblog", "../../../", $_SERVER['PHP_SELF'], 25);

//NeXTenesio3 Special List Recordset
$maxRows_rsblog = $_SESSION['max_rows_nav_listrsblog1'];
$pageNum_rsblog = 0;
if (isset($_GET['pageNum_rsblog'])) {
  $pageNum_rsblog = $_GET['pageNum_rsblog'];
}
$startRow_rsblog = $pageNum_rsblog * $maxRows_rsblog;

// Defining List Recordset variable
$NXTFilter_rsblog = "1=1";
if (isset($_SESSION['filter_tfi_listrsblog1'])) {
  $NXTFilter_rsblog = $_SESSION['filter_tfi_listrsblog1'];
}
// Defining List Recordset variable
$NXTSort_rsblog = "cardinality";
if (isset($_SESSION['sorter_tso_listrsblog1'])) {
  $NXTSort_rsblog = $_SESSION['sorter_tso_listrsblog1'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);

$query_rsblog = "SELECT blog.id, blog.title, blog.`description`, blog.filename, blog.isOnline, blog.date_modified, blog.cardinality  FROM blog WHERE {$NXTFilter_rsblog} ORDER BY {$NXTSort_rsblog} ";
$query_limit_rsblog = sprintf("%s LIMIT %d, %d", $query_rsblog, $startRow_rsblog, $maxRows_rsblog);
$rsblog = mysql_query($query_limit_rsblog, $karaoke_db) or die(mysql_error());
$row_rsblog = mysql_fetch_assoc($rsblog);

if (isset($_GET['totalRows_rsblog'])) {
  $totalRows_rsblog = $_GET['totalRows_rsblog'];
} else {
  $all_rsblog = mysql_query($query_rsblog);
  $totalRows_rsblog = mysql_num_rows($all_rsblog);
}
$totalPages_rsblog = ceil($totalRows_rsblog/$maxRows_rsblog)-1;
//End NeXTenesio3 Special List Recordset

$nav_listrsblog1->checkBoundries();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<link href="../../../includes/skins/mxkollection3.css" rel="stylesheet" type="text/css" media="all" />
<script src="../../../includes/common/js/base.js" type="text/javascript"></script>
<script src="../../../includes/common/js/utility.js" type="text/javascript"></script>
<script src="../../../includes/skins/style.js" type="text/javascript"></script>
<script src="../../../includes/nxt/scripts/list.js" type="text/javascript"></script>
<script src="../../../includes/nxt/scripts/list.js.php" type="text/javascript"></script>
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
  .KT_col_title {width:210px; overflow:hidden;}
  .KT_col_date_modified {width:140px; overflow:hidden;}
  .KT_col_isOnline {width:42px; overflow:hidden;}
</style>
<?php echo $tor_listrsblog1->scriptDefinition(); ?>
</head>

<body>
<div class="KT_tng" id="listrsblog1">
  <h1> Blog
    <?php
  $nav_listrsblog1->Prepare();
  require("../../../includes/nav/NAV_Text_Statistics.inc.php");
?>
  </h1>
  <div class="KT_tnglist">
    <form action="<?php echo KT_escapeAttribute(KT_getFullUri()); ?>" method="post" id="form1">
      <div class="KT_options"> <a href="<?php echo $nav_listrsblog1->getShowAllLink(); ?>"><?php echo NXT_getResource("Show"); ?>
        <?php 
  // Show IF Conditional region1
  if (@$_GET['show_all_nav_listrsblog1'] == 1) {
?>
          <?php echo $_SESSION['default_max_rows_nav_listrsblog1']; ?>
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
  if (@$_SESSION['has_filter_tfi_listrsblog1'] == 1) {
?>
          <a href="<?php echo $tfi_listrsblog1->getResetFilterLink(); ?>"><?php echo NXT_getResource("Reset filter"); ?></a>
          <?php 
  // else Conditional region2
  } else { ?>
          <a href="<?php echo $tfi_listrsblog1->getShowFilterLink(); ?>"><?php echo NXT_getResource("Show filter"); ?></a>
          <?php } 
  // endif Conditional region2
?>
      </div>
      <table cellpadding="2" cellspacing="0" class="KT_tngtable">
        <thead>
          <tr class="KT_row_order">
            <th> <input type="checkbox" name="KT_selAll" id="KT_selAll"/>
            </th>
            <th id="title" class="KT_col_title">Title</th>
            <th id="date_modified" class="KT_col_date_modified">Date_modified</th>
            <th id="isOnline" class="KT_col_isOnline">isOnline</th>
<th id="cardinality" class="KT_sorter <?php echo $tso_listrsblog1->getSortIcon('cardinality'); ?> KT_order"> <a href="<?php echo $tso_listrsblog1->getSortLink('cardinality'); ?>"><?php echo NXT_getResource("Order"); ?></a> <a class="KT_move_op_link" href="#" onclick="nxt_list_move_link_form(this); return false;"><?php echo NXT_getResource("save"); ?></a></th>
            <th>&nbsp;</th>
          </tr>
          <?php 
  // Show IF Conditional region3
  if (@$_SESSION['has_filter_tfi_listrsblog1'] == 1) {
?>
            <tr class="KT_row_filter">
              <td>&nbsp;</td>
              <td><input type="text" name="tfi_listrsblog1_title" id="tfi_listrsblog1_title" value="<?php echo KT_escapeAttribute(@$_SESSION['tfi_listrsblog1_title']); ?>" size="30" maxlength="20" /></td>
              <td><input type="text" name="tfi_listrsblog1_date_modified" id="tfi_listrsblog1_date_modified" value="<?php echo @$_SESSION['tfi_listrsblog1_date_modified']; ?>" size="10" maxlength="22" /></td>
              <td><select name="tfi_listrsblog1_isOnline" id="tfi_listrsblog1_isOnline">
                <option value="0" <?php if (!(strcmp(0, KT_escapeAttribute(@$_SESSION['tfi_listrsblog1_isOnline'])))) {echo "SELECTED";} ?>>NO</option>
                <option value="1" <?php if (!(strcmp(1, KT_escapeAttribute(@$_SESSION['tfi_listrsblog1_isOnline'])))) {echo "SELECTED";} ?>>YES</option>
              </select></td>
              <td>&nbsp;</td>
              <td><input type="submit" name="tfi_listrsblog1" value="<?php echo NXT_getResource("Filter"); ?>" /></td>
            </tr>
            <?php } 
  // endif Conditional region3
?>
        </thead>
        <tbody>
          <?php if ($totalRows_rsblog == 0) { // Show if recordset empty ?>
            <tr>
              <td colspan="6"><?php echo NXT_getResource("The table is empty or the filter you've selected is too restrictive."); ?></td>
            </tr>
            <?php } // Show if recordset empty ?>
          <?php if ($totalRows_rsblog > 0) { // Show if recordset not empty ?>
            <?php do { ?>
              <tr class="<?php echo @$cnt1++%2==0 ? "" : "KT_even"; ?>">
                <td><input type="checkbox" name="kt_pk_blog" class="id_checkbox" value="<?php echo $row_rsblog['id']; ?>" />
                  <input type="hidden" name="id" class="id_field" value="<?php echo $row_rsblog['id']; ?>" /></td>
                <td><div class="KT_col_title"><?php echo KT_FormatForList($row_rsblog['title'], 30); ?></div></td>
                <td><div class="KT_col_date_modified"><?php echo KT_formatDate($row_rsblog['date_modified']); ?></div></td>
                <td><div class="KT_col_isOnline"><?php echo KT_FormatForList($row_rsblog['isOnline'], 6); ?></div></td>
                <td class="KT_order"><input type="hidden" class="KT_orderhidden" name="<?php echo $tor_listrsblog1->getOrderFieldName() ?>" value="<?php echo $tor_listrsblog1->getOrderFieldValue($row_rsblog) ?>" />
                  <a class="KT_movedown_link" href="#move_down">v</a> <a class="KT_moveup_link" href="#move_up">^</a></td>
                <td><a class="KT_edit_link" href="form.php?id=<?php echo $row_rsblog['id']; ?>&amp;KT_back=1"><?php echo NXT_getResource("edit_one"); ?></a> <a class="KT_delete_link" href="#delete"><?php echo NXT_getResource("delete_one"); ?></a></td>
              </tr>
              <?php } while ($row_rsblog = mysql_fetch_assoc($rsblog)); ?>
            <?php } // Show if recordset not empty ?>
        </tbody>
      </table>
      <div class="KT_bottomnav">
        <div>
          <?php
            $nav_listrsblog1->Prepare();
            require("../../../includes/nav/NAV_Text_Navigation.inc.php");
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
mysql_free_result($rsblog);
?>
