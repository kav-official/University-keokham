<?php
class AdminController
{
	private $f3,$tmp,$db,$secur,$Svr,$memSvr;

	function __construct()
	{
		$this->f3 = Base::instance();
		$this->tmp = new Template;
		$this->db = DBConfig::config();
		$this->secur = new CustomSecurity();
		$this->secur->security();
	}

	function index() {
		$this->f3->set('nav', 'home');
		$this->f3->set('subnav', '');
		$this->f3->set('strAction', 'Dashboard');
		$this->f3->set('strPage', 'Home');
		echo($this->tmp->instance()->render('backend/index.html'));
	}
}
