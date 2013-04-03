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
echo $options_get['upload_dir'].'<br>';
/*
......................................
init the current upload relative path
......................................
*/
$wp_upload_array = wp_upload_dir();//get the wp upload array
$final_dest = $append_relative.str_replace(get_bloginfo('wpurl').'/', '', $wp_upload_array['url'] ).'/'.$options_get['upload_dir'];//subtract blog root from uploads and get the final path
echo $final_dest.'<br>';

/*
......................................
check if upload folder exists, if not, make it
......................................
*/
if(file_exists($final_dest)){
	echo "Dir Exists!!".'<br>';
}else{
	echo 'Dir does not exist '.'<br>';
	mkdir ($final_dest,0755,true);
}

/*
......................................
get a list of the uploaded files and append new path
......................................
*/
$count_files=(int)$_POST['uploader_count'];
echo $count_files.'<br>';
$file_list = array();
for ($i=0; $i<$count_files; $i++){
	$temp_name = 'uploader_'.$i.'_tmpname';
	$real_name = 'uploader_'.$i.'_name';
	echo $_POST[$real_name].'<br>';
	$work_file = $final_dest.str_replace(' ', '_', $_POST[$real_name]);
	echo $work_file.'<br>';
	array_push($file_list, $work_file);
}
var_dump ($file_list);
echo '<br>';
/*
......................................
check if files exist in upload dir and rename them if name exists
......................................
*/
echo 'file check: '.'<br>';
$new_file_list = array();
foreach ($file_list as $file_obj){
	echo $file_obj.'<br>';
		while (file_exists($file_obj)) {
			$info = pathinfo($file_obj);
    		$file_obj = $info['dirname'] . '/' . $info['filename'] . '_1' . '.' . $info['extension'];
		}
		array_push($new_file_list, $file_obj);
}
var_dump($new_file_list);
echo '<br>';
/*
......................................
take new file list and move files
......................................
*/
$i=0;
foreach ($new_file_list as $file_to_move){
	$temp_name = 'uploader_'.$i++.'_tmpname';
	echo 'TEMP NAME and PATH: uploads/'.$_POST[$temp_name].'<br>';
	echo $file_to_move.'<br>';
	rename('uploads/'.$_POST[$temp_name], $file_to_move );
}

/*
......................................
testing the zip archiving functions...to be finished...
......................................
*/
function do_zip(){
	$zip = new ZipArchive();
	$filename = "customer.zip";
	$zip->open($filename, ZIPARCHIVE::CREATE);
	$ii=1;
	foreach ($new_file_list as $add_me_to_zip){
		echo $add_me_to_zip.'<br>';
		if (file_exists($add_me_to_zip)){
		echo "yes!" . '<br>';
		$zip->addFile($add_me_to_zip, 'file.00'.$ii++);
	}
}
echo "numfiles: " . $zip->numFiles . "\n";
echo "status:" . $zip->status . "\n";
$zip->close();
}
//do_zip();
?>