(
		function($){
		// attach to the document on load event
			$( document ).ready(function() {
				if ($('#modelCanvas').length){
					$result=$('.wrapModel').data();
					renderCSRScene($result['source'],$result['address'],$result['scene'],'modelCanvas');
					$title=$('.wrapModelArea').data('caption');
					document.title=$title;
				}
			});
})(jQuery);

