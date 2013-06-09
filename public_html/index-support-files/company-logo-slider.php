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
$query_rs_companyLogos = "SELECT * FROM manufacturerimages WHERE title = 'white_reflected' ORDER BY cardinality ASC";
$rs_companyLogos = mysql_query($query_rs_companyLogos, $karaoke_db) or die(mysql_error());
$row_rs_companyLogos = mysql_fetch_assoc($rs_companyLogos);
$totalRows_rs_companyLogos = mysql_num_rows($rs_companyLogos);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rs_companyLogos.filename}");
$objDynamicThumb1->setResize(0, 25, true);
$objDynamicThumb1->setWatermark(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link type="text/css" href="/frameworks/bxslider/jquery.bxslider.css" rel="stylesheet"/>
<link type="text/css" href="/index-support-files/company-logo-slider.css" rel="stylesheet"/>
<script type="text/javascript" src="/frameworks/bxslider/jquery.bxslider.min.js"></script>
</head>

<body>

<div style="position: absolute; top: 15px; z-index: 10000; right: 15px; height: 385px; width: 200px; background-color: rgba(255,255,255,0);">
	<ul class="bxslider_company-logos">
	
    	<?
        	$counter=0;
		?>
    	<?php
        	do {
				
				if ($counter==0) {
		?>
            	<li>
        <?
        		}
		?>
      			<img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" style="width: auto; height: 25; float: right; margin: 3px;" />
        <?
            	if ($counter==8) {
		?>
                </li>
        <?
				}
				
				if ($counter==8) {
					$counter=0;
				} else {
					$counter=$counter+1;
				}
		?>
            
    	  <?php } while ($row_rs_companyLogos = mysql_fetch_assoc($rs_companyLogos)); ?>
    
	</ul>
</div>
</body>
</html>
<?php
mysql_free_result($rs_companyLogos);
?>
