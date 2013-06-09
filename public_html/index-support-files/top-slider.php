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
$query_getV_index_topSlider = "SELECT * FROM v_index_topslider";
$getV_index_topSlider = mysql_query($query_getV_index_topSlider, $karaoke_db) or die(mysql_error());
$row_getV_index_topSlider = mysql_fetch_assoc($getV_index_topSlider);
$totalRows_getV_index_topSlider = mysql_num_rows($getV_index_topSlider);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_getV_index_topSlider_captionContent = "SELECT * FROM v_index_topslider";
$getV_index_topSlider_captionContent = mysql_query($query_getV_index_topSlider_captionContent, $karaoke_db) or die(mysql_error());
$row_getV_index_topSlider_captionContent = mysql_fetch_assoc($getV_index_topSlider_captionContent);
$totalRows_getV_index_topSlider_captionContent = mysql_num_rows($getV_index_topSlider_captionContent);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../uploads-admin/");
$objDynamicThumb1->setRenameRule("{getV_index_topSlider.filename}");
$objDynamicThumb1->setResize(994, 0, true);
$objDynamicThumb1->setWatermark(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link href="/frameworks/nivo-slider/nivo-slider.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="/frameworks/nivo-slider/themes/dark/dark.css" type="text/css" media="screen" />
<link href="/index-support-files/top-slider.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/frameworks/nivo-slider/jquery.nivo.slider.pack.js"></script>
</head>

<style>
.nivo-caption { background-color: rgba(0,0,0,0.6); font-weight:normal; }
</style>
<body>

    <div class="slider-wrapper theme-dark">
        <div class="ribbon"></div>
        <div id="slider" class="nivoSlider">
            <?php $iterationCounter = 0; ?>
            <?php do { ?>
            <?php
                $content = $row_getV_index_topSlider['description'];
                $dot = ".";
                $position = stripos ($content, $dot); //find first dot position
                if($position) { //if there's a dot in our soruce text do
                    $offset = $position + 2; //prepare offset
                    $position2 = stripos ($content, $dot, $offset); //find second dot using offset
                    $first_two = substr($content, 0, $position2); //put two first sentences under $first_two
                    $title = $first_two . '.'; //add a dot
                }
                else {  //if there are no dots
                    //do nothing
                }
            ?>
            <a href="/products/complete-systems.php?systems_id=<?php echo $row_getV_index_topSlider['id']; ?>"><img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" width="994" title="#titleID-<?php echo $iterationCounter; ?>" /></a>
            <?php $iterationCounter = $iterationCounter +1; ?>
            <?php } while ($row_getV_index_topSlider = mysql_fetch_assoc($getV_index_topSlider)); ?>
        </div>
    </div>
    
	<?php $iterationCounter = 0; ?>
    <?php do { ?>
    <?php
                $content = $row_getV_index_topSlider_captionContent['description'];
                $dot = ".";
                $position = stripos ($content, $dot); //find first dot position
                if($position) { //if there's a dot in our soruce text do
                    $offset = $position + 2; //prepare offset
                    $position2 = stripos ($content, $dot, $offset); //find second dot using offset
                    $first_two = substr($content, 0, $position2); //put two first sentences under $first_two
                    $title = $first_two . '.'; //add a dot
                }
                else {  //if there are no dots
                    //do nothing
                }
            ?>
        <div id="titleID-<?php echo $iterationCounter; ?>" class="nivo-html-caption">
            <div style="position: relative; width: 80%; height: 50px; float: left;">
            <div style="position: relative; width: auto; height: 40px; float: left; padding-top: 5px; margin-left: 15px; font-size: 16px; color: #fff; text-shadow: #000 0px -1px 1px; overflow: hidden; ">
				<div style="font-size: 14px; line-height: 12px;"><?php echo $row_getV_index_topSlider_captionContent['description']; ?></div>
				<!--<div style="font-size: 13px; line-height: 14px;"><?php echo $title; ?></div>-->
            </div>
            </div>
            <div style="position: relative; width: auto; height: 50px; float: right; font-size: 26px; color: #ffd200; text-shadow: #000 0px -2px 2px; ">
                <div style="position: relative; margin-right: 15px; margin-top: 10px;"><strong>$ <?php echo $row_getV_index_topSlider_captionContent['regularPrice']; ?><strong></div>
            </div>
        </div>
    <?php $iterationCounter = $iterationCounter +1; ?>
    <?php } while ($row_getV_index_topSlider_captionContent = mysql_fetch_assoc($getV_index_topSlider_captionContent)); ?>


</body>
</html>
<?php
mysql_free_result($getV_index_topSlider);

mysql_free_result($getV_index_topSlider_captionContent);
?>
