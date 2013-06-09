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

$manufacturers_id=$_GET["manufacturers_id"];


mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_all_categories = "SELECT * FROM v_products_all_categories";
$rs_all_categories = mysql_query($query_rs_all_categories, $karaoke_db) or die(mysql_error());
$row_rs_all_categories = mysql_fetch_assoc($rs_all_categories);
$totalRows_rs_all_categories = mysql_num_rows($rs_all_categories);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_all_subcategories = "SELECT * FROM v_products_all_subcategories";
$rs_all_subcategories = mysql_query($query_rs_all_subcategories, $karaoke_db) or die(mysql_error());
$row_rs_all_subcategories = mysql_fetch_assoc($rs_all_subcategories);
$totalRows_rs_all_subcategories = mysql_num_rows($rs_all_subcategories);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rs_all_categories.filename}");
$objDynamicThumb1->setResize(35, 35, true);
$objDynamicThumb1->setWatermark(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<style>
.main_category_icon {
	position: relative; float: left;
}
.main_category {
	position: relative; font-size: 15px; float: left; width: 130px; padding-left: 15px; margin-top: 10px;
}
.subcat {
	font-size: 13px;
}
</style>
</head>
<script>
currentSubCatGroup = 0;
subcategory_ids = new Array;
subategorygroups = new Array;

function goToCategory(catID,subCatBOOLEAN) {
	$('.main_category_link').css({'color':'black'});
	$('#main_category_link_id_'+catID).css({'color':'#900'});
	$('.main_subcategory_link_all').css({'color':'black'});
	$('#category_id_'+catID+' .main_subcategory_link_all').css({'color':'#900', 'font-weight': 'bold'});
	$('.subcategory').css({'color':'black', 'font-weight': 'normal'});
	localStorage.clear();
	if (subCatBOOLEAN==0) {
		$(".subcat").slideUp();
		$('#category_id_'+catID).slideToggle();
		//$("#products_for_category_main").fadeOut();
		$("#products_content").html("<div style='width: 100%; text-align: center; margin-top: 100px;'><img src='/images/spinner-purple.gif' /></div>");
		$("#products_content").load("/products-support-files/products-for-category.php",{ 'category_id': catID}, function(){
			//$("#products_for_category_main").fadeIn();
		});
	} else {
		$("#products_content").load("/products-support-files/products-for-category.php",{ 'category_id': catID}, function(){
			//$("#products_for_category_main").fadeIn();
		});
	}
	localStorage.clear();	
}
function goToSubcategory (catID, subCatID, subCatGroupID) {
	/*if(subategorygroups.indexOf(subCatGroupID) == -1){
		subategorygroups.push(subCatGroupID);
	}
		
	$('.subcategory').css({'color':'black', 'font-weight': 'normal'});
	localStorage[subCatGroupID] = subCatID;
	
	var counter=0;
	for (var key in localStorage){
		$("#subcategory_id_"+localStorage[key]+"[subCatGroupID="+key+"]").css({'color':'#900', 'font-weight': 'bold'});
		subcategory_ids[counter]=localStorage[key];
	}
	
	$('.main_subcategory_link_all').css({'color':'black', 'font-weight': 'normal'});
	$("#products_content").load("/products-support-files/products-for-category.php",{ 'category_id': catID, 'subategorygroups[]':subategorygroups, 'subcategories[]':localStorage });
	*/
	$("#products_content").html("<div style='width: 100%; text-align: center; margin-top: 100px;'><img src='/images/spinner-purple.gif' /></div>");
	$('.subcategory').css({'color':'black', 'font-weight': 'normal'});
	$("#subcategory_id_"+subCatID+"[subCatGroupID="+subCatGroupID+"]").css({'color':'#900', 'font-weight': 'bold'});
	$("#products_content").load("/products-support-files/products-for-category.php",{ 'category_id': catID, 'subcategorygroups':subCatGroupID, 'subcategories':subCatID});
	$('.main_subcategory_link_all').css({'color':'black'});
}
<?php
if($_GET['categories_id']){
?>	
	
	$(".subcat").slideUp();
	$('#category_id_'+<? echo $_GET['categories_id']; ?>).slideToggle();
	$('#main_category_link_id_'+<? echo $_GET['categories_id']; ?>).css({'color':'#900'});
	<?php
	if($_GET['subcategories_id']){
	?>
		$("#subcategory_id_"+<? echo $_GET['subcategories_id']; ?>+"[subCatGroupID="+<? echo $_GET['subcategorygroups_id']; ?>+"]").css({'color':'#900', 'font-weight': 'bold'});	
		$('.main_subcategory_link_all').css({'color':'black'});
	<?	
	} else {
	?>
		$('#category_id_'+<? echo $_GET['categories_id']; ?>+' .main_subcategory_link_all').css({'color':'#900', 'font-weight': 'bold'});
		$('.main_subcategory_link_all').css({'color':'#900', 'font-weight': 'bold'});
	<?	
	}
	?>
<?	
}
?>
</script>
<body>

<?php do { ?>

	<div class="main_category_icon">
    	<img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" />
    </div>
<div class="main_category">
	<div class="main_category_link" id="main_category_link_id_<?php echo $row_rs_all_categories['id']; ?>" style="padding-bottom: 8px; cursor: pointer;" onclick="goToCategory(<?php echo $row_rs_all_categories['id']; ?>,0);">
		<strong><?php echo $row_rs_all_categories['title']; ?></strong></div>
		<div class="subcat" id="category_id_<?php echo $row_rs_all_categories['id']; ?>">
		<div id="main_subcategory_link_all_helper_categorie_id_<?php echo $row_rs_all_categories['id']; ?>">
			<div class="main_subcategory_link_all" style="padding-left: 10px; cursor: pointer;" onclick="goToCategory(<?php echo $row_rs_all_categories['id']; ?>,1);">ALL</div>
			<div style="height: 3px;"><hr size="1" style="opacity: 0.3;" /></div>
		</div>
        <div>
        <?
		$counter=0;
		?>
		<?php do { ?>
        <?
		if ( $row_rs_all_categories['id'] == $row_rs_all_subcategories['categories_id']) {
		?>
        	<?
			if (($previous_subcategorygroups_title <> $row_rs_all_subcategories['subcategorygroups_title']) && ($counter<>0)) {
			?>
				<div class="subcategorygroup_divider" style="height: 3px;"><hr size="1" style="opacity: 0.3;" /></div>
			<?
			}
			?>
        	<div class="subcategory" style="padding: 3px 0 2px 10px; cursor: pointer;" id="subcategory_id_<?php echo $row_rs_all_subcategories['subcategories_id']; ?>" subCatGroupID="<?php echo $row_rs_all_subcategories['subcategorygroups_id']; ?>" onclick="goToSubcategory(<? echo $row_rs_all_subcategories['categories_id']; ?>, <?php echo $row_rs_all_subcategories['subcategories_id']; ?>, <?php echo $row_rs_all_subcategories['subcategorygroups_id']; ?> );"><?php echo $row_rs_all_subcategories['subcategories_title']; ?></div>
        	
		<?
		}
		?>
        <?
		$counter = $counter + 1;
		$previous_subcategorygroups_title = $row_rs_all_subcategories['subcategorygroups_title'];
		?>
        <script>
			 	$('#category_id_<?php echo $row_rs_all_categories['id']; ?> .subcategorygroup_divider:eq(0)').hide();
				
		</script>
		<?php } while ($row_rs_all_subcategories = mysql_fetch_assoc($rs_all_subcategories)); ?>
        <?
		mysql_data_seek($rs_all_subcategories,0); 
		?>
        </div>
      </div>
    </div>
    <div style="clear: both;"></div>
    <div style="height: 5px;"><hr size="1" style="opacity: 0.5;" /></div>
    <?
	$previous_category_id = $row_rs_all_categories['categories_id'];
	?>
    <script>
	if(!$("#category_id_<?php echo $row_rs_all_categories['id']; ?> .subcategory").length) {
		$("#main_subcategory_link_all_helper_categorie_id_<?php echo $row_rs_all_categories['id']; ?>").html("");
	}
	$(".subcat").hide();

	</script>
    <?php } while ($row_rs_all_categories = mysql_fetch_assoc($rs_all_categories)); ?>
</body>
</html>
<?php
mysql_free_result($rs_all_categories);

mysql_free_result($rs_all_subcategories);
?>
