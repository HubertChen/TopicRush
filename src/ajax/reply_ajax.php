<?php
	session_start();
        $username = $_SESSION['username'];
        $content_id = $_GET['content_id'];
        $response_id = $_GET['response_id'];

        if($response_id == 'undefined')
                $response_id = -1;
?>
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title" id="myModalLabel">Reply</h4>
				</div>

				<div class="modal-body">
					<textarea style="width:100%;" form='replyform' name='reply' id='replyText'></textarea>
					<p id="replyMessage"></p>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary submit" data-dismiss="modal">Submit</button>
				</div>
			</div>
		</div>
	</div>

<script>
        $(document).ready(function(){
                $(".submit").click(function(){
                        if($("#replyText").val().trim() == ""){
                                if($("#replyMessage").text().indexOf("Please enter a reply!") == -1)
                                        $("#replyMessage").append("Please enter a reply!");                         
                        } else {
                                $.ajax({
                                                type: "GET",
                                                url: "ajax/reply_upload.php?text=" + $("#replyText").val() + "&id=" + <?php echo $content_id; ?> + "&replyid=" + <?php echo $response_id;?>,
                                                async: false,
                                                success: function(text){
                                                        response = text;
                                                }
                                 });
					if(response.indexOf("failed") == -1) {
						$("#replyResponse").empty();
						$("#replyResponse").append("<div class='alert alert-success' role='alert'>" + response + "</div>");
					} else {
						$("#replyResponse").empty();
						$("#replyResponse").append("<div class='alert alert-failure' role='alert'>" + response + "</div>");
					}
                        }
                });
        });
</script>

