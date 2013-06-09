<?php ini_set('display_errors','off'); ?><?php require_once('../../Connections/karaoke_db.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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
error_log("BEFORE: DISC NO:".$_POST["DISC"]);

if($_POST["ARTIST"] && !$_POST["TITLE"]) {
	$colname_rs_ArtistTitle = "-1";
	if (isset($_POST['DISC'])) {
	  $colname_rs_ArtistTitle = $_POST['DISC'];
	}
	$thisTitle_rs_ArtistTitle = "-1";
	if (isset($_POST['ARTIST'])) {
	  $thisTitle_rs_ArtistTitle = $_POST['ARTIST'];
	}
	mysql_select_db($database_karaoke_db, $karaoke_db);
	$query_rs_ArtistTitle = sprintf("SELECT * FROM discs WHERE DISC = %s AND ARTIST LIKE %s ORDER BY TCK ASC", GetSQLValueString($colname_rs_ArtistTitle, "text"),GetSQLValueString("%" . $thisTitle_rs_ArtistTitle . "%", "text"));
	$rs_ArtistTitle = mysql_query($query_rs_ArtistTitle, $karaoke_db) or die(mysql_error());
	$row_rs_ArtistTitle = mysql_fetch_assoc($rs_ArtistTitle);
	$totalRows_rs_ArtistTitle = mysql_num_rows($rs_ArtistTitle);
	
	error_log("SEARCH BY ARTIST - DISC NO:".$_POST["DISC"]);
}elseif($_POST["TITLE"] && !$_POST["ARTIST"]) {
	$colname_rs_ArtistTitle = "-1";
	if (isset($_POST['DISC'])) {
	  $colname_rs_ArtistTitle = $_POST['DISC'];
	}
	$thisTitle_rs_ArtistTitle = "-1";
	if (isset($_POST['TITLE'])) {
	  $thisTitle_rs_ArtistTitle = $_POST['TITLE'];
	}
	mysql_select_db($database_karaoke_db, $karaoke_db);
	$query_rs_ArtistTitle = sprintf("SELECT * FROM discs WHERE DISC = %s AND TITLE LIKE %s ORDER BY TCK ASC", GetSQLValueString($colname_rs_ArtistTitle, "text"),GetSQLValueString("%" . $thisTitle_rs_ArtistTitle . "%", "text"));
	$rs_ArtistTitle = mysql_query($query_rs_ArtistTitle, $karaoke_db) or die(mysql_error());
	$row_rs_ArtistTitle = mysql_fetch_assoc($rs_ArtistTitle);
	$totalRows_rs_ArtistTitle = mysql_num_rows($rs_ArtistTitle);
	
	error_log("SEARCH BY TITLE - DISC NO:".$_POST["DISC"]);
}elseif($_POST["TITLE"] && $_POST["ARTIST"]) {
	$thisArtist_rs_ArtistTitle = "-1";
	if (isset($_POST['ARTIST'])) {
	  $thisArtist_rs_ArtistTitle = $_POST['ARTIST'];
	}
	$thisDisc_rs_ArtistTitle = "-1";
	if (isset($_POST["DISC"])) {
	  $thisDisc_rs_ArtistTitle = $_POST["DISC"];
	}
	$thisTitle_rs_ArtistTitle = "-1";
	if (isset($_POST["TITLE"])) {
	  $thisTitle_rs_ArtistTitle = $_POST["TITLE"];
	}

	mysql_select_db($database_karaoke_db, $karaoke_db);
	$query_rs_ArtistTitle = sprintf("SELECT * FROM discs WHERE ARTIST LIKE %s AND DISC = %s AND TITLE LIKE %s ORDER BY TCK ASC", GetSQLValueString("%" . $thisArtist_rs_ArtistTitle . "%", "text"),GetSQLValueString($thisDisc_rs_ArtistTitle, "text"),GetSQLValueString("%" . $thisTitle_rs_ArtistTitle . "%", "text"));
	$rs_ArtistTitle = mysql_query($query_rs_ArtistTitle, $karaoke_db) or die(mysql_error());
	$row_rs_ArtistTitle = mysql_fetch_assoc($rs_ArtistTitle);
	$totalRows_rs_ArtistTitle = mysql_num_rows($rs_ArtistTitle);
	
	error_log("SEARCH BY TITLE AND ARTIST - DISC NO:".$_POST["DISC"]);
}else{error_log("ERROR");}

$colname_rs_countTracks = "-1";
if (isset($_POST["DISC"])) {
  $colname_rs_countTracks = $_POST["DISC"];
}
mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_countTracks = sprintf("SELECT * FROM discs WHERE DISC = %s ORDER BY TCK ASC", GetSQLValueString($colname_rs_countTracks, "text"));
$rs_countTracks = mysql_query($query_rs_countTracks, $karaoke_db) or die(mysql_error());
$row_rs_countTracks = mysql_fetch_assoc($rs_countTracks);
$totalRows_rs_countTracks = mysql_num_rows($rs_countTracks);
error_log("TrackCount SQL:".$query_rs_countTracks);

//error_log($query_rs_ArtistTitle);


?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>
<style>
.trackCount {
	font-size: 16px;
	display:inline;
}
</style>
<body>
<div itemscope itemtype="http://schema.org/MusicGroup" style="margin-top: -2px; margin-left: 10px;">
<?php
if($_POST["ARTIST"] && !$_POST["TITLE"]) {
	?>
    <span style="color: red; text-transform:uppercase;" itemprop="name"><? echo $row_rs_ArtistTitle['ARTIST']; ?></span> - 
	<span style="font-style:italic;" itemprop="track" itemscope itemtype="http://schema.org/MusicRecording">"<span itemprop="name"><?
	echo $row_rs_ArtistTitle['TITLE'];
	?>"</span></span>
	<div class='trackCount' style="margin-left: 10px;">  ( <strong><? echo $totalRows_rs_countTracks;?></strong> tracks on this disc )</div>
	<?
	
}elseif($_POST["TITLE"] && !$_POST["ARTIST"]){
	?>
	<span itemprop="name"><? echo $row_rs_ArtistTitle['ARTIST']; ?></span>
    &nbsp;- <span style="font-style:italic;" itemscope itemtype="http://schema.org/MusicRecording"><span style="font-style:italic;">"<span style="color: red; text-transform:uppercase;" itemprop="name"><? echo $row_rs_ArtistTitle['TITLE']; ?></span>"</span>
    <div class='trackCount' style="margin-left: 10px;">  ( <strong><? echo $totalRows_rs_countTracks;?></strong> tracks on this disc )</div>
	<?
}elseif($_POST["TITLE"] && $_POST["ARTIST"]){
	?><span style="color: red; text-transform:uppercase;" itemprop="name"><?
	echo $row_rs_ArtistTitle['ARTIST']." - <span itemscope itemtype='http://schema.org/MusicRecording'><span style='font-style:italic; itemprop='name''>\"".$row_rs_ArtistTitle['TITLE']."\"</span></span>";
	?></span>
	<div class='trackCount' style="margin-left: 10px;">  ( <strong><? echo $totalRows_rs_countTracks;?></strong> tracks on this disc )</div>
	<?
}elseif(!$_POST["TITLE"] && !$_POST["ARTIST"]){
?>
	<div class='trackCount' style="margin-left: 10px;"><? echo $totalRows_rs_countTracks;?> tracks on this disc</div>
<?
}
?>
</div>
</body>
</html>
<?php
//mysql_free_result($rs_ArtistTitle);
?>
