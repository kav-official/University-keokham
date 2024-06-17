<?php
class ImportServices extends BaseServiceReadBean
{
	private $f3;
	private $data;
	private $Svr;
	public $tbl;

	function __construct($db)
	{
		$this->f3 = Base::instance();
		$this->tbl = "tblimport";
		parent::__construct($db,$this->tbl);
	}

	function getData(){
		$help    = new HelpFunctions();
		$barcode = $this->f3->get('PARAMS.barcode');
		$items   = $help->getSQL('SELECT *,tblsupplyer.name as supplier ,tblorder.total_qty FROM tblproduct INNER JOIN tblsupplyer 
		ON (tblproduct.supplier_id = tblsupplyer.id)
		INNER JOIN tblorder ON(tblproduct.product_no = tblorder.product_no)
		WHERE tblproduct.barcode =?',[$barcode]);
		$arr     = [];

		foreach ($items as $row) {
			$arr[]=[
				'product_no'  => $row['product_no'],
				'name'        => $row['name'],
				'qty'         => $row['total_qty'],
				'base_price'  => $row['base_price'],
				'sale_price'  => $row['sale_price'],
				'supplier'    => $row['supplier'],
				'image' 	  => $row['image'],
			];
		}

		API::success(['success'=>true,'data'=>$arr]);
	}
	function updateQTY(){
		$help       = new HelpFunctions();
		$Svr        = new ProductServices($this->db);
		$SvrOrder   = new OrderServices($this->db);
		$product_no = $this->f3->get('PARAMS.product_no');
		$qty        = $this->f3->get('PARAMS.qty');

		$items   = $help->getSQL('SELECT tblproduct.name as product_name,tblorder.total_qty,tblorder.order_no,tblorder.employee FROM tblproduct INNER JOIN tblorder 
		ON (tblproduct.product_no = tblorder.product_no)
		WHERE tblproduct.product_no =?',[$product_no]);

		$checkImport = $this->load(['product_no =?',$product_no]);
		
		if($checkImport){

			// $SvrOrder->reset();
			$SvrOrder->total_qty = 0;
			$SvrOrder->update();
			
			foreach ($items as $value) {
				$this->product_no   = $product_no;
				$this->product_name = $value['product_name'];
				$this->order_no     = $value['order_no'];
				$this->employee     = $value['employee'];
				$this->total_qty    = $qty;
				$this->update();
			}
		}else{
			foreach ($items as $value) {
				$this->product_no   = $product_no;
				$this->product_name = $value['product_name'];
				$this->order_no     = $value['order_no'];
				$this->employee     = $value['employee'];
				$this->total_qty    = $qty;
				$this->save();
			}
		}

		$checkProduct = $Svr->load(['product_no =?',$product_no]);
		if($checkProduct){
			$Svr->qty += $qty;
			$Svr->update();
			$data = ['success'=>true,'message'=>'ນຳເຂົ້າສຳເລັດແລ້ວ'];
		}else{
			$data = ['success'=>false,'message'=>'ມີບາງຢ່າງຜິດພາດ'];
		}
		API::success($data);
	}
}