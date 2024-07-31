<?php
class AdminController
{
	private $f3,$tmp,$db,$secur,$Svr,$memSvr;

	function __construct()
	{
		$this->db = DBConfig::config();
		$secur    = new CustomSecurity();
		$secur->security();
	}

	function index() {
		$f3  = Base::instance();
		$tmp = new Template;
		$Svr = new SaleServices($this->db);
		$day = date('Y-m-d');
		$dateNow = date('Y-m');

		$total_amount_day   = 0;
		$total_amount_month = 0;
		$total_amount_year  = 0;

		$daySale = $Svr->getSQL('SELECT * FROM tblsale WHERE DATE(created_at) = ?',[$day]);
		foreach ($daySale as $value) {
			$total_amount_day += $value['total_amount'];
		}
		$monthSale = $Svr->getSQL('SELECT * FROM tblsale WHERE SUBSTRING(created_at,1,7) = ?',[$dateNow]);
		foreach ($monthSale as $value) {
			$total_amount_month += $value['total_amount'];
		}
		$yearSale = $Svr->getSQL('SELECT * FROM tblsale WHERE YEAR(created_at) = ?',[$day]);
		foreach ($yearSale as $value) {
			$total_amount_year += $value['total_amount'];
		}

		$f3->set('total_amount_day', $total_amount_day);
		$f3->set('total_amount_month', $total_amount_month);
		$f3->set('total_amount_year', $total_amount_year);
		$f3->set('nav', 'home');
		$f3->set('subnav', '');
		$f3->set('strAction', 'Dashboard');
		$f3->set('strPage', 'Home');
		echo($tmp->instance()->render('backend/index.html'));
	}
}
