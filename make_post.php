<?php 
    include('head.php');

?>
    <div class="container">

        <!-- Jumbotron Header -->
        <header class="move jumbotron " style="padding:10px; width:95%;margin:auto;">
         <form action="post.php" method="POST">
		  <div class="form-group">
		  	<textarea class="form-control" placeholder="Share your thoughts" name="post_desc" rows="5"></textarea>
		  </div>
		  <button type="submit" class="btn btn-block btn-primary">Submit</button>
		</form>
		<br><br>
		<div id="top_posts"></div>
		<div id="recent_posts"></div>
        </header>


 <?php
 include('foot.php');
 ?>
 <script>
 var upvote =function (id){
         $.post('up_count.php?id='+id, function (result) {
        }, "text");
    };
 var downvote =function (id){
         $.post('down_count.php?id='+id, function (result) {
        }, "text");
    };
    var Data =function (){
        $.post('get_top.php', function (result) {
            $("#top_posts").html(result);
        }, "text");
        setTimeout(Data, 1000);
        $("#top_posts").css({"height":"auto"});
        
    };
    Data();
</script>