<head>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

 

<!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->

<script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>


<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->

<script type="text/javascript" src="js/plupload.full.js"></script>

<script type="text/javascript" src="js/jquery.plupload.queue/jquery.plupload.queue.js"></script>




</head>
<body style="margin:50px";>

<script type="text/javascript">
// Convert divs to queue widgets when the DOM is ready
$(function() {
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'html5',
		url : 'upload.php',
		max_file_size : '400mb', 
		chunk_size : '1mb',
		unique_names : true,
 
		// Resize images on clientside if we can
		//resize : {width : 320, height : 240, quality : 90},

		// Specify what files to browse for
		filters : [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		],

		// Flash settings
		flash_swf_url : 'js/plupload.flash.swf',

		// Silverlight settings
		silverlight_xap_url : 'js/plupload.silverlight.xap'
	});

	// Client side form validation
	$('form').submit(function(e) {
        var uploader = $('#uploader').pluploadQueue();

        // Files in queue upload them first
        if (uploader.files.length > 0) {
            // When all files are uploaded submit form
            uploader.bind('StateChanged', function() {
                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                    $('form')[0].submit();
                }
            });
                
            uploader.start();
        } else {
            alert('You must queue at least one file.');
        }

        return false;
    });
});
</script>

...

<form action="welcome.php" method="post">
	<div id="uploader">
		<p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
	</div>
	<div>Put some shit in the box: <input type="text" name="fname"></div>
	<input type="submit" value="Send" />

</form>

<?php echo "Test"; ?>

</body>