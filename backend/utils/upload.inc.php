<?php
//console.log("upload");
//exit;


function upload_files() {
  //return json_encode("Upload files");
    $error = "";
    $copyFile = false;
    $extensions = array('jpg', 'jpeg', 'gif', 'png', 'bmp');

    if(!isset($_FILES)) {
        $error .=  'No existe $_FILES <br>';
    }
    if(!isset($_FILES['file'])) {
        $error .=  'No existe $_FILES[file] <br>';
    }

    $img = $_FILES['file']['tmp_name'];
    $name_file= $_FILES['file']['name'];
    $size_file=$_FILES['file']['size'];
    $type_file=$_FILES['file']['type'];
    $error_file=$_FILES['file']['error'];

    if ($error_file>0) { // El error 0 quiere decir que se subió el archivo correctamente
        switch ($error_file){
            case 1: $error .=  'The file size is too heavy <br>'; break;//Fitxer major que upload_max_filesize
            case 2: $error .=  'The file size is too large <br>';break;//Fitxer major que max_file_size
            case 3: $error .=  'File upload incomplete <br>';break;//Fitxer només parcialment pujat
            //case 4: $error .=  'No has pujat cap fitxer <br>';break; //assignarem a l'us default-avatar
        }
    }

    if ($_FILES['file']['size'] > 55000 ){
        $error .=  "Large File Size <br>";
    }

    if ($_FILES['file']['name'] !== "") {
        ////////////////////////////////////////////////////////////////////////////
        @$extension = strtolower(end(explode('.', $_FILES['file']['name']))); // Obtenemos la extensión, en minúsculas para poder comparar
        if( ! in_array($extension, $extensions)) {
            $error .=  'Sólo se permite subir archivos con estas extensiones: ' . implode(', ', $extensions).' <br>';
        }
        ////////////////////////////////////////////////////////////////////////////
        //getimagesize falla si $_FILES['avatar']['name'] === ""
        if (!@getimagesize($_FILES['file']['tmp_name'])){
            $error .=  "Invalid Image File... <br>";
        }
        ////////////////////////////////////////////////////////////////////////////
        list($width, $height, $type, $attr) = @getimagesize($_FILES['file']['tmp_name']);
        if ($width > 150 || $height > 150){
            $error .=   "Maximum width and height exceeded. Please upload images below 100x100 px size <br>";
        }
    }

///////////////

    $upfile = (MEDIA_PATH.$_FILES['file']['name']);

    if (is_uploaded_file($_FILES['file']['tmp_name'])){
        if (is_file($_FILES['file']['tmp_name'])) {
            $idUnico = rand();
            $nombreFichero = $idUnico."-".$_FILES['file']['name'];
            $_SESSION['nombreFichero']=$nombreFichero;
            $copiarFichero = true;

            // I use absolute route to move_uploaded_file because this happens when i run ajax
            $upfile = MEDIA_PATH.$nombreFichero;

        }else{
                $error .=   "Invalid File...";
        }
    }


    $i=0;
    if ($error == "") {
        if ($copiarFichero) {

            if (!move_uploaded_file($_FILES['file']['tmp_name'], $upfile)) {

                $error .= "<p>Error al subir la imagen.</p>";
                return $return=array('resultado'=>false,'error'=>$error,'datos'=>"");
            }
            //We need edit $upfile because now i don't need absolute route.
            $upfile ='media/'.$nombreFichero;

            return $return=array('resultado'=>true , 'error'=>$error,'datos'=>$upfile);
        }
        if($_FILES['file']['error'] !== 0) { //Assignarem a l'us default-avatar

            $upfile = ('./media/default-avatar.png');
            return $return=array('resultado'=>true,'error'=>$error,'datos'=>$upfile);
        }
    }else{
        return $return=array('resultado'=>false,'error'=>$error,'datos'=>"");
    }
}

function remove_files(){

	//$name = $_POST["filename"];
	if(file_exists(MEDIA_PATH.$_SESSION['nombreFichero'])){
		unlink(MEDIA_PATH.$_SESSION['nombreFichero']);
		return true;
	}else{
		return false;
	}
}
