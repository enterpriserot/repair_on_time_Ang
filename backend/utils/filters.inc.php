<?php

function filter_num_int($num){
  $num = filter_var($num, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
  if (!is_numeric($num)) {
      return $return = array('result' => false, 'error' => "Invalid page number!", 'data' => 1);
  }
  return $return = array('result' => true, 'error' => "", 'data' => $num);
}

function filter_string($cad){
      $result = filter_var($cad, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-zA-Z0-9 .,]*$/')));
      if(!$result){
        return $return=array('result'=>false,'error'=>"Invalid value input",'data'=>"");
      }
      return $return=array('result'=>true, 'error'=>"",'data'=>$cad);
}
