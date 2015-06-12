<?php

if(isset($_GET['imagepath']) && $_GET['imagepath']!=''){ 
	$img_path= $_GET['imagepath'];
    //$destdir = 'image/';
	$size = get_headers($img_path, 1);
		
	if($size["Content-Length"]>'30000'){	
		echo "File is not valid OR exceed size. Please try another image.";
	}else{		
		$url_arr = explode ('/', $img_path);
		$ct = count($url_arr);
		$name = $url_arr[$ct-1];
		$name_div = explode('.', $name);
		$ct_dot = count($name_div);
		$img_type = $name_div[$ct_dot -1];

		$ch = curl_init($img_path);
		$fp = fopen('/home/ecestudent/imageclassification/imagenet/val/'.$name, 'wb');
		curl_setopt($ch, CURLOPT_FILE, $fp);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_exec($ch);
		curl_close($ch);
		fclose($fp);   
		echo "File is valid, and was successfully uploaded.";
	} 
	
    /* $img=file_get_contents($img_path);
	$img_size = strlen($img);
	if($img_size>'30000'){	
		echo "File is not valid OR exceed size. Please try another image.";
	}else{
		file_put_contents($destdir.substr($img_path, strrpos($img_path,'/')), $img);
		echo "File is valid, and was successfully uploaded.";
	} */
}else{ 
	if(isset($_POST)){ 
		if($_FILES['userfile']['error']>0){
			echo "File is not valid OR exceed size. Please try another image.";
		}else{
			$uploaddir = "/home/ecestudent/imageclassification/imagenet/val/";
			$uploadfile = $uploaddir . basename($_FILES["userfile"]["name"]);
		  
      if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
			
				echo "File is valid, and was successfully uploaded.";
        if (updateValFile(basename($_FILES["userfile"]["name"]))) {
          do {
            sleep(2);

            $output = readValFile();

            $label = getLabel($output);
          } while($label == "-1");

          $imageName = getImageName($label);
          echo "<pre>This Image is $imageName</pre>";
        }
			}
		}
	}
}

function getImageName($label) {
  $myfile = fopen("/home/ecestudent/imageclassification/phpServices/ee/LabelMap.txt", "r") or die("Unable to open file!");
 
  while(!feof($myfile)){
    $line = fgets($myfile);
    $pos = strpos($line, " ");
    if ($pos !== false) {
      $id = substr($line, 0, $pos);
      $name = substr($line, $pos+1);
      //echo "<pre>Check: $label ---$id:$name</pre>";
      if ($id == $label)
        return $name;
    }
  }

  return "";
}
	   
function getLabel($content) {

  if (strlen($content)) {
    $parts = explode(" ", $content);
    return $parts[1];
  }
  return "empty string";
}


function updateValFile($fileName) {
  $myfile = fopen("/home/ecestudent/imageclassification/imagenet/val.txt", "w") or die("Unable to open file!");
  $txt = $fileName." -1";
  fwrite($myfile, $txt);
  
  fclose($myfile);
  return true;
}

function readValFile() {
  $myfile = fopen("/home/ecestudent/imageclassification/imagenet/val.txt", "r") or die("Unable to open file!");

  if(!feof($myfile)){
    $line = fgets($myfile);
    return $line;
  }

  return "";
}



?>
