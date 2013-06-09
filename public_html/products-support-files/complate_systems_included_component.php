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

$colname_rs_included_components = "-1";
if (isset($_POST['system_id'])) {
  $colname_rs_included_components = $_POST['system_id'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_included_components = sprintf("SELECT * FROM v_systems_complete WHERE systems_id = %s  GROUP BY products_id ORDER BY categories_id ASC", GetSQLValueString($colname_rs_included_components, "int"));
$rs_included_components = mysql_query($query_rs_included_components, $karaoke_db) or die(mysql_error());
$row_rs_included_components = mysql_fetch_assoc($rs_included_components);
$totalRows_rs_included_components = mysql_num_rows($rs_included_components);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rs_included_components.products_filename}");
$objDynamicThumb1->setResize(90, 90, true);
$objDynamicThumb1->setWatermark(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>

<div style="position: relative; margin-top: 15px; width: 944px; margin-left: 25px; height: 110px;">
        
        
        
        <?php do { ?>
          <div style="position: relative; margin-left: 10px; float: left; height: 96px; width: 96px; margin-top: 8px;  background-color: rgba(255,255,255,1); border: 1px solid grey;  text-align:center; display: table; ">
            
            <div style="display:table-cell;vertical-align:middle; width:96px; height: 96px; overflow: hidden;">
            
            <?
			if($row_rs_included_components['subcategories_subcategorygroup_id']) {
				$setSubcategoryGroupsId=$row_rs_included_components['subcategories_subcategorygroup_id'];
			} else {
				$setSubcategoryGroupsId=0;
			}
		
			if($row_rs_included_components['subcategories_id']) {
				$setSubcategoriesId=$row_rs_included_components['subcategories_id'];
			} else {
				$setSubcategoriesId=0;
			}
		
			if($row_rs_included_components['subcategories_title']) {
				$setSubcategories_title=$row_rs_included_components['subcategories_title'];
			} else {
				$setSubcategories_title=0;
			}
		
		?>
			<a href="/product/<?php echo $row_rs_included_components['categories_id']; ?>/<?php echo $setSubcategoryGroupsId; ?>/<?php echo $setSubcategoriesId; ?>/<?php echo $row_rs_included_components['products_id']; ?>/<?php echo $setSubcategories_title; ?>/<?php echo str_replace(' ', '-',$row_rs_included_components['categories_title']); ?>/<?php echo str_replace(' ', '-',$row_rs_included_components['manufacturers_title']); ?>-<?php echo str_replace(' ', '-',$row_rs_included_components['products_sku']); ?>/">
			
			
			
            <!--<a href="/products/index.php?product_id=<?php echo $row_rs_included_components['products_id']; ?>&categories_id=<?php echo $row_rs_included_components['categories_id']; ?>&subcategorygroups_id=<?php echo $row_rs_included_components['subcategories_id']; ?>&subcategories_id=<?php echo $row_rs_included_components['subcategories_id']; ?>">-->
				<img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" style="margin: 0 auto;" />
            </a></div>
            
            
            <div style="position: absolute; bottom: -8px; left: 31px; width:30px; height: 18px; border:color: white; text-align: center;
						-moz-border-radius: 5px; /* from vector shape */
                        -webkit-border-radius: 5px; /* from vector shape */
                        border-radius: 5px; /* from vector shape */
                        -moz-background-clip: padding;
                        -webkit-background-clip: padding-box;
                        background-clip: padding-box; /* prevents bg color from leaking outside the border */
                        background-color: #fff; /* layer fill content */
                        -moz-box-shadow: 0 2px 3px rgba(0,0,0,.75); /* drop shadow */
                        -webkit-box-shadow: 0 2px 3px rgba(0,0,0,.75); /* drop shadow */
                        box-shadow: 0 2px 3px rgba(0,0,0,.75); /* drop shadow */
                        background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGxpbmVhckdyYWRpZW50IGlkPSJoYXQwIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjUwJSIgeTE9IjEwMCUiIHgyPSI1MCUiIHkyPSIwJSI+CjxzdG9wIG9mZnNldD0iMCUiIHN0b3AtY29sb3I9IiMzMmQ3ZmYiIHN0b3Atb3BhY2l0eT0iMSIvPgo8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiMwMDZjZTkiIHN0b3Atb3BhY2l0eT0iMSIvPgogICA8L2xpbmVhckdyYWRpZW50PgoKPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNoYXQwKSIgLz4KPC9zdmc+); /* gradient fill */
                        background-image: -moz-linear-gradient(90deg, #32d7ff 0%, #006ce9 100%); /* gradient fill */
                        background-image: -o-linear-gradient(90deg, #32d7ff 0%, #006ce9 100%); /* gradient fill */
                        background-image: -webkit-linear-gradient(90deg, #32d7ff 0%, #006ce9 100%); /* gradient fill */
                        background-image: linear-gradient(90deg, #32d7ff 0%, #006ce9 100%); /* gradient fill */
                        
					 "><?php echo $row_rs_included_components['systems_products_quantity']; ?>x</div>
            </div>
          <?php } while ($row_rs_included_components = mysql_fetch_assoc($rs_included_components)); ?>
</div>


</body>
</html>
<?php
mysql_free_result($rs_included_components);
?>
