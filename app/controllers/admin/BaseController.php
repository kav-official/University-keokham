<?php
class BaseController
{
	private $f3, $tmp, $Svr, $fileName, $nav, $subnav, $strAction, $strWhere, $strOrder, $limit;

	function __construct($serviceName, $fileName, $nav, $subnav, $strAction, $strWhere, $strOrder, $limit)
	{
		$this->f3 = Base::instance();
		$this->tmp = new Template;
		if ($serviceName != null) {
			$objectReflection = new ReflectionClass($serviceName);
			$this->Svr = $objectReflection->newInstanceArgs(array($this->db));
		}

		$this->nav = $nav;
		$this->subnav = $subnav;
		$this->strAction = $strAction;
		$this->fileName = $fileName;
		$this->strWhere = $strWhere;
		$this->strOrder = $strOrder;
		$this->limit = $limit;
	}

	public function index()
	{
		if ($this->f3->get('GET.pg') == null) {
			$page_number = 1;
		} else {
			$page_number = $this->f3->get('GET.pg');
		}

		$previous_page = $page_number - 1;
		$next_page = $page_number + 1;

		$where = $this->strWhere != '' ? $where = $this->strWhere : array();
		$limit = $this->f3->get('GET.limit') != null ? $this->f3->get('GET.limit') : $this->limit;

		if($this->strOrder != '')
		{
			$order = array("order"=>$this->strOrder,"limit"=>$limit,"offset"=>($page_number - 1)*$limit);
		} else {
			$order = array("order"=>'created_at DESC',"limit"=>$limit,"offset"=>($page_number-1)*$limit);
		}

		$entrycount = $this->Svr->countAll($where);

		$pages = ceil($entrycount/$limit);

		$doublePrevious = '';
		$singlePrevious = array();
		$PreviousStart = array();
		$arrPagination = array();
		$nexPage = array();
		$singleNexPage = array();
		$doubleNexPage = array();

		if ($pages > 1) {
			$start = (($page_number - 7) > 0) ? $page_number - 7 : 1;
			$end = (($page_number + 7) < $pages) ? $page_number + 7 : $pages;

			if ($previous_page < 1) {
				$doublePrevious = "disabled";
			} else {
				$doublePrevious = "";
			}

			if ($previous_page < 1) {
				$singlePrevious = array('pg' => '', 'class' => 'disabled');
			} else {
				$singlePrevious = array('pg' => $previous_page, 'class' => '');
			}

			if ($start > 1) {
				$PreviousStart = array('pg' => 1);
			}

			for ($i = $start; $i <= $end; $i++) {
				if ($i == $page_number) {
					$arrPagination[] = array('pg' => $i, 'class' => 'active');
				} else {
					$arrPagination[] = array('pg' => $i, 'class' => '');
				}
			}

			if ($end < $pages) {
				$nexPage = array('pg' => $pages);
			}

			if ($next_page > $pages) {
				$singleNexPage = array('pg' => '', 'class' => 'disabled');
			} else {
				$singleNexPage = array('pg' => $next_page, 'class' => '');
			}

			if ($next_page > $pages) {
				$doubleNexPage = array('pg' => $pages, 'class' => 'disabled');
			} else {
				$doubleNexPage = array('pg' => $pages, 'class' => '');
			}
		}

		if (!is_numeric($page_number)) {
			$this->f3->reroute('/admin');
			exit();
		}

		$items = $this->Svr->getAll($where, $order);

		$this->f3->set('items', $items);
		$this->f3->set('doublePrevious', $doublePrevious);
		$this->f3->set('singlePrevious', $singlePrevious);
		$this->f3->set('PreviousStart', $PreviousStart);
		$this->f3->set('arrPagination', $arrPagination);
		$this->f3->set('nexPage', $nexPage);
		$this->f3->set('singleNexPage', $singleNexPage);
		$this->f3->set('doubleNexPage', $doubleNexPage);
		$this->f3->set('limit', $limit);
		$this->f3->set('nav', $this->nav);
		$this->f3->set('subnav', $this->subnav);
		$this->f3->set('entrycount', $entrycount);
		$this->f3->set('strPage', $this->strAction);
		$this->f3->set('strAction', $this->strAction);
		echo($this->tmp->instance()->render($this->fileName));
	}
}