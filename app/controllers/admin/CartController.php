<?php
class CartController
{
    private $f3;
    private $db;
    private $secur;
    private $Svr;
    private $data;
    private $help;
    function __construct()
    {
        $this->f3 = Base::instance();
        $this->db = DBConfig::config();
        $this->secur = new CustomSecurity();
        $this->secur->security($this->db);
        $this->help = new HelpFunctions();
    }
// ||||||||||||||||||||||||||||||||||||||||||||||||||| START ORDER ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    function addOrder(){
        $help       = new HelpFunctions();
        $product_no = $this->f3->get('PARAMS.product_no');
        $qty        = $this->f3->get('PARAMS.qty');

        if($product_no){
            $item = $help->getByOne('ProductServices',array('product_no = ?',$product_no));
        } else {
            $item = [];
        }

        if($item != null){
            $qty        = $qty;
            $product_no = $item->product_no;
        }else{
            API::success(array('success' => false,'message'=>'ບໍພົບລະຫັດສິນຄ້ານີ້'));
        }

        $action = 'all';
        if($this->f3->get('SESSION.ARR_ORDER_NO') != null){
            $arrPrdNo = $this->f3->get('SESSION.ARR_ORDER_NO');
        } else {
            $arrPrdNo = array();
        }

         if($product_no != null ){
                $have = false;
                foreach($arrPrdNo as $key => $value){
                    if($key == $product_no){
                        $have = true;
                        break;
                    }
                }
                if($have){
                    if($arrPrdNo[$product_no] == 0){
                        $arrPrdNo[$product_no] = 1;
                    } else {
                        if($action == 'update'){
                            $arrPrdNo[$product_no] = $qty;
                        } else {
                            $arrPrdNo[$product_no] = $arrPrdNo[$product_no]+$qty > 0 ? $arrPrdNo[$product_no]+$qty : 1;
                        }
                    }
                } else {
                    $arrPrdNo[$product_no] = $qty;
                }
          
            $this->f3->set('SESSION.ARR_ORDER_NO',$arrPrdNo);
        }
        API::success(array('success' => true));
    }

    function orderListData(){
        $Svr       = new ProductServices($this->db);
        $help      = new HelpFunctions();
        $arrPrdNo  = $this->f3->get('SESSION.ARR_ORDER_NO');
        $arr       = array();
        $total_qty = 0;

        if($arrPrdNo != null){
            foreach($arrPrdNo as $key => $value){
                $items = $Svr->getSQL('SELECT tblproduct.* FROM tblproduct WHERE product_no = ? ',array($key));
                foreach($items as $Row){
                    $arr[] = array('product_no' => $key,'name' => $Row['name'],'qty' => $value);
                } 
                
            }
        }
        
        API::success(array('success' => true,'data' =>$arr));
    }

    function removeOrder(){
        $product_no = $this->f3->get('PARAMS.product_no');
        $arrPrdNo   = $this->f3->get('SESSION.ARR_ORDER_NO');
        
        unset($arrPrdNo[$product_no]);

        if(count($arrPrdNo) > 0)
        {
            $this->f3->set('SESSION.ARR_ORDER_NO',$arrPrdNo);
        } else {
            $this->f3->clear('SESSION.ARR_ORDER_NO');
        }

        $this->data = array('success' => true,'data'=>$product_no);
        API::success($this->data);
    }

// ||||||||||||||||||||||||||||||||||||||||||||||||||| START SALE ||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    function addToCart() {
        $help    = new HelpFunctions();
        $barcode = $this->f3->get('PARAMS.barcode');

        if(is_numeric($barcode)){
            $item = $help->getByOne('ProductServices',array('barcode = ?',$barcode));
        } else {
            $item = [];
        }

        if($item != null){
            $price   = $item->sale_price;
            $qty     = 1;
            $barcode = $item->barcode;
        }else{
            API::success(array('success' => false,'message'=>'ບໍພົບລະຫັດສິນຄ້ານີ້'));
        }


        $action = 'all';
        if($this->f3->get('SESSION.ARR_PRD_NO') != null && $this->f3->get('SESSION.ARR_PRD_PRICE') != null){
            $arrPrdNo    = $this->f3->get('SESSION.ARR_PRD_NO');
            $arrPrdPrice = $this->f3->get('SESSION.ARR_PRD_PRICE');
        } else {
            $arrPrdNo    = array();
            $arrPrdPrice = array();
        }

        if($barcode != null && $price != null){
            if(count($arrPrdNo) > 0 && count($arrPrdPrice) > 0){
                $have = false;
                foreach($arrPrdNo as $key => $value){
                    if($key == $barcode){
                        $have = true;
                        break;
                    }
                }
                if($have){
                    if($arrPrdNo[$barcode] == 0 && $qty < 0){
                        $arrPrdNo[$barcode] = 1;
                    } else {
                        if($action == 'update'){
                            $arrPrdNo[$barcode] = $qty;
                        } else {
                            $arrPrdNo[$barcode] = $arrPrdNo[$barcode]+$qty > 0 ? $arrPrdNo[$barcode]+$qty : 1;
                        }
                    }
                } else {
                    $arrPrdNo[$barcode]    = $qty;
                    $arrPrdPrice[$barcode] = $price;
                }
            } else {
                $arrPrdNo[$barcode]      = $qty;
                $arrPrdPrice[$barcode]   = $price;
            }
            $this->f3->set('SESSION.ARR_PRD_NO',$arrPrdNo);
            $this->f3->set('SESSION.ARR_PRD_PRICE',$arrPrdPrice);
        }
        API::success(array('success' => true, 'cart_count' => count($arrPrdNo)));
    }
    function cartData(){
        $Svr         = new ProductServices($this->db);
        $help        = new HelpFunctions();

        $arrPrdNo    = $this->f3->get('SESSION.ARR_PRD_NO');
        $arrPrdPrice = $this->f3->get('SESSION.ARR_PRD_PRICE');

        $arr          = array();
        $total_amount = 0;
        $total_qty    = 0;
        $base_price   = 0;

        if($arrPrdNo != null){
            foreach($arrPrdNo as $key => $value){
                $items = $Svr->getSQL('SELECT tblproduct.name as product_name,tblproduct.sale_price,tblcategory.name as cate_name
                FROM tblproduct INNER JOIN tblcategory ON(tblproduct.category_id = tblcategory.id) WHERE tblproduct.barcode = ? ',array($key));

                $base_qty = 1;
                foreach($items as $Row){}

                $arr[] = array('barcode' => $key, 'product_name' => $Row['product_name'] ?? '-','cate_name' => $Row['cate_name'] ?? '-','qty' => $value, 'sale_price' => number_format($arrPrdPrice[$key]),'total_price' => number_format($value*$arrPrdPrice[$key]), 'action' => 'sell');
                $total_amount += $value*$arrPrdPrice[$key];
                $total_qty    += 1;
            }
        }
        
        $this->data = array(
            'success'               => true,
            'data'                  => $arr,
            'total_amount'          => number_format($total_amount),
            'total_amount_exchange' => $total_amount,
            'total_qty'             => $total_qty,
        );
        API::success($this->data);
    }
    function cartCount(){
        $cart_count = 0;
        if($this->f3->get('SESSION.ARR_PRD_NO') != null)
        {
            $cart_count = count($this->f3->get('SESSION.ARR_PRD_NO'));
        }
        API::success(array('success' => true, 'cart_count' => $cart_count));
    }
    function removeCart(){
        $barcode     = $this->f3->get('PARAMS.barcode');
        $arrPrdNo    = $this->f3->get('SESSION.ARR_PRD_NO');
        $arrPrdPrice = $this->f3->get('SESSION.ARR_PRD_PRICE');
        
        unset($arrPrdNo[$barcode]);
        unset($arrPrdPrice[$barcode]);

        if(count($arrPrdNo) > 0)
        {
            $this->f3->set('SESSION.ARR_PRD_NO',$arrPrdNo);
            $this->f3->set('SESSION.ARR_PRD_PRICE',$arrPrdPrice);
        } else {
            $this->f3->clear('SESSION.ARR_PRD_NO');
            $this->f3->clear('SESSION.ARR_PRD_PRICE');
        }

        $this->data = array('success' => true);
        API::success($this->data);
    }
}