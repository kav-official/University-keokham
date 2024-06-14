<?php

class StaticController extends Controller
{
	public $custom;
	public $help;
	public $db;

	function __construct()
	{
		parent::__construct();
		$this->db     = DBConfig::config();
		$this->tmp    = new Template;
		$this->custom = new CustomFunctions();
		$this->help   = new HelpFunctions();
	}

	public function index()
	{
		if (file_exists(getcwd()."/ui/frontend/".$this->f3->get('PARAMS.page').".html")) {   
            echo($this->tmp->render("frontend/".$this->f3->get('PARAMS.page').".html"));
          } else {
            $this->f3->reroute('/404');
          }
	}
}
