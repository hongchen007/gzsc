<?php
  // if ((($_FILES["file"]["type"] == "image/gif") || ($_FILES["file"]["type"] == "image/jpeg") || ($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/pjpeg")) && ($_FILES["file"]["size"] < 20000)) {
    if ($_FILES["file"]["error"] > 0){
      echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }else{
      //修改文件名
      $date = time().rand(111111,999999);
      $uptype = explode(".", $_FILES["file"]["name"]);
      $newname = $date . "." . $uptype[1];
      //echo($newname);
      $_FILES["file"]["name"] = $newname;
      //首先生成新的文件夹路径
      $path = date('Y-m-d', time());
      //文件夹不存在，先生成文件夹
      if (!file_exists($path)){
          mkdir($path);
      }

      if (file_exists($path . "/" .$_FILES["file"]["name"])){
        echo $_FILES["file"]["name"] . " already exists. ";
      }else{
        move_uploaded_file($_FILES["file"]["tmp_name"],$path . "/" .$_FILES["file"]["name"]);
        $info['url'] =  $path . "/" . $_FILES["file"]["name"];
        echo json_encode($info);
        }
    }
  // } else {
  //     echo "Invalid file";
  // } 

?>
