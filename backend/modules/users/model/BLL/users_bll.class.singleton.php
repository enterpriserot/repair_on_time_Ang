<?php
// echo json_encode("USERS BLL");
// exit;
class users_bll{

    private $dao;
    private $db;
    static $_instance;

    private function __construct() {
        $this->dao = users_dao::getInstance();
        $this->db = db::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function create_users_bll($arrArgument){
      return $this->dao->create_users_dao($this->db, $arrArgument);
    }

    public function update_bll($arrArgument){
        return $this->dao->update_dao($this->db, $arrArgument);
    }

    public function count_bll($arrArgument){
        return $this->dao->count_dao($this->db, $arrArgument);
    }

    public function select_bll($arrArgument){
        return $this->dao->select_dao($this->db, $arrArgument);
    }

    public function obtain_countries_bll($url){
      return $this->dao->obtain_countries_dao($url);
    }

    public function obtain_provinces_bll(){
      return $this->dao->obtain_provinces_dao();
    }

    public function obtain_cities_bll($arrArgument){
      return $this->dao->obtain_cities_dao($arrArgument);
    }
}
