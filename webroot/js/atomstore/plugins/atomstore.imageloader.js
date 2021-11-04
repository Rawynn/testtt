var ImageLoader = (function($){
	var blazy;
	
	return {
		load : function(){
			$(".product-box.gallery .double-image[data-loaded!=true]").unbind("mouseover.image-loader").on("mouseover.image-loader", function(){
				ImageLoader.load();
				
				$(this).attr("data-loaded", "true");
			});
			
			if (typeof blazy == "undefined"){
				bLazy = new Blazy({
					selector: ".blazy",
					offset  : 100,
					success : function(image){
						$($(image).parents(".preload-image").get(0)).attr("data-loaded", "true");
					}
				});
			}else{
				bLazy.revalidate();
			}
		}
	};
}(window.jQuery));