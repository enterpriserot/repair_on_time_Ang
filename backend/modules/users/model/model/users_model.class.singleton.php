<?php
// echo json_encode("USERS MODEL");
// exit;
class users_model {
    private $bll;
    static $_instance;

    private function __construct() {
        $this->bll = users_bll::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function create_users($arrArgument) {
        return $this->bll->create_users_bll($arrArgument);
    }

    public function update($arrArgument){
        return $this->bll->update_bll($arrArgument);
    }

    public function count($arrArgument){
        return $this->bll->count_bll($arrArgument);
    }

    public function select($arrArgument){
        return $this->bll->select_bll($arrArgument);
    }

    public function obtain_countries($url){
        return $this->bll->obtain_countries_bll($url);
    }

    public function obtain_provinces(){
        return $this->bll->obtain_provinces_bll();
    }

    public Function obtain_cities($arrArgument){
        return $this->bll->obtain_cities_bll($arrArgument);
    }

}
