<?php
class ProductListController extends BaseController {

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
	    parent::__construct('ProductServices', 'backend/product-list.html', 'product', 'product-list', 'ສິນຄ້າ', '', '', $this->f3->get('ITEM_PER_PAGE'));
    }
}