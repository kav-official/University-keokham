<?php
class StoreController{
    private $Svr;
    function __construct(){
        $this->f3 = Base::instance();
        $this->db = DBConfig::config();
    }

    function storeRegister(){
        $this->Svr = new RegisterServices($this->db);
        $this->Svr->add();
    }
}