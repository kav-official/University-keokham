<?php
class SaleController extends ActionController {
    private $f3;
    private $secur;
    private $custom;
    public $db;
    function __construct(){
        $this->f3 = Base::instance();
        $this->db = DBConfig::config();
        $this->secur = new CustomSecurity();
        $this->secur->security();
        $this->custom = new CustomFunctions();
	    parent::__construct('SaleServices', 'backend/sale.html', 'sale', 'sale', 'ຂາຍສີນຄ້າ');
    }

    function saleBill(){
        $custom = new CustomFunctions();
        $help   = new HelpFunctions();

        $items = $help->getSQL('SELECT * FROM tblsaledetail WHERE bill_no = ?',[$this->f3->get('PARAMS.bill_no')]);
        $item  = $help->getByOne('SaleServices',['bill_no=?',$this->f3->get('PARAMS.bill_no')]);
        $this->f3->set('nav','sale');
        $this->f3->set('subnav','sale');
        $this->f3->set('items',$items);
        $this->f3->set('item',$item);
        $this->f3->set('custom',$custom);
        $this->f3->set('help',$help);
        echo $this->tmp->render('backend/sale-bill.html');
    }
}