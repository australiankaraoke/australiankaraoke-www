function PacApiClient () {
	//PRIVATE: currently selected api
	var apiType='aus-letter';
	var apiLocation='letter/domestic';
	var authKey = "bf3c639e-87c5-4a7b-b364-454a3c261f95";
	
	var apiAll = [
		{div:'aus-letter',uri:'letter/domestic'}
		,{div:'aus-parcel',uri:'parcel/domestic'}
		,{div:'int-letter',uri:'letter/international'}
		,{div:'int-parcel',uri:'parcel/international'}
	];

	//PUBLIC: init jQuery driven elements
	this.init = function () 
	{
		//create templates for output
		$.template( "SOTemplate", $('#service').html() );
		$.template( "PCRTemplate", $('#calculate').html() );

		//hide warning and display first step
		$('#splash').hide();
		$('#step1').show();
		
		//Assign apiChanger click handler
		// add the click event
        $("#apiType").click( function(event) 
		{
			//show next button which is hidden by default
			$('#btnStep1Next').show();
			
			apiType = $('input[name=apiType]:checked').val();
			for (var i=0; i<apiAll.length; i++)
			{
				if (apiType == apiAll[i].div) {
					apiLocation = apiAll[i].uri;
					//change page title to show api name
					$('#pacApiTitle').html('PAC API JS Client: ' + apiType);
					$('#'+apiAll[i].div).show();
					
				}
				else
					$('#'+apiAll[i].div).hide();
			}
        });
		
		//Populate country combo boxes
		$.ajax({
			type: "GET"
			,url: "https://auspost.com.auhttps://auspost.com.au/api/postage/country.xml"
			,headers: {
				'AUTH-KEY': authKey
			}
			,dataType: "xml"
			,success:function(response)
			{
				$(response).find('countries country').each(function(){
					$("#int-letter-country-code").append($("<option />").val($(this).find('> code').text()).text($(this).find('> name').text()));
					$("#int-parcel-country-code").append($("<option />").val($(this).find('> code').text()).text($(this).find('> name').text()));
				});
			}
			,error:function (xhr, ajaxOptions, thrownError){
				processError(xhr, thrownError);
			}    
		});
		
		//create autocomplete fields
		$('#aus-parcel-from-postcode').autocomplete({
			minLength: 3
			,source: function(request, response) {
				$.ajax({
					url: 'https://auspost.com.au/api/postcode/search.json'
					,dataType: 'json'
					,data: {
						excludePostBoxFlag: true
						,q: request.term
					}
					,headers: {
						'AUTH-KEY': authKey
					}
					,success: function(data) {
						if (data.localities.locality instanceof Array)
							response($.map(data.localities.locality, function(item) {
								return {
									label: item.postcode + ', ' + item.location,
									value: item.postcode
								}
							}));
						else
							response($.map(data.localities, function(item) {
								return {
									label: item.postcode + ', ' + item.location,
									value: item.postcode
								}
							}));
					}
				})
			}
		});
		$('#aus-parcel-to-postcode').autocomplete({
			minLength: 3
			,source: function(request, response) {
				$.ajax({
					url: 'https://auspost.com.au/api/postcode/search.json'
					,dataType: 'json'
					,data: {
						excludePostBoxFlag: true
						,q: request.term
					}
					,headers: {
						'AUTH-KEY': authKey
					}
					,success: function(data) {
						if (data.localities.locality instanceof Array)
							response($.map(data.localities.locality, function(item) {
								return {
									label: item.postcode + ', ' + item.location,
									value: item.postcode
								}
							}));
						else
							response($.map(data.localities, function(item) {
								return {
									label: item.postcode + ', ' + item.location,
									value: item.postcode
								}
							}));
					}
				})
			}
		});
		
		//Assign click handlers to buttons
		$('#btnStep1Next').click(function(){
			$('#debug').show();
			getServices();
		});
		
		$('#btnStep2Prev').click(function(){
			$('#debug').hide();
			$('#step1').show();
			$('#step2').hide();
		});
		
		$('#btnStep2Next').click(function(){
			getCalculatedResults();
		});
		
		$('#btnStep3Prev').click(function(){
			$('#step3').hide();
			$('#step2').show();
		});
	}
	
	//PRIVATE: print Debug info
	var showDebug = function(xmlDocument, url)
	{
		$("#debug").width( $(window).width() - 470 );
		$("#apiUrl").text(url);
		
		if ($.browser.msie) {
			$("#xmlResult").text( formatXml(xmlDocument.xml) );
		}
		else {
			$("#xmlResult").text( formatXml((new XMLSerializer()).serializeToString(xmlDocument)) );
		}
	}
	
	//PRIVATE: get services XML result
	var getServices = function() {
		//depending on API type data should be different
		var data = {}
		if (apiType == 'aus-letter')
			data = {
				length: $('#'+apiType+'-length').val()
				,width: $('#'+apiType+'-width').val()
				,thickness: $('#'+apiType+'-thickness').val()
			};
		else if (apiType == 'aus-parcel')
			data = {
				from_postcode: $('#'+apiType+'-from-postcode').val()
				,to_postcode: $('#'+apiType+'-to-postcode').val()
				,length: $('#'+apiType+'-length').val()
				,width: $('#'+apiType+'-width').val()
				,height: $('#'+apiType+'-height').val()
			};
		if (apiType == 'int-letter' || apiType == 'int-parcel')
			data = {
				country_code: $('#'+apiType+'-country-code').val()
			};
		//common
		data.weight = $('#'+apiType+'-weight').val();
		
		$.ajax({
			type: "GET"
			,url: "https://auspost.com.au/api/postage/"+apiLocation+"/service.xml"
			,dataType: "xml"
			,data:data
			,headers: {
				'AUTH-KEY': authKey
			}
			,success:function(response){
				processServicesXmlResult(response);
				showDebug(response, this.url);
				$('#step1').hide();
				$('#step2').show();
			}
			,error:function (xhr, ajaxOptions, thrownError){
				processError(xhr, thrownError);
				showDebug(xhr.responseXML, this.url);
			}    
		});
	}
	
	//parse services and show on screen
	var serviceObjectArray;
	
	//PRIVATE: process services results and render it into template
	var processServicesXmlResult = function(xmlDocument)  {
		serviceObjectArray = new Array();
		//get services
		$(xmlDocument).find('services service').each(function(serviceNum)
		{
			var serviceObject = {};
			
			//domestic and international service objects are different, international options are optional and are not required
			//lets specify whether service is local or international
			if (isDomesticApi())
				serviceObject.serviceType = 'domestic';
			else
				serviceObject.serviceType = 'international';
				
			serviceObject.serviceCode = $(this).find('> code').text();
			serviceObject.serviceName = $(this).find('> name').text();
			serviceObject.price = parseFloat( $(this).find('> price').text() );
			serviceObject.max_extra_cover = parseInt( $(this).find('> max_extra_cover').text()!=""?$(this).find('> max_extra_cover').text():0 );
			
			//get service options
			var optionsObjectArray = new Array();
			$(this).find('> options > option').each(function(optionNum)
			{
				var optionObject = {};

				optionObject.optionCode = $(this).find('> code').text();
				optionObject.optionName = $(this).find('> name').text();
				
				//get service options suboptions
				var subOptionsObjectArray = new Array();
				$(this).find('> suboptions > option').each(function(subOptionNum)
				{
					var subOptionObject = {};

					subOptionObject.code = $(this).find('> code').text();
					subOptionObject.name = $(this).find('> name').text();
					
					subOptionsObjectArray.push(subOptionObject);
				});
				optionObject.subOptions=subOptionsObjectArray;
				optionsObjectArray.push(optionObject);
			});
			
			serviceObject.options=optionsObjectArray;
			serviceObjectArray.push(serviceObject);
		});

		//render results to services div
		$( "#service" ).empty();
		$.tmpl( "SOTemplate", serviceObjectArray ).appendTo( "#service" );
		
		showDebug(xmlDocument);
	}
	
	//PRIVATE: get calculated XML result
	var getCalculatedResults = function() 
	{
		//lets get user selected values via
		//loop through all input fields and checking of the checked/ticked options
		
		var serviceCode = "";
		var optionCode = "";
		var subOptionCodes = new Array();
		
		//for multivalues optionsCode for international services
		var optionCodesArray = new Array(); 
		
		var extraCoverValue = "";
		
		//looping through services
		for (var i=0; i<serviceObjectArray.length; i++)
		{
			
			if( $('#SERVICE_'+serviceObjectArray[i].serviceCode).is(':checked') )
			{
				serviceCode = $('#SERVICE_'+serviceObjectArray[i].serviceCode).val();
				
				//looping through service options
				for(var j=0; j<serviceObjectArray[i].options.length; j++)
				{
					if ( $('#SERVICE_'+serviceCode+'_SERVICE_OPTION_'+serviceObjectArray[i].options[j].optionCode).is(':checked') )
					{
						optionCode = $('#SERVICE_'+serviceCode+'_SERVICE_OPTION_'+serviceObjectArray[i].options[j].optionCode).val();
						optionCodesArray.push(optionCode); // <= used by international services only for multivalues optionsCode
						
						//for international services extra cover is within options
						if (optionCode == 'INTL_SERVICE_OPTION_EXTRA_COVER')
						{
							extraCoverValue = $('#SERVICE_'+serviceCode+'_SERVICE_OPTION_'+optionCode+'_EXTRA_COVER_VALUE').val();
						}
						
						//looping through suboptions
						for(var k=0; k<serviceObjectArray[i].options[j].subOptions.length; k++)
						{
							var code = serviceObjectArray[i].options[j].subOptions[k].code;
							if ( $('#SERVICE_'+serviceCode+'_SERVICE_OPTION_'+optionCode+'_SUBOPTION_'+code).is(':checked') )
							{
								subOptionCodes.push(code);
								//for domestic services extra cover is within suboptions
								if (code == 'AUS_SERVICE_OPTION_EXTRA_COVER')
									extraCoverValue = $('#SERVICE_'+serviceCode+'_SERVICE_OPTION_'+optionCode+'_SUBOPTION_'+code+'_EXTRA_COVER_VALUE').val();
							}
						}
						//since options are single values for domestic services (radioboxes) - lets break this loop
						//for international services, options are multivalues - loop will keep going through all tick boxes
						if (apiType == 'aus-parcel' || apiType=='aus-letter')
							break;
					}
				}
				break;
			}
			
		}
		
		//Before doing ajax call - treat options or suboptions differently for URL parameters, as per API document:
		//    option / suboption will have to by multivalued like:
		//        suboption_code=code1&suboption_code=code2 ... etc...
		//Code below creates it in a format: "suboption_code=code1&suboption_code=code2 ... etc..."
		
		var url_explicit_param = "";
		
		if (isDomesticApi())
		{
			for (var i=0; i<subOptionCodes.length; i++)
				if (i < subOptionCodes.length-1)
					url_explicit_param += 'suboption_code='+subOptionCodes[i] + '&';
				else
					url_explicit_param += 'suboption_code='+subOptionCodes[i];
		}
		else 
		{
			for (var i=0; i<optionCodesArray.length; i++)
				if (i < optionCodesArray.length-1)
					url_explicit_param += 'option_code='+optionCodesArray[i] + '&';
				else
					url_explicit_param += 'option_code='+optionCodesArray[i];
		}
		
		//depending on API type data should be different
		var data = {}
		if (apiType == 'aus-letter')
			data = {
				//will be defined in COMMON
				option_code: optionCode
			};
			
		else if (apiType == 'aus-parcel')
			data = {
				length: $('#'+apiType+'-length').val()
				,width: $('#'+apiType+'-width').val()
				,height: $('#'+apiType+'-height').val()
				,from_postcode: $('#'+apiType+'-from-postcode').val()
				,to_postcode: $('#'+apiType+'-to-postcode').val()
				,option_code: optionCode
			};
			
		else if (apiType == 'int-letter' || apiType == 'int-parcel')
			data = {
				country_code: $('#'+apiType+'-country-code').val()
				,suboption_code: subOptionCodes[0] //workaround: suboptions for international is singlevalue, but subOptionCodes is array, lets ALWAYS get the first element
			};
			
		//COMMON parameters
		data.weight= $('#'+apiType+'-weight').val();
		data.service_code=serviceCode;
		data.extra_cover=extraCoverValue;
		
		//combine ajax request to get calculated results
		//please note sub_options are set explicitely in URL address as they are getting URLencoded by #.ajax
		$.ajax({
			type: "GET"
			,url: "https://auspost.com.au/api/postage/"+apiLocation+"/calculate.xml?"+url_explicit_param
			,dataType: "xml"
			,data:data
			,headers: {
				'AUTH-KEY': authKey
			}
			,success:function(response){
				processCalculateXmlResult(response);
				showDebug(response, this.url);
				$('#step2').hide();
				$('#step3').show();
			}
			,error:function (xhr, ajaxOptions, thrownError){ 
				processError(xhr, thrownError);
				showDebug(xhr.responseXML, this.url);
			}    
		});
		
	}
	
	//PRIVATE: process calculated results and render it into template
	var processCalculateXmlResult = function(xmlDocument)  
	{
		var postageCostResult = {};
		postageCostResult.serviceName = $(xmlDocument).find('postage_result > service').text();
		postageCostResult.deliveryTime = $(xmlDocument).find('postage_result > delivery_time').text();
		postageCostResult.totalCost = $(xmlDocument).find('postage_result > total_cost').text();
		
		var costItemsArray = new Array();
		$(xmlDocument).find('postage_result > costs > cost').each(function(serviceNum)
		{
			var costObject = {};
			costObject.cost = $(this).find('> cost').text();
			costObject.item  = $(this).find('> item').text();
			
			costItemsArray.push(costObject);
		});
		postageCostResult.costs = costItemsArray;
		
		//render results to calculate div
		$( "#calculate" ).empty();
		$.tmpl( "PCRTemplate", postageCostResult ).appendTo( "#calculate" );
		
		showDebug(xmlDocument);
	}
	
	//PRIVATE: process error - show Validation message
	var processError = function(xhr, thrownError) 
	{
		if (xhr.status == 404)
		{
			if ($(xhr.responseXML).find("[nodeName='errorMessage']").length == 0)
				alert ('Service down or not found');
			else
				alert( $(xhr.responseXML).find("[nodeName='errorMessage']").text() );
		}
		else
			alert("Error: " + xhr.status + ' - ' + thrownError);
	}
	
	//PRIVATE: helper function to specify if we are calling domestic api or not
	var isDomesticApi = function() {
		return (apiType == 'aus-letter' || apiType == 'aus-parcel');
	}

}
//end PacApiClient Class

//pretty print XML
var formatXml = this.formatXml = function (xml) {
	var reg = /(>)(<)(\/*)/g;
	var wsexp = / *(.*) +\n/g;
	var contexp = /(<.+>)(.+\n)/g;
	xml = xml.replace(reg, '$1\n$2$3').replace(wsexp, '$1\n').replace(contexp, '$1\n$2');
	var pad = 0;
	var formatted = '';
	var lines = xml.split('\n');
	var indent = 0;
	var lastType = 'other';
	// 4 types of tags - single, closing, opening, other (text, doctype, comment) - 4*4 = 16 transitions 
	var transitions = {
		'single->single': 0,
		'single->closing': -1,
		'single->opening': 0,
		'single->other': 0,
		'closing->single': 0,
		'closing->closing': -1,
		'closing->opening': 0,
		'closing->other': 0,
		'opening->single': 1,
		'opening->closing': 0,
		'opening->opening': 1,
		'opening->other': 1,
		'other->single': 0,
		'other->closing': -1,
		'other->opening': 0,
		'other->other': 0
	};
	var NEW_LINE='\n';
	if ($.browser.msie)
		NEW_LINE='\r';
	for (var i = 0; i < lines.length; i++) {
		var ln = lines[i];
		var single = Boolean(ln.match(/<.+\/>/)); // is this line a single tag? ex. <br />
		var closing = Boolean(ln.match(/<\/.+>/)); // is this a closing tag? ex. </a>
		var opening = Boolean(ln.match(/<[^!].*>/)); // is this even a tag (that's not <!something>)
		var type = single ? 'single' : closing ? 'closing' : opening ? 'opening' : 'other';
		var fromTo = lastType + '->' + type;
		lastType = type;
		var padding = '';

		indent += transitions[fromTo];
		for (var j = 0; j < indent; j++) {
			padding += '\t';
		}
		if (fromTo == 'opening->closing')
			formatted = formatted.substr(0, formatted.length - 1) + ln + NEW_LINE; // substr removes line break (\n) from prev loop
		else
			formatted += padding + ln + NEW_LINE;
	}

	return formatted;
}