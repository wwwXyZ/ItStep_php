<div class="border_half_page">
	<div id="content_left" class="text_center">
	<span>
		<span style="display: block; margin-top:15%;">Добавление интересов:</span><br />
		<input id="new_interes" type="text" name="new_interes" /><br />
		<input style="" onclick="add_interes();" id="add_interes_btn" type="submit" value="Add interes!" /><br />
	</span>

	</div>
</div>
<script   src="https://code.jquery.com/jquery-3.2.1.min.js"   integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="   crossorigin="anonymous"></script>
<script>
function add_interes() {
		var new_interes = document.getElementById("new_interes").value;
		if (new_interes != null && new_interes != "")
			$.ajax({
			  type: "POST",
			  url: "/api/add_user_interes/",
			  data: {
				'interes' : new_interes
			  },
			  success: function (msg) {
				if (msg['error'] != null)
					$(".alert").text(msg['error']);
				else {
					$("#interes_list").append('<option value="' + msg['id'] + '">'+ document.getElementById("new_interes").value +'</option>');
					document.getElementById("new_interes").value = '';
				}
				
			  }
			});
	}
function switchColor() {
		var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++ ) {
            color += letters[Math.floor(Math.random() * 16)];
        }
	$("#bckg").css('background', color);
	setTimeout(switchColor, 700);
}
//switchColor();
</script>