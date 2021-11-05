jQuery.ketchup

.validation('required', 'This field is required.', function(form, el, value) {
	var type;

	if (el.prop('tagName').toLowerCase() == 'select'){
		type = 'select';
	} else {
		type = el.attr('type').toLowerCase();
	}

	if (type == 'radio'){
		var name = $(el).attr("name");
		
		if ($("input[name='" + name + "']:radio:checked").length == 1){
			return true
		}else{
			return false;
		}
	}else if (type == 'checkbox') {
		return el.prop('checked');
	} else {
		return (value.length != 0);
	}
})

.validation('required-textarea', 'This field is required.', function(form, el, value) {
	return (value.length != 0);
})

.validation('minlength', 'This field must have a minimal length of {arg1}.', function(form, el, value, min) {
	return (value.length >= +min);
})

.validation('maxlength', 'This field must have a maximal length of {arg1}.', function(form, el, value, max) {
	return (value.length <= +max);
})

.validation('rangelength', 'This field must have a length between {arg1} and {arg2}.', function(form, el, value, min, max) {
	return (value.length >= min && value.length <= max);
})

.validation('min', 'Must be at least {arg1}.', function(form, el, value, min) {
	return (this.isNumber(value) && +value >= +min);
})

.validation('max', 'Can not be greater than {arg1}.', function(form, el, value, max) {
	return (this.isNumber(value) && +value <= +max);
})

.validation('range', 'Must be between {arg1} and {arg2}.', function(form, el, value, min, max) {
	return (this.isNumber(value) && +value >= +min && +value <= +max);
})

.validation('number', 'Must be a number.', function(form, el, value) {
	return this.isNumber(value);
})

.validation('digits', 'Must be digits.', function(form, el, value) {
	return /^\d+$/.test(value);
})

.validation('email', 'Must be a valid E-Mail.', function(form, el, value) {
	return this.isEmail(value);
})

.validation('url', 'Must be a valid URL.', function(form, el, value) {
	return this.isUrl(value);
})

.validation('username', 'Must be a valid username.', function(form, el, value) {
	return this.isUsername(value);
})

.validation('match', 'Must be {arg1}.', function(form, el, value, word) {
	return (el.val() == word);
})

.validation('match-value', 'This field must be identical.', function(form, el, value, targetElement) {
	return (el.val() == $(targetElement).val());
})

.validation('contain', 'Must contain {arg1}', function(form, el, value, word) {
	return this.contains(value, word);
})

.validation('date', 'Must be a valid date.', function(form, el, value) {
	return this.isDate(value);
})

.validation('postal-pl', 'Invalid postal code', function(form, el, value) {
	/* Polska*/
	var regex = /^[0-9]{2}\-[0-9]{3}$/;

	return regex.test(value);
})

.validation('postal-fr', 'Invalid postal code', function(form, el, value) {
	/* Francja */
	var regex = /^[0-9]{5}$/;

	return regex.test(value);
})

.validation('postal-be', 'Invalid postal code', function(form, el, value) {
	/* Belgia */
	var regex = /^[0-9]{4}$/;

	return regex.test(value);
})

.validation('postal-hu', 'Invalid postal code', function(form, el, value) {
	/* Węgry */
	var regex = /^[0-9]{4}$/;

	return regex.test(value);
})

.validation('postal-se', 'Invalid postal code', function(form, el, value) {
	/* Szwecja */
	var regex = /^[0-9]{5}$/;

	return regex.test(value);
})

.validation('postal-nl', 'Invalid postal code', function(form, el, value) {
	/* Holandia */
	var regex = /^[0-9]{4}[A-Z]{2}$/;

	return regex.test(value);
})

.validation('postal-es', 'Invalid postal code', function(form, el, value) {
	/* Hiszpania */
	var regex = /^[0-9]{5}$/;

	return regex.test(value);
})

.validation('postal-lt', 'Invalid postal code', function(form, el, value) {
	/* Litwa */
	var regex = /^[0-9]{5}$/;

	return regex.test(value);
})

.validation('postal-lv', 'Invalid postal code', function(form, el, value) {
	/* Łotwa */
	var regex = /^[0-9]{4}$/;

	return regex.test(value);
})

.validation('postal-fi', 'Invalid postal code', function(form, el, value) {
	/* Finlandia */
	var regex = /^[0-9]{5}$/;

	return regex.test(value);
})

.validation('postal-dk', 'Invalid postal code', function(form, el, value) {
	/* Dania */
	var regex = /^[0-9]{4}$/;

	return regex.test(value);
})

.validation('postal-gb', 'Invalid postal code', function(form, el, value) {
	/* Wielka Brytania */
	var regex = /^[A-Z]{2}[0-9]{2,3}[A-Z]{2}$/;

	return regex.test(value);
})

.validation('minselect', 'Select at least {arg1} checkboxes.', function(form, el, value, min) {
	return (min <= this.inputsWithName(form, el).filter(':checked').length);
}, function(form, el) {
	this.bindBrothers(form, el);
})

.validation('maxselect', 'Select not more than {arg1} checkboxes.', function(form, el, value, max) {
	return (max >= this.inputsWithName(form, el).filter(':checked').length);
}, function(form, el) {
	this.bindBrothers(form, el);
})

.validation('nip-pl', 'Incorrect NIP', function(form, el, value) {
	var weights = [6, 5, 7, 2, 3, 4, 5, 6, 7];
	var nip = value.replace(/[\s-]/g, '');

	if (nip.length === 10 && parseInt(nip, 10) > 0) {
		var sum = 0;
		for(var i = 0; i < 9; i++){
			sum += nip[i] * weights[i];
		}                     
		return (sum % 11) == Number(nip[9]);
	}
	
	return false;
})

.validation('nip-foreign', 'Invalid nip code', function(form, el, value) {
	var nipforeign =  /^(AT|BE|BG|CY|CZ|DK|EE|FI|FR|EL|ES|NL|IE|LT|LU|LV|MT|DE|PL|PT|RO|SK|SI|SE|HU|GB|IT)?[0-9]{5,}$/i;

	return nipforeign.test(value);
})

.validation('rangeselect', 'Select between {arg1} and {arg2} checkboxes.', function(form, el, value, min, max) {
	var checked = this.inputsWithName(form, el).filter(':checked').length;
	
	return (min <= checked && max >= checked);
}, function(form, el) {
	this.bindBrothers(form, el);
});
