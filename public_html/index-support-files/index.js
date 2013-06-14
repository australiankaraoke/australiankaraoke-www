$(window).load(function() {
	$("#manufacturers_categories_content").html("<div style='width: 100%; text-align: center;'><img src='/images/spinner-purple.gif' style='margin-top: 100px;' /></div>");
	$("#manufacturers_categories_content").load("/index-support-files/manufacturer-categories.php", function(){
		
	});
	$.get('/index-support-files/top-slider.php', function(data) {
		$("#nivo_content").append(data);
		$('#slider').nivoSlider({
		    effect: 'boxRain', // Specify sets like: 'fold,fade,sliceDown'
		    slices: 15, // For slice animations
		    boxCols: 8, // For box animations
		    boxRows: 4, // For box animations
		    animSpeed: 500, // Slide transition speed
		    pauseTime: 6500, // How long each slide will show
		    startSlide: 0, // Set starting Slide (0 index)
		    directionNav: false, // Next & Prev navigation
		    controlNav: true, // 1,2,3... navigation
		    controlNavThumbs: false, // Use thumbnails for Control Nav
		    pauseOnHover: true, // Stop animation while hovering
		    manualAdvance: false, // Force manual transitions
		    prevText: 'Prev', // Prev directionNav text
		    nextText: 'Next', // Next directionNav text
		    randomStart: false, // Start on a random slide
		    beforeChange: function(){}, // Triggers before a slide transition
		    afterChange: function(){}, // Triggers after a slide transition
		    slideshowEnd: function(){}, // Triggers after all slides have been shown
		    lastSlide: function(){}, // Triggers when last slide is shown
		    afterLoad: function(){} // Triggers when slider has loaded
		});
		$.get('/index-support-files/mini-blog.php', function(blogData) {
			$("#mini_blog_content").append(blogData);
			$('.bxslider').bxSlider({
				mode: 'vertical',
				auto: true,
				controls: false,
				pager: false
			});
			$.get('/index-support-files/products-slider.php', function(productsData) {
				$("#products_slider_content").append(productsData);
			});
			
			/*$('#masonryContainer').masonry({
			    // options
			    itemSelector : '.masonryItem',
			    columnWidth : 180,
			    isResizable: true
			});*/
		});
	});
});
