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

$colname_rs_singleProduct = "-1";
if (isset($_POST['product_id'])) {
  $colname_rs_singleProduct = $_POST['product_id'];
}
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_singleProduct = sprintf("SELECT * FROM v_singleproduct WHERE products_id = %s", GetSQLValueString($colname_rs_singleProduct, "int"));
$rs_singleProduct = mysql_query($query_rs_singleProduct, $karaoke_db) or die(mysql_error());
$row_rs_singleProduct = mysql_fetch_assoc($rs_singleProduct);
$totalRows_rs_singleProduct = mysql_num_rows($rs_singleProduct);


mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_singleProduct_onsell = sprintf("SELECT * FROM v_singleproduct WHERE products_id = %s", GetSQLValueString($colname_rs_singleProduct, "int"));
$rs_singleProduct_onsell = mysql_query($query_rs_singleProduct_onsell, $karaoke_db) or die(mysql_error());
$row_rs_singleProduct_onsell = mysql_fetch_assoc($rs_singleProduct_onsell);
$totalRows_rs_singleProduct_onsell = mysql_num_rows($rs_singleProduct_onsell);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rs_singleProduct.products_filename}");
$objDynamicThumb1->setResize(600, 320, true);
$objDynamicThumb1->setWatermark(false);

// Show Dynamic Thumbnail
$objDynamicThumb2 = new tNG_DynamicThumbnail("../../", "KT_thumbnail2");
$objDynamicThumb2->setFolder("../uploads-admin/");
$objDynamicThumb2->setRenameRule("{rs_singleProduct.productimages_filename}");
$objDynamicThumb2->setResize(92, 92, true);
$objDynamicThumb2->setWatermark(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>

<link href="/frameworks/shadowbox-3-2.0.3/shadowbox.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/frameworks/shadowbox-3-2.0.3/shadowbox.js"></script>


</head>

<body>
<script>
	$("title").text("Australian Karaoke - <?php echo $row_rs_singleProduct['manufacturers_title'] ; ?> <?php echo $row_rs_singleProduct['products_sku'] ; ?>, <?php echo $row_rs_singleProduct['products_title'] ; ?>");
</script>
<div  itemscope itemtype="http://schema.org/Product" class="product_box" style="position: relative; width: 630px; margin: 0 10px 0 10px;
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
				if ($row_rs_singleProduct['products_date_modified']< ('-30 days')) {
				?>
				
				<div style="position: absolute; left: -7px; top: -7px; z-index: 100000;" class="onsale_badge"><img src="/images/new_badge.png" /></div>
				<?
				}
				?>
<?
if ($row_rs_singleProduct['products_isOnSale']=="1") {
?>
	<div style="position: absolute; right: -7px; top: -7px; z-index: 100000;" class="onsale_badge"><img src="/images/on_sale_badge.png" /></div>
<?
}
?>
<div id="product_header">

    <h1>
		<div style="color: #860e2a; padding: 5px 10px 5px 10px; height: 20px; padding-top: 10px; background-color: rgba(0,0,0,0.1); width: 610px; text-align: center; font-size: 25px;"><span itemprop="brand"><?php echo $row_rs_singleProduct['manufacturers_title']; ?></span> <span itemprop="model"><?php echo $row_rs_singleProduct['products_sku']; ?></span></div>
        <div style="color:#2a2a2a; font-size: 18px; padding: 0px 10px 15px 10px; height: 20px; padding-top: 8px; background-color: rgba(0,0,0,0.1); width: 610px; text-align: center;"><span itemprop="description"><?php echo $row_rs_singleProduct['products_title']; ?></span></div>
    </h1>
    <div id="product_image" style="position: relative; width: 100%; margin: 0 auto; text-align: center;">
    	<a rel="shadowbox[Mixed];width=980;height=620" href="/products-support-files/product-shadownbox.php?image=<?php echo $row_rs_singleProduct['products_filename']; ?>&isPosterImage=1">
    	
    	<img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" style="position: relative; margin: 10px; "/>
    	</a>
    	<script>
		setMT('property', 'og:image', '<?php echo $objDynamicThumb1->Execute(); ?>');
		function setMT(metaName, name, value) {
		        var t = 'meta['+metaName+'='+name+']';
		        var mt = $(t);
		        if (mt.length === 0) {
		            t = '<meta '+metaName+'="'+name+'" />';
		            mt = $(t).appendTo('head');
		        }
		        mt.attr('content', value);
		    }
		    	//$("head").append('<meta property="og:image" content="<?php echo $objDynamicThumb1->Execute(); ?>"/>');
		    	//$("head").append('<link rel="image_src" href="<?php echo $objDynamicThumb1->Execute(); ?>" />');
		    	</script>
    </div>
</div>


<?
if($row_rs_singleProduct['productimages_filename']) {
?>
    <div style="position: relative; width: 590px; padding: 20px; min-height: 100px; background-color: rgba(0,0,0,0.1); bottom: 0;">
      <?php do { ?>
      <?
      if($previousImage<>$row_rs_singleProduct['productimages_filename']) {
      ?>
      
      
      
			<div style="position: relative; border: 1px solid grey; background-color: white; width: 98px; height: 98px; float: left;display:-webkit-box; margin-right: 10px;
                    -webkit-box-flex:1; 
                    -webkit-box-align: center; 
                    -webkit-box-pack: center; 
                    -webkit-box-orient:vertical;
                    display:box; 
                    box-flex:1; 
                    box-align: center; 
                    box-pack: center; 
                    box-orient:vertical;">
			
            	<a rel="shadowbox[Mixed];width=980;height=620" href="/products-support-files/product-shadownbox.php?image=<?php echo $row_rs_singleProduct['productimages_filename']; ?>&isPosterImage=0">
            	<img src="<?php echo $objDynamicThumb2->Execute(); ?>" border="0" style=""/>
            	<!-- onclick="//imageToStage(<?php echo $row_rs_singleProduct['productimages_id']; ?>);"  -->
            </a>
			</div>
		

	
      
      
      <?
      }
      ?>
      <?
      $previousImage = $row_rs_singleProduct['productimages_filename'];
      ?>
    <?php } while ($row_rs_singleProduct = mysql_fetch_assoc($rs_singleProduct)); ?>
      
    </div>
<?
}
?>

</div>











<div id="features_tabs">
    
</div>
<script>
$("#features_tabs").load("/products-support-files/features-tabs.php",{'product_id': <? echo $_POST['product_id']; ?> }, function(){
	$( "#tabs" ).tabs();
});
    
	
function imageToStage(imageID) {
	alert(imageID);
}
</script>










<div id="product_onsell" style="position: relative; padding: 15px; margin-top: 5px;">
<h2 style="font-size: 16px; margin-bottom: 5px;">We also recommend:</h2>
</div> 
<?
$link_ids = array();
?>
<?
if($row_rs_singleProduct_onsell['productonsell_product_link_id']){
?>
<?php do { ?>
	
	<?
	if(!in_array($row_rs_singleProduct_onsell['productonsell_product_link_id'], $link_ids)){
	?>
    
	<script>
	$.get("/products-support-files/onsell-product.php", { productonsell_product_link_id: "<?php echo $row_rs_singleProduct_onsell['productonsell_product_link_id']; ?>" }).done(function(data) {
	  $("#product_onsell").append(data);
	});
	</script>
	<?
	array_push($link_ids, $row_rs_singleProduct_onsell['productonsell_product_link_id']);
	}
	?>
	
	
<?php } while ($row_rs_singleProduct_onsell = mysql_fetch_assoc($rs_singleProduct_onsell)); ?>
<?
} else {
?>

<script>
	$("#product_onsell").hide();
</script>
<?
}
?>
<script type="text/javascript">
	Shadowbox.init({
		handleOversize: "drag",
		modal: false
	});
	
	
	
</script>


</body>
</html>
<?php
mysql_free_result($rs_singleProduct);
mysql_free_result($rs_singleProduct_onsell)
?>
