<?php
class HomeController extends ActionController {
    private $f3;
    private $custom;
    private $help;
    private $tmp;
    public $db;
    function __construct(){
        $this->tmp    = new Template();
        $this->f3     = Base::instance();
        $this->db     = DBConfig::config();
        $this->custom = new CustomFunctions();
        $this->help   = new HelpFunctions();
    }

    function index(){
        $this->f3->set('nav','Home');
        $this->f3->set('subnav','Home');
        $this->f3->set('custom',$this->custom);
        $this->f3->set('help',$this->help);
        echo $this->tmp->render('frontend/index.html');
    }
}