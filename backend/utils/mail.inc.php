<?php
    function enviar_email($arr) {
        $html = '';
        $subject = '';
        $body = '';
        $ruta = '';
        $return = '';

        switch ($arr['type']) {
            case 'alta':
                $subject = 'Email confirmation from Repair on Time';
                $ruta = "<a href='" . amigable("?module=users&function=verify", true). $arr['token'] . "'>aqu&iacute;</a>";
                $body = 'Thanks for joining to our app<br> To end the process , click here: ' . $ruta;
                break;

            case 'modificacion':
                $subject = 'Tu Nuevo Password en Repair on Time<br>';
                // $ruta = '<a href="' . amigable("?module=users&function=changepass&aux=" . $arr['token'], true) . '">aqu&iacute;</a>';
                $ruta = '<a href="' . amigable("?module=users&function=changepass", true). $arr['token'] . '">aqu&iacute;</a>';
                $body = 'Para recordar tu password pulsa ' . $ruta;
                break;

            case 'contact':
                $subject = 'Your question has been sent<br>';
                $ruta = '<a href=' . 'http://arevert.tk/repair_on_time'. '>here</a>';
                $body = 'To visit our web, click ' . $ruta;
                break;

            case 'admin':
                $subject = $arr['inputSubject'];
                $body = 'inputName: ' . $arr['inputName']. '<br>' .
                'inputEmail: ' . $arr['inputEmail']. '<br>' .
                'inputSubject: ' . $arr['inputSubject']. '<br>' .
                'inputMessage: ' . $arr['inputMessage'];
                break;
        }

        $html .= "<html>";
        $html .= "<body>";
	      $html .= "<h4>". $subject ."</h4>";
	      $html .= $body;
	      $html .= "<br><br>";
	      $html .= "<p>Sent by Repair on Time</p>";
		    $html .= "</body>";
		    $html .= "</html>";

        set_error_handler('ErrorHandler');
        try{
            $mail = email::getInstance();
            $mail->name = $arr['inputName'];
            if ($arr['type'] === 'admin')
                $mail->address = 'enterpriserot@gmail.com';
            else
                $mail->address = $arr['inputEmail'];
            $mail->subject = $subject;
            $mail->body = $html;
        } catch (Exception $e) {
			$return = 0;
		}
		restore_error_handler();

        /*
        if ($mail->enviar()) {
            $return = 1;
        } else {
            $return = 0;
        }
        */
        $return = $mail->enviar();
        return $return;
    }
