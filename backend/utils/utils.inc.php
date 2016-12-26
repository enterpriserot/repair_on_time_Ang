<?php
    function debugPHP($array){
        echo "<pre>";
        print_r($array);
        echo "</pre><br>";
    }

    function redirect($url){
        die('<script>top.location.href="'.$url.'";</script>');
    }

    function close_session(){
        $_SESSION = array();//Destroy all session variables
        session_destroy();//Destroy the session
    }

    function amigable($url, $return = false) {
        $amigableson = URL_AMIGABLES;
        $link = "";
        if ($amigableson) {
            $url = explode("&", str_replace("?", "", $url));
            foreach ($url as $key => $value) {
                $aux = explode("=", $value);
                $link .=  $aux[1]."/";
            }
        } else {
            $link = "index.php" . $url;
        }
        if ($return) {
            return SITE_PATH . $link;
        }
        echo SITE_PATH . $link;
    }
