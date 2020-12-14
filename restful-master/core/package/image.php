//         $target_dir = "uploads/";
//       //  print_r($this->cdata->Input["FILES"]);
// $target_file = $target_dir . basename($this->cdata->Input["FILES"]["image"]["name"]);
// $uploadOk = 1;
// print_r($target_file);
// $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// // print_r(pathinfo($target_file,PATHINFO_EXTENSION));
// // Check if image file is a actual image or fake image
// // if(isset($_POST["submit"])) {
//   $check = getimagesize($this->cdata->Input["FILES"]["image"]["tmp_name"]);
//   if($check !== false) {
//     echo "File is an image - " . $check["mime"] . ".";
//     move_uploaded_file($this->cdata->Input["FILES"]["image"]["tmp_name"], $target_file);
//     $uploadOk = 1;
// //   } else {
//     // echo "File is not an image.";
//     // $uploadOk = 0;
// //   }
// }

//         return "Do Post ".$this->cdata->Id;