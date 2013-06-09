<?php require_once('../../Connections/karaoke_db.php'); ?>
<?php
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

$colname_rs_included = "-1";
if (isset($_GET['system_id'])) {
  $colname_rs_included = $_GET['system_id'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_included = sprintf("SELECT * FROM v_systems_complete WHERE systems_id = %s GROUP BY products_id", GetSQLValueString($colname_rs_included, "int"));
$rs_included = mysql_query($query_rs_included, $karaoke_db) or die(mysql_error());
$row_rs_included = mysql_fetch_assoc($rs_included);
$totalRows_rs_included = mysql_num_rows($rs_included);
?>
<link href='http://fonts.googleapis.com/css?family=Scada:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
<div style="font-family: 'Scada', sans-serif; color: #666;font-size: 16px;">
<ul>
<?php do { ?>

	<li><?php echo $row_rs_included['systems_products_quantity']; ?>x <?
	if($row_rs_included['subcategories_subcategorygroup_id']) {
		$setSubcategoryGroupsId=$row_rs_included['subcategories_subcategorygroup_id'];
	} else {
		$setSubcategoryGroupsId=0;
	}

	if($row_rs_included['subcategories_id']) {
		$setSubcategoriesId=$row_rs_included['subcategories_id'];
	} else {
		$setSubcategoriesId=0;
	}

	if($row_rs_included['subcategories_title']) {
		$setSubcategories_title=$row_rs_included['subcategories_title'];
	} else {
		$setSubcategories_title=0;
	}

?>
	<a href="/product/<?php echo $row_rs_included['categories_id']; ?>/<?php echo $setSubcategoryGroupsId; ?>/<?php echo $setSubcategoriesId; ?>/<?php echo $row_rs_included['products_id']; ?>/<?php echo $setSubcategories_title; ?>/<?php echo str_replace(' ', '-',$row_rs_included['categories_title']); ?>/<?php echo str_replace(' ', '-',$row_rs_included['manufacturers_title']); ?>-<?php echo str_replace(' ', '-',$row_rs_included['products_sku']); ?>/" target="_parent"><!--<a href="/products/index.php?product_id=<?php echo $row_rs_included['products_id']; ?>&category=<?php echo $row_rs_included['systems_filename']; ?>&manufacturer=<?php echo $row_rs_included['systems_products_system_id']; ?>&product=<?php echo $row_rs_included['products_sku']; ?>" target="_parent">--><?php echo $row_rs_included['manufacturers_title']; ?> <?php echo $row_rs_included['products_sku']; ?></a> (<?php echo $row_rs_included['products_title']; ?>)</li>
	
<?php } while ($row_rs_included = mysql_fetch_assoc($rs_included)); ?>
<li>All connection leads provided!</li>
</ul>
</div>

<?php
mysql_free_result($rs_included);
?>
