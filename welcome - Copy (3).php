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
global $real_name, $hash_name, $final_upload_dir;
echo $post_array['uploader_count'];
	echo "Is Set".'<br>';
	for ($i=0; $i<(int)$post_array['uploader_count']; $i++ ){
		$index_tmpname = 'uploader_'.$i.'_tmpname';
		$index_uploader_name = 'uploader_'.$i.'_name';
		echo $index_tmpname.'<br>';
		$hash_name = $post_array[$index_tmpname];
		
		if (!isset($options_get['chk_button_rename'])){
			$real_name = str_replace(' ', '_', $post_array[$index_uploader_name]);
		}else{
			$real_name = str_replace(' ', '_', $post_array[$index_tmpname]);			
		}
		
		$blogurl = get_bloginfo('wpurl');
		echo $blogurl.'<br>';
		$uploads = wp_upload_dir();
		$uploads_path = $uploads['url'];
		echo $uploads_path.'<br>';
		$final_upload_dir = $append_relative.str_replace($blogurl.'/', '', $uploads_path).'/';
		echo $final_upload_dir.'<br>';
		if(file_exists($final_upload_dir.$real_name)){
			echo 'file exists'.'<br>';
			$name_chunk = strchr($real_name, '.', true);
			echo 'namechunk: '.$name_chunk.'<br>';
			$name_chunk .= '_1';
			echo 'namechunk: '.$name_chunk.'<br>';
			$name_extension = strchr($real_name, '.');
			echo 'name_extension: '.$name_extension.'<br>';
			$real_name = $name_chunk.$name_extension;
			echo 'real_name: '.$real_name.'<br>';
			echo 'hash_name: '.'uploads/'.$hash_name.'<br>';
			
		}
		var_dump ($real_name);
		echo 'final dest: '.$final_upload_dir.$real_name.'<br>';
		rename( 'uploads/'.$hash_name, $final_upload_dir.$real_name );
	}	
//*!*!*!*!*!*!*!*!* NEED TO CHECK REMOTE TO SEE IF IT HAS BEEN RENAMED ALREADY!*!*!*!*!*!*!*!*!*!*!*!*!
var_dump($options_get);


?>