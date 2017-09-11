<?php

function uploadImage($image, $user_id) {
	$target_dir = "uploads/";
	$ext = pathinfo($image["name"], PATHINFO_EXTENSION);
	$target_file = $target_dir . $user_id . Date("YmdHis") . ".$ext";

	$uploadOk = 1;

	$check = getimagesize($image["tmp_name"]);

	if($check !== false) {
		if ($image["size"] > 500000) {
			echo "Sorry, your file is too large.";
			$uploadOk = 0;
		} else {
			$uploadOk = 1;

			if (move_uploaded_file($image["tmp_name"], $target_file)) {
				echo "The file ". basename( $image["name"]). " has been uploaded.";
			} else {
				echo "Sorry, there was an error uploading your file.";
			}
		}
	} else {
		echo "File is not an image.";
		$uploadOk = 0;
	}
}

?>