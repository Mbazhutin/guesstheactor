 $(document).on("click", ".photo.unknown", function() { 
	$.ajax({
		url : "/guesstheactor/actors/checkAnswer",
		type : "post",
		data : {
			actorId: $(this).attr('data-id'),
		},
		success : function(data) {
			var res = JSON.parse(data);
			$(".photo").each(function(){
				$(this).removeClass('unknown');
				if ($(this).attr('data-id') == res.correctAnswer) {
					$(this).addClass("correct");
				} else {
					$(this).addClass('wrong');
				}
			});

			var answer ='';
			if (res.success) {
				$("#answer").css('color', 'green');
			} else {
				$("#answer").css('color', 'red');
			}
			$("#answer").html(res.message);
		}
	});
});

$(document).ready(function(){
	loadActors();

	$(document).on("click", "#loadActors", function() {
		$(this).html("Загружается...");
		loadActors();
	});
});

function loadActors() {
	$.ajax({
		url : "/guesstheactor/actors/getActors",
		type : "post",
		success : function(data) {
			$("#actorsContainer").html(data);
		}
	});	
}
