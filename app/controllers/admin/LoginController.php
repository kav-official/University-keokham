<?php
class LoginController
{
	private $f3,$tmp,$db,$Svr,$accesslog,$data;

	function __construct()
	{
		$this->f3 = Base::instance();
		$this->tmp = new Template;
		$this->db = DBConfig::config();
		$objectReflection = new ReflectionClass("UserServices");
		$this->Svr = $objectReflection->newInstanceArgs(array($this->db));
		$UserAccessLog = new ReflectionClass("AccessServices");
		$this->accesslog = $UserAccessLog->newInstanceArgs(array($this->db));
	}

	public function login()
	{
		$txtEmail = $this->f3->get('POST.email');
		$txtPassword = $this->f3->get('POST.password');
		$result = $this->Svr->getEmail($txtEmail);
		if ($result != null)
		{
			if ($result->password == crypt($txtPassword, $result->password))
			{
				$this->f3->set('COOKIE.user_id', $result->id);
				$this->f3->set('COOKIE.key', md5($result->id . $this->f3->get('HASH_SECRET')), 0, "/");
				$this->Svr->loginDateTime($result->id);
				$this->accesslog->add($result->id, $result->role, 1);
				$this->data = [
					'success' => true,
					'message' => 'Login success!',
				];
			} else {
				$this->accesslog->add($result->id, $result->role, 0);
				$this->data = [
					'success' => false,
					'message' => 'Invalid email/password!',
				];
			}
		} else {
			$this->data = [
				'success' => false,
				'message' => 'Invalid email/password!',
			];
		}
		API::success($this->data);
	}

	function logout()
	{
		$this->f3->clear('COOKIE.user_id');
		$this->f3->clear('COOKIE.key');
		$this->f3->reroute('/?success=You are logged out!');
	}
}