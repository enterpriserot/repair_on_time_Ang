<?php
// echo json_encode("controller users");
// exit;
	class controller_users {

		public function __construct(){
			// echo FUNCTIONS_USERS . "functions_users.inc.php";
				include(FUNCTIONS_USERS . "functions_users.inc.php");
				include(LIBS . 'password_compat-master/lib/password.php');
				include(UTILS . "upload.inc.php");
				require_once(LIBS . 'twitteroauth/twitteroauth.php');
				// include LOG_DIR;
				$_SESSION['module'] = "users";
		}

		// function signup() {
		// 	loadView('modules/users/view/'.'signup.php');
		// }

		/**
     * Create a new user
     *
     * @param mixed[] $userJSON with the user info to be created
     *
     * @return mixed[] returns array['success']=boolean with the result confirmation, if false returns array['typeErr']=string and array['error']=string with the error info too.
     */
		public function signup_user() {
				$jsondata = array();
				$userJSON = json_decode($_POST['signup_user_json'], true);

				$result = validate_signupPHP($userJSON);
				if ($result['result']) {
					$avatar = get_gravatar($result['data']['email'], $s = 400, $d = 'identicon', $r = 'g', $img = false, $atts = array());
					$arrArgument = array(
							'name' => $result['data']['name'],
							'email' => $result['data']['email'],
							'password' => password_hash($result['data']['password'], PASSWORD_BCRYPT),
							'type' => "client",
							'token' => "",
							'active' => "0",
							'avatar' => $avatar
					);


					/*CONTROL DE REGISTRO*/
					set_error_handler('ErrorHandler');
					try {
						//loadModel
							$arrValue = loadModel(MODEL_USERS, "users_model", "count", array('column' => array('email'), 'like' => array($arrArgument['email'])));
							if ($arrValue[0]['total'] == 1) {
								$arrValue = false;
								$typeErr = 'Email';
								$error = "Email ya registrado";
							}
					} catch (Exception $e) {
							$arrValue = false;
					}
					restore_error_handler();
          /* Fin de control de registro */

					if ($arrValue) {
                set_error_handler('ErrorHandler');
                try {
                    //loadModel
                    $arrArgument['token'] = "Ver" . md5(uniqid(rand(), true));
                    $arrValue = loadModel(MODEL_USERS, "users_model", "create_users", $arrArgument);
                } catch (Exception $e) {
                    $arrValue = false;
                }
                restore_error_handler();

                if ($arrValue) {
                    sendtoken($arrArgument, "alta");
                    // $url = amigable('?module=main&function=begin&param=reg', true);
                    $jsondata["success"] = true;
                    // $jsondata["redirect"] = $url;
                    echo json_encode($jsondata);
                    exit;
                } else {
                    // $url = amigable('?module=main&function=begin&param=503', true);
                    $jsondata["success"] = false;
										$jsondata["typeErr"] = "error_server";
                    // $jsondata["redirect"] = $url;
                    echo json_encode($jsondata);
										exit;
                }
            } else {
                $jsondata["success"] = false;
                $jsondata['typeErr'] = "error_server";
                echo json_encode($jsondata);
            }

			} else {
            $jsondata["success"] = false;
						$jsondata['typeErr'] = "error";
            $jsondata['error'] = $result;
            echo json_encode($jsondata);
        }
		}

		function verify() {
        if (substr($_GET['param'], 0, 3) == "Ver") {
            $arrArgument = array(
                'column' => array('token'),
                'like' => array($_GET['param']),
                'field' => array('active'),
                'new' => array('1')
            );

            set_error_handler('ErrorHandler');
            try {
                $value = loadModel(MODEL_USERS, "users_model", "update", $arrArgument);
            } catch (Exception $e) {
                $value = false;
            }

            if ($value) {
							$arrArgument = array(
									'column' => array("token"),
									'like' => array($_GET['param']),
									'field' => array('*')
							);
							$user = loadModel(MODEL_USER, "users_model", "select", $arrArgument);
                $json['user'] = $user;
                $json['success'] = true;
                echo json_encode($json);
                exit();
            }

						restore_error_handler();
						echo json_encode($json);
        }
    }
		////////////////end signup////////////

		///////////////profile///////////////
		// function profile() {
    //     loadView('modules/users/view/', 'profile.php');
    // }

    function upload_avatar() {
        $result_avatar = upload_files();
        $_SESSION['avatar'] = $result_avatar;
    }

    function delete_avatar() {
        $_SESSION['avatar'] = array();
        $result = remove_files();
        if ($result === true) {
            echo json_encode(array("res" => true));
        } else {
            echo json_encode(array("res" => false));
        }
    }

    function profile_filler() {
        if (isset($_POST['email'])) {
            set_error_handler('ErrorHandler');
            try {
                $arrValue = loadModel(MODEL_USERS, "users_model", "select", array(column => array('email'), like => array($_POST['email']), field => array('*')));
            } catch (Exception $e) {
                $arrValue = false;
            }
            restore_error_handler();

            if ($arrValue) {
                $jsondata["success"] = true;
                $jsondata['user'] = $arrValue[0];
                echo json_encode($jsondata);
                exit();
            } else {
                $url = amigable('?module=main', true);
                $jsondata["success"] = false;
                $jsondata['redirect'] = $url;
                echo json_encode($jsondata);
                exit();
            }
        } else {
            $url = amigable('?module=main', true);
            $jsondata["success"] = false;
            $jsondata['redirect'] = $url;
            echo json_encode($jsondata);
            exit();
        }
    }

		public function modify_users(){
			if((isset($_POST["mod_users_json"]))){
				$jsondata= array();
				$usersJSON = json_decode($_POST["mod_users_json"], true);
				$result = validate_profilePHP($usersJSON);

				if($result['result']){
						$arrArgument = array(
								'dni' => $result['data']['dni'],
								'name' => $result['data']['name'],
								'surnames' => $result['data']['surnames'],
								'mobile' => $result['data']['mobile'],
								'email' => $result['data']['email'],
								'password' => password_hash($result['data']['password'], PASSWORD_BCRYPT),
								'date_birthday' => $result['data']['date_birthday'],
								'type' => 'client',
								'country' => $result['data']['country'],
								'province' => $result['data']['province'],
								'city' => $result['data']['city'],
								'street' => $result['data']['street'],
								'avatar' => $SESSION['avatar']['data']
						);

						$arratData = array(
								column => array(
										'email'
								),
								like => array(
										$arrArgument['email']
								)
						);

						$j = 0;
            foreach ($arrArgument as $clave => $valor) {
                if ($valor != "") {
                    $arratData['field'][$j] = $clave;
                    $arratData['new'][$j] = $valor;
                    $j++;
                }
            }

						// echo json_encode($arratData);
						// exit;

						set_error_handler('ErrorHandler');
						try{
								$arrValue = loadModel(MODEL_USERS, "users_model", "update", $arratData);
						}catch (Exception $e){
								$arrValue = false;
						}
						restore_error_handler();

						if($arrValue){
								$jsondata['success'] = true;
								$url = amigable('?module=users&function=profile&param=done',true);
								$jsondata['redirect'] = $url;
								echo json_encode($jsondata);
								exit;
						}else{
								$jsondata['success'] = false;
								$url = amigable('?module=users&function=profile&param=503',true);
								$jsondata["redirect"] = $url;
								echo json_encode($jsondata);
						}
				}else{
						$jsondata["success"] = false;
						$jsondata["error"] = $result['error'];
						echo json_encode($jsondata);
						}
				}
		}//End modify_users

		public function load_country_users(){
			if(  (isset($_GET["param"])) && ($_GET["param"] == true)  ){

						$json = array();

						$url = 'http://www.oorsprong.org/websamples.countryinfo/CountryInfoService.wso/ListOfCountryNamesByName/JSON';


						set_error_handler('ErrorHandler');
						try{
								$json = loadModel(MODEL_USERS, "users_model", "obtain_countries", $url);
						}catch(Exception $e){
								$json = array();
						}
						restore_error_handler();

						if($json){
							echo $json;
							exit;
						}else{
							$json = "error";
							echo $json;
							exit;
						}
			}
		}//Load country users

		public function load_provinces_users(){

			if( (isset($_GET["param"])) && ($_GET["param"] == true)  ){

				$jsondata = array();
				$json = array();

				set_error_handler('ErrorHandler');
				try{
						$json = loadModel(MODEL_USERS, "users_model", "obtain_provinces");
				}catch(Exception $e){
						$json = array();
				}
				restore_error_handler();

				if($json){
					$jsondata["provinces"] = $json;
					echo json_encode($jsondata);
					exit;
				}else{
					$jsondata["provinces"] = "error";
					echo json_encode($jsondata);
					exit;
				}
			}
		}//End load provinces users

		public function load_cities_users(){
			if(  isset($_GET['param']) ){
				$jsondata = array();
				$json = array();

				set_error_handler('ErrorHandler');
				try{
						$json = loadModel(MODEL_USERS, "users_model", "obtain_cities", $_POST['idPoblac']);
				}catch (Exception $e){
						$json = array();
				}
				restore_error_handler();

				if($json){
					$jsondata["cities"] = $json;
					echo json_encode($jsondata);
					exit;
				}else{
					$jsondata["cities"] = "error";
					echo json_encode($jsondata);
					exit;
				}
			}
		}//End load cities users

		//////////////profile end///////////

		//////////////begin restore////////////
    function restore() {
        loadView('modules/users/view/', 'restore.php');
    }

		public function process_restore() {
        $result = array();
        if (isset($_POST['inputEmail'])) {
            $result = validatemail($_POST['inputEmail']);
            if ($result) {
                $column = array(
                    'email'
                );
                $like = array(
                    $_POST['inputEmail']
                );
                $field = array(
                    'token'
                );

                $token = "Cha" . md5(uniqid(rand(), true));
                $new = array(
                    $token
                );

                $arrArgument = array(
                    'column' => $column,
                    'like' => $like,
                    'field' => $field,
                    'new' => $new
                );
                $arrValue = loadModel(MODEL_USERS, "users_model", "count", $arrArgument);
                if ($arrValue[0]['total'] == 1) {
                    $arrValue = loadModel(MODEL_USERS, "users_model", "update", $arrArgument);
                    if ($arrValue) {
                        //////////////// Envio del correo al usuario
                        $arrArgument = array(
                            'token' => $token,
                            'email' => $_POST['inputEmail']
                        );
                        if (sendtoken($arrArgument, "modificacion"))
                            echo "Tu nueva contraseña ha sido enviada al email";
                        else
                            echo "Error en el servidor. Intentelo más tarde";
                    }
                } else {
                    echo "El email introducido no existe ";
                }
            } else {
                echo "El email no es válido";
            }
        }
    }///end process_restore////

		// function changepass() {
    //     if (substr($_GET['param'], 0, 3) == "Cha") {
    //         loadView('modules/users/view/', 'changepass.php');
    //     } else {
    //         showErrorPage(1, "", 'HTTP/1.0 503 Service Unavailable', 503);
    //     }
    // }
		/**
     * Change the user's password
     *
     * @param string $_POST['json'] Json filled with the new password and the token.
     *
     * @return mixed[] returns array['success']=boolean with the result confirmation
     */
		function update_pass() {
        // $jsondata = array();
        // $pass = json_decode($_POST['passw'], true);
        $arrArgument = array(
            'column' => array('token'),
            'like' => array($_POST['token']),
            'field' => array('password'),
            'new' => array(password_hash($_POST['password'], PASSWORD_BCRYPT))
        );

        set_error_handler('ErrorHandler');
        try {
            $value = loadModel(MODEL_USERS, "users_model", "update", $arrArgument);
        } catch (Exception $e) {
            $value = false;
        }
        restore_error_handler();

        if ($value) {
            $jsondata["success"] = true;
            echo json_encode($jsondata);
            exit;
        } else {
            $jsondata["success"] = true;
            echo json_encode($jsondata);
            exit;
        }
    }
    ////////////////////end restore/////////////////


		/////////////////////begin signin/////////////
    public function login() {
        $user = json_decode($_POST['login_json'], true);
				// $pass = password_hash($user['pass'],PASSWORD_BCRYPT);
				// echo json_encode($pass);
				//pass: 123456 equivale: $2y$10$Eneiw4czC28zpyn3UkysLeVKzoZQJynDp0yfXELQb8jfXiC2O1t02

				// $password = password_hash("123456", PASSWORD_BCRYPT);
				// echo json_encode($password);
				// exit;

				$column = array(
            'email'
        );
        $like = array(
            $user['email']
        );

        $arrArgument = array(
            'column' => $column,
            'like' => $like,
            'field' => array('password')
        );

				set_error_handler('ErrorHandler');
        try {
					  //loadModel
						$arrValue = loadModel(MODEL_USERS, "users_model", "select", $arrArgument);
						// echo json_encode($arrValue);
						// exit;
            $arrValue = password_verify($user['pass'], $arrValue[0]['password']);
        } catch (Exception $e) {
            $arrValue = "error";
        }
        restore_error_handler();

        if ($arrValue !== "error") {
            if ($arrValue) { //OK
                set_error_handler('ErrorHandler');
                try {
                    $arrArgument = array(
                        'column' => array("email", "active"),
                        'like' => array($user['email'], "1")
                    );
                    $arrValue = loadModel(MODEL_USERS, "users_model", "count", $arrArgument);
										// echo json_encode($arrValue[0]);
										// exit;
                    if ($arrValue[0]["total"] == 1) {
                        $arrArgument = array(
                            'column' => array("email"),
                            'like' => array($user['email']),
                            'field' => array('*')
                        );
                        $user = loadModel(MODEL_USERS, "users_model", "select", $arrArgument);
                        echo json_encode($user);
                        exit();
                    } else {
                        $value = array(
                            "error" => true,
                            "data" => "User not activaterd, review your email please"
                        );
                        echo json_encode($value);
                        exit();
                    }
                } catch (Exception $e) {
                    $value = array(
                        "error" => true,
                        "data" => 503
                    );
                    echo json_encode($value);
                }
            } else {
                $value = array(
                    "error" => true,
                    "data" => "User and password doesn't match"
                );
                echo json_encode($value);
            }
        } else {
            $value = array(
                "error" => true,
                "data" => 503
            );
            echo json_encode($value);
        }
    }

    ////////////////end signin//////////////


		////////////////////////////////////////////////////begin social///////////////////////////////////////////
    function social_signin() { //utilitzada per Facebook i Twitter

				$user = $_POST;
        // $user = json_decode($_POST['user'], true);
				// echo json_encode("Dins social_signin: ".$user['email']);
				// exit;
        if ($user['twitter']) {
            $user['surnames'] = "";
            $user['email'] = $user['user_id'];
            $mail = $user['user_id'] . "@gmail.com";
        }

        set_error_handler('ErrorHandler');
        try {
            $arrValue = loadModel(MODEL_USERS, "users_model", "count", array('column' => array('email'), 'like' => array($user['email'])));
						// echo json_encode($arrValue);
						// exit;
        } catch (Exception $e) {
            $arrValue = false;
        }
        restore_error_handler();
				// json_encode("despres error handler ".$arrValue);
				// exit;
        if (!$arrValue[0]["total"]) {

            if (!$user['avatar'])
                $user['avatar'] = 'https://graph.facebook.com/' . ($user['email']) . '/picture';
            // else
            //     $avatar = get_gravatar($mail, $s = 400, $d = 'identicon', $r = 'g', $img = false, $atts = array());

						// echo json_encode("if arrValue: ".$avatar);
						// exit;
            $arrArgument = array(
                'email' => $user['email'],
                'name' => $user['name'],
                'surnames' => $user['surnames'],
                // 'email' => $user['email'],
                'type' => 'client',
                'avatar' => $user['avatar'],
                'active' => "1"
            );
						// echo json_encode("Array: ".$arrArgument['user']);
						// exit;
            set_error_handler('ErrorHandler');
            try {
                $value = loadModel(MODEL_USERS, "users_model", "create_users", $arrArgument);
            } catch (Exception $e) {
                $value = false;
            }
            restore_error_handler();
        } else{
					$value = true;
				}


        if ($value) {
						// json_encode("Dins del if");
						// exit;
            set_error_handler('ErrorHandler');
            $arrArgument = array(
                'column' => array("email"),
                'like' => array($user['email']),
                'field' => array('*')
            );
            $user = loadModel(MODEL_USERS, "users_model", "select", $arrArgument);
            restore_error_handler();
            echo json_encode($user);
        } else {
            echo json_encode(array('error' => true, 'datos' => 503));
        }
    }

}//End controller users
