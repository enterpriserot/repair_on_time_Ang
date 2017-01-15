<?php
class technicians_bll {
    private $dao;
    private $db;
    static $_instance;

    private function __construct() {
        $this->dao = technicians_dao::getInstance();
        $this->db = db::getInstance();
    }

    public static function getInstance() {
        if (!(self::$_instance instanceof self))
            self::$_instance = new self();
        return self::$_instance;
    }

    public function create_technicians_bll($arrArgument) {
        return $this->dao->create_technicians_dao($this->db, $arrArgument);
    }

    public function update_bll($arrArgument) {
        return $this->dao->update_dao($this->db, $arrArgument);
    }

    public function count_bll($arrArgument) {
        return $this->dao->count_dao($this->db, $arrArgument);
    }

    public function select_bll($arrArgument) {
        return $this->dao->select_dao($this->db, $arrArgument);
    }
}
