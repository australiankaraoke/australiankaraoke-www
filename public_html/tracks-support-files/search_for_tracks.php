<?php ini_set('display_errors','off'); ?><?php require_once('../../Connections/karaoke_db.php'); ?>
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
$query_rs_manufacturers = "SELECT DISTINCT MAN FROM discs";
$rs_manufacturers = mysql_query($query_rs_manufacturers, $karaoke_db) or die(mysql_error());
$row_rs_manufacturers = mysql_fetch_assoc($rs_manufacturers);
$totalRows_rs_manufacturers = mysql_num_rows($rs_manufacturers);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_formatList = "SELECT DISTINCT FMT FROM discs";
$rs_formatList = mysql_query($query_rs_formatList, $karaoke_db) or die(mysql_error());
$row_rs_formatList = mysql_fetch_assoc($rs_formatList);
$totalRows_rs_formatList = mysql_num_rows($rs_formatList);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_count_discs = "SELECT DISC FROM discs";
$rs_count_discs = mysql_query($query_rs_count_discs, $karaoke_db) or die(mysql_error());
$row_rs_count_discs = mysql_fetch_assoc($rs_count_discs);
$totalRows_rs_count_discs = mysql_num_rows($rs_count_discs);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_artistCount = "SELECT DISTINCT ARTIST FROM discs";
$rs_artistCount = mysql_query($query_rs_artistCount, $karaoke_db) or die(mysql_error());
$row_rs_artistCount = mysql_fetch_assoc($rs_artistCount);
$totalRows_rs_artistCount = mysql_num_rows($rs_artistCount);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_discCount = "SELECT DISTINCT DISC FROM discs";
$rs_discCount = mysql_query($query_rs_discCount, $karaoke_db) or die(mysql_error());
$row_rs_discCount = mysql_fetch_assoc($rs_discCount);
$totalRows_rs_discCount = mysql_num_rows($rs_discCount);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_printables = "SELECT * FROM tracksdocumentsdownloads ORDER BY date_modified DESC";
$rs_printables = mysql_query($query_rs_printables, $karaoke_db) or die(mysql_error());
$row_rs_printables = mysql_fetch_assoc($rs_printables);
$totalRows_rs_printables = mysql_num_rows($rs_printables);

// Download File downloadObj6
$downloadObj6 = new tNG_Download("../../", "KT_download1");
// Execute
$downloadObj6->setFolder("/uploads-admin/");
$downloadObj6->setRenameRule("{rs_printables.file_url}");
$downloadObj6->Execute();






?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
</head>

<body style="">
<div style="padding: 25px;">
	
    
    
    
    <div style="float: left; width: 51%; text-align: left; font-size: 11px;line-height: 15px;margin-left: 10px; width: 550px;">
            <!--<form action="query_result.php" method="get" name="query_discs" id="query_discs">-->
            <form name="query_discs" id="query_discs">
                        <fieldset style="position: relative; padding: 10px; width: 95%; border: 1px solid grey;
            
            "><legend><span style="font-size: 16px; font-style: italic; padding: 5px; ">Search Discs</span></legend>
                        <br>
            &nbsp;&nbsp;Manufacturer:<br>
                        <select id="queryManufacturer" style="font-size: 9px; width: 100%; height: 25px; -webkit-appearance: menulist-button; font-size: 14px;" name="queryManufacturer">
                          <option value="">ALL MANUFACTURERS</option>
                          
                          <?php
            do {  
            ?>
                          <option value="<?php echo $row_rs_manufacturers['MAN']?>"><?php echo $row_rs_manufacturers['MAN']?></option>
                          <?php
            } while ($row_rs_manufacturers = mysql_fetch_assoc($rs_manufacturers));
              $rows = mysql_num_rows($rs_manufacturers);
              if($rows > 0) {
                  mysql_data_seek($rs_manufacturers, 0);
                  $row_rs_manufacturers = mysql_fetch_assoc($rs_manufacturers);
              }
            ?></select>

            <br><br>
            <div style="width: 50%; float: left;">
            &nbsp;&nbsp;Artist:<br>
            <input name="queryArtist" type="text" id="queryArtist" style="width: 230px; color: #61638d; font-style:italic; height: 25px; font-weight: bold; font-size: 15px; letter-spacing: 1px;">
            </div>
            <script>
				//$("input[name='queryArtist']").watermark("ALL ARTISTS");
			</script>
            
            
            <div style="width: 50%; float: right;">
            &nbsp;&nbsp;Title:<br>
            <input name="queryTitle" type="text" id="queryTitle" style="width: 255px; color: #61638d; font-style:italic; height: 25px; font-weight: bold; font-size: 15px; letter-spacing: 1px;">
            </div>
            <script>
				//$("input[name='queryTitle']").watermark("ALL TITLES");
			</script>
            
            <div style="clear: both;" /><br>
            <div style="width: 50%; float: left;">
            &nbsp;&nbsp;Disc Number:<br>
            <input name="queryDisc" type="text" id="queryDisc" style="width: 230px; color: #61638d; font-style:italic; height: 25px; font-weight: bold; font-size: 15px; letter-spacing: 1px;">
            </div>
            <script>
				//$("input[name='queryDisc']").watermark("(if known)");
			</script>
            
            <div style="width: 50%; float: left;">
            &nbsp;&nbsp;Format:<br>
            <select name="queryFormat" id="queryFormat" style="font-size: 9px; width: 100%; height: 25px; padding: 3px; -webkit-appearance: menulist-button; font-size: 14px; margin-top: 2px;">
              <option value="">ALL FORMATS</option>
              <?php
			do {  
			?>
              <option value="<?php echo $row_rs_formatList['FMT']?>"><?php echo $row_rs_formatList['FMT']?></option>
              <?php
			} while ($row_rs_formatList = mysql_fetch_assoc($rs_formatList));
			  $rows = mysql_num_rows($rs_formatList);
			  if($rows > 0) {
				  mysql_data_seek($rs_formatList, 0);
				  $row_rs_formatList = mysql_fetch_assoc($rs_formatList);
			  }
			?></select>
            </div>
            <div style="clear: both;" />
            <div style="margin-right: 0;">
            <br><br><input type="button" name="submitButton" id="submitButton" value="SEARCH" style="margin-left: 0;height: 25px; font-size: 13px;">
            <script>
				
				//console.log(queryArtist);
				$("#queryArtist").keyup(function(event){
				    if(event.keyCode == 13){
				        $("#submitButton").click();
				    }
				});
				$("#queryTitle").keyup(function(event){
				    if(event.keyCode == 13){
				        $("#submitButton").click();
				    }
				});
				$("#queryDisc").keyup(function(event){
				    if(event.keyCode == 13){
				        $("#submitButton").click();
				    }
				});
				$("#submitButton").click(function(){
					var queryArtist = $("#queryArtist").val();
					var queryTitle = $("#queryTitle").val(); 
					var queryDisc = $("#queryDisc").val(); 
					var queryFormat = $("#queryFormat").val(); 
					var queryManufacturer = $("#queryManufacturer").val(); 
					$("#query_spinner").show();
					$("#queryArtist").prop('disabled', true);
					$("#queryManufacturer").prop('disabled', true);
					$("#queryTitle").prop('disabled', true);
					$("#queryDisc").prop('disabled', true);
					$("#queryFormat").prop('disabled', true);
					$("#submitButton").prop('disabled', true);
					$("#tracks_search_result").load("/tracks-support-files/list-tracks.php",{"queryArtist":queryArtist, "queryTitle": queryTitle, "queryDisc": queryDisc, "queryFormat": queryFormat, "queryManufacturer": queryManufacturer},function(){
						//
					});
				});
			</script>
            </div><br>
            </fieldset>
            </form>
            <div style="width : 96%; margin: 10px; font-size: 14px;line-height: 20px;">
				Australian Karaoke currently ships <span style="color: red; font-weight: bold;"><?php echo $totalRows_rs_count_discs ?></span> titles of <span style="color: red; font-weight: bold;"><?php echo $totalRows_rs_artistCount ?> </span>Artists on <span style="color: red; font-weight: bold;"><?php echo $totalRows_rs_discCount ?> </span> Discs in formats CD+G, VCD, DVD, CD and MP3+G. 
				<div style="position: relative; height: 5px; border-bottom: 1px solid grey;"></div>
				<div style="position: relative; height: 5px;"></div>
			</div>
	</div>
    
    
    
    
    
    
    
    
    
    <div style="float: right; width: auto; text-align: left; font-size: 11px;line-height: 15px; margin-right: 17px;">
			 	<fieldset style="position: relative; padding: 10px; width: 95%; border: 1px solid grey;
                ">
			<legend>
			<span style="font-size: 16px; font-style: italic; padding: 5px; ">Download Catalogues</span>
			</legend>
			<center>
			<br>
			
            
            <?php do { ?>
               <a href="<?php echo $downloadObj6->getDownloadLink(); ?>">
               <div style="width: 300px;
                height: 35px;
                background-color: red;
                -moz-border-radius: 5px; /* from vector shape */
                -webkit-border-radius: 5px; /* from vector shape */
                border-radius: 5px; /* from vector shape */
                -moz-background-clip: padding;
                -webkit-background-clip: padding-box;
                background-clip: padding-box; /* prevents bg color from leaking outside the border */
                -moz-box-shadow: 3px 4px 5px rgba(0,0,0,.33); /* drop shadow */
                -webkit-box-shadow: 3px 4px 5px rgba(0,0,0,.33); /* drop shadow */
                box-shadow: 3px 4px 5px rgba(0,0,0,.33); /* drop shadow */
                background-image: url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiA/Pgo8c3ZnIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDMyNCAzOCIgcHJlc2VydmVBc3BlY3RSYXRpbz0ibm9uZSI+PGxpbmVhckdyYWRpZW50IGlkPSJoYXQwIiBncmFkaWVudFVuaXRzPSJvYmplY3RCb3VuZGluZ0JveCIgeDE9IjUwJSIgeTE9IjEwMCUiIHgyPSI1MCUiIHkyPSItMS40MjEwODU0NzE1MjAyZS0xNCUiPgo8c3RvcCBvZmZzZXQ9IjAlIiBzdG9wLWNvbG9yPSIjOTUwNTA1IiBzdG9wLW9wYWNpdHk9IjEiLz4KPHN0b3Agb2Zmc2V0PSIxMDAlIiBzdG9wLWNvbG9yPSIjZDEwZjBhIiBzdG9wLW9wYWNpdHk9IjEiLz4KICAgPC9saW5lYXJHcmFkaWVudD4KCjxyZWN0IHg9IjAiIHk9IjAiIHdpZHRoPSIzMjQiIGhlaWdodD0iMzgiIGZpbGw9InVybCgjaGF0MCkiIC8+Cjwvc3ZnPg==); /* gradient overlay */
                background-image: -moz-linear-gradient(90deg, #950505 0%, #d10f0a 100%); /* gradient overlay */
                background-image: -o-linear-gradient(90deg, #950505 0%, #d10f0a 100%); /* gradient overlay */
                background-image: -webkit-linear-gradient(90deg, #950505 0%, #d10f0a 100%); /* gradient overlay */
                background-image: linear-gradient(90deg, #950505 0%, #d10f0a 100%); /* gradient overlay */
                ">


				
                
				
				
                <img src="/images/pdf-icon.png" style="position: relative; float: left; margin-top: 5px; margin-left: 15px; " alt="PDF Icon"/>
                <div style="position: relative; float: left; margin-right: 15px; margin-left: 10px; margin-top:9px; color: #fff; /* text color */ text-shadow: 1px 2px 3px rgba(0,0,0,.75); /* drop shadow */ font-size: 14px;">
                 <?php echo $row_rs_printables['fileTitle']; ?>
                </div>
                <div style="clear: both;"></div>
              </div></a><div style="clear: both;"></div><br>
              <?php } while ($row_rs_printables = mysql_fetch_assoc($rs_printables)); ?>
            </center>
			
			</fieldset>
	</div>
    <div style="clear: both;"></div>
    <div id="query_spinner" style="position: absolute; top: 255px; left: 145px; display: none;">
    	<img src="/images/spinner.gif" style="float: left;"/> <div style="float: left; margin-left: 10px; margin-top: 8px; opacity: 0.8;">Search In Progress ... <a href="" onclick="document.location.reload(true);">NEW SEARCH</a></div>
    </div>
</div>
<script>
$('#queryArtist').focus();
</script>
</body>
</html>
<?php
mysql_free_result($rs_manufacturers);

mysql_free_result($Recordset1);
?>
