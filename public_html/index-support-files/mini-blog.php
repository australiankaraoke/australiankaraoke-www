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

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rsblog = "SELECT * FROM v_index_blog";
$rsblog = mysql_query($query_rsblog, $karaoke_db) or die(mysql_error());
$row_rsblog = mysql_fetch_assoc($rsblog);
$totalRows_rsblog = mysql_num_rows($rsblog);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link type="text/css" href="/frameworks/bxslider/jquery.bxslider.css" rel="stylesheet"/>

<script type="text/javascript" src="/frameworks/bxslider/jquery.bxslider.min.js"></script>
<style>
.blogLink {
	text-decoration: none;
	color: #45619d;
}
.blogLink a {
	text-decoration: none;
	color: #45619d;
}
.blogLink a:link {
	text-decoration: none;
	color: #45619d;
}
.blogLink a:visited {
	text-decoration: none;
	color: #45619d;
}
.blogLink a:active {
	text-decoration: underline;
	color: #45619d;
}
.blogLink a:hover {
	text-decoration: underline;
	color: #45619d;
}
</style>

</head>

<body>
<div style="position: relative; width: 1250px; height:78px;">
	<div style="position: absolute; margin-left: -130px;"><img src="/index-support-files/images/blog-banner.png" alt="Blog Banner" /></div>
    <div style="position: absolute; color: #4d4d4d; text-shadow: -1px 0 1px #fff; font-size: 22px; top: 12px; left: 7px;">
	    <img src="/images/facebook_updates.png">
    </div>
    <div id="blogSliderWrapper" style="position: absolute; left: 135px; height: 25px; overflow: hidden; width: 820px; top: 22px; padding-left: 5px; font-size: 16px; background-color: rgba(0,0,0,0);">
		<ul class="bxslider">
			<?php do { ?>
		    <li class="blogLink"><a href="https://www.facebook.com/pages/Australian-Karaoke-Pty-Ltd/123292887824048"><?php echo $row_rsblog['title']; ?></a></li>
			  <?php } while ($row_rsblog = mysql_fetch_assoc($rsblog)); ?>
        </ul>
	</div>
	<div class="fb-like" data-href="http://www.facebook.com/pages/Australian-Karaoke-Pty-Ltd/123292887824048" data-send="true" data-layout="button_count" data-width="450" data-show-faces="false" style="position: absolute; right: 262px; top: 22px;"></div>
    <div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
</div>



</body>
</html>
<?php
mysql_free_result($rsblog);
?>
