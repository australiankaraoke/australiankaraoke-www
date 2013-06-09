<?php require_once('../../Connections/karaoke_db.php'); ?>
<?php
session_start();
$PHPSESSID = session_id();



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Untitled Form</title>
<link rel="stylesheet" type="text/css" href="reserve-form-assets/view.css" media="all">
<script type="text/javascript" src="reserve-form-assets/view.js"></script>
<link href="/styles/css/normalize.css" rel="stylesheet" type="text/css">
<script src="http://code.jquery.com/jquery.js"></script>
<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<link href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
<link href='http://fonts.googleapis.com/css?family=Scada:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
<link href="/styles/css/fonts.css" rel="stylesheet" type="text/css">
<link href="/styles/css/main.css" rel="stylesheet" type="text/css">

<script src="/frameworks/jQuery-Validation-Engine-master/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="/frameworks/jQuery-Validation-Engine-master/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="/frameworks/jQuery-Validation-Engine-master/css/validationEngine.jquery.css" type="text/css"/>

</head>
<body id="main_body" >
	
	<img id="top" src="reserve-form-assets/top.png" alt="">
<div id="form_container">
	
  <form id="form_608052" class="appnitro"  method="post" action="finish-reserve-online.php">
					<div class="form_description">
			<h2>RESERVE ONLINE</h2>
			
		</div>						
			<ul >
			
					<li id="li_1" >
		<label class="description" for="delivery_method_deliver">Delivery Options </label>
		<span>
        
			<input id="delivery_method_delivery" name="delivery_method" class="element radio" type="radio" value="1"  checked  />
<label class="choice" for="element_1_1">Delivery (Delivery Charges Apply)</label>
<input id="delivery_method_pickup" name="delivery_method" class="element radio" type="radio" value="2" />
<label class="choice" for="element_1_2">Pick-Up</label>

		</span> 
		</li>		<li id="li_2" >
		<label class="description" for="fullName">Full Name </label>
		<div>
			<input id="fullName" name="fullName" class="element text medium validate[required]" data-prompt-position="inline" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		<li id="li_3" >
		<label class="description" for="emailAddress">Email </label>
		<div>
			<input id="emailAddress" name="emailAddress" class="element text medium validate[required,custom[email]]" data-prompt-position="inline" type="text" maxlength="255" value="" /> 
		</div> 
		</li>	
        
        <div id="address_part">
        <li id="li_4" >
        
            <label class="description" for="element_4">Address </label>
            
            <div>
                <input id="street_address" name="street_address" class="element text large element text medium validate[required]" data-prompt-position="inline" value="" type="text">
                <label for="street_address">Street Address</label>
            </div>
        
            <div>
                <input id="address_line2" name="address_line2" class="element text large" value="" type="text">
                <label for="address_line2">Address Line 2</label>
            </div>
		
		<div class="left">
			<input id="city" name="city" class="element text medium validate[required]" data-prompt-position="inline" value="" type="text">
			<label for="city">City</label>
		</div>
	
		<div class="right">
			<input id="state" name="state" class="element text small validate[required]" data-prompt-position="inline" value="" type="text">
			<label for="state">State / Province / Region</label>
		</div>
	
		<div class="left">
			<input id="postcode" name="postcode" class="element text small validate[required]" data-prompt-position="inline" maxlength="15" value="" type="text">
			<label for="postcode">Postal / Zip Code</label>
		</div>
	
		
		</li>
        </div>		
        
        <li id="li_5" >
		<label class="description" for="telephone">Phone </label>
		<div>
			<input id="telephone" name="telephone" class="element text medium validate[required]" data-prompt-position="inline" type="text" maxlength="255" value=""/> 
		</div> 
		</li>		<li id="li_6" >
		<label class="description" for="additional_notes">Additional Notes </label>
		<div>
			<textarea name="additional_notes" rows="3" class="element textarea SMALL" id="additional_notes"></textarea> 
		</div> 
		</li>
			
					<li class="buttons">
			    <input type="hidden" name="form_id" value="608052" />
			    
				<input id="saveForm" class="button_text" type="submit" name="submit" value="Send Order" style="height: 25px;" />
		</li>
			</ul>
  		</form>
        
        <input type="hidden" value="" id="" />
        
		<div id="footer">
			
		</div>
	</div>
	<img id="bottom" src="reserve-form-assets/bottom.png" alt="">
<script>
	$("#form_608052").validationEngine('attach');
	
		$("#delivery_method_pickup").click(function(){
			$("#street_address").removeClass('validate[required]');
			$("#city").removeClass('validate[required]');
			$("#state").removeClass('validate[required]');
			$("#postcode").removeClass('validate[required]');
			$("#address_part").slideUp();
		});
		$("#delivery_method_delivery").click(function(){
			$("#street_address").addClass('validate[required]');
			$("#city").addClass('validate[required]');
			$("#state").addClass('validate[required]');
			$("#postcode").addClass('validate[required]');
			$("#address_part").slideDown();
		});
		
	</script>
</body>
</html>

