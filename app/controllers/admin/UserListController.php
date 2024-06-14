<?php
class UserListController extends BaseController {

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
	    parent::__construct('UserServices', 'backend/user-list.html', 'user', 'user-list', 'ພະນັກງານ', '', '', $this->f3->get('ITEM_PER_PAGE'));
    }
}