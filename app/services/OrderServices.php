<?php
class OrderServices extends BaseServiceReadBean
{
	private $f3;
	private $data,$help;
	private $Svr;
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
		$arr     	= [];

		$file_content = file_get_contents("uploads/order-bill.ini");
		$split = explode("|", $file_content);
		
		// $handle = fopen('uploads/order-bill.ini','w');
		// fwrite($handle,"2|".date('Y'));
		$order_no = "OR-".date('Y') . '-'.$split[0];
		
		// $handle = fopen('uploads/order-bill.ini','w');
		// fwrite($handle,($split[0]+1)."|".date('Y'));
		// $order_no = substr(date('Y'), -2) . '-'.$split[0];
		

		foreach ($items as $row) {
			$this->order_no    = '90';
			$this->product_no  = $row['product_no'];
			$this->total_qty   = $qty;
			$this->employee    = $this->f3->get('LOGON_USER_NAME');
			$this->save();

			$Svr = new OrderDetailServices($this->db);
			$Svr->product_no  = $row['product_no'];
			$Svr->qty         = $qty;
			$Svr->base_price  = $row['base_price'];
			$Svr->sale_price  = $row['sale_price'];
			$Svr->save();
		}
		
		
		API::success(['success'=>true,'data'=>$arr,'no'=>$order_no]);
	}
}