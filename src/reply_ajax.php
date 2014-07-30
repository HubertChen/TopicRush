<?php
	$username = $_SESSION['username'];
	$content_id = $_GET['content_id'];
	$response_id = $_GET['response_id'];
	
	if($response_id == 'undefined')
		$response_id = -1;
?>

<div class="replydiv">
	<textarea rows='4' cols='50' form='replyform' name='reply'></textarea>
	<br><a class="submit">Submit</a> <a class="cancel">Cancel</a>
</div>
<div class="replydiv commentstatus">
</div>

<script>
	$(document).ready(function(){
		$(".submit").click(function(e){
			if($(this).closest("div").find("textarea").val().trim() == ""){
				e.preventDefault();
				if($(this).closest("div").text().indexOf("Please enter a reply!") == -1)
					$(this).closest("div").append("Please enter a reply!");				
			} else {
				e.preventDefault();
				$.ajax({
                                                type: "GET",
                                                url: "reply_upload.php?text=" + $(this).closest("div").find("textarea").val() + "&id=" + <?php echo $content_id; ?> + "&replyid=" + <?php echo $response_id;?>,
						async: false,
                                                success: function(text){
                                                        response = text;
                                                }
                                 });
				$(this).closest("div").after("<p class='replydiv commentstatus'>" + response + "</p>");
				$(this).closest("div").remove();
			}
		});

		$(".cancel").click(function(){
			$(this).closest("div").remove();
		});
	});
</script>
