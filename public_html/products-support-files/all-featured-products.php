<?php require_once('../../Connections/karaoke_db.php'); ?>
<?php
// Load the common classes
require_once('../../includes/common/KT_common.php');

// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

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


session_start();
$PHPSESSID = session_id();

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_products = sprintf("SELECT * FROM v_products_list WHERE products_featured = 1 GROUP BY products_sku");
$rs_products = mysql_query($query_rs_products, $karaoke_db) or die(mysql_error());
$row_rs_products = mysql_fetch_assoc($rs_products);
$totalRows_rs_products = mysql_num_rows($rs_products);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rs_products.manufacturers_filename}");
$objDynamicThumb1->setResize(80, 0, true);
$objDynamicThumb1->setWatermark(false);

// Show Dynamic Thumbnail
$objDynamicThumb2 = new tNG_DynamicThumbnail("../../", "KT_thumbnail2");
$objDynamicThumb2->setFolder("../uploads-admin/");
$objDynamicThumb2->setRenameRule("{rs_products.products_filename}");
$objDynamicThumb2->setResize(160, 110, true);
$objDynamicThumb2->setWatermark(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<style type="text/css">
.details_button {
	-moz-box-shadow:inset 0px 1px 0px 0px #caefab;
	-webkit-box-shadow:inset 0px 1px 0px 0px #caefab;
	box-shadow:inset 0px 1px 0px 0px #caefab;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #77d42a), color-stop(1, #5cb811) );
	background:-moz-linear-gradient( center top, #77d42a 5%, #5cb811 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#77d42a', endColorstr='#5cb811');
	background-color:#77d42a;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #268a16;
	display:inline-block;
	color:#306108;
	font-family:arial;
	font-size:15px;
	font-weight:bold;
	padding:4px 12px;
	text-decoration:none;
	text-shadow:1px 1px 0px #aade7c;
}.details_button:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #5cb811), color-stop(1, #77d42a) );
	background:-moz-linear-gradient( center top, #5cb811 5%, #77d42a 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#5cb811', endColorstr='#77d42a');
	background-color:#5cb811;
}.details_button:active {
	position:relative;
	top:1px;
}
/* This imageless css button was generated by CSSButtonGenerator.com */
</style>
<style type="text/css">
.buy_now_button {
	-moz-box-shadow:inset 0px 1px 0px 0px #f29c93;
	-webkit-box-shadow:inset 0px 1px 0px 0px #f29c93;
	box-shadow:inset 0px 1px 0px 0px #f29c93;
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #fe1a00), color-stop(1, #ce0100) );
	background:-moz-linear-gradient( center top, #fe1a00 5%, #ce0100 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#fe1a00', endColorstr='#ce0100');
	background-color:#fe1a00;
	-moz-border-radius:6px;
	-webkit-border-radius:6px;
	border-radius:6px;
	border:1px solid #d83526;
	display:inline-block;
	color:#ffffff;
	font-family:arial;
	font-size:15px;
	font-weight:bold;
	padding:4px 14px;
	text-decoration:none;
	text-shadow:1px 1px 0px #b23e35;
}.buy_now_button:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ce0100), color-stop(1, #fe1a00) );
	background:-moz-linear-gradient( center top, #ce0100 5%, #fe1a00 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ce0100', endColorstr='#fe1a00');
	background-color:#ce0100;
}.buy_now_button:active {
	position:relative;
	top:1px;
}

</style>

<script src="/frameworks/masonry/masonry.js"></script>
<script src="/frameworks/fittext/jquery.fittext.js"></script>
<script>

</script>

</head>

<body>





<div id="products_for_category_main" style="position: relative; margin-top: -8px;">
<div style="width: 617px; background-color: #891a9c; padding: 8px; color: white; margin-top: 10px; margin-left: 9px; margin-bottom: 5px; ">Featured Products</div>	
	
	
	<!-- LOOP -->
		<?php do { ?>
		  
		  <?
		  if ($previous_products_id <> $row_rs_products['products_id']){
		  ?>
		  	
			<div class="product_box" id="boxProductsID_<?php echo $row_rs_products['products_id']; ?>" boxProductsID="<?php echo $row_rs_products['products_id']; ?>" boxSubCatID="<?php echo $row_rs_products['subcategories_id']; ?>" boxSubCatGroupID="<?php echo $row_rs_products['subcategories_subcategorygroup_id']; ?>" style="position: relative; float: left; width: 197px; margin: 10px; min-height: 400px; 
				-moz-border-radius: 2px; /* from vector shape */
				-webkit-border-radius: 2px; /* from vector shape */
				border-radius: 2px; /* from vector shape */
				-moz-background-clip: padding;
				-webkit-background-clip: padding-box;
				background-clip: padding-box; /* prevents bg color from leaking outside the border */
				background-color: #fff; /* layer fill content */
				-moz-box-shadow:
					0 4px 10px rgba(0,0,0,.23) /* drop shadow */,
					0 0 0 1px rgba(0,0,0,.58) /* outer stroke */;
				-webkit-box-shadow:
					0 4px 10px rgba(0,0,0,.23) /* drop shadow */,
					0 0 0 1px rgba(0,0,0,.58) /* outer stroke */;
				box-shadow:
					0 4px 10px rgba(0,0,0,.23) /* drop shadow */,
					0 0 0 1px rgba(0,0,0,.58) /* outer stroke */;
				background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDEgMSIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGxpbmVhckdyYWRpZW50IGlkPSJoYXQwIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjUwJSIgeTE9IjEwMCUiIHgyPSI1MCUiIHkyPSIwJSI+CjxzdG9wIG9mZnNldD0iMCUiIHN0b3AtY29sb3I9IiNiZGM1Y2QiIHN0b3Atb3BhY2l0eT0iMC40MyIvPgo8c3RvcCBvZmZzZXQ9IjEwMCUiIHN0b3AtY29sb3I9IiNlZGY1ZjkiIHN0b3Atb3BhY2l0eT0iMC40MyIvPgogICA8L2xpbmVhckdyYWRpZW50PgoKPHJlY3QgeD0iMCIgeT0iMCIgd2lkdGg9IjEiIGhlaWdodD0iMSIgZmlsbD0idXJsKCNoYXQwKSIgLz4KPC9zdmc+); /* gradient fill */
				background-image: -moz-linear-gradient(90deg, rgba(189,198,205,.43) 0%, rgba(238,246,249,.43) 100%); /* gradient fill */
				background-image: -o-linear-gradient(90deg, rgba(189,198,205,.43) 0%, rgba(238,246,249,.43) 100%); /* gradient fill */
				background-image: -webkit-linear-gradient(90deg, rgba(189,198,205,.43) 0%, rgba(238,246,249,.43) 100%); /* gradient fill */
				background-image: linear-gradient(90deg, rgba(189,198,205,.43) 0%, rgba(238,246,249,.43) 100%); /* gradient fill */
				
				
	
			">
				<?
				if ($row_rs_products['products_date_modified']< ('-30 days')) {
				?>
				
				<div style="position: absolute; left: -7px; top: -7px; z-index: 100000;" class="onsale_badge"><img src="/images/new_badge.png" /></div>
				<?
				}
				?>
				
				<?
				if ($row_rs_products['products_isOnSale']=="1") {
				?>
					<div style="position: absolute; right: -7px; top: -7px; z-index: 100000;" class="onsale_badge"><img src="/images/on_sale_badge.png" /></div>
				<?
				}
				?>
				<div style="position: relative; width:100%;">
					<div style="position: absolute; margin-top: 350px; width: 100%; height: 50px; background: rgba(97, 32, 108, 0.1);">
						<?
						if($row_rs_products['subcategories_subcategorygroup_id']) {
							$setSubcategoryGroupsId=$row_rs_products['subcategories_subcategorygroup_id'];
						} else {
							$setSubcategoryGroupsId=0;
						}

						if($row_rs_products['subcategories_id']) {
							$setSubcategoriesId=$row_rs_products['subcategories_id'];
						} else {
							$setSubcategoriesId=0;
						}

						if($row_rs_products['subcategories_title']) {
							$setSubcategories_title=$row_rs_products['subcategories_title'];
						} else {
							$setSubcategories_title=0;
						}

					?>
						<a href="/product/<?php echo $row_rs_products['categories_id']; ?>/<?php echo $setSubcategoryGroupsId; ?>/<?php echo $setSubcategoriesId; ?>/<?php echo $row_rs_products['products_id']; ?>/<?php echo $setSubcategories_title; ?>/<?php echo str_replace(' ', '-',$row_rs_products['categories_title']); ?>/<?php echo str_replace(' ', '-',$row_rs_products['manufacturers_title']); ?>-<?php echo str_replace(' ', '-',$row_rs_products['products_sku']); ?>/" class="details_button" style="box-shadow: 0px 0px 1px 2px rgba(0,0,0,0.2); float: left; margin: 10px 0px 7px 10px;">DETAILS</a>
						
						
						
						<!--<a href="/product/<?php echo $row_rs_products['categories_id']; ?>/<?php echo $row_rs_products['subcategories_subcategorygroup_id']; ?>/<?php echo $row_rs_products['subcategories_id']; ?>/<?php echo $row_rs_products['products_id']; ?>/<?php echo $row_rs_products['subcategories_title']; ?>/<?php echo str_replace(' ', '-',$row_rs_products['categories_title']); ?>/<?php echo str_replace(' ', '-',$row_rs_products['manufacturers_title']); ?>-<?php echo str_replace(' ', '-',$row_rs_products['products_sku']); ?>/" class="details_button" style="box-shadow: 0px 0px 1px 2px rgba(0,0,0,0.2); float: left; margin: 10px 0px 7px 10px;">DETAILS</a>-->
						<!--<a href="#" class="buy_now_button" style="box-shadow: 0px 0px 1px 2px rgba(0,0,0,0.2); float: right; margin: 10px 10px 7px 7px;">BUY</a>-->
                        <form action="" method="post" style="float: right;margin: 10px 10px 7px 7px;">
                        <input type="hidden" name='quantity' value="1"> 
                        <input type="hidden" name="session_id" value="<?php echo $PHPSESSID; ?>">
                        <input name="product_id" type="hidden" value="<?php echo $row_rs_products['products_id']; ?>">
                        <input type="hidden" name="price" value="<?php echo $row_rs_products['products_regularPrice']; ?>">
                        <input type="submit" value="Buy" name="KT_Insert1" class="buy_now_button" style="box-shadow: 0px 0px 1px 2px rgba(0,0,0,0.2); color: white;" />
                        <!--<a href="#" class="buy_now_button" style="box-shadow: 0px 0px 1px 2px rgba(0,0,0,0.2); color: white;">BUY</a>	-->
                        </form>
					</div>
					<div class="product_regularPrice" data-len="100" style="font-size: 22px; color: #666666; position: absolute; width: 100%; text-align: center;margin-top: 315px">$<?php echo $row_rs_products['products_regularPrice']; ?></div>
		            <div>
			            <h1 style="color: #891a9c; padding: 5px 10px 5px 10px; height: 35px; padding-top: 10px; background-color: rgba(0,0,0,0.1); width: 90%; text-align: center;" id="fittext_manuSku_id_<?php echo $row_rs_products['products_id']; ?>"><span style=""><?php echo $row_rs_products['manufacturers_title']; ?> <?php echo $row_rs_products['products_sku']; ?></span></h1>
						
						<h2 style="color: #333; padding: 5px 10px 5px 10px; height: 25px; font-size: 16px; width: 90%; text-align: center;" id="fittext_prodTitle_id_<?php echo $row_rs_products['products_id']; ?>"><?php echo $row_rs_products['products_title']; ?></h2>
						<script>
							$("#fittext_manuSku_id_<?php echo $row_rs_products['products_id']; ?>").fitText(1.1);
							$("#fittext_prodTitle_id_<?php echo $row_rs_products['products_id']; ?>").fitText(1.5);
						</script>
		            </div>
		            
		            
					
		            <div class="product_box_manufacturer_logo" style="position: width: auto; relative; margin: 0 auto; text-align: center; margin-top: 5px;">
		            <?
		            if ($row_rs_products['manufacturers_filename']) {
		            ?>
		            	<img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" style= "position: width: auto; relative; margin: 0 auto; "/>
		            <?
		            }
		            ?>
		            </div>
		            
		            <div class="product_box_product_image" style="position: width: auto; relative; margin: 0 auto; text-align: center;
		            	-webkit-box-reflect: below -20px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(30%, transparent) , to(rgba(250, 250, 250, 0.1))); 
		            "><img src="<?php echo $objDynamicThumb2->Execute(); ?>" border="0" /></div>
					
					<div class="product_description" data-len="100" style="padding: 5px 10px 5px 10px; font-size: 13px; color: #666666; height: 75%; display: block;" id="fittext_prodDescr_id_<?php echo $row_rs_products['products_id']; ?>"><?php echo $row_rs_products['products_mini_description']; ?></div>
					
					<script>
						//$("#fittext_prodDescr_id_<?php echo $row_rs_products['products_id']; ?>").fitText(1.5);
						(function($){
						 	$.fn.extend({ 
						 		trimTxt: function() {
						    		return this.each(function() {
										var str_txt = $(this).text();
										var num_len = $(this).attr('data-len');
										var str_trim = (str_txt.substring(0,num_len));
										$(this).text(str_trim+' ...');	
						    		});
						    	}
							});
						})(jQuery);
						$('#fittext_prodDescr_id_<?php echo $row_rs_products['products_id']; ?>').trimTxt(1.5);
						$(window).load(function(){
							//$('#products_for_category_main').masonry({
							    // options
							    //itemSelector : '.product_box',
							//});
						});
						
					</script>
					
	            </div>
				
	            
	  </div>
		  <?
		  }
		  ?>
		  <?
		  $previous_products_id = $row_rs_products['products_id'];
		  ?>
		  <?php } while ($row_rs_products = mysql_fetch_assoc($rs_products)); ?>
		  <div style="clear: all;"></div>

	
	<!-- END:: LOOP -->
	
	
	
	
	
	
	

	
	
	
	
	
		
	
	
	
	
	
	
	
	
	
	
</div>
 

<script>
//boxProductsID boxSubCatID boxSubCatGroupID
//category_id=<?php echo $_POST["category_id"]; ?>;
subcategory_ids=new Array();
subcategorygroup_ids = new Array();
counter=0;

for (var key in localStorage){
	subcategory_ids[counter]=localStorage[key];
	subcategorygroup_ids[counter]=key;
	console.log("subcategorygroup_id: "+key+"\n");
	console.log("subcategory_id: "+localStorage[key]+"\n");
	//if(key== $(".product_box").attr('boxSubCatGroupID').value()){
		//console.log("subcategory_id: "+localStorage[key]+"\n");
	//}
	//$(".product_box[boxSubCatGroupID="+key+"][boxSubCatID!="+localStorage[key]+"]").css({"opacity": 0.3});
	$(".product_box[boxSubCatGroupID="+key+"][boxSubCatID="+localStorage[key]+"]").css({"opacity": 0.3});
	counter++;
}
</script>    

</body>
</html>
<?php
mysql_free_result($rs_products);
?>
