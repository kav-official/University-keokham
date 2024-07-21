<?php
class ProductListController extends BaseController {

    private $f3;
    private $secur;
    private $custom;
    public $db;
    function __construct(){
        $this->f3    = Base::instance();
        $this->db    = DBConfig::config();
        $this->secur = new CustomSecurity();
        $this->secur->security();
        $this->custom = new CustomFunctions();
        $this->help   = new HelpFunctions();

        $cateArr=[];
        $suppArr=[];

        $category = $this->help->getSQL("SELECT * FROM tblcategory",[]);
        foreach ($category as $value) {
            $cateArr[$value['id']] = $value['name'];
        }
        $supplier = $this->help->getSQL("SELECT * FROM tblsupplyer",[]);
        foreach ($supplier as $value) {
            $suppArr[$value['id']] = $value['name'];
        }

        
        $this->f3->set('arrCategory',$cateArr);
        $this->f3->set('arrSupplier',$suppArr);
	    parent::__construct('ProductServices', 'backend/product-list.html', 'product', 'product-list', 'ສິນຄ້າ', '', '', $this->f3->get('ITEM_PER_PAGE'));
    }
}