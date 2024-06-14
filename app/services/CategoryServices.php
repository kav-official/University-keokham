<?php
class CategoryServices extends BaseServiceReadBean
{
	private $f3;
	private $data;
	private $Svr;
	public $tbl;

	function __construct($db)
	{
		$this->f3 = Base::instance();
		$this->tbl = "tblcategory";
		parent::__construct($db,$this->tbl);
	}

	function add()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$name = $this->f3->get('POST.name');
			
			$this->name = $name;
			$this->save();
			$this->data = ['success' => true, 'message' =>$name.' ເພີມແລ້ວ'];
	
		}
		if ($_SERVER['REQUEST_METHOD'] == 'PUT') 
		{
			$data = $this->f3->get('BODY');
			parse_str($data, $post_vars);
			$id   = $post_vars['id'];
			$name = $post_vars['name'];
			
			$this->Svr       = $this->load(['id = ?',$id]);
			$this->Svr->name = $name;
			$this->Svr->update();

			$this->data = ['success' => true, 'message' =>$name.' ແກ້ໄຂແລ້ວ'];
		
		}

		API::success($this->data);
	}


}