<?php
class ReportController
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

	function product() {
        $Svr = new ProductServices($this->db);
        $help   = new HelpFunctions();

        $cateArr=[];
        $suppArr=[];

        $category = $help->getSQL("SELECT * FROM tblcategory",[]);
        foreach ($category as $value) {
            $cateArr[$value['id']] = $value['name'];
        }
        $supplier = $help->getSQL("SELECT * FROM tblsupplyer",[]);
        foreach ($supplier as $value) {
            $suppArr[$value['id']] = $value['name'];
        }
        $this->f3->set('arrCategory',$cateArr);
        $this->f3->set('arrSupplier',$suppArr);

		$this->f3->set('entrycount', $Svr->countAll([]));
		$this->f3->set('items', $Svr->getSQL('SELECT tblproduct.*,tblcategory.name as category FROM tblproduct INNER JOIN tblcategory ON(tblproduct.category_id=tblcategory.id)',[]));
		$this->f3->set('nav', 'report-product');
		$this->f3->set('subnav', 'report-product');
		$this->f3->set('strAction', 'Report Product');
		$this->f3->set('strPage', 'Report Product');
		echo($this->tmp->instance()->render('backend/report-product.html'));
	}

	function expirtDate(){
		$Svr = new ProductServices($this->db);
        $help   = new HelpFunctions();

        $cateArr=[];
        $suppArr=[];

        $category = $help->getSQL("SELECT * FROM tblcategory",[]);
        foreach ($category as $value) {
            $cateArr[$value['id']] = $value['name'];
        }
        $this->f3->set('arrCategory',$cateArr);
		$this->f3->set('entrycount', $Svr->countAll([]));
		$this->f3->set('items', $Svr->getSQL('SELECT tblproduct.*,tblcategory.name as category FROM tblproduct INNER JOIN tblcategory ON(tblproduct.category_id=tblcategory.id) WHERE tblproduct.date_expirt <= ?',[date('Y-m-d')]));
		$this->f3->set('nav', 'report-expirt-date');
		$this->f3->set('subnav', 'report-expirt-date');
		$this->f3->set('strAction', 'Report Expirt Date');
		$this->f3->set('strPage', 'Report Expirt Date');
		echo($this->tmp->instance()->render('backend/report-expirt-date.html'));
	}
	function order(){
		$Svr     = new ProductServices($this->db);
		$help    = new HelpFunctions();
		$cateArr = [];

 		$category = $help->getSQL("SELECT * FROM tblcategory",[]);
        foreach ($category as $value) {
            $cateArr[$value['id']] = $value['name'];
        }
        $this->f3->set('arrCategory',$cateArr);
		$this->f3->set('entrycount', $Svr->countAll([]));
		$this->f3->set('items', $Svr->getSQL('SELECT tblproduct.*,tblorder.*,tblcategory.id as category_name FROM tblproduct INNER JOIN tblorder ON(tblproduct.product_no=tblorder.product_no) INNER JOIN tblcategory ON (tblproduct.category_id=tblcategory.id)',[]));
		$this->f3->set('nav', 'report-order');
		$this->f3->set('subnav', 'report-order');
		$this->f3->set('strAction', 'Report Order');
		$this->f3->set('strPage', 'Report Order');
		echo($this->tmp->instance()->render('backend/report-order.html'));
	}
	function sale(){
		$Svr     = new ProductServices($this->db);
		$help    = new HelpFunctions();

		$this->f3->set('entrycount', $Svr->countAll([]));
		$this->f3->set('items', $Svr->getSQL('SELECT * FROM tblsale',[]));
		$this->f3->set('nav', 'report-sale');
		$this->f3->set('subnav', 'report-sale');
		$this->f3->set('strAction', 'Report Sale');
		$this->f3->set('strPage', 'Report Sale');
		echo($this->tmp->instance()->render('backend/report-sale.html'));
	}
	function billNo(){
		$custom = new CustomFunctions();
        $help   = new HelpFunctions();

        $items = $help->getSQL('SELECT * FROM tblsaledetail WHERE bill_no = ?',[$this->f3->get('PARAMS.bill_no')]);
        $item  = $help->getByOne('SaleServices',['bill_no=?',$this->f3->get('PARAMS.bill_no')]);
        $this->f3->set('nav','report-sale');
        $this->f3->set('subnav','report-sale');
        $this->f3->set('items',$items);
        $this->f3->set('item',$item);
        $this->f3->set('custom',$custom);
        $this->f3->set('help',$help);
        echo $this->tmp->render('backend/report-bill-no.html');
	}
}
