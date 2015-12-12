<?php if(!defined("BASEPATH")){ exit("No direct script access allowed"); }
	/**
	 * Multi-Upload
	 * 
	 *  Upload function to add support for easy single or multiple uploads
	 *  uploads.
	 *
	 * @package		CodeIgniter
	 * @subpackage	Libraries
	 * @category	Uploads
	 * @author		Conveyor Group <me@ayyazzafar.com>
	 * @link		https://github.com/ayyazzafar/Codeigniter-Multiple-Uploader/
	 */
	
function do_upload($configs = array())
{
	// print_r($_FILES); die;

	$CI = & get_instance();
	$defaults = array(
		'file'				=>	'documents', 
		"max_size"			=> 0,
		"max_width"			=> 0,
		"max_height"		=> 0,
		"max_filename"		=> 0,
		"allowed_types"		=> "",
		"file_temp"			=> "",
		"file_name"			=> "",
		"file_size"			=> "500000",
		"upload_path"		=> "./",
		"overwrite"			=> FALSE,
		"encrypt_name"		=> true,
		"image_width"		=> "",
		"image_height"		=> "",
 		"remove_spaces"		=> TRUE,
	);
	$file = $configs['file'];

	if(isset($_FILES[$file]))
	{
		// setting configurations
		foreach($defaults as $key => $value):

			if(!isset($configs[$key]))
			{
				$configs[$key] = $value;
			}

		endforeach;

		
			// re-arranging $_FILES
			if(isset($_FILES[$file])):
				$i=0;
				$total_files = 0;
				//print_r($_FILES[$file]);
				if(is_array($_FILES[$file]['name'])):
					foreach($_FILES[$file]['name'] as $file_name):
						$total_files++;
						
					
							$_FILES[$file.$i]=array(
								'name'	=>	$_FILES[$file]['name'][$i],
								'type'	=>	$_FILES[$file]['type'][$i],
								'tmp_name'	=>	$_FILES[$file]['tmp_name'][$i],
								'error'	=>	$_FILES[$file]['error'][$i],
								'size'	=>	$_FILES[$file]['size'][$i],
							);
						
							
						$i++;
					endforeach;
				else:
					$total_files++;
					$_FILES[$file.$i]=array(
							'name'	=>	$_FILES[$file]['name'],
							'type'	=>	$_FILES[$file]['type'],
							'tmp_name'	=>	$_FILES[$file]['tmp_name'],
							'error'	=>	$_FILES[$file]['error'],
							'size'	=>	$_FILES[$file]['size'],
						);
				endif;
			endif;
		

		// actual upload process starts
		for($i=0; $i<$total_files; $i++):
			

			$CI->load->library('upload', $configs);

			if ( ! $CI->upload->do_upload($file.$i))
			{
				echo $CI->upload->display_errors();

			}
			else
			{
				$uploaded_files[]=$CI->upload->data();
			}
			
		endfor;

		return $uploaded_files;
	}
	else
	{
		return array();
	}
}
