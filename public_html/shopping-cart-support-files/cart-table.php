<?php require_once('../../Connections/karaoke_db.php'); ?>
<?php
// Load the common classes
require_once('../../includes/common/KT_common.php');

// Load the tNG classes
require_once('../../includes/tng/tNG.inc.php');

// Make a transaction dispatcher instance
$tNGs = new tNG_dispatcher("../../");

// Make unified connection variable
$conn_karaoke_db = new KT_connection($karaoke_db, $database_karaoke_db);

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
$query_rs_cart_systems = "SELECT * FROM v_shopping_cart_systems WHERE shoppingcart_session_id = '$PHPSESSID'";
$rs_cart_systems = mysql_query($query_rs_cart_systems, $karaoke_db) or die(mysql_error());
$row_rs_cart_systems = mysql_fetch_assoc($rs_cart_systems);
$totalRows_rs_cart_systems = mysql_num_rows($rs_cart_systems);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_rs_cart_products = "SELECT * FROM v_shopping_cart_products WHERE shoppingcart_session_id = '$PHPSESSID'";
$rs_cart_products = mysql_query($query_rs_cart_products, $karaoke_db) or die(mysql_error());
$row_rs_cart_products = mysql_fetch_assoc($rs_cart_products);
$totalRows_rs_cart_products = mysql_num_rows($rs_cart_products);

mysql_select_db($database_karaoke_db, $karaoke_db);
$query_re_cart_discs = "SELECT * FROM v_shopping_cart_discs WHERE shoppingcart_session_id = '$PHPSESSID'";
$re_cart_discs = mysql_query($query_re_cart_discs, $karaoke_db) or die(mysql_error());
$row_re_cart_discs = mysql_fetch_assoc($re_cart_discs);
$totalRows_re_cart_discs = mysql_num_rows($re_cart_discs);

// Show Dynamic Thumbnail
$objDynamicThumb1 = new tNG_DynamicThumbnail("../../", "KT_thumbnail1");
$objDynamicThumb1->setFolder("../uploads-admin/");
$objDynamicThumb1->setRenameRule("{rs_cart_systems.systems_filename}");
$objDynamicThumb1->setResize(120, 0, true);
$objDynamicThumb1->setWatermark(false);

// Show Dynamic Thumbnail
$objDynamicThumb2 = new tNG_DynamicThumbnail("../../", "KT_thumbnail2");
$objDynamicThumb2->setFolder("../uploads-admin/");
$objDynamicThumb2->setRenameRule("{rs_cart_products.products_filename}");
$objDynamicThumb2->setResize(120, 0, true);
$objDynamicThumb2->setWatermark(false);




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<style>
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
	font-size:14px;
	font-weight:bold;
	padding:4px 14px;
	text-decoration:none;
	text-shadow:1px 1px 0px #b23e35;
	height: 20px;
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

<script>
total = 0;
Shadowbox.init({
	handleOversize: "drag",
	modal: true
});
</script>

</head>

<body>



<div style="padding: 25px;">
<div id="cart_header" style="position: relative; width: 100%; height: 2em; background-color: #412054; color: white;">
		<div style="width: 400px; float: left;padding: 6px;">Product</div>
		<div style="width: 140px; float: right; text-align: right; padding: 6px;">SUBTOTAL</div>
		<div style="width: 140px; float: right; text-align: right; padding: 6px;">PRICE <span style="font-size: 11px;">(ea)</span></div>
		<div style="width: 100px; float: right; text-align: right; padding: 6px; padding-right: 12px">Quantity</div>
	</div>

<?php if ($totalRows_rs_cart_systems > 0) { // Show if recordset empty ?>
  <?php do { ?>
    <!-- SYSTEMS REPEAT -->
    
    <div class="cart_row" style="position: relative; width: 100%; color: #412054; border: 1px solid grey; margin-left: -1px;" id="cart_row_<?php echo $row_rs_cart_systems['shoppingcart_id']; ?>">
      
      <div style="width: 400px; border-right: 1px solid grey; float: left; padding: 6px;">
        <div style="float: left; width: 140px;">
          <img src="<?php echo $objDynamicThumb1->Execute(); ?>" border="0" />
        </div>
        <div style="float: left; width:240px;">
          <div style="">COMPLETE KARAOKE SYSTEM <?php echo $row_rs_cart_systems['systems_id']; ?></div>
          <div style=""><?php echo $row_rs_cart_systems['systems_title']; ?></div>
        </div>
      </div>
      <div style="width: 140px; float: right; text-align: right; padding: 6px;" id="subtotal_for_cart_id_<?php echo $row_rs_cart_systems['shoppingcart_id']; ?>" class="subtotal">XXX</div>
      <div style="width: 140px; float: right; text-align: right;border-right: 1px solid grey; padding: 6px;" id="price_for_cart_id_<?php echo $row_rs_cart_systems['shoppingcart_id']; ?>"><?php echo $row_rs_cart_systems['systems_regularPrice']; ?></div>
      <div style="width: 100px; float: right; text-align: right;border-right: 1px solid grey; padding: 6px; padding-right: 12px;">
        <input type="text" style="width: 98px; margin-right: 6px; text-align: right;" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="<?php echo $row_rs_cart_systems['shoppingcart_quantity']; ?>"  id="cart_id_<?php echo $row_rs_cart_systems['shoppingcart_id']; ?>" onchange="changeSystemQuantity(<?php echo $row_rs_cart_systems['shoppingcart_id']; ?>, <?php echo $row_rs_cart_systems['shoppingcart_id']; ?>)" on />
        <div id="remove_cart_id" cartID="<?php echo $row_rs_cart_systems['shoppingcart_id']; ?>" onclick="removeCartItem(<?php echo $row_rs_cart_systems['shoppingcart_id']; ?>)" style="cursor: pointer; font-size: 12px; margin-top: 4px;">(REMOVE)</div>
      </div>
      <div style="clear: both;"></div>
    </div>
    <script>
		var subtotal=$("#price_for_cart_id_<?php echo $row_rs_cart_systems['shoppingcart_id']; ?>").html();
		subtotal = subtotal * $("#cart_id_<?php echo $row_rs_cart_systems['shoppingcart_id']; ?>").val();
		$("#subtotal_for_cart_id_<?php echo $row_rs_cart_systems['shoppingcart_id']; ?>").html(subtotal);
		total = parseFloat(total) + parseFloat($("#subtotal_for_cart_id_<?php echo $row_rs_cart_systems['shoppingcart_id']; ?>").html());
		$("#cart_total_price").html("<strong>"+total+"</strong>");
	</script>
    <!-- END::SYSTEMS REPEAT -->
    <?php } while ($row_rs_cart_systems = mysql_fetch_assoc($rs_cart_systems)); ?>
  <?php } // Show if recordset empty ?>
  <?php if ($totalRows_rs_cart_products > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <!-- PRODUCTS REPEAT -->
    <div class="cart_row" style="position: relative; width: 100%; color: #412054; border: 1px solid grey; margin-left: -1px;" id="cart_row_<?php echo $row_rs_cart_products['shoppingcart_id']; ?>">
      <div style="width: 400px; border-right: 1px solid grey; float: left; padding: 6px;">
        <div style="float: left; width: 140px;">
          <img src="<?php echo $objDynamicThumb2->Execute(); ?>" border="0" />
          </div>
        <div style="float: left; width:240px;">
          <div style=""><?php echo $row_rs_cart_products['manufacturers_title']; ?> <?php echo $row_rs_cart_products['products_sku']; ?></div>
          <div style=""><?php echo $row_rs_cart_products['products_title']; ?></div>
          </div>
        </div>
      <div style="width: 140px; float: right; text-align: right; padding: 6px;" id="subtotal_for_cart_id_<?php echo $row_rs_cart_products['shoppingcart_id']; ?>" class="subtotal">XXX</div>
      <div style="width: 140px; float: right; text-align: right;border-right: 1px solid grey; padding: 6px;" id="price_for_cart_id_<?php echo $row_rs_cart_products['shoppingcart_id']; ?>"><?php echo $row_rs_cart_products['products_regularPrice']; ?></div>
      <div style="width: 100px; float: right; text-align: right;border-right: 1px solid grey; padding: 6px; padding-right: 12px;">
        <input type="text" style="width: 98px; margin-right: 6px; text-align: right;" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="<?php echo $row_rs_cart_products['shoppingcart_quantity']; ?>"  id="cart_id_<?php echo $row_rs_cart_products['shoppingcart_id']; ?>" onchange="changeSystemQuantity(<?php echo $row_rs_cart_products['shoppingcart_id']; ?>, <?php echo $row_rs_cart_products['shoppingcart_id']; ?>)" on />
        <div id="remove_cart_id" cartID="<?php echo $row_rs_cart_products['shoppingcart_id']; ?>" onclick="removeCartItem(<?php echo $row_rs_cart_products['shoppingcart_id']; ?>)">REMOVE</div>
        </div>
      <div style="clear: both;"></div>
    </div>
    <script>
		var subtotal=$("#price_for_cart_id_<?php echo $row_rs_cart_products['shoppingcart_id']; ?>").html();
		subtotal = subtotal * $("#cart_id_<?php echo $row_rs_cart_products['shoppingcart_id']; ?>").val();
		$("#subtotal_for_cart_id_<?php echo $row_rs_cart_products['shoppingcart_id']; ?>").html(subtotal);
		total = parseFloat(total) + parseFloat($("#subtotal_for_cart_id_<?php echo $row_rs_cart_products['shoppingcart_id']; ?>").html());
		$("#cart_total_price").html("<strong>"+total+"</strong>");
	</script>
    <!-- END::PRODUCTS REPEAT -->
    <?php } while ($row_rs_cart_products = mysql_fetch_assoc($rs_cart_products)); ?>
    <?php } // Show if recordset not empty ?>
    <?php if ($totalRows_re_cart_discs > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <!-- DISCS REPEAT -->
    <div class="cart_row" style="position: relative; width: 100%; color: #412054; border: 1px solid grey; margin-left: -1px;" id="cart_row_<?php echo $row_re_cart_discs['shoppingcart_id']; ?>">
      <div style="width: 400px; border-right: 1px solid grey; float: left; padding: 6px;">
        <div style="float: left; width: 140px;">
          
          </div>
        <div style="float: left; width:240px;">
          <div style=""><?php echo $row_re_cart_discs['discs_MAN']; ?> <?php echo $row_re_cart_discs['discs_DISC']; ?></div>
          </div>
        </div>
      <div style="width: 140px; float: right; text-align: right; padding: 6px;" id="subtotal_for_cart_id_<?php echo $row_re_cart_discs['shoppingcart_id']; ?>" class="subtotal">XXX</div>
      <div style="width: 140px; float: right; text-align: right;border-right: 1px solid grey; padding: 6px;" id="price_for_cart_id_<?php echo $row_re_cart_discs['shoppingcart_id']; ?>"><?php echo $row_re_cart_discs['discs_PRICE']; ?></div>
      <div style="width: 100px; float: right; text-align: right;border-right: 1px solid grey; padding: 6px; padding-right: 12px;">
        <input type="text" style="width: 98px; margin-right: 6px; text-align: right;" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="<?php echo $row_re_cart_discs['shoppingcart_quantity']; ?>"  id="cart_id_<?php echo $row_re_cart_discs['shoppingcart_id']; ?>" onchange="changeSystemQuantity(<?php echo $row_re_cart_discs['shoppingcart_id']; ?>, <?php echo $row_re_cart_discs['shoppingcart_id']; ?>)" on />
        <div id="remove_cart_id" cartID="<?php echo $row_re_cart_discs['shoppingcart_id']; ?>" onclick="removeCartItem(<?php echo $row_re_cart_discs['shoppingcart_id']; ?>)">REMOVE</div>
        </div>
      <div style="clear: both;"></div>
    </div>
    <script>
		var subtotal=$("#price_for_cart_id_<?php echo $row_re_cart_discs['shoppingcart_id']; ?>").html();
		subtotal = subtotal * $("#cart_id_<?php echo $row_re_cart_discs['shoppingcart_id']; ?>").val();
		$("#subtotal_for_cart_id_<?php echo $row_re_cart_discs['shoppingcart_id']; ?>").html(subtotal);
		total = parseFloat(total) + parseFloat($("#subtotal_for_cart_id_<?php echo $row_re_cart_discs['shoppingcart_id']; ?>").html());
		$("#cart_total_price").html("<strong>"+total+"</strong>");
	</script>
    <!-- END::DISCS REPEAT -->
    <?php } while ($row_re_cart_discs = mysql_fetch_assoc($re_cart_discs)); ?>
      <?php } // Show if recordset not empty ?>
<div id="cart_total" style="position: relative; width: 100%; color: #412054; border: 1px solid grey; margin-left: -1px;">
<div style="width: 400px; float: left;"></div>
		<div style="width: 140px; float: right; text-align: right; padding: 6px; font-size: 18px;" id="cart_total_price"><strong></strong></div>
		<div style="width: 140px; float: right; text-align: right; padding: 6px; border-right: 1px solid grey; font-size: 18px;"><strong>TOTAL</strong></span></div>
		<div style="width: 100px; float: right; text-align: right; padding: 6px;"></div>
		<div style="clear: both;"></div>
	</div>
	
	<div id="cart_checkout" style="position: relative; width: 100%; color: #412054; border: 1px solid grey; margin-left: -1px; padding-top: 10px; padding-bottom: 10px;">
		<div style="width: 400px; float: left;"></div>
		<div style="width: 140px; float: right; text-align: right; padding: 6px; font-size: 18px;">
		<strong>
			<a rel="shadowbox[Mixed];width=650;height=760" href="/shopping-cart-support-files/reserve-online.php">
				<div class="buy_now_button" style="font-size: 12px; cursor: pointer;">
					<div style="margin-top: 3px;" id="reserve_online">
					RESERVE ONLINE
					</div>
				</div>
			</a>
		</strong>
		</div>
		<div style="width: 140px; float: right; text-align: right; padding: 6px; font-size: 18px;"><strong></strong></span></div>
		<div style="width: 100px; float: right; text-align: right; padding: 6px;"></div>
		<div style="clear: both;"></div>
	</div>
	<div style="clear: both;"></div>
</div>
<script>
		

	function changeSystemQuantity(cart_id) {
		total=0;
		$.get("/shopping-cart-support-files/changeQuantity.php", { cart_id: cart_id, qty: $("#cart_id_"+cart_id).val() })
		.done(function(data) {
			var subtotal=$("#price_for_cart_id_"+cart_id).html();
			subtotal = subtotal * $("#cart_id_"+cart_id).val();
			$("#subtotal_for_cart_id_"+cart_id).html(subtotal);
			$(".subtotal").each(function(i){
			   if ($(this).html() != '') {
				   total = parseFloat(total) + parseFloat($(this).html());
			   }
		   });
			$("#cart_total_price").html("<strong>"+total+"</strong>");
		});
	}
	
	function removeCartItem(cart_id) {
		$("#cart_row_"+cart_id).remove();
		total=0;
		$.get("/shopping-cart-support-files/removeItem.php", { cart_id: cart_id})
		.done(function(data) {
			$(".subtotal").each(function(i){
			   if ($(this).html() != '') {
				   total = parseFloat(total) + parseFloat($(this).html());
			   }
		   });
			$("#cart_total_price").html("<strong>"+total+"</strong>");
		});
	}
</script>
</body>
</html>
<?php
mysql_free_result($rs_cart_systems);

mysql_free_result($rs_cart_products);

mysql_free_result($re_cart_discs);
?>
