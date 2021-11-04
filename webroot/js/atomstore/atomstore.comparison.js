var Comparison = (function(){
	function attachEvents(){
		$("[data-type=comparison-modal]").on("shown.bs.modal", function(){
			loadComparisonTable();
		});
		
		$("[data-type=show-only-differences]").on("change.comparison", function(){
			showOnlyDifferences($(this).prop("checked"));
		});
	}
	
	function attachAfterLoadEvents(){
		$("[data-type=delete-product]").on("click", function(e){
			e.preventDefault();
			deleteComparisonProduct(this);
		});
	}
	
	function loadComparisonTable(){
		var container = $("[data-type=comparison-table-container]");
		
		if (container.attr("data-loaded") == "false"){
			getComparisonTable(container);
		}
	}
	
	function getComparisonTable(container){
		$.get(
			App.getAjaxUrl($(container).attr("data-url")),
			function(response){
				container.html(response);
				container.attr("data-loaded", "true");
				
				attachAfterLoadEvents();
			}
		);
	}
	
	function deleteComparisonProduct(element){
		var container = $("[data-type=comparison-table-container]");
		
		$.get(
			App.getAjaxUrl($(element).attr("href")),
			function(response){
				container.attr("data-loaded", "false");
				
				getComparisonTable(container);
			}
		);
	}
	
	function showOnlyDifferences(checked){
		var compareTable = $("[data-type=compare-table]");
		
		if (checked){
			$.each($("[data-type=compare-row]", compareTable), function(index, row){
				var currentValue = undefined;
				var hide         = true;
				var values       = $("[data-type=compare-value]", row);
				
				$.each(values, function(index, value){
					if (index == 0){
						currentValue = $(value).html();
					}else{
						if (currentValue != $(value).html()){
							hide = false;
						}
					}
				});
				
				if (hide){
					$(row).hide();
				}
				
				currentValue = undefined;
				hide         = true;
			});
		}else{
			$("[data-type=compare-row]", compareTable).show();
		}
	}
	
	return{
		init: function(){
			attachEvents();
		}
	};
}());