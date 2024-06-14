<?php
class OrderController extends ActionController {
    private $f3;
    private $secur;
    private $custom;
    public $db;
    function __construct(){
        $this->f3    = Base::instance();
        $this->db    = DBConfig::config();
        $this->secur = new CustomSecurity();
        $this->secur->security();
        $this->custom = new CustomFunctions();

        $this->f3->set('custom',$this->custom);
	    parent::__construct('OrderServices', 'backend/order.html', 'order', 'order', 'ສິນຄ້າ');
    }
}