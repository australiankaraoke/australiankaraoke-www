<?php require_once('../../Connections/karaoke_db.php'); ?>
<?PHP
require_once('../frameworks/tcpdf/config/lang/eng.php');
require_once('../frameworks/tcpdf/tcpdf.php');
require_once('../frameworks/PHPMailer/class.phpmailer.php');
session_start();
$PHPSESSID=session_id();
$name = $_POST["fullName"];
$address1 = $_POST["street_address"];
$address2 = $_POST["address_line2"];
$city = $_POST["city"];
$zip = $_POST["postcode"];
$state = $_POST["state"];
$email = $_POST["emailAddress"];
$telephone = $_POST["telephone"];
$addmessage = $_POST["additional_notes"];
$delivery_method_delivery = $_POST["delivery_method_delivery"];
$delivery_method_pickup = $_POST["delivery_method_pickup"];
$delivery_method = $_POST["delivery_method"];
$total=0;
$orderLines="";



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
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

	<head>
		<meta http-equiv="content-type" content="text/html;charset=ISO-8859-1">
		<title>Australian Karaoke Pty. Ltd. | ONLINE MAIL-ORDER</title>
		<link rel="stylesheet" type="text/css" href="reserve-form-assets/view.css" media="all">
	</head>

	<body  id="main_body">
	<img id="top" src="reserve-form-assets/top.png" alt="">
	<div id="form_container">
		<div align="center">
			<b>Australian Karaoke Pty. Ltd.<br>
ONLINE RESERVATION (<?php
if($delivery_method==1) {
	echo "DELIVERY";
} else {
	echo "PICK-UP";
} 
?>)<br>
					</b>
				<fieldset>
					<legend>Customer Details</legend>
					<table width="100%" border="0" cellspacing="0" cellpadding="3">
						<tr>
							<td valign="top">

<?php
//echo $PHPSESSID;
echo $name;


?>							
<br>
<?php
echo $address1;
?>
<br>
<?php
echo $address2;

?>
<br>
<?php
echo $city;

?> &#149; 
<?php
echo $zip;

?> &#149; 
<?php
echo $state;

?>
<br>

			          <br>
								</td>
							
<?php
echo $email;

?>
<br>
									<?php
echo $telephone;

?><br>
									<?php

?>
</td>
						</tr>
					</table>
					 
				</fieldset>
				<br>
				<fieldset>
					<legend>Order (PO: <b>
<?php
$today = getdate(); 
$month = $today['mon']; 
$mday = $today['mday']; 
$year = $today['year'];
echo $name.$mday.$month.$year;


?></b>)</legend>
					<table width="100%" border="0" cellspacing="0" cellpadding="2">
						<tr>
							<td>Product SKU</td>
							<td>Single Item Price (in A$)</td>
							<td>Quantity</td>
							<td>Price (in A$)</td>
						</tr>
						<tr>
							<td colspan="4">
								<div align="center">
									<hr size="1" width="100%">
								</div>
							</td>
						</tr>
					</table>
					<table width="100%" border="0" cellspacing="0" cellpadding="2">
						
						<!-- START REPEAT PRODUCTS -->
			          <?php do { ?>
			            <?
					    if ($row_rs_cart_products['products_sku']) {
					    ?>
			            <tr>
			              <td><?php echo $row_rs_cart_products['products_sku']; ?></td>
			              <td><?php echo $row_rs_cart_products['products_regularPrice']; ?></td>
			              <td><?php echo $row_rs_cart_products['shoppingcart_quantity']; ?></td>
			              <td><?
								echo ($row_rs_cart_products['shoppingcart_quantity']*$row_rs_cart_products['products_regularPrice']);
								?></td>
		              </tr>
		              <? $total=$total+($row_rs_cart_products['shoppingcart_quantity']*$row_rs_cart_products['products_regularPrice']); ?>
		              <? 
						    $orderLines=$orderLines."
							<tr>
						    <td style=\"border: 1px solid black; font-size: 28px;\">".$row_rs_cart_products['products_sku']."</td>
						    <td  style=\"border: 1px solid black; font-size: 28px;\">".$row_rs_cart_products['products_title']."</td>
						    <td  style=\"border: 1px solid black; font-size: 28px;\">".number_format((($row_rs_cart_products['products_regularPrice']*100)/110),2)."</td>
						    <td  style=\"border: 1px solid black; font-size: 28px;\">".$row_rs_cart_products['shoppingcart_quantity']."</td>
						    <td  style=\"border: 1px solid black; font-size: 28px;\">".number_format((($row_rs_cart_products['products_regularPrice']*$row_rs_cart_products['shoppingcart_quantity']*100)/110),2)."</td>
						    </tr>";
					    ?>
					    <?
					    }
					    ?>
			            <?php } while ($row_rs_cart_products = mysql_fetch_assoc($rs_cart_products)); ?>
<!-- END REPEAT PRODUCTS  -->
                        
                        <!-- START REPEAT SYSTEMS -->
						<?php do { ?>
					    <?
					    if ($row_rs_cart_systems['systems_title']) {
					    ?>
					    <tr>
						    <td>
						      <?php echo $row_rs_cart_systems['systems_title']; ?>
					      </td>
						    <td>
						      <?php echo $row_rs_cart_systems['systems_regularPrice']; ?>
					      </td>
						    <td>
						      <?php echo $row_rs_cart_systems['shoppingcart_quantity']; ?>
					      </td>
						    <td>
						      <?
								echo ($row_rs_cart_systems['systems_regularPrice']*$row_rs_cart_systems['shoppingcart_quantity']);
								?>
					      </td>
					    </tr>
					   
					    <? $total=$total+($row_rs_cart_systems['systems_regularPrice']*$row_rs_cart_systems['shoppingcart_quantity']); ?>
					   <? 
						    $orderLines=$orderLines."
							<tr>
							<td  style=\"border: 1px solid black; font-size: 28px;\">AKS".$row_rs_cart_systems['systems_id']."</td>
						    <td style=\"border: 1px solid black; font-size: 28px;\">".$row_rs_cart_systems['systems_title']."</td>
						    <td  style=\"border: 1px solid black; font-size: 28px;\">".number_format((($row_rs_cart_systems['systems_regularPrice']*100)/110),2)."</td>
						    <td  style=\"border: 1px solid black; font-size: 28px;\">".$row_rs_cart_systems['shoppingcart_quantity']."</td>
						    <td  style=\"border: 1px solid black; font-size: 28px;\">".number_format((($row_rs_cart_systems['systems_regularPrice']*$row_rs_cart_systems['shoppingcart_quantity']*100)/110),2)."</td>
						    </tr>";
					    ?>
					     <?
					    }
					    ?>
						  <?php } while ($row_rs_cart_systems = mysql_fetch_assoc($rs_cart_systems)); ?>
<!-- END REPEAT SYSTEMS  -->
                        
                        <!-- START REPEAT TRACKS -->
						<?php do { ?>
					    <?
					    if ($row_re_cart_discs['discs_DISC']) {
					    ?>
					    <tr>
						    <td>
						      <?php echo $row_re_cart_discs['discs_DISC']; ?>
						      </td>
						    <td>
						      <?php echo $row_re_cart_discs['shoppingcart_price']; ?>
						      </td>
						    <td>
						      <?php echo $row_re_cart_discs['shoppingcart_quantity']; ?>
					        </td>
						    <td>
						      <?
								echo ($row_re_cart_discs['shoppingcart_quantity']*$row_re_cart_discs['shoppingcart_price']);
								?>
						      </td>
					    </tr>
					    <? $total=$total+($row_re_cart_discs['shoppingcart_quantity']*$row_re_cart_discs['shoppingcart_price']); ?>
					    <? 
						    $orderLines=$orderLines."
							<tr>
							
						    <td style=\"border: 1px solid black; font-size: 28px;\">".$row_re_cart_discs['discs_DISC']."</td>
						    <td  style=\"border: 1px solid black; font-size: 28px;\">".$row_re_cart_discs['discs_MAN']."</td>
						    <td  style=\"border: 1px solid black; font-size: 28px;\">".number_format((($row_re_cart_discs['shoppingcart_price']*100)/110),2)."</td>
						    <td  style=\"border: 1px solid black; font-size: 28px;\">".$row_re_cart_discs['shoppingcart_quantity']."</td>
						    <td  style=\"border: 1px solid black; font-size: 28px;\">".number_format((($row_re_cart_discs['shoppingcart_price']*$row_re_cart_discs['shoppingcart_quantity']*100)/110),2)."</td>
						    </tr>";
						    
					    ?>
					    <?
					    }
					    ?>
						  <?php } while ($row_re_cart_discs = mysql_fetch_assoc($re_cart_discs)); ?>
<!-- END REPEAT TRACKS  -->
						
					</table>
					<br>
					<table width="100%" border="0" cellspacing="0" cellpadding="2">
						<tr>
							<td></td>
							<td></td>
							<td><b>TOTAL:
								<?
								echo ($total);
								?>
							</b></td>
							<td><b>

<?php

?>
							
							</b></td>
						</tr>
						<tr>
							<td colspan="4">
								<div align="center">
									<hr size="1" width="100%">
								</div>
							</td>
						</tr>
					</table>
					 
				</fieldset>
				<br>
				<fieldset>
					



					<legend>Additional Notes</legend>
<?php
echo $addmessage;

?>

</fieldset>
<br>
<?php

// START LOOP
 

// END LOOP

$beforeGST=number_format((($total*100)/110),2);
$GSTonly = number_format($total-(($total*100)/110),2);
$total=number_format($total, 2);


if($delivery_method==1) {
	$header_note = "<td style=\"padding:5px; font-size: 35px; text-align: right;\">
			<b>ORDER<br>CONFIRMATION</b><br>
			(Delivery)<br><br>
			<span style=\"font-size: 21px;\">Note: The items have been reserved for you and we will be in contact shortly to arrange payment and delivery.<br><br>
			An additional <b>shipping rate</b> will apply!
			</span>
		</td>";
} else {
	$header_note = "<td style=\"padding:5px; font-size: 35px; text-align: right;\">
			<b>ORDER<br>CONFIRMATION</b><br>
			(Pick-Up)<br><br>
			<span style=\"font-size: 21px;\">Note: The items have been reserved for you and we will be in contact shortly to arrange payment and pick-up date/time.<br><br>
			</span>
		</td>";
} 

$mailBody="
<style>
.cellBorder {
	border: 1px solid black; font-size: 30px;
}
</style>

<table width=\"100%\" cellpadding=\"5\">
	<tr>
		<td>
			<table style=\"border: 1px solid black;\" cellpadding=\"5\">
				<tr>
					<td>
					$name
					</td>
				</tr>
				<tr>
					<td>
					$address1
					</td>
				</tr>
				<tr>
					<td>
					$city
					</td>
				</tr>
				<tr>
					<td>
					$zip $state $country
					</td>
				</tr>
				<tr>
					<td>
					$telephone
					</td>
				</tr>
				<tr>
					<td>
					$email
					</td>
				</tr>
			</table>
		</td>
		<td>
		</td>
		$header_note
	</tr>
</table>

<br>

<table width=\"100%\" border=\"0\" cellpadding=\"5\">
  <tr style=\"background-color: #CCC; font-weight: bold;\">
    <th scope=\"col\" class=\"cellBorder\" width=\"11%\">SKU</th>
    <th scope=\"col\" width= \"50%\" class=\"cellBorder\">ITEM</th>
    <th scope=\"col\" width= \"13%\" class=\"cellBorder\">UNIT PRICE</th>
    <th scope=\"col\" width= \"13%\" class=\"cellBorder\">QTY</th>
    <th scope=\"col\" width= \"13%\" class=\"cellBorder\">PRICE</th>
  </tr>
  
  $orderLines

</table>

<table width=\"100%\" border=\"0\" cellpadding=\"5\">
	<tr>
    <td width=\"61%\" ></td>
    
    <td width= \"39%\" style=\"border: 1px solid black; font-size: 32px;\" >
    	<table width=\"100%\" cellpadding=\"5\">
    		<tr>
	    		<td width=\"63%\">
	    			Subtotal
	    		</td>
	    		<td width=\"37%\">
	    			$beforeGST
	    		</td>
    		</tr>
    		<tr>
	    		<td width=\"63%\">
	    			(GST)
	    		</td>
	    		<td width=\"37%\">
	    			($GSTonly)
	    		</td>
    		</tr>
    		<tr>
	    		<td width=\"63%\" style=\"font-size: 34px;\">
	    			<b>Total</b>
	    		</td>
	    		<td width=\"37%\">
	    			<b>$total</b>
	    		</td>
    		</tr>
    	</table>
    </td>
  </tr>
</table><br><br>
NOTE: $addmessage
";


//$mailTo="akd1@bigpond.net.au";

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        $image_file = K_PATH_IMAGES.'australian_karaoke_logo.png';
        $this->Image($image_file, 10, 10, 120, '', 'PNG', '', 'T', true, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', '', 8);
        // Title
        //$this->Cell(0, 15, '279 Inkerman Street', 0, false, 'R', 0, '', 0, false, 'M', 'M');
        $this->Cell	(	$w=0,
						$h = 5,
						$txt = '279 Inkerman Street',
						$border = 0,
						$ln = 0,
						$align = 'R',
						$fill = false,
						$link = '',
						$stretch = 0,
						$ignore_min_height = false,
						$calign = 'T',
						$valign = 'B' 
					);	
		$this->SetX(-25);
		$this->SetY(15);
        $this->Cell	(	$w=0,
						$h = 5,
						$txt = 'Balaclava',
						$border = 0,
						$ln = 0,
						$align = 'R',
						$fill = false,
						$link = '',
						$stretch = 0,
						$ignore_min_height = false,
						$calign = 'T',
						$valign = 'B' 
					);	
		$this->SetX(-25);
		$this->SetY(20);
        $this->Cell	(	$w=0,
						$h = 5,
						$txt = 'VIC 3183',
						$border = 0,
						$ln = 0,
						$align = 'R',
						$fill = false,
						$link = '',
						$stretch = 0,
						$ignore_min_height = false,
						$calign = 'T',
						$valign = 'B' 
					);
		$this->SetX(-25);
		$this->SetY(25);
        $this->Cell	(	$w=0,
						$h = 5,
						$txt = 'Tel. 03 9534 4106',
						$border = 0,
						$ln = 0,
						$align = 'R',
						$fill = false,
						$link = '',
						$stretch = 0,
						$ignore_min_height = false,
						$calign = 'T',
						$valign = 'B' 
					);
		$this->SetX(-25);
		$this->SetY(30);
        $this->Cell	(	$w=0,
						$h = 5,
						$txt = 'Fax 03 9534 8231',
						$border = 0,
						$ln = 0,
						$align = 'R',
						$fill = false,
						$link = '',
						$stretch = 0,
						$ignore_min_height = false,
						$calign = 'T',
						$valign = 'B' 
					);
		$this->SetY(30);
		//$this->SetX(-120);
		$this->Cell	(	$w=0,
						$h = 5,
						$txt = 'ABN: 44 006 187 542 • BSB: 083231 • A/C: 688156694 ',
						$border = 0,
						$ln = 0,
						$align = 'L',
						$fill = false,
						$link = '',
						$stretch = 0,
						$ignore_min_height = false,
						$calign = 'T',
						$valign = 'B' 
					);
		
		$this->Line	(	15,
						38,
						195,
						38
						//$style = array() 
						);		
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator("AUSTRALIAN KARAOKE PTY LTD");
$pdf->SetAuthor("AUSTRALIAN KARAOKE PTY LTD");
$pdf->SetTitle("PRODUCT RESERVATION");
$pdf->SetSubject('PRODUCT RESERVATION');
$pdf->SetKeywords('karaoke, product, reserve, australia');


// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();


// Set some content to print
$html_page_X = $mailBody;

// Print text using writeHTMLCell()
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='44', $html_page_X, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', "Here would be the content for the next page .... but there is other stuff more important right now!", $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

$filename = $PHPSESSID.".pdf";

//$pdf->writeHTML($mailBody, true, false, true, false, '');
$pdf->Output($filename, 'F'); // save the pdf under filename

$mail = new PHPMailer(true);
$mail->AddReplyTo('order@australiankaraoke.com.au', 'Australian Karaoke Pty. Ltd. | Product Orders & Reservations');
$mail->AddAddress($email);
$mail->AddAddress('order@australiankaraoke.com.au', 'Australian Karaoke Pty. Ltd. | Product Orders & Reservations');
//$mail->AddAddress('akd1@bigpond.net.au', 'Australian Karaoke Pty. Ltd.');
$mail->SetFrom('order@australiankaraoke.com.au', 'Australian Karaoke Pty. Ltd. | Product Orders & Reservations');
  
$pdf_content = file_get_contents($filename);

$mail->WordWrap = 50;
$mail->AddStringAttachment($pdf_content, $PHPSESSID.".pdf", "base64", "application/pdf");  // note second item is name of emailed pdf
//$mail->IsHTML(true);
$mail->Subject = "Australian Karaoke - PRODUCT RESERVATION | #".$PHPSESSID;
$mail->MsgHTML("
Dear $name,<br>
<br>
Attached please find the PRODUCT RESERVATION <b>".$name.$mday.$month.$year."</b> you submitted via our website.<br><br>
We will shortly get in touch with you in order to arrange for delivery and payment details.<br><br>
If you have any questions please contact us at <b>order@australiankaraoke.com.au</b> or via phone <b>03 9534 4106</b> (Mo-Fr: 9am-5pm | Sa: 9am-1pm ).<br><br>
Australian Karaoke Pty. Ltd.
");
if(!$mail->Send()) {
     echo "Sorry ... EMAIL FAILED"; 
     }

unlink($filename); // this

?><br>
			<b>THANK YOU FOR YOUR PRODUCT RESERVATION.<br>
						WE WILL BE IN CONTACT SHORTLY IN ORDER TO ARRANGE PAYMENT AND DELIVERY<br>
						<br>
					</b>IF YOU HAVE ANY FURTHER QUESTIONS DO NOT HESITATE TO <a href="mailto:contact@australiankaraoke.com.au"><b>CONTACT</b></a> US!<br>
				
		</div>
        <script>
		//window.opener.location = "/index.php"
		</script>
		<?PHP
		$tempConn=mysql_pconnect ("localhost","karaoke_admin","bun4CeS5");
mysql_select_db ("karaoke_db2",$tempConn);

$thisSql ="DELETE FROM shoppingcart ";
$thisSql.="WHERE session_id='$PHPSESSID'";
//$sql.= date("YmdHis", (time()-86400));

mysql_query($thisSql,$tempConn);


		?>
		</div>
	</body>

</html>
<?php
mysql_free_result($rs_cart_products);

mysql_free_result($re_cart_discs);

mysql_free_result($rs_cart_systems);
?>
