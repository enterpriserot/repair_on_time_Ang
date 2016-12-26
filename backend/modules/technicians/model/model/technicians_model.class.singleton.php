<?php
// echo json_encode("json");
// exit;
class technicians_model {

    private $bll;
    static $_instance;

    private function __construct() {
        $this->bll = technicians_bll::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function create_technicians($arrArgument) {
        return $this->bll->create_technicians_bll($arrArgument);
    }

    public function update($arrArgument) {
        return $this->bll->update_bll($arrArgument);
    }

    public function count($arrArgument) {
        return $this->bll->count_bll($arrArgument);
    }

     public function select($arrArgument) {
        //return "hola";
        return $this->bll->select_bll($arrArgument);
    }
}
