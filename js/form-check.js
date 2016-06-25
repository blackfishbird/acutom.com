$(function() {
	$('[data-toogle="tooltip"]').tooltip();
});

function isFormValid(form) {
	var isValid = true;
	form.find('input, textarea').each(function() {
		var $this = $(this);
		if($.trim($this.val()).length === 0) {
			$this.tooltip('show').closest('div').addClass('error');
			isValid = false;
		} else {
			$this.tooltip('destroy').closest('div').removeClass('error');
		}
	});
	return isValid;
}
function isKeyEnter(form, btn) {
	form.find('input, textarea').each(function() {
		$(this).keyup(function(e) {
			if(e.keyCode == 13)  btn.click();
		});
	});
}
function isInputValid(input) {
	var isValid = true;
	if(input.val().length === 0) {
		input.tooltip('show').closest('div').addClass('error');
		isValid = false;
	} else {
		input.tooltip('destroy').closest('div').removeClass('error');
	}
	return isValid;
}
function isInputBetween(input, min, max) {
	var isBetween = true;
	if(input.val() < min || input.val() > max) {
		input.tooltip('show').closest('div').addClass('error');
		isBetween = false;
	} else {
		input.tooltip('destroy').closest('div').removeClass('error');
	}
	return isBetween;
}
