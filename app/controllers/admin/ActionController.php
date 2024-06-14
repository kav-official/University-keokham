<?php
class ActionController
{
	private $f3,$fileName, $nav, $subnav, $strAction,$Svr;

	function __construct($serviceName, $fileName, $nav, $subnav, $strAction)
	{
		$this->f3 = Base::instance();
		$this->tmp = new Template;
		$objectReflection = new ReflectionClass($serviceName);
		$this->Svr = $objectReflection->newInstanceArgs(array($this->db));
		$this->nav = $nav;
		$this->subnav = $subnav;
		$this->strAction = $strAction;
		$this->fileName = $fileName;
	}

	public function edit()
	{
		$id = $this->f3->get('PARAMS.id');
        if ($id == null)
        {
        	$this->f3->set('strAction',"ເພີ່ມ ".$this->strAction);
        	$this->f3->set('method', 'POST');
        } else {
    	   $this->f3->set('strAction',"ແກ້ໄຂ ".$this->strAction);
    	   $this->f3->set('method', 'PUT');
        }
        $this->f3->set('nav', $this->nav);
        $this->f3->set('subnav', $this->subnav);
		$this->f3->set('strPage', $this->strAction);
        $this->f3->set('id', $id);
        $this->f3->set('item',$this->Svr->getById($id));
        echo($this->tmp->render($this->fileName));

	}

	public function profile()
	{
		$id = $this->f3->get('LOGON_USER_ID');
		$this->f3->set('strAction', $this->strAction);
		$this->f3->set('method', 'put');
		$this->f3->set('nav', $this->nav);
		$this->f3->set('subnav', $this->subnav);
		$this->f3->set('strPage', $this->strAction);
		$this->f3->set('id', $id);
		$this->f3->set('item', $this->Svr->getById($id));
		echo($this->tmp->instance()->render($this->fileName));
	}
	public function delete()
	{
		$id = $this->f3->get('PARAMS.id');
		if ($this->Svr->delete($id)) {
			$this->data = ['success' => true, 'message' => 'Delete Success!'];
		} else {
			$this->data = ['success' => false, 'message' => 'Something went wrong!'];
		}
		API::success($this->data);
	}

	public function access()
	{
		$data = $this->f3->get('BODY');
		parse_str($data, $post_vars);
		$id = $post_vars["id"];
		$active = $post_vars["active"] == 0 ? 1 : 0;
		if ($this->Svr->access($id, $active)) {
			$this->data = ['success' => true, 'message' => 'Success!'];
		} else {
			$this->data = ['success' => false, 'message' => 'Something went wrong!'];
		}
		API::success($this->data);
	}

	public function userAccess()
	{
		$data = $this->f3->get('BODY');
		parse_str($data, $post_vars);
		$id = $post_vars["id"];
		$active = $post_vars["active"] == 0 ? 1 : 0;
		if ($this->Svr->access($id, $active)) {
			$this->data = ['success' => true, 'message' => 'Success!'];
		} else {
			$this->data = ['success' => false, 'message' => 'Something went wrong!'];
		}
		API::success($this->data);
	}

	public function publish()
	{
		$data = $this->f3->get('BODY');
		parse_str($data, $post_vars);
		$id 	 = $post_vars["id"];
		$publish = $post_vars["publish"] == 0 ? 1 : 0;
		if ($this->Svr->publish($id, $publish)) {
			$this->data = ['success' => true, 'message' => 'Success!'];
		} else {
			$this->data = ['success' => false, 'message' => 'Something went wrong!'];
		}
		API::success($this->data);
	}

	public function upload()
		{
		$f3          = Base::instance();
		$path        = "uploads/image/";
		$site_domain = $f3->get('SITE_DOMAIN');
		$custom      = new CustomFunctions();
		$upload      = $custom->uploadFile($path);
		$this->data  = array('success' => false, 'file_name' => '');
		foreach($upload as $key => $value)
		{
			if($value == true) {
				$this->data = array('success' => true, 'file_name' => $site_domain.$key);
			} else {
				$this->data = array('success' => false, 'file_name' => $file);
			}
			break;
		}
		API::success($this->data);
	}

	public function orderNum()
	{
		$this->Svr->addOrderNum();
	}
	public function storeUser()
	{
		$this->Svr->add();
	}

	public function storeProfile()
	{
		$this->Svr->addProfile();
	}
	public function storeCategory()
	{
		$this->Svr->add();
	}
	public function storeSupplier()
	{
		$this->Svr->add();
	}
	public function storeProduct()
	{
		$this->Svr->add();
	}
	public function storeOrder()
	{
		$this->Svr->add();
	}
	public function storeImport()
	{
		$this->Svr->add();
	}
	public function orderData()
	{
		$this->Svr->getData();
	}
}