<?php
class CategoryController extends ActionController {
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
	    parent::__construct('CategoryServices', 'backend/category.html', 'category', 'category', 'ພະເພດສິນຄ້າ');
    }
}