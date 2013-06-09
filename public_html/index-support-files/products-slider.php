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
$query_rs_loop_categories = "SELECT * FROM v_index_productsslider GROUP BY categories_title";
$rs_loop_categories = mysql_query($query_rs_loop_categories, $karaoke_db) or die(mysql_error());
$row_rs_loop_categories = mysql_fetch_assoc($rs_loop_categories);
$totalRows_rs_loop_categories = mysql_num_rows($rs_loop_categories);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_loop_products = "SELECT * FROM v_index_productsslider order by products_id";
$rs_loop_products = mysql_query($query_rs_loop_products, $karaoke_db) or die(mysql_error());
$row_rs_loop_products = mysql_fetch_assoc($rs_loop_products);
$totalRows_rs_loop_products = mysql_num_rows($rs_loop_products);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rs_loop_products.products_filename}");
$objDynamicThumb1->setResize(120, 120, true);
$objDynamicThumb1->setWatermark(false);

// Show Dynamic Thumbnail
$objDynamicThumb3 = new tNG_DynamicThumbnail("../../", "KT_thumbnail3");
$objDynamicThumb3->setFolder("../uploads-admin/");
$objDynamicThumb3->setRenameRule("{rs_loop_products.manufacturerimages_filename}");
$objDynamicThumb3->setResize(65, 65, true);
$objDynamicThumb3->setWatermark(false);

// Show Dynamic Thumbnail
$objDynamicThumb2 = new tNG_DynamicThumbnail("../../", "KT_thumbnail2");
$objDynamicThumb2->setFolder("../uploads-admin/");
$objDynamicThumb2->setRenameRule("{rs_loop_categories.categories_filename}");
$objDynamicThumb2->setResize(75, 75, true);
$objDynamicThumb2->setWatermark(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link type="text/css" href="/index-support-files/products-slider.css" rel="stylesheet"/>
<script type="text/javascript" src="/frameworks/jquery-list-style-rotator/js/jquery.list-rotator.min.js"></script>
<script type="text/javascript" src="/frameworks/jquery-list-style-rotator/js/preview.js"></script>

<style type="text/css">
		.panel{
			margin:0 auto;
			//background-color:#FFF;
			width:900px;
			min-height:100%;
			padding:20px;
			text-align:left;
			//-moz-box-shadow: 0px 0px 4px #000;
			//box-shadow: 0px 0px 4px #000;
			//-webkit-box-shadow: 0px 0px 4px #000;
		}
		
    	.p-title {
			font-size:15px;
			color:#B5FF00;
		}
		.cap-title{
			font-size:15px;
			color:#1FB3DD;
		}
</style> 

</head>

<body>

<div style="position:absolute; z-index: 60; margin-left: 823px; margin-top: 12px;">
<img src="../images/featured_banner.png" width="139" height="84" alt="Featured Products - Banner" />
</div>

<div style="position: relative;">
<div class="panel">
<div class="l-rotator-container">
        <div class="l-rotator">
            <div class="screen">
            	<noscript><img src="/frameworks/jquery-list-style-rotator/images/hk.jpg" alt=""/></noscript>
          	</div>
            <div class="thumbnails">
                <ul>
                    
                    
                    
                    
                    <?php do { ?>
                    <li>
                        <div class="thumb">
                            	<span style="position: relative; display: block; float: left;"><img src="<?php echo $objDynamicThumb2->Execute(); ?>" border="0" style="position: absolute; top: 5px;"/></span>
                            	<span style="position: relative; display: block; float: left; margin-top: 33px; margin-left: 80px; font-size: 15px; font-weight: bold; text-align:left;"><?php echo $row_rs_loop_categories['categories_title']; ?></span>
                        </div>
                                               
				    <div style="position: absolute; top:0; left:25px; width:600px; height:400px;">
                            <div style="position: absolute;width: 588px; height: 388px;">
                            	<!--<span class="p-title">$XXXX</span><br/>-->
                                
                                
                                
                                
                                <?php do { ?>
                                <?php 
									// Show IF Conditional region1 
									if ( $row_rs_loop_categories['categories_id'] ==   $row_rs_loop_products['categories_id'] && $row_rs_loop_products['products_id'] <> $previousProduct) {
								?>
								
								
                                <?
									if($row_rs_loop_products['subcategorygroups_id']) {
										$setSubcategoryGroupsId=$row_rs_loop_products['subcategorygroups_id'];
									} else {
										$setSubcategoryGroupsId=0;
									}
			
									if($row_rs_loop_products['subcategories_id']) {
										$setSubcategoriesId=$row_rs_loop_products['subcategories_id'];
									} else {
										$setSubcategoriesId=0;
									}
			
									if($row_rs_loop_products['subcategories_title']) {
										$setSubcategories_title=$row_rs_loop_products['subcategories_title'];
									} else {
										$setSubcategories_title=0;
									}
			
								?>
									<a href="/product/<?php echo $row_rs_loop_products['categories_id']; ?>/<?php echo $setSubcategoryGroupsId; ?>/<?php echo $setSubcategoriesId; ?>/<?php echo $row_rs_loop_products['products_id']; ?>/<?php echo $setSubcategories_title; ?>/<?php echo str_replace(' ', '-',$row_rs_loop_products['categories_title']); ?>/<?php echo str_replace(' ', '-',$row_rs_loop_products['manufacturers_title']); ?>-<?php echo str_replace(' ', '-',$row_rs_loop_products['products_sku']); ?>/">
									
									
                                <!--<a href="/product/<?php echo $row_rs_loop_products['categories_id']; ?>/<?php echo $row_rs_loop_products['subcategorygroups_id']; ?>/<?php echo $row_rs_loop_products['subcategories_id']; ?>/<?php echo $row_rs_loop_products['products_id']; ?>/<?php echo $row_rs_loop_products['subcategories_title']; ?>/<?php echo str_replace(' ', '-',$row_rs_loop_products['categories_title']); ?>/<?php echo str_replace(' ', '-',$row_rs_loop_products['manufacturers_title']); ?>-<?php echo str_replace(' ', '-',$row_rs_loop_products['products_sku']); ?>/">-->
                                
                                
                                <div style="position: relative; width: 135px; height: 180px; padding: 2px; float: left;margin: 2px; box-shadow: 0 1px 2px rgba(0,0,0,0.4); border: 1px solid rgba(0,0,0,0.2);
                                	background-color: #fff; /* layer fill content */
                                    -moz-box-shadow: 0 4px 8px rgba(0,0,0,.17); /* drop shadow */
                                    -webkit-box-shadow: 0 4px 8px rgba(0,0,0,.17); /* drop shadow */
                                    box-shadow: 0 4px 8px rgba(0,0,0,.17); /* drop shadow */
                                    background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGxpbmVhckdyYWRpZW50IGlkPSJoYXQwIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjUwJSIgeTE9IjEwMCUiIHgyPSI1MCUiIHkyPSIwJSI+CjxzdG9wIG9mZnNldD0iMCUiIHN0b3AtY29sb3I9IiMwMDAiIHN0b3Atb3BhY2l0eT0iMC4wOCIvPgo8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiMwMDAiIHN0b3Atb3BhY2l0eT0iMCIvPgogICA8L2xpbmVhckdyYWRpZW50PgoKPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNoYXQwKSIgLz4KPC9zdmc+); /* gradient fill */
                                    background-image: -moz-linear-gradient(90deg, rgba(0,0,0,.08) 0%, rgba(0,0,0,0) 100%); /* gradient fill */
                                    background-image: -o-linear-gradient(90deg, rgba(0,0,0,.08) 0%, rgba(0,0,0,0) 100%); /* gradient fill */
                                    background-image: -webkit-linear-gradient(90deg, rgba(0,0,0,.08) 0%, rgba(0,0,0,0) 100%); /* gradient fill */
                                    background-image: linear-gradient(90deg, rgba(0,0,0,.08) 0%, rgba(0,0,0,0) 100%); /* gradient fill */
									">
										<div style="position: absolute; top: 5px; left: 5px; z-index: 50;">
                                        	<img src="<?php echo $objDynamicThumb3->Execute(); ?>" border="0" />
                                        	<!--<?php echo $row_rs_loop_products['manufacturers_title']; ?>-->
                                        </div>
                                        
                                		<div style="position: relative; margin: 0 auto; width: 120px; height: 120px; display: table-cell; vertical-align:middle; margin-left: 8px; z-index: 40;">
                                            <img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" style="position: relative; margin-left: 8px;" />
                                        </div>
                                        
                                        <div style="position: relative; color: #333; text-align:center; margin-top: -2px;margin-bottom: 4px; font-size: 10px; font-weight: bold;">
                                    		<?php echo $row_rs_loop_products['products_sku']; ?>
                                    	</div>
                                        <div style="position: relative; color: #666; text-align:center; margin-top: 4px;margin-bottom: 4px; font-size: 9px;">
                                    		<?php echo $row_rs_loop_products['products_title']; ?>
                                    	</div>
                                        <div style="position: relative; color: #900; text-align:center; margin-top: 4px;margin-bottom: 4px; font-size: 14px; font-weight: bold;">
                                    		$<?php echo $row_rs_loop_products['products_regularPrice']; ?>
                                    	</div>
                                </div></a>
                                
                                
                                
                                <?php } 
									// endif Conditional region1
								?>
                                <?php $previousProduct = $row_rs_loop_products['products_id']; ?>
                                <?php } while ($row_rs_loop_products = mysql_fetch_assoc($rs_loop_products)); ?>
                                
                                
                                
							</div>
                        </div>
                        
                    <?    
                    mysql_data_seek($rs_loop_products,0);  
					?>
                    </li>
                    <?php } while ($row_rs_loop_categories = mysql_fetch_assoc($rs_loop_categories)); ?>
                    
                    
                    
                    
                    
           	  </ul>
        	</div>     
		</div>     	

</div>

</div>
</div>



<script>
	var $container = $(".l-rotator-container");
	$container.wtListRotator({
		screen_width:650,
		screen_height:400,
		item_width:250,
		item_height:100,
		item_display:4,
		list_align:"left",
		scroll_type:"mouse_move",
		auto_start:true,
		delay:4000,
		transition:"fade",
		transition_speed:800,
		display_playbutton:false,
		display_number:false,
		display_timer:false,
		display_arrow:true,
		display_thumb:true,
		display_scrollbar:false,
		pause_mouseover:true,
		cpanel_mouseover:false,					
		text_mouseover:false,
		text_effect:"fade",
		text_sync:false,
		cpanel_align:"TR",
		timer_align:"bottom",
		move_one:false,
		auto_adjust:true,
		shuffle:false,
		block_size:75,
		vert_size:80,
		horz_size:80,
		block_delay:35,
		vstripe_delay:90,
		hstripe_delay:180		
	});
	$(".textbox").children().css({'background-color' : 'rgba(0,0,0,0)'});
</script>
</body>
</html>
<?php
mysql_free_result($rs_loop_categories);
?>
