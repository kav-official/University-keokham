<?php
class UserServices extends BaseServiceReadBean
{
	private $f3;
	private $data;
	private $Svr;
	public $tbl;

	function __construct($db)
	{
		$this->f3 = Base::instance();
		$this->tbl = "tbluser";
		parent::__construct($db,$this->tbl);
	}

	function add()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$full_name       	= $this->f3->get('POST.full_name');
			$email            	= $this->f3->get('POST.email');
			$password         	= $this->f3->get('POST.password');
			$role             	= $this->f3->get('POST.role');
			
			$this->full_name 	= $full_name;
			$this->email      	= $email;
			$this->password   	= PasswordHash::hashing($password);
			$this->role      	= $role;
			$this->created_at 	= time();
			$this->login_date 	= time();
			$this->save();
			$this->data = ['success' => true, 'message' =>$full_name.' ເພີມແລ້ວ'];
	
		}

		if ($_SERVER['REQUEST_METHOD'] == 'PUT') 
		{
			$data = $this->f3->get('BODY');
			parse_str($data, $post_vars);
			$id               	= $post_vars['id'];
			$full_name       	= $post_vars['full_name'];
			$email            	= $post_vars['email'];
			$password         	= $post_vars['password'];
			$role            	= $post_vars['role'];
			
			$this->Svr =$this->load(['id = ?',$id]);
			$this->Svr->full_name 		= $full_name;
			$this->Svr->email      		= $email;
			$this->Svr->password   		= PasswordHash::hashing($password);
			$this->Svr->updated_at 		= time();
			$this->Svr->role 		    = $role;
			$this->Svr->update();

			$this->data = ['success' => true, 'message' =>$full_name.' ແກ້ໄຂແລ້ວ'];
		
		}

		API::success($this->data);
	}


	function appUpdate(){
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $Svr             = new UserServices($this->db);
        $data            = array();
        $data            = json_decode(file_get_contents('php://input'), true);
        $_id             = $data['id'];
        $name            = $data['fullname'];
        $email           = $data['email'];
        $password        = $data['password'];
        $confirmpassword = $data['confirmpassword'];

		http_response_code(200);
		$this->load(['id=?',$_id]);
		$this->full_name = $name;
		$this->email     = $email;
		$this->update();
		$data = ['success' => true, 'message' => 'Updated Success',];
      }
       API::success($data);
	}


	function access($id,$active)
	{
		$this->load(array('id = ?',$id));
		$this->active = $active;
		return $this->update();
	}

	function addProfile()
	{
		if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
			$data = ($this->f3->get('BODY'));
			parse_str($data, $post_vars);
			$id               = $post_vars['id'];
			$full_name        = $post_vars['full_name'];
			$email            = $post_vars['email'];
			$password         = $post_vars['password'];

			$this->Svr = $this->load(array('id = ?',$id));
			$this->Svr->full_name  = $full_name;
			$this->Svr->email      = $email;
			$this->Svr->password   = PasswordHash::hashing($password);
			$this->Svr->update();

			$this->data = ['success' => true,'message' => 'Profile ແກ້ໄຂແລ້ວ'];
			
		}
		API::success($this->data);
	}


	function getEmail($email)
	{
		return $this->load(['email = ? AND active = ?',$email,1]);
	}

	function getUser($id)
	{
		return $this->load(['id = ? AND active = ?',$id,1]);
	}

	function loginDateTime($id)
	{
		$this->load(['id = ?', $id]);
		$this->login_date = time();
		return $this->update();
	}
}