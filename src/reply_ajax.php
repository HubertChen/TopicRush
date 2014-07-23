<div class="replydiv">
	<textarea rows='4' cols='50' form='replyform' name='reply'></textarea>
	<form id='replyform' method='post'>
		<input type='submit' name='submit' class='submit'>	
		<input type='submit' name='cancel' value='Cancel'>
	</form>
</div>

<script>
	$(function(){
		$(".submit").click(function(e){
			if($(this).closest("div").find("textarea").val().trim() == ""){
				e.preventDefault();
				if($(this).closest("div").text().indexOf("Please enter a reply!") == -1)
					$(this).closest("div").append("Please enter a reply!");				
			}
		});
	});

</script>
