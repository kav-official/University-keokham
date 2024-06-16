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
		$help    	= new HelpFunctions();
		$product_no = $this->f3->get('PARAMS.product_no');
		$qty		= $this->f3->get('PARAMS.qty');
		$items   	= $help->getSQL('SELECT * FROM tblproduct WHERE product_no =?',[$product_no]);
		$check      = $this->load(['product_no =?',$product_no]);
		$arr     	= [];

		$file_content = file_get_contents("uploads/invoice.txt");
		$split = explode(" ", $file_content);
		if(date('Y') > $split[1]) 
		{
			$handle = fopen('uploads/invoice.txt','w');
			fwrite($handle,"1 ".date('Y'));
			$order_no = "MT-".substr(date('Y'),0) . '-1';
		} else {
			$handle = fopen('uploads/invoice.txt','w');
			fwrite($handle,($split[0])." ".$split[1]);
			$order_no = "MT-".substr($split[1],-2) . '-'.$split[0];
		}
		if($check){
			foreach ($items as $row) {
				$this->order_no    = $order_no;
				$this->product_no  = $row['product_no'];
				$this->total_qty   = $qty;
				$this->employee    = $this->f3->get('LOGON_USER_NAME');
				$this->update();
			}
		}else{
			foreach ($items as $row) {
				$this->order_no    = $order_no;
				$this->product_no  = $row['product_no'];
				$this->total_qty   = $qty;
				$this->employee    = $this->f3->get('LOGON_USER_NAME');
				$this->save();
			}
		}

		$itemTable  = $help->getSQL('SELECT tblorder.order_no,tblorder.product_no,tblorder.total_qty,tblproduct.name FROM tblorder INNER JOIN tblproduct ON(tblorder.product_no=tblproduct.product_no) WHERE tblorder.order_no =?',[$check->order_no]);
		if($itemTable){
			foreach ($itemTable as $row) {
				$arr[]=[
					'order_no'   => $row['order_no'],
					'product_no' => $row['product_no'],
					'name'       => $row['name'],
					'qty'        => $row['total_qty'],
				];
			}
		}
		API::success(['success'=>true,'data'=>$arr,'message'=>'ສັ່ງຊື້ສຳເລັດແລ້ວ']);
	}

	function updateBill(){
		$file_content = file_get_contents("uploads/invoice.txt");
		$split = explode(" ", $file_content);
		if(date('Y') > $split[1]) 
		{
			$handle = fopen('uploads/invoice.txt','w');
			fwrite($handle,"1 ".date('Y'));
			$order_no = "MT-".substr(date('Y'),0) . '-1';
		} else {
			$handle = fopen('uploads/invoice.txt','w');
			fwrite($handle,($split[0]+1)." ".$split[1]);
			$order_no = "MT-".substr($split[1],-2) . '-'.$split[0];
		}
		API::success(['success'=>true]);
	}

	function deleteOrder(){
		$help    	= new HelpFunctions();
		$product_no = $this->f3->get('PARAMS.product_no');
		$this->db->exec("DELETE FROM tblorder WHERE product_no = ?",array($product_no));
		API::success(['success'=>true,'message'=>'Deleted']);
	}
}