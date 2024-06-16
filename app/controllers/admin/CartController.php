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

    function addToCart() {
        $help         = new HelpFunctions();
        $barcode      = $this->f3->get('PARAMS.barcode');

        if(is_numeric($barcode)){
            $item = $help->getByOne('ProductServices',array('barcode = ?',$barcode));
        } else {
            $item = [];
        }

        if($item != null){
            $price      = $item->sale_price;
            $qty        = 1;
            $barcode    = $item->barcode;
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

                // $arrUnit  = array();
                $base_qty = 1;
                foreach($items as $Row){
                    // $arrUnit[] = array('id' => $Row['id'], 'unit_name' => $Row['unit_name']);
                    // if($arrPrdUnit[$key]  == $Row['id']){  
                        // $base_qty    = $Row['base_qty'];
                    //     $base_price  = $Row['price'];
                    // }
                }

                $arr[] = array('barcode' => $key, 'product_name' => $Row['product_name'] ?? '-','cate_name' => $Row['cate_name'] ?? '-','qty' => $value, 'sale_price' => number_format($arrPrdPrice[$key]),'total_price' => number_format($value*$arrPrdPrice[$key]), 'action' => 'sell');
                $total_amount += $value*$arrPrdPrice[$key];
                $total_qty    += 1;
            }
        }
        
        $this->data = array(
            'success' => true, 
            'data' => $arr,
            'total_amount' => number_format($total_amount,2), 
            'total_qty' => $total_qty,
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
        $barcode = $this->f3->get('PARAMS.barcode');
        // $action = $this->f3->get('GET.action');
        // if($action == 'sell')
        // {
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
        // } else {
        //     $arrPrdNo = $this->f3->get('SESSION.ARR_BONUS_PRD_NO');
        //     $arrPrdUnit = $this->f3->get('SESSION.ARR_BONUS_PRD_UNIT');
            
        //     unset($arrPrdNo[$product_no]);
        //     unset($arrPrdUnit[$product_no]);

        //     if(count($arrPrdNo) > 0)
        //     {
        //         $this->f3->set('SESSION.ARR_BONUS_PRD_NO',$arrPrdNo);
        //         $this->f3->set('SESSION.ARR_BONUS_PRD_UNIT',$arrPrdUnit);
        //     } else {
        //         $this->f3->clear('SESSION.ARR_BONUS_PRD_NO');
        //         $this->f3->clear('SESSION.ARR_BONUS_PRD_UNIT');
        //     }
        // }

        $this->data = array('success' => true);
        API::success($this->data);
    }
}