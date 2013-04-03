<?php
/*
Plugin Name: Rexcode Upload
Plugin URI: http://ellasol.com/
Description: Large and multi-file uploader for the WP front end.
Version: 0.6 alpha
Author: Rex Keal
Author URI: http://ellasol.com
License: GPLv2
*/
?>
<?php
/*
......................................
activate functions
......................................
*/

function rexcode_activation(){
    if ( get_option( 'rex_options' ) === false ) {
	
$tmp = get_option('rex_options');
		$arr = array(	"upload_dir" => "uploads/",
						"max_file_size" => "300",
						"chunk_size" => "1",
						"runtime" => "html5",
						"max_file_uploads_number" => "2",
						"chk_button_rename" => "0"
					);	
		
		update_option('rex_options', $arr);

	}
}
register_activation_hook( __FILE__, 'rexcode_activation' );
/*
......................................
Deactivate functions
......................................
*/
function rexcode_deactivation(){
        //delete_option( 'rex_options' );
   
}

register_deactivation_hook(__FILE__, 'rexcode_deactivation');
/*
......................................
register and vaildate options
......................................
*/
function rex_init(){
	register_setting( 'rex_plugin_options', 'rex_options', 'rex_validate_options' );
}
add_action('admin_init', 'rex_init' );


function rex_validate_options($input) {

	return $input;
}
/*
......................................
add the admin page
......................................
*/
function rex_add_options_page() {
	add_options_page('Rexcode Options', 'Rexcode-Uploader', 'manage_options', __FILE__, 'rex_render_form');
}
/*
......................................
the actual settings page display 
......................................
*/
function rex_render_form() {
	?>
	<div class="wrap">
		
		<!-- Display Plugin Icon, Header, and Description -->
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>Rexcode Uploader Options</h2>
		<h3><a href="http://www.youtube.com/watch?v=v5_0iZQ-TuA"><img src="http://upload.wikimedia.org/wikipedia/en/5/54/Saucerful_of_secrets2.jpg" style="float:left; margin-right:25px;" height="100px"/></a>Set the controls for the heart of the sun.</h3>
		<h4><em>Use </em><strong>[headcode]</strong><em> shortcode on pages</em></h4>
		
		
		<p><?php echo BLOG_ROOTY; echo "<br>".dirname(__FILE__); echo "<br>".$_SERVER['DOCUMENT_ROOT'];?></p>
		
		<?php  echo wp_script_is( 'jq-ui', $list = 'queue' ); ?>
		
		
		<!-- Beginning of the Plugin Options Form -->
		<form method="post" action="options.php">
			<?php settings_fields('rex_plugin_options'); ?>
			<?php $options = get_option('rex_options'); ?>

			<!-- Table Structure Containing Form Controls -->
			<!-- Each Plugin Option Defined on a New Table Row -->
			<table class="form-table">

				<!-- Text Area Control -->
			
				<tr>
					<th scope="row"><strong>Path for the file uploads:</strong><em> (all files will end up in the WP uploads directory. This will append them. For example, if you type <strong>bigfile/</strong> your file will end up in <strong>wp-content/uploads/2013/03/bigfile/</strong></em></th>
					<td>
						<input type="text" size="57" name="rex_options[upload_dir]" value="<?php echo $options['upload_dir']; ?>" />
					</td>
				</tr>			
				<tr>
					<th scope="row"><strong>Max file size:</strong> <em>(must be a positive integer)</em></th>
					<td>
						<input type="text" size="57" name="rex_options[max_file_size]" value="<?php echo $options['max_file_size']; ?>" />mb
					</td>
				</tr>
				<tr>
					<th scope="row"><strong>File chunking size:</strong><em> (mess with this if you need to adjust due to hosting upload size limits. default 1)</em></th>
					<td>
						<input type="text" size="57" name="rex_options[chunk_size]" value="<?php echo $options['chunk_size']; ?>" />mb
					</td>
				</tr>
				<tr>
					<th scope="row"><strong>Max number of files a user can upload:</strong><em> (Positive integer that limits the number of files that can be uploaded)</em></th>
					<td>
						<input type="text" size="57" name="rex_options[max_file_uploads_number]" value="<?php echo $options['max_file_uploads_number']; ?>" />files
					</td>
				</tr>
				<tr>
					<td>
						<label>
							<input name="rex_options[chk_button_rename]" type="checkbox" value="1" <?php if (isset($options['chk_button_rename'])) { checked('1', $options['chk_button_rename']); } ?> /> <strong>Rename files?</strong> <em>(if checked, your files are renamed with a random string)</em>
						</label><br />
					</td>
				</tr>
				<tr>
					<th scope="row"><strong>Runtime:</strong><em> (comma separated list of runtimes. Valid options include html5,flash,html4,silverlight. Place them in order of preference/fallback.)</em></th>
					<td>
						<input type="text" size="57" name="rex_options[runtime]" value="<?php echo $options['runtime']; ?>" />
					</td>
				</tr>			
			</table>
			<p class="submit">
			<input type="submit" class="bustton-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>

		<p style="margin-top:15px;">
			<p style="font-style: italic;font-weight: bold;color: #26779a;">Help me feed my babies, please, and make a small <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=VVCR4JRJ38VYS" target="_blank" style="color:#72a1c6;">donation</a>. Thank you, anything helps!</p>
		</p>

	</div>
	<?php	
}
/*
......................................
add options page action to WP
......................................
*/
add_action('admin_menu', 'rex_add_options_page');

/*
......................................
register scripts with wordpress
......................................
*/

function add_scripts(){
    $plugs_dir = plugins_url().'/headers-plug-testing';
    wp_register_script('jq-min',  plugins_url().'/headers-plug-testing/js/jquery.min.js' );
    wp_register_style('plup-style-ui', $plugs_dir.'/js/jquery.ui.plupload/css/jquery.ui.plupload.css');
    wp_register_style('jquery-style-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/base/jquery-ui.css');
    wp_register_script('jq-min', $plugs_dir.'/js/jquery.min.js', array('jquery') );
    wp_register_script('jq-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js', array('jquery') );
    wp_register_script('plup-ui', $plugs_dir.'/js/jquery.ui.plupload/jquery.ui.plupload.js', array('jquery') );



}
add_action('init', 'add_scripts');



function check_for_shortcode($posts) {
   if ( stripos($posts[0]->post_content, '[headcode')){
   	   // $url contains the path to your plugin folder
        wp_enqueue_style( 'my_test_Stylesheet',$url.'style_test.css' );
 		wp_enqueue_style('plup-style-ui');
		wp_enqueue_style('jquery-style-ui');
		wp_enqueue_script('jq-min');
    	wp_enqueue_script('plupload-all');
 		wp_enqueue_script('jq-ui');     
	//LOAD ME LAST!!!! <--either calling me last or adding enqueue_script priority!!!> 
		wp_enqueue_script('plup-ui');
		}
   
    return $posts; }

// perform the check when the_posts() function is called
add_action('the_posts', 'check_for_shortcode');


function rex_do_shortcode(){
	$_SESSION['wp-root'] = 'xxxxxxxxxxxx';
	$hidURL = get_bloginfo('wpurl');
	$form_submit_page = plugins_url()."/headers-plug-testing/welcome.php"; 
	$fill_options = get_option('rex_options');
	$upload_directory_opt = $fill_options['upload_dir'];
	$max_file_size_opt = $fill_options['max_file_size'];
	$chunk_size_opt = $fill_options['chunk_size'];
	$runtime_opt = $fill_options['runtime'];
	$max_file_uploads_number_opt = $fill_options['max_file_uploads_number'];
	if (isset($fill_options['chk_button_rename'])){
		$chk_button_rename_opt = "true";
	}else{
		$chk_button_rename_opt = "false";
	}
	echo $runtimes;
	$plup_upload = plugins_url().'/headers-plug-testing/';
?>	
	
	<form action="<?php echo $form_submit_page; ?>" method="post">

	<div id="uploader">

		<p>Our uploader requires that you are using a modern browser with either HTML5, Flash, or Silverlight installed. We recommend that you use Chrome, Firefox, or Safari.</p>

	</div>

	<div>Put some shit in the box: <input type="text" name="fname"></div>

	<div>Put some shit in this box too: <input type="text" name="otherbox"></div>

	<div>Can I haz emailz: <input type="text" name="thirdbox"></div>
	<input type="hidden" name="hidval" value="<?php echo $hidURL; ?>">
	<input type="submit" value="Send" />
	
</form></br>
<?php echo '<script type="text/javascript">'; ?>
// Convert divs to queue widgets when the DOM is ready

<?php echo 'jQuery(function() {'; ?>

	jQuery("#uploader").plupload({

		// General settings

		<?php echo "runtimes : "."'".$runtime_opt."'"; ?>,

		url : <?php echo "'".$plup_upload."upload.php'"; ?>,

		<?php echo "max_file_size : "."'".$max_file_size_opt."mb'"; ?>,

		<?php echo "max_file_count: "."'".$max_file_uploads_number_opt."'"; ?>, // user can add no more than (int)x files at a time

		<?php echo "chunk_size : "."'".$chunk_size_opt."mb'"; ?>,

		rename: 'false',
		
		unique_names: 'false',

		multiple_queues : true,



		// Resize images on clientside if we can

		//resize : {width : 320, height : 240, quality : 90},

		

		// Rename files by clicking on their titles

		//rename: false,

		

		// Sort files

		sortable: true,



		// Specify what files to browse for

		filters : [

			{title : "Image files", extensions : "jpg,gif,png,bmp"},

			{title : "Zip files", extensions : "zip,avi"}

		],



		// Flash settings

		flash_swf_url : <?php echo "'".$plup_upload."js/plupload.flash.swf'"; ?>,



		// Silverlight settings

		silverlight_xap_url : 'js/plupload.silverlight.xap'

	});



	// Client side form validation

	jQuery(document).ready(function() {
		jQuery('form').submit(function(e) {

        var uploader = jQuery('#uploader').plupload('getUploader');



        // Files in queue upload them first

        if (uploader.files.length > 0) {

            // When all files are uploaded submit form

            uploader.bind('StateChanged', function() {

                if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {

                    jQuery('form')[0].submit();

                }

            });

                

            uploader.start();

        } else

            alert('You must at least upload one file.');



        return false;

    });

});	 



});

</script>
<?php	
	
}
add_shortcode ('headcode', 'rex_do_shortcode');

?>