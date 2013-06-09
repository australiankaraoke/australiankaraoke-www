<?php require_once('../../Connections/karaoke_db.php'); ?>
<?php
// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

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
$query_rs_manufacturers_loop = "SELECT * FROM v_index_manufacturers";
$rs_manufacturers_loop = mysql_query($query_rs_manufacturers_loop, $karaoke_db) or die(mysql_error());
$row_rs_manufacturers_loop = mysql_fetch_assoc($rs_manufacturers_loop);
$totalRows_rs_manufacturers_loop = mysql_num_rows($rs_manufacturers_loop);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_categories_loop = "SELECT * FROM v_index_categories";
$rs_categories_loop = mysql_query($query_rs_categories_loop, $karaoke_db) or die(mysql_error());
$row_rs_categories_loop = mysql_fetch_assoc($rs_categories_loop);
$totalRows_rs_categories_loop = mysql_num_rows($rs_categories_loop);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rs_manufacturers_loop.filename}");
$objDynamicThumb1->setResize(75, 35, true);
$objDynamicThumb1->setWatermark(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script src="/frameworks/masonry/masonry.js"></script>
<style>
.masonryItem {
  width: 160px;
  margin: 10px;
  float: left;
  border-top: 1px solid grey;
  padding-top: 5px;
  //border: 1px solid green;
}
.categoryLink {
	font-size: 11px;
}
.categoryLink a {
	color: #900;
	text-decoration: none;
}
.categoryLink a:link {
	color: #900;
	text-decoration: none;
}
.categoryLink a:hover {
	color: #900;
	text-decoration: underline;
}
.categoryLink a:visited {
	color: #900;
	text-decoration: none;
}
.categoryLink a:active {
	color: #900;
	text-decoration: underline;
}
</style>
</head>
<body>
<div style="position: relative; width: 100%; margin: 25px;padding-left: 20px;">
	<div id="masonryContainer">
    
	  <?php do { ?> <!-- outer loop -->
      <div class="masonryItem">
        <img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" style="margin-top: 5px;"/>
        	<?php do { ?> <!-- inner loop -->
				<?
                if (($row_rs_manufacturers_loop['id'] == $row_rs_categories_loop['manufacturer_id']) && ($previousCategory<>$row_rs_categories_loop['categories_id'])) {
                ?>
                    <div class="categoryLink">
	                    <a href="/products/?categories_id=<?php echo $row_rs_categories_loop['categories_id']; ?>&categories_title=<?php echo $row_rs_categories_loop['categories_title']; ?>&manufacturer_id=<?php echo $row_rs_categories_loop['manufacturer_id']; ?>&manufacturer_title=<?php echo $row_rs_manufacturers_loop['title']; ?>">
	                    	<div style="margin-left: 10px;"><?php echo $row_rs_categories_loop['categories_title']; ?></div>
	                    </a>
                    </div>
                <?
                $previousCategory = $row_rs_categories_loop['categories_id'];
                }
                ?>
                <?
                
                ?>
            <?php } while ($row_rs_categories_loop = mysql_fetch_assoc($rs_categories_loop)); ?> <!-- END::inner loop -->
      </div>
      
      	<?    
           mysql_data_seek($rs_categories_loop,0);  
		?>
	    <?php } while ($row_rs_manufacturers_loop = mysql_fetch_assoc($rs_manufacturers_loop)); ?> <!-- END::outer loop -->
  </div><div style="clear: both;"></div>
</div>
<div style="position: relative; border-bottom: 1px solid grey; margin: 25px;"></div>
<script>
$('#masonryContainer').masonry({
    // options
    itemSelector : '.masonryItem',
    columnWidth : 180,
    isResizable: true
});
</script>
</body>
</html>
<?php
mysql_free_result($rs_manufacturers_loop);

mysql_free_result($rs_categories_loop);
?>
