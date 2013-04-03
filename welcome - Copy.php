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
var_dump($_POST);
/*
......................................
cycle through $_POST and identify uploads by key name
......................................
*/
$options_get = get_option('rex_options');//load plugs options
$is_renamed = $options_get['chk_button_rename'];
//var_dump($options_get);
if (isset($is_renamed)){
	$file_ends_in = "_tmpname"; echo $file_ends_in;
}else{
	$file_ends_in = "_name"; echo $file_ends_in;
}//loop identifies renamed file or not
//echo $file_ends_in;
//var_dump ($_POST);
$post_keys = array_keys($_POST);//makes array of key names
//var_dump ($post_keys);
$file_names = array();//readies empty array
foreach ($post_keys as $ps){
	
	$is_uploaded_file = strpos($ps, $file_ends_in);//check for key ending in...
	if ((int)$is_uploaded_file > 1){
		array_push($file_names, $ps);//if it does push it into new array for upload
	}	
}
/*
......................................
checks if uploaded file exists
now that we have file names in and array, make sure they are there for realz
then move themz to WP uploads subdir
......................................
*/
$uploads_array = wp_upload_dir();
$upload_subdir = $uploads_array['subdir'];
$content_dir = content_url();
$blog_url = get_bloginfo('wpurl');
$wp_content_path = str_replace('/', '', str_replace ( $blog_url, '', $content_dir ));
$uploads_dir = $append_relative.$wp_content_path.'/uploads/'.$upload_subdir.'/';
foreach ($file_names as $file_name){
	$uped_file = str_replace(' ', '_', $_POST[$file_name]);//replace spaces
	if(file_exists('uploads/'.$uped_file)){
		echo 'uploads/'.$uped_file.' <--exists and is true'.'<br>';
		echo $uploads_dir.'<br>';
		rename('uploads/'.$uped_file, $uploads_dir.$uped_file);
		}
}

?>