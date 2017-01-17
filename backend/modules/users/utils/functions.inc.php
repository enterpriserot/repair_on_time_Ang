<?php

function validate_signupPHP($value){

  $error = array();
  $valid = true;
  $filter = array(
    'name' => array(
      'filter'=>FILTER_VALIDATE_REGEXP,
      // 'options'=>array('regexp'=>'/^\D{3,30}$/')
      'options'=>array('regexp'=>'/^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/')
    ),

    'email' => array(
      'filter'=>FILTER_CALLBACK,
      'options'=>'validatemail'
    ),

    'password' => array(
      'filter'=>FILTER_VALIDATE_REGEXP,
      'options'=>array('regexp'=>'/^.{6,12}$/')
    )
  );

  $result = filter_var_array($value, $filter);
  $result['password2'] = $value['password2'];

  $result = validate_signup($result);
  return $result;
};//End validate user SIGN UP

function validate_signup($resultado){

  if (!$resultado['name']) {
      $result['name'] = 'Nombre debe tener de 3 a 30 letras';
      $result['result'] = false;
  } elseif (!$resultado['email']) {
      $result['email'] = 'El email debe contener de 5 a 50 caracteres y debe ser un email valido';
      $result['result'] = false;
  } elseif (!$resultado['password']) {
      $result['password'] = 'Invalid password';
      $result['result'] = false;
  } elseif(!$resultado['password'] || $resultado['password']!=$resultado['password2'] ){
      $result['password2'] = 'Invalid password repeat';
      $result['password2'] = false;
      $result['result'] = false;
  } else {
    $result['result'] = true;
    $result['data']=$resultado;
  }
  return $result;

};
  //

  //
  // return $return = array('result' => $valid, 'error' => $error, 'data' => $result);



function validate_profilePHP($value){

  $error = array();
  $valid = true;
  $filter = array(
    'dni' => array(
      'filter'=>FILTER_CALLBACK,
      'options'=>'validate_dni'
    ),

    'name' => array(
      'filter'=>FILTER_VALIDATE_REGEXP,
      // 'options'=>array('regexp'=>'/^\D{3,30}$/')
      'options'=>array('regexp'=>'/[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?(( |\-)[a-zA-ZÀ-ÖØ-öø-ÿ]+\.?)*/')
    ),

    'surnames' => array(
      'filter'=>FILTER_VALIDATE_REGEXP,
      // 'options'=>array('regexp'=>'/^[a-zA-Z0-9]*$/')
      'options'=>array('regexp'=>'/^([A-ZÁÉÍÓÚ]{1}[a-zñáéíóú]+[\s]*)+$/')
    ),

    'mobile' => array(
      'filter'=>FILTER_VALIDATE_REGEXP,
      'options'=>array('regexp'=>'/^[9|6|7][0-9]{8}$/')
    ),

    'email' => array(
      'filter'=>FILTER_CALLBACK,
      'options'=>'validatemail'
    ),

    'password' => array(
      'filter'=>FILTER_VALIDATE_REGEXP,
      'options'=>array('regexp'=>'/^.{6,12}$/')
    )
    ,

    'date_birthday' => array(
      'filter' => FILTER_VALIDATE_REGEXP,
      'options' => array('regexp' => '/\d{2}.\d{2}.\d{4}$/')
    )
    ,

    'country' => array(
      'filter' => FILTER_VALIDATE_REGEXP,
      'options'=>array('regexp'=>'/^[a-zA-Z_]*$/')
    )
    ,

    'province' => array(
      'filter' => FILTER_VALIDATE_REGEXP,
      'options'=>array('regexp'=>'/^[a-zA-Z0-9, _]*$/')
    )
    ,

    'city' => array(
      'filter'=>FILTER_CALLBACK,
      'options'=>'validate_city'
    )
    ,

    'street' => array(
      'filter'=>FILTER_VALIDATE_REGEXP,
      'options' => array('regexp' => "/[A-Za-z0-9'\.\-\s\,]+$/")
    ),
  );

  $result = filter_var_array($value, $filter);
  $result['type'] = $value['type'];
  $result['password2'] = $value['password2'];

      if ($result['date_birthday']) {
          $datebirthday = validate_datebirthday($value['date_birthday']);

          if (!$datebirthday) {
              $error['date_birthday'] = 'User must have more than 18 years';
              $valid = false;
          }
      }

      if (!$result['dni']) {
          $error['dni'] = 'invalid dni';
          $result['dni'] = $value['dni'];
          $valid = false;
      }
      if (!$result['name']) {
          $error['name'] = 'invalid name';
          $result['name'] = $value['name'];
          $valid = false;
      }
      if (!$result['surnames']) {
          $error['surnames'] = 'invalid surname/s';
          $result['surnames'] = $value['surnames'];
          $valid = false;
      }
      if($value['mobile'] !== "" && !$result['mobile']){
          $error['mobile'] = 'Invalid mobile number must start with 6/7/9';
          $result['mobile'] = $value['mobile'];
          $valid = false;
      }
      if (!$result['email']) {
          $error['email'] = 'Invalid email';
          $result['email'] = $value['email'];
          $valid = false;
      }
      if($value['password'] !== "" && !$result['password']){
          $error['password'] = 'Invalid password';
          $result['password'] = $value['password'];
          $valid = false;
      }

      if((!$result['password'] || $result['password']!=$result['password2']) && $value['password2'] !== "" ){
          $error['password'] = 'Invalid password repeat';
          $result['password'] = $value['password'];
          $valid = false;
      }
      if (!$result['date_birthday']) {
          $error['date_birthday'] = 'Invalid date birthday';
          $result['date_birthday'] = $value['date_birthday'];
          $valid = false;
      }
      if (!$result['country']) {
          $error['country'] = 'Invalid country';
          $result['country'] = $value['country'];
          $valid = false;
      }
      if (!$result['province']) {
          $error['province'] = 'Invalid province';
          $result['province'] = $value['province'];
          $valid = false;
      }
      if (!$result['city']) {
          $error['city'] = 'Invalid city';
          $result['city'] = $value['city'];
          $valid = false;
      }
      if (!$result['street']) {
          $error['street'] = 'Invalid street';
          $result['street'] = $value['street'];
          $valid = false;
      }
  return $return = array('result' => $valid, 'error' => $error, 'data' => $result);
}//End validate user

function validate_dni($dni){
	$letter = substr($dni, -1);
	$numbers = substr($dni, 0, -1);
	if ( substr("TRWAGMYFPDXBNJZSQVHLCKE", $numbers%23, 1) == $letter && strlen($letter) == 1 && strlen ($numbers) == 8 ){
    return $dni;
    //echo 'valido';
	}else{
    return false;
		//echo 'no valido';
	}
}

function validatemail($email){
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
      if(filter_var($email, FILTER_VALIDATE_REGEXP, array('options' => array('regexp'=> '/^.{5,50}$/')))){
        return $email;
      }
    }
    return false;
}

function validate_city($city){
    //$city = addslashes($city);
    $city = filter_var($city, FILTER_SANITIZE_STRING);
    return $city;
}

function validate_datebirthday($birthday, $age = 18) {
    if (is_string($birthday)) {
        $birthday = strtotime($birthday);
    }

    // 31536000 is the number of seconds in a 365 days year
    if (time() - $birthday < $age * 31536000) {
        return false;
    }
    return true;
}

function get_gravatar($email, $s = 80, $d = 'wavatar', $r = 'g', $img = false, $atts = array()){
    $email = trim($email);
    $email = strtolower($email);
    $email_hash = md5($email);

    $url = "https://www.gravatar.com/avatar/" . $email_hash;
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img){
        $url = '<img src"' . $url . '"';
        foreach ($atts as $key => $val)
            $url .= ' ' . $key . '="' . $val . '"';
        $url .= ' />';
    }
    return $url;
}

function sendtoken($arrArgument, $type){
    $mail = array(
        'type' => $type,
        'token' => $arrArgument['token'],
        'inputEmail' => $arrArgument['email']
    );
    set_error_handler('ErrorHandler');
    try{
       enviar_email($mail);
       return true;
    }catch (Exception $e){
       return false;
    }
    restore_error_handler();
}
