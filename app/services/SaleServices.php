<?php
class SaleServices extends BaseServiceReadBean
{
	private $f3;
	private $data,$help;
	private $Svr,$listSvr;
	public $tbl;
	function __construct($db)
	{
		$this->f3 = Base::instance();
		$this->tbl = "tblsale";
		parent::__construct($db,$this->tbl);
	}
	
    function addSale(){
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $id           = $this->f3->get('POST.id');
            $barcode      = $this->f3->get('POST.barcode');
            $product_name = $this->f3->get('POST.product_name');
            $qty          = $this->f3->get('POST.qty');
            $category     = $this->f3->get('POST.category');
            $price        = $this->f3->get('POST.price');
            $total_amount = $this->f3->get('POST.total_amount');
            $cash         = $this->f3->get('POST.cash');
            $onepay       = $this->f3->get('POST.onepay');
            
                if($cash){
                    $payment_type = 'Cash';
                }else if($onepay){
                    $payment_type = 'Onepay';
                }

                $file_content = file_get_contents("uploads/bill.txt");
                $split = explode(" ", $file_content);
                if(date('Y') > $split[1]) 
                {
                    $handle = fopen('uploads/bill.txt','w');
                    fwrite($handle,"1 ".date('Y'));
                    $bill_no = "IV-".substr(date('Y'),-2) . '-1';
                } else {
                    $handle = fopen('uploads/bill.txt','w');
                    fwrite($handle,($split[0]+1)." ".$split[1]);
                    $bill_no = "IV-".substr($split[1],-2) . '-'.$split[0];
                }
           
				 
                $this->bill_no      = $bill_no;
                $this->barcode      = $barcode;
                $this->employee     = $this->f3->get('LOGON_USER_NAME');
                $this->total_amount = str_replace(",","",$total_amount);
                $this->payment_type = $payment_type;
                $this->save();

				$sale_id = $this->get('_id');

                foreach($barcode as $key => $value)
                {
					$listSvr = new SaleDetailServices($this->db);
					$listSvr->reset();
					$listSvr->sale_id      = $sale_id;
					$listSvr->bill_no      = $bill_no;
					$listSvr->category     = $category[$key];
					$listSvr->product_name = $product_name[$key];
					$listSvr->barcode      = $value;
					$listSvr->qty          = $qty[$key];
					$listSvr->price        = str_replace(",","",$price[$key]);
					$listSvr->save();
                }

                $this->f3->clear('SESSION.ARR_PRD_NO');
                $this->f3->clear('SESSION.ARR_PRD_PRICE');

                $this->data = ['success'=>true,'message'=>'ສັ່ງຊື້ສຳເລັດແລ້ວ','bill_no'=>$bill_no];
                // $this->data = ['success'=>true,'message'=>$product_name];

            API::success($this->data);
        }
    }
}