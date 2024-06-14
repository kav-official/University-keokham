<?php
class SupplierController extends ActionController {
    private $f3;
    private $secur;
    private $custom;
    public $db;
    function __construct(){
        $this->f3 = Base::instance();
        $this->db = DBConfig::config();
        $this->secur = new CustomSecurity();
        $this->secur->security();
        $this->custom = new CustomFunctions();
	    parent::__construct('SupplierServices', 'backend/supplier.html', 'supplier', 'supplier', 'ຜູ້ສະໜອງ');
    }
}