<?php
class OrderServices extends BaseServiceReadBean
{
	private $f3;
	private $data,$help;
	private $Svr,$SvrPro;
	public $tbl;
	function __construct($db)
	{
		$this->f3 = Base::instance();
		$this->tbl = "tblorder";
		parent::__construct($db,$this->tbl);
	}
	function getData(){
		$help    = new HelpFunctions();
		$barcode = $this->f3->get('PARAMS.barcode');
		$items   = $help->getSQL('SELECT * FROM tblproduct WHERE barcode =?',[$barcode]);
		$arr     = [];

		foreach ($items as $row) {
			$arr[]=[
				'product_no'  => $row['product_no'],
				'name'        => $row['name'],
				'qty'         => $row['qty'],
				'base_price'  => $row['base_price'],
				'sale_price'  => $row['sale_price'],
				'date_expirt' => $row['date_expirt'],
				'image' 	  => $row['image'],
			];
		}

		API::success(['success'=>true,'data'=>$arr]);
	}
	function addOrder(){
		 if ($_SERVER['REQUEST_METHOD'] == 'POST'){

            $product_no = $this->f3->get('POST.product_no');
            $total_qty  = $this->f3->get('POST.qty');
            
                $file_content = file_get_contents("uploads/order-bill.ini");
                $split = explode(" ", $file_content);
                if(date('Y') > $split[1]) 
                {
                    $handle = fopen('uploads/order-bill.ini','w');
                    fwrite($handle,"1 ".date('Y'));
                    $order_no = "OR-".substr(date('Y'),-2) . '-1';
                } else {
                    $handle = fopen('uploads/order-bill.ini','w');
                    fwrite($handle,($split[0]+1)." ".$split[1]);
                    $order_no = "OR-".substr($split[1],-2) . '-'.$split[0];
                }
           
				 
               

				// $sale_id = $this->get('_id');
                foreach($product_no as $key => $value)
                {
					$this->reset();
					$this->order_no   = $order_no;
					$this->product_no = $product_no[$key];
					$this->total_qty  = $total_qty[$key];
					$this->employee   = $this->f3->get('LOGON_USER_NAME');
					$this->save();
                }

                $this->f3->clear('SESSION.ARR_ORDER_NO');

                $this->data = ['success'=>true,'message'=>'ສັ່ງຊື້ສຳເລັດແລ້ວ'];
            API::success($this->data);
        }
	}

	// function updateBill(){
	// 	$file_content = file_get_contents("uploads/invoice.txt");
	// 	$split = explode(" ", $file_content);
	// 	if(date('Y') > $split[1]) 
	// 	{
	// 		$handle = fopen('uploads/invoice.txt','w');
	// 		fwrite($handle,"1 ".date('Y'));
	// 		$order_no = "MT-".substr(date('Y'),0) . '-1';
	// 	} else {
	// 		$handle = fopen('uploads/invoice.txt','w');
	// 		fwrite($handle,($split[0]+1)." ".$split[1]);
	// 		$order_no = "MT-".substr($split[1],-2) . '-'.$split[0];
	// 	}
	// 	API::success(['success'=>true]);
	// }

	// function deleteOrder(){
	// 	$help    	= new HelpFunctions();
	// 	$product_no = $this->f3->get('PARAMS.product_no');
	// 	$this->db->exec("DELETE FROM tblorder WHERE product_no = ?",array($product_no));
	// 	API::success(['success'=>true,'message'=>'Deleted']);
	// }
}