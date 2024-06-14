<?php
class ImportDetailServices extends BaseServiceReadBean
{
	private $f3;
	private $data;
	private $Svr;
	public $tbl;

	function __construct($db)
	{
		$this->f3 = Base::instance();
		$this->tbl = "tblimportdetail";
		parent::__construct($db,$this->tbl);
	}
}