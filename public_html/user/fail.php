<!-- InstanceBegin template="/Templates/dev-dec12.dwt.php" codeOutsideHTMLIsLocked="false" --><?php session_start(); ?><?php require_once '../php_classes/Mobile-Detect-2.3/Mobile_Detect.php'; ?>
<?php
    $detect = new Mobile_Detect;
    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
?>
<!doctype html>
<!--[if lt IE 9]><html class="ie"><![endif]-->
<!--[if gte IE 9]><!--><html><!--<![endif]--><head>

		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
		<!-- InstanceBeginEditable name="doctitle" -->
		<title>Australian Karaoke Pty. Ltd. | Melbourne's No1 Shop for Complete Karaoke Systems, Components and Tracks!</title>
		<!-- InstanceEndEditable -->
		<link rel="shortcut icon" href="../favicon.ico">
		
			<meta http-equiv='Cache-Control' content='no-cache'>
		
		<meta name="format-detection" content="telephone=no">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name='apple-touch-fullscreen' content='yes'>
		<meta name="apple-mobile-web-app-status-bar-style" content="black" />
		<meta name="apple-mobile-web-app-title" content="Australian Karaoke">
		
		<meta name="description" content="Complete Karaoke Systems for Purchase and Hire, Karaoke Machine/Gear/Components/Equipment/Accessories/Discs, Store in St Kilda/Melbourne/Victoria."/>
		<meta name="keywords" content="karaoke, melbourne, victoria, karaoke shop, karaoke store, karaoke equipment, karaoke complete systems, karaoke systems, karaoke discs, karaoke tracks, karaoke titles, kareoke player, kareoke machine, computer karaoke, multimedia studio, recording studio, vocal studio, karaoke studio, karaoke, karaoke australia, melbourne karaoke, victoria karaoke, karaoke hire, karaoke buy, karaoke bargains, professional karaoke, Samson, Numark, Phonic, V2GO, Wharfedale, Rubicon, CAVS, Sunfly, Music Maestro, Sound Choice, DB Technologies, Alesis, Ultrasone, Tascam, On-Stage, Quiklok, Japan Fender, Japanese Fender, Kids, Chartbusters, Sound Choice, Karaoke Kool, Kids, Kids Karaoke, DJ Equipment, DJ Sales, DJ Service, Entertainment, Karaoke Hire, Corporate Hire, Event Hire, Party Hire, Key Changing, Key Change, Pitch Changing, Kareoke, Karoake, VCD, CDG, DVD, VCD Karaoke, CDG Karaoke, DVD Karaoke, Backing Track, Karaoke Hire Melbourne, Karaoke Hire Victoria, Microphone, Karaoke Discs, Karaoke Microphone, Sunfly Karaoke, Capital Karaoke, Karaoke System, Voice Removal, Australian Karaoke, Karaoke Player, Karaoke Equipment, Backing Track, Backing Tracks, Recording Studio, Vocal Studio, Speakers, Amplifiers, Turntables, CDJ, DJ CD, DJ Turntables, Leads, Mic Stand, Microphone Stand, Speaker Stand, Wireless Microphones, Wireless Mics, MP3 Players, Powered Speakers, CD Duplicators, USB Mixers, Vinyl CD, Signal Processors, Graphic Equalisers, Graphic Equalizers, Vocal Trainers, Karaoke Mixers, DJ Packages, Cartridges, Mixers, Powered Mixers, Second Hand Audio, Second Hand Audio Equipment, Headphones, Complete Karaoke Packages, Complete PA Packages, Karaoke Machines, Victoria Karaoke, Victorian Karaoke, Karaoke Melbourne, Karaoke Sales, Karaoke Service, karaoke gear, karaoke shop melbourne, karaoke shop victoria, shop, karaoke hire, karoke, kareoke, melbroune, VIC, karaoke music, cheap karaoke machines, karaoke machines for sale, backing tracks, karaoke players, super cd+g, CDG, karaoke machine sale, buy karaoke machine, cd karaoke machine, home karaoke machines, buy a karaoke machine, buy a karaoke machine, where to buy a karaoke machine, buy a karaoke machine, online karaoke machine, karaoke dvds, best karaoke players, video karaoke machine, home karaoke systems, karaok, pro karaoke system, pro karaoke system, karaoke recorder, karaoke recorder, karaoke sites, karaoke song, karaoke anything, power karaoke, karaoke places, 279 Inkerman St East St Kilda VIC 3183 Australia, karaoke supplies, karaoke party, music store, cd g discs, cd g, custom karaoke"/>
		<meta name="subject" content="Complete Karaoke Systems for Purchase and Hire, Karaoke Machine/Gear/Components/Equipment/Accessories/Discs, Store in St Kilda/Melbourne/Victoria." />
		<meta name="robots" content="NOODP,NOYDIR"/>
		<meta name='copyright' content='Codeien'>
		<meta name='language' content='EN'>
		<meta name="author" content="Codeien, codeien@gmail.com">
		<!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2">-->
		<meta name="viewport" content="width=1500px;">
        
		<link rel="canonical" href="http://www.australiankaraoke.com.au"/>
		<link rel="apple-touch-icon" href="/touch-icon.png"/>
		<link rel="apple-touch-icon" sizes="72x72" href="/touch-icon.png"/>
		<link rel="apple-touch-icon" sizes="114x114" href="/touch-icon-retina.png"/>
		<link rel="apple-touch-startup-image" href="/favicon-ios.png" />
		
		
<noscript>
			<p class="alert">
				This site makes heavy use of JavaScript, which could not be detected at this time!<br>Please enable it in the browser settings or upgrade your web client!
			</p>
		</noscript>

		<?php
			if($deviceType=="computer"){
		?>
			<!--[if lt IE 9]>
				<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->
			
			<link href="/styles/css/normalize.css" rel="stylesheet" type="text/css">
			<link href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
			<link href='http://fonts.googleapis.com/css?family=Scada:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
			
	    	<link href="/styles/css/fonts.css" rel="stylesheet" type="text/css">
	        <link href="/styles/css/main.css" rel="stylesheet" type="text/css">
				
				
			<script src="/frameworks/modernizr.custom.22737.js"></script>
			<script src="http://code.jquery.com/jquery.js"></script>
			<script src="/frameworks/jquery-plugins/jquery.animate-enhanced.min.js"></script>
			<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
			<script src="/frameworks/jquery-plugins/jquery.horizontalNav.js"></script>
            
	    	<script src="/scripts/functions-desktop-all.js"></script>
	    	<script src="/scripts/objects-desktop-all.js"></script>
	    	<script src="/scripts/onLoad-desktop-all.js"></script>
	    	<script src="/scripts/onReady-desktop-all.js"></script>

		<?php
			}
				
			if($deviceType=="tablet"){
		?>

			<link href="/styles/css/normalize.css" rel="stylesheet" type="text/css">
			<link href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
			<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
			<link rel="stylesheet" href="/styles/css/jquery-theme-tablet/theme-tablet.css" />
			
            <link href='http://fonts.googleapis.com/css?family=Scada:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
            
	    	<link href="/styles/css/fonts.css" rel="stylesheet" type="text/css">
            <link href="/styles/css/main.css" rel="stylesheet" type="text/css">


			<script src="/frameworks/modernizr.custom.22737.js"></script>
			<script src="http://code.jquery.com/jquery.js"></script>
			<script src="/frameworks/jquery-plugins/jquery.animate-enhanced.min.js"></script>
			<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
			<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
			<script src="/frameworks/jquery-plugins/jquery.ui.touch-punch.min.js"></script>
            <script src="/frameworks/jquery-plugins/jquery.horizontalNav.js"></script>

	    	<script src="/scripts/functions-mobile-tablet.js"></script>
	    	<script src="/scripts/objects-mobile-tablet.js"></script>
	    	<script src="/scripts/onLoad-mobile-tablet.js"></script>
	    	<script src="/scripts/onReady-mobile-tablet.js"></script>

		<?php
			}
			
			if($deviceType=="phone"){
		?>

						<link href="/styles/css/normalize.css" rel="stylesheet" type="text/css">
						<link href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" rel="stylesheet" type="text/css">
						<link rel="stylesheet" href="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
						<link rel="stylesheet" href="/styles/css/jquery-theme-phone/theme-phone.css" />

						<link href='http://fonts.googleapis.com/css?family=Scada:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
                        
				    	<link href="/styles/css/fonts.css" rel="stylesheet" type="text/css">
		                <link href="/styles/css/main.css" rel="stylesheet" type="text/css">


							<script src="/frameworks/modernizr.custom.22737.js"></script>
							<script src="http://code.jquery.com/jquery.js"></script>
							<script src="/frameworks/jquery-plugins/jquery.animate-enhanced.min.js"></script>
							<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
							<script src="http://code.jquery.com/mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
							<script src="/frameworks/jquery-plugins/jquery.ui.touch-punch.min.js"></script>
                            <script src="/frameworks/jquery-plugins/jquery.horizontalNav.js"></script>

				    	<script src="/scripts/functions-mobile-phone.js"></script>
				    	<script src="/scripts/objects-mobile-phone.js"></script>
				    	<script src="/scripts/onLoad-mobile-phone.js"></script>
				    	<script src="/scripts/onReady-mobile-phone.js"></script>

		<?php
			}
		?>
		
        <!--[if lte IE 9]>
        	<link href="/styles/css/main-desktop.css" rel="stylesheet" type="text/css">
        	<link href="/styles/css/lteIE9-adjust.css" rel="stylesheet" type="text/css">
		<![endif]-->
		
        
        <!-- InstanceBeginEditable name="head" -->
        
		<!-- InstanceEndEditable -->
	</head>

	<body lang="en" onorientationchange="">
	<div id="wrapper" data-role="page">
		
		
			<?php
			if($deviceType=="computer"){
				?>
                	<?php require_once("../../site-template-components/header-desktop-all.php"); ?>
                    <?php require_once("../../site-template-components/nav-main-desktop-all.php"); ?>
                <?
			}
				
			if($deviceType=="tablet"){
				?>
                	<?php require_once("../../site-template-components/header-mobile-tablet.php"); ?>
                    <?php require_once("../../site-template-components/nav-main-mobile-tablet.php"); ?>
                <?
			}
			
			if($deviceType=="phone"){
				?>
                	<?php require_once("../../site-template-components/header-mobile-phone.php"); ?>
                    <?php require_once("../../site-template-components/nav-main-mobile-phone.php"); ?>
                <?
			}
			?>
			<!-- InstanceBeginEditable name="main_content" -->
            <?php
			//if($deviceType=="computer"){ // remove comment // to activate
		?>
            <div id="main_content" data-role="content">
              <section>
                <div class="section" id="section1"> Section
                  <p>              
                  <h1>P>H1</h1>
                  <p></p>
                  <p>P</p>
                  <p><a href="/#">P>A</a></p>
                  <a href="">A</a> </div>
              </section>
              <section>
                <div class="section" id="section2"> Section
                  <p>              
                  <h1>P>H1</h1>
                  <p></p>
                  <p>P</p>
                  <a href="">A</a> </div>
              </section>
              <aside>
                <div class="aside" id="aside1"> Aside Draggable
                  <p>              
                  <h2>P>H2</h2>
                  <p></p>
                </div>
              </aside>
            </div>
            <?php
			//}
		?>
            <?php
			if($deviceType=="<tablet>"){ // remove brackets to activate
		?>
            <div id="main_content" data-role="content"> tabletContent </div>
            <?php
			}
		?>
            <?php
			if($deviceType=="<phone>"){ // remove brackets to activate
		?>
            <div id="main_content" data-role="content"> phoneContent </div>
            <?php
			}
		?>
            <!-- InstanceEndEditable -->
		<?php
		
			if($deviceType=="computer"){
		?>
				<?php require_once('../../site-template-components/footer-desktop-all.php'); ?>
		<?php
			}
			
			
			if($deviceType=="tablet"){
		?>
				<?php require_once('../../site-template-components/footer-mobile-tablet.php'); ?>
		<?php
			}
			
			
			if($deviceType=="phone"){
		?>
				<?php require_once('../../site-template-components/footer-mobile-phone.php'); ?>
		<?php
			}
			?>
		<script type="text/javascript">
			
			var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', 'UA-2373781-1']);
			  _gaq.push(['_trackPageview']);
			
			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();
		</script>
	</div>
	</body>
<!-- InstanceEnd --></html>
