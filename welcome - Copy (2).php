<?php
/*
......................................
Can be used in any WP child dir to find WP root outside of WP environment
$append_relative can be used to append for WP root folder
$root_url can be used to actually load wp-load.php 
use this to load WP environmental functions
$levels is used to limit the number of levels deep the script should look
......................................
*/
function find_wp_root(){
	global $append_relative, $root_url;
	$append_relative = "";
	$levels = 10;
	for ($i=1; $i<=$levels; $i++){
		if(file_exists($append_relative.'wp-load.php')){
			$root_url = $append_relative.'wp-load.php';
			break;
			}else{
			$append_relative .= "../";
		}	
	}
}
find_wp_root();
require_once ($root_url);
//var_dump($_POST);
/*
......................................

......................................
*/
echo '<br>';
echo '<br>';
echo '<br>';

$post_array = $_POST;
var_dump($post_array);
echo '<br>';
$options_get = get_option('rex_options');//load plugs options
/*
......................................
check if user wants files to be renamed, and move them to user chosen directory
......................................
*/
$wp_upload_array = wp_upload_dir();
$wp_upload_url = $wp_upload_array['url'];
$final_dest = str_replace(bloginfo('wpurl'), '', $wp_upload_url );
echo $final_dest;

?>