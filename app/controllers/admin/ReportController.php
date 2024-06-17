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
}
