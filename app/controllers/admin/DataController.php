<?php
class DataController {
    private $f3;
    private $secur;
    private $custom;
    private $Svr;
    public $db;
    function __construct(){
        $this->f3 = Base::instance();
        $this->db = DBConfig::config();
        $this->secur = new CustomSecurity();
        $this->secur->security();
        $this->custom  = new CustomFunctions();
        $this->Svr     =  new OrderServices($this->db);
        $this->Svrlist = new OrderListServices($this->db);
    }
}