function hasNumber(myString) {
	return /\d/.test(myString);
}

function hasHTML(myString) {
	return /<[a-z/][\s\S]*>/i.test(myString);
}


$(document).on('submit', 'form[name="postForm"]', function(e) {
	e.preventDefault();

	var title = $('input[name="title"]').val();
	var content = $('textarea[name="content"]').val();
	var form = $(this);
	
	if (title.length === 0) {
		alert('Titel måste fyllas i');
		return false;
	}

	if (content.length === 0) {
		alert('Beskrivning måste fyllas i');
		return false;
	}

	if (hasNumber(title)) {
		alert('Titel får ej innehålla siffror');
		return false;
	}
	
	if (hasHTML(content)) {
		alert('Beskrivning får ej innehålla HTML kod');
		return false;
	}

	$.ajax({
            url: form.attr('action'),
            type: 'post',
            dataType: 'text',
            data: form.serialize(),
            success: function(data) {
                window.location.href = location.protocol + '//' + location.host;
            }
    });
});