<?php
class ProductServices extends BaseServiceReadBean
{
	private $f3;
	private $data;
	private $Svr;
	public $tbl;

	function __construct($db)
	{
		$this->f3 = Base::instance();
		$this->tbl = "tblproduct";
		parent::__construct($db,$this->tbl);
	}

	function add()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$image       = $this->f3->get('POST.image');
			$barcode     = $this->f3->get('POST.barcode');
			$product_no  = $this->f3->get('POST.product_no');
			$category_id = $this->f3->get('POST.category_id');
			$supplier_id = $this->f3->get('POST.supplier_id');
			$name        = $this->f3->get('POST.name');
			$qty         = $this->f3->get('POST.qty');
			$base_price  = $this->f3->get('POST.base_price');
			$sale_price  = $this->f3->get('POST.sale_price');
			
			$this->image       = $image;
			$this->barcode     = $barcode;
			$this->product_no  = $product_no;
			$this->category_id = $category_id;
			$this->supplier_id = $supplier_id;
			$this->name        = $name;
			$this->qty         = $qty;
			$this->base_price  = $base_price;
			$this->sale_price  = $sale_price;
			$this->save();
			$this->data = ['success' => true, 'message' =>$name.' ເພີມແລ້ວ'];
	
		}
		if ($_SERVER['REQUEST_METHOD'] == 'PUT') 
		{
			$data = $this->f3->get('BODY');
			parse_str($data, $post_vars);
			$id          = $post_vars['id'];
			$image       = $post_vars['image'];
			$barcode     = $post_vars['barcode'];
			$product_no  = $post_vars['product_no'];
			$category_id = $post_vars['category_id'];
			$supplier_id = $post_vars['supplier_id'];
			$name        = $post_vars['name'];
			$qty         = $post_vars['qty'];
			$base_price  = $post_vars['base_price'];
			$sale_price  = $post_vars['sale_price'];
			
			$this->Svr              = $this->load(['id = ?',$id]);
			$this->Svr->image       = $image;
			$this->Svr->barcode     = $barcode;
			$this->Svr->product_no  = $product_no;
			$this->Svr->category_id = $category_id;
			$this->Svr->supplier_id = $supplier_id;
			$this->Svr->name        = $name;
			$this->Svr->qty         = $qty;
			$this->Svr->base_price  = $base_price;
			$this->Svr->sale_price  = $sale_price;
			$this->Svr->update();

			$this->data = ['success' => true, 'message' =>$name.' ແກ້ໄຂແລ້ວ'];
		
		}

		API::success($this->data);
	}


}