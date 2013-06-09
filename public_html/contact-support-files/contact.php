<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script src="/frameworks/jQuery-Validation-Engine-master/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="/frameworks/jQuery-Validation-Engine-master/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="/frameworks/jQuery-Validation-Engine-master/css/validationEngine.jquery.css" type="text/css"/>
<script>

</script>
</head>

<body>
<div id="contact_content" style="font-size: 19px; padding: 10px; color: #6b6b6b; margin-top: 25px;">
	<div id="contact_webform" style="position: relative; float: left; width: 500px; height: 400px; color: white; background-color: rgba(70,25,90,0.9);-webkit-box-shadow: 0px 3px 20px rgba(50, 50, 50, 0.52);
-moz-box-shadow:    0px 3px 20px rgba(50, 50, 50, 0.52);
box-shadow:         0px 3px 20px rgba(50, 50, 50, 0.52); padding: 15px; font-size: 15px;">
		
		
		<form id="contact_form" action="/" >
		<h2 style="margin-left: 10px;">Online Form</h2>
		<div style="height: 10px;"></div>
		<div style="display: table-cell; width: 150px; float: left; padding: 10px;">Full Name<sup style="color: red">*</sup>:</div><div style="display: table-cell; width: 290px; float: left; padding: 10px;">
			<div style="position: relative; width: 290px;"><input type="text" id="contact_form_full_name" name="contact_form_full_name" style="width: 290px;" class="validate[required]" /></div>
		</div>
		<div style="display: block; position: relative;"></div>
		<div style="display: table-cell; width: 150px; float: left; padding: 10px;">Company:</div><div style="display: table-cell; width: 290px; float: left; padding: 10px;">
			<input type="text" id="contact_form_company" name="contact_form_company" style="width: 290px;" />
		</div>
		<div style="display: block; position: relative;"></div>
		<div style="display: table-cell; width: 150px; float: left; padding: 10px;">Email<sup style="color: red">*</sup>:</div><div style="display: table-cell; width: 290px; float: left; padding: 10px;">
			<div style="position: relative; width: 290px;"><input type="text" id="contact_form_email" name="contact_form_email" style="width: 290px;" class="validate[required,custom[email]]" /></div>
		</div>
		<div style="display: table-cell; width: 150px; float: left; padding: 10px;">Phone:</div><div style="display: table-cell; width: 290px; float: left; padding: 10px;">
			<input type="text" id="contact_form_phone" name="contact_form_phone" style="width: 290px;" />
		</div>
		<div style="display: table-cell; width: 150px; float: left; padding: 10px;">Message<sup style="color: red">*</sup>:</div><div style="display: table-cell; width: 290px; float: left; padding: 10px;">
			<div style="position: relative; width: 290px;"><textarea name="contact_form_message" id="contact_form_message" style="height: 120px; width: 290px;" class="validate[required]"></textarea></div>
		</div>
		<div style="display: table-cell; width: 150px; float: left; padding: 10px;">&nbsp;</div><div style="display: table-cell; width: 290px; float: left; padding: 10px;">
			<input type="submit" onClick="submitContactForm();return false;"/>
		</div>
		<div style="clear: both;"></div>
		</form>
		<script>
		    $("#contact_form").validationEngine('attach');
			function submitContactForm(){
				if($("#contact_form").validationEngine('validate')) {
					$("#contact_webform").load("/contact-support-files/contact_send.php",{
						'contact_form_full_name':$("#contact_form_full_name").val(),
						'contact_form_company':$("#contact_form_company").val(),
						'contact_form_email':$("#contact_form_email").val(),
						'contact_form_phone':$("#contact_form_phone").val(),
						'contact_form_message':$("#contact_form_message").val()
					});
				}
			}
		</script>
	</div>
	<div id="contact_info" style="position: relative; float: right; width: 350px; height: 400px; padding: 25px; ">
		<div style="position: relative; height: 10px; border-top: 1px solid grey;"></div>
		<div style="position: relative; width: 350px;">
			<h3>Postal Address / Shop</h3>
			<div style="height: 10px;"></div>
			<p><strong>Australian Karaoke Pty. Ltd.</strong></p>
			<p>279 Inkerman Street</p>
			<p>Balaclava (St Kilda East)</p>
			<p>VIC 3183</p>
		</div>
		<div style="position: relative; height: 10px; border-bottom: 1px solid grey;"></div>
		<div style="position: relative; width: 350px; margin-top: 10px;">
			<h3>Phone Numbers</h3>
			<div style="height: 10px;"></div>
			<p>Telephone: (03) 9534 4106</p>
			<p>Fax: (03) 9534 8231</p>
		</div>
		<div style="position: relative; height: 10px; border-bottom: 1px solid grey;"></div>
		<div style="position: relative; width: 350px;margin-top: 10px;">
			<h3>Shop Opening Hours</h3>
			<div style="height: 10px;"></div>
			<p>Mon - Fri: 9am - 5pm</p>
			<p>Sat: 9am - 1pm</p>
			<p>Sun: Closed</p>
		</div>
		<div style="position: relative; height: 10px; border-bottom: 1px solid grey;"></div>
	</div>
	<div style="clear: both;"></div>
</div>
</body>
</html>