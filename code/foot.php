    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
    <script>
	$(document).keydown(function(e) {
	    switch(e.which) {
	        case 37: // left
	        document.getElementById('prev').click();
	        break;

	        
	        case 39: // right
	        document.getElementById('next').click();
	        break;

	        default: return; // exit this handler for other keys
	    }
	    e.preventDefault(); // prevent the default action (scroll / move caret)
	});
	</script>
</body>

</html>
