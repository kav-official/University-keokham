<?php
class AccessServices extends BaseServiceReadBean
{
	private $f3;
	public $tbl;

	function __construct($db)
	{
		$this->f3 = Base::instance();
		$this->tbl = "tblaccesslog";
		parent::__construct($db,$this->tbl);
	}

	function add($id, $role, $success)
	{
		$classObject = new CustomFunctions();
		$this->user_id = $id;
		$this->type = $role;
		$this->ip_address = $classObject->get_real_ip();
		$this->login_success = $success;
		$this->date_created = time();
		return $this->save();
	}
}
