jQuery.ketchup

.createErrorContainer(function(form, el) {
	var elementContainer = $("<div>", {"class": "error-message", "data-type": "ketchup-error-message"});
	var parentContainer	= el.parents(".form-row");

	parentContainer.append(elementContainer);
	
	return elementContainer;
})

.addErrorMessages(function(form, el, container, messages) {
	container.html("");

	for(i = 0; i < messages.length; i++) {
		container.append(messages[i] + "<br>");
	}
})

.showErrorContainer(function(form, el, container) {
	container.slideDown("fast");
	el.addClass("invalid");
	el.removeClass("valid");
	el.parents(".form-row").removeClass("valid-row").addClass("invalid-row");
	
	$("html, body").stop().animate({
		scrollTop: form.find(".invalid:first-of-type").offset().top
	}, 1000);
})

.hideErrorContainer(function(form, el, container) {
	container.slideUp("fast");
	el.addClass("valid");
	el.removeClass("invalid");
	el.parents(".form-row").removeClass("invalid-row").addClass("valid-row");
});