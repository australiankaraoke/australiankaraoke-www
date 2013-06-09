<?php require_once('Connections/karaoke_db.php'); ?>
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


// ALL COMPONENTS KINDS
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_all_kinds = "select * from categories";
$all_kinds = mysql_query($query_all_kinds, $karaoke_db) or die(mysql_error());
$row_all_kinds = mysql_fetch_assoc($all_kinds);
$totalRows_all_kinds = mysql_num_rows($all_kinds);

// ALL COMPONENTS
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_all_components = "select * from v_products_list where products_online=1 GROUP BY products_id";
$all_components = mysql_query($query_all_components, $karaoke_db) or die(mysql_error());
$row_all_components = mysql_fetch_assoc($all_components);
$totalRows_all_components = mysql_num_rows($all_components);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
$sitemapData = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
';

// home
$sitemapData .= "\n\t<url>\n\t\t<loc>http://www.australiankaraoke.com.au/</loc>\n\t\t<changefreq>hourly</changefreq>\n\t\t<priority>1.0</priority>\n\t</url>\n";

// Sale Systems
$sitemapData .= "\n\t<url>\n\t\t<loc>http://www.australiankaraoke.com.au/products/complete-systems.php</loc>\n\t\t<changefreq>daily</changefreq>\n\t\t<priority>0.9</priority>\n\t</url>\n";

// Components
$sitemapData .= "\n\t<url>\n\t\t<loc>http://www.australiankaraoke.com.au/products/</loc>\n\t\t<changefreq>daily</changefreq>\n\t\t<priority>0.8</priority>\n\t</url>\n";

// Bargain Bin
$sitemapData .= "\n\t<url>\n\t\t<loc>http://www.australiankaraoke.com.au/products/bargains-special-used.php</loc>\n\t\t<changefreq>daily</changefreq>\n\t\t<priority>0.8</priority>\n\t</url>\n";

// Discs
$sitemapData .= "\n\t<url>\n\t\t<loc>http://www.australiankaraoke.com.au/tracks/</loc>\n\t\t<changefreq>weekly</changefreq>\n\t\t<priority>0.8</priority>\n\t</url>\n";

// Studio
$sitemapData .= "\n\t<url>\n\t\t<loc>http://www.australiankaraoke.com.au/studio/</loc>\n\t\t<changefreq>daily</changefreq>\n\t\t<priority>0.6</priority>\n\t</url>\n";

// Contact
$sitemapData .= "\n\t<url>\n\t\t<loc>http://www.australiankaraoke.com.au/contact/</loc>\n\t\t<changefreq>daily</changefreq>\n\t\t<priority>0.6</priority>\n\t</url>\n";



	/* Sale Systems */
		$sitemapData .= "";
	 	 
	 /* Component Kind List */
	do {
	
		if($row_all_components['categories_title']) {
				$setCategories_title=$row_all_kinds['title'];
			} else {
				$setCategories_title=0;
			}
			
		$sitemapData .=
						"\n\t<url>\n\t\t<loc>http://www.australiankaraoke.com.au/category/"
						.$row_all_kinds['id'].
						'/'
						.$setCategories_title.
						"/</loc>\n\t\t<changefreq>monthly</changefreq>\n\t\t<priority>0.9</priority>\n\t</url>\n";
		echo $row_all_kinds['categories_id'];
	 } while ($row_all_kinds = mysql_fetch_assoc($all_kinds));
	 
		  /* Individual Components  */
		do {
			//$sitemapData .= "\n\t<url>\n\t\t<loc>http://www.australiankaraoke.com.au/products/index.php".urlencode('?product_id='.$row_all_components['products_id'].'&categories_id='.$row_all_components['categories_id'].'&subcategories_id='.$row_all_components['subcategories_id'].'&subcategorygroups_id='.$row_all_components['subcategories_subcategorygroup_id'].'&manufacturers_title='.$row_all_components['manufacturers_title'].'&products_sku='.$row_all_components['products_sku'].'&products_title='.$row_all_components['products_title'])."</loc>\n\t\t<changefreq>hourly</changefreq>\n\t\t<priority>0.8</priority>\n\t</url>\n";
			
			if($row_all_components['subcategories_subcategorygroup_id']) {
				$setSubcategoryGroupsId=$row_all_components['subcategories_subcategorygroup_id'];
			} else {
				$setSubcategoryGroupsId=0;
			}
		
			if($row_all_components['subcategories_id']) {
				$setSubcategoriesId=$row_all_components['subcategories_id'];
			} else {
				$setSubcategoriesId=0;
			}
		
			if($row_all_components['subcategories_title']) {
				$setSubcategories_title=str_replace(' ', '-',$row_all_components['subcategories_title']);
			} else {
				$setSubcategories_title=0;
			}
			
			if($row_all_components['categories_title']) {
				$setCategories_title=str_replace(' ', '-',$row_all_components['categories_title']);
			} else {
				$setCategories_title=0;
			}
			
			if($row_all_components['manufacturers_title']) {
				$setManufacturers_title=str_replace(' ', '-',$row_all_components['manufacturers_title']);
			} else {
				$setManufacturers_title=0;
			}
			
			if($row_all_components['products_sku']) {
				$setProducts_sku=str_replace(' ', '-',$row_all_components['products_sku']);
			} else {
				$setProducts_sku=0;
			}
			
			$sitemapData .=
							"\n\t<url>\n\t\t<loc>http://www.australiankaraoke.com.au/product/"
							.$row_all_components['categories_id'].
							"/"
							.$setSubcategoryGroupsId.
							"/"
							.$setSubcategoriesId.
							"/"
							.$row_all_components['products_id'].
							"/"
							.$setSubcategories_title.
							"/"
							.$setCategories_title.
							"/"
							.$setManufacturers_title.
							"-"
							.$setProducts_sku.
							"/</loc>\n\t\t<changefreq>monthly</changefreq>\n\t\t<priority>0.9</priority>\n\t</url>\n";
			
			echo $row_all_components['products_id'];
		 } while ($row_all_components = mysql_fetch_assoc($all_components));
  

// Closing Tag
$sitemapData .= "\n</urlset>";

// Save To sitemap.xml File
$sitemapFile = "sitemap.xml";
$fh = fopen($sitemapFile, 'w') or die("can't open file");
fwrite($fh, $sitemapData);
fclose($fh);
?>
</body>
</html>
<?php

mysql_free_result($rs_sale_systems);
mysql_free_result($rs_hire_systems);
mysql_free_result($all_kinds);
mysql_free_result($all_components);
?>
