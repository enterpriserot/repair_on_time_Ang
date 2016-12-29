<?php
  class controller_contact{

    public function __construct() {
      $_SESSION['module'] = "contact";
      //include LOG_DIR;
    }

    /**
     * Send an email to client with the information that's filled in the form and send a copy to admin
     *
     * @return mixed[] Return an array containing a token, a name, an email, a subject and a message which has been filled
     * by the user previously
     */

    public function process_contact(){

      if($_POST['token'] === "contact_form"){
        /////Email send to the user
        $arrArgument = array(
            'type' => 'contact',
            'token' => '',
            'inputName' => $_POST['inputName'],
            'inputEmail' => $_POST['inputEmail'],
            'inputSubject' => $_POST['inputSubject'],
            'inputMessage' => $_POST['inputMessage']
        );
        set_error_handler('ErrorHandler');
        try{
            enviar_email($arrArgument);
        } catch (Exception $e){
            $value = false;
        }
        restore_error_handler();

        /////Email send to the admin
        $arrArgument = array(
            'type' => 'admin',
            'token' => '',
            'inputName' => $_POST['inputName'],
            'inputEmail' => $_POST['inputEmail'],
            'inputSubject' => $_POST['inputSubject'],
            'inputMessage' => $_POST['inputMessage']
        );
        set_error_handler('ErrorHandler');
        try{
            sleep(5);
            enviar_email($arrArgument);
            echo "true|Your message has been sent";
        } catch (Exception $e){
            echo "false|Server error. Try later...";
        }
        restore_error_handler();
      }else{
            echo "false|Server error. Try later...";
      }
    }//End process contact
  }//End controller_main
