<?php
class UserController extends ActionController {
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
        $this->f3->set('arrRole',$this->custom->role());
        $this->f3->set('custom',$this->custom);
	    parent::__construct('UserServices', 'backend/user.html', 'user', 'user', 'ພະນັກງານ');
    }
}