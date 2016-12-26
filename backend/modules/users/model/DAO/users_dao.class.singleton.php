<?php
// echo json_encode("USERS DAO");
// exit;

class users_dao {

    static $_instance;

    private function __construct() {

    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function create_users_dao($db, $arrArgument) {

        $active = $arrArgument['active'];
        $dni = $arrArgument['dni'];
        $name = $arrArgument['name'];
        $surnames = $arrArgument['surnames'];
        $mobile = $arrArgument['mobile'];
        $email = $arrArgument['email'];
        $password = $arrArgument['password'];
        $date_birthday = $arrArgument['date_birthday'];
        $type = $arrArgument['type'];
        $country = $arrArgument['country'];
        $province = $arrArgument['province'];
        $city = $arrArgument['city'];
        $street = $arrArgument['street'];
        $avatar = $arrArgument['avatar'];
        $token = $arrArgument['token'];



        $sql = "INSERT INTO users (active, dni, name, surnames, mobile, email,"
                . " password, date_birthday, type, country, province,"
                . " city, street, avatar, token) VALUES ('$active', '$dni', '$name',"
                . " '$surnames', '$mobile', '$email', '$password', '$date_birthday', "
                . " '$type', '$country', '$province',"
                . " '$city', '$street', '$avatar', '$token')";



        // echo json_encode($sql);
        // exit;
        return $db->ejecutar($sql);

    }//End create_users_dao


    public function select_dao($db, $arrArgument){
        $i = count($arrArgument['column']);
        $k = count($arrArgument['field']);
        $sql1 = "SELECT ";
        $sql2 = " FROM users WHERE ";

        for ($j = 0; $j < $i; $j++) {
            if ($i > 1 && $j != 0)
                $sql.=" AND ";
            $sql .= $arrArgument['column'][$j] . " like '" . $arrArgument['like'][$j] . "'";
        }

        for ($l = 0; $l < $k; $l++) {
            if ($l > 1 && $k != 0)
                $fields.=", ";
            $fields .= $arrArgument['field'][$l];
        }

        $sql = $sql1 . $fields . $sql2 . $sql;

        $stmt = $db->ejecutar($sql);
        return $db->listar($stmt);

        // $json = array();
        // $json = "Estoy en select dao";
        // return $json;

    }//End select_dao

    public function count_dao($db, $arrArgument){

        $i = count($arrArgument['column']);

        $sql = "SELECT COUNT(*) as total FROM users WHERE ";

        for ($j = 0; $j < $i; $j++) {
            if ($i > 1 && $j != 0){
                $sql.=" AND ";
            }

            $sql .= $arrArgument['column'][$j] . " like '" . $arrArgument['like'][$j] . "'";
        }

        // echo json_encode($sql);
        // exit;
        $stmt = $db->ejecutar($sql);
        // echo json_encode($db->listar($stmt));
        // exit;
        return $db->listar($stmt);

        // $json = array();
        // $json = "Estoy en count dao";
        // return $json;
    }//End count_dao

    public function update_dao($db, $arrArgument){
        $i = count($arrArgument['field']);
        $k = count($arrArgument['column']);

        $sql1 = "UPDATE users SET ";
        $sql2 = " WHERE ";

        for ($j = 0; $j < $i; $j++) {
            if ($i > 1 && $j != 0)
                $change.=", ";
            $change .= $arrArgument['field'][$j] . "='" . $arrArgument['new'][$j] . "'";
        }
        for ($l = 0; $l < $k; $l++) {
            if ($k > 1 && $l != 0)
                $sql.=" AND ";
            $sql .= $arrArgument['column'][$l] . " like '" . $arrArgument['like'][$l] . "'";
        }

        $sql = $sql1 . $change . $sql2 . $sql;
        // echo json_encode($sql);
        // exit;
        return $db->ejecutar($sql);

    }//End update_dao

    public function obtain_countries_dao($url){
          $ch = curl_init();
          curl_setopt ($ch, CURLOPT_URL, $url);
          curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
          $file_contents = curl_exec($ch);

          $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
          curl_close($ch);
          $accepted_response = array(200, 301, 302);
          if(!in_array($httpcode, $accepted_response)){
            return FALSE;
          }else{
            return ($file_contents) ? $file_contents : FALSE;
          }

    }//End obtain_countries_dao

    public function obtain_provinces_dao(){
          $json = array();
          $tmp = array();

          $provinces = simplexml_load_file(RESOURCES . "provinciasypoblaciones.xml");
          $result = $provinces->xpath("/lista/provincia/nombre | /lista/provincia/@id");
          for ($i=0; $i<count($result); $i+=2) {
            $e=$i+1;
            $provincia=$result[$e];

            $tmp = array(
              'id' => (string) $result[$i], 'nombre' => (string) $provincia
            );
            array_push($json, $tmp);
          }
              return $json;

    }//End obtain_provinces_dao

    public function obtain_cities_dao($arrArgument){
          $json = array();
          $tmp = array();

          $filter = (string)$arrArgument;
          $xml = simplexml_load_file(RESOURCES.'provinciasypoblaciones.xml');
          $result = $xml->xpath("/lista/provincia[@id='$filter']/localidades");

          for ($i=0; $i<count($result[0]); $i++) {
              $tmp = array(
                'poblacion' => (string) $result[0]->localidad[$i]
              );
              array_push($json, $tmp);
          }
          return $json;
    }//End obtain_cities_dao

}//End users DAO
