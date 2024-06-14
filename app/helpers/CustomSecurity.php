<?php
class CustomSecurity
{
	private $f3,$tmp,$db,$Svr;
	function __construct()
	{
		$this->f3 = Base::instance();
		$this->tmp = new Template;
		$this->db = DBConfig::config();
		$this->Svr = new UserServices($this->db);
	}
	
	function security()
	{
		$this->f3->set('error',$this->f3->get('GET.error') != null ? $this->f3->get('GET.error') : null);
		$this->f3->set('success',$this->f3->get('GET.success') != null ? $this->f3->get('GET.success') : null);
		$this->f3->set('SITE_NAME',$this->f3->get('SITE_NAME'));
		if ($this->f3->get('COOKIE.user_id') == null) {
			echo($this->tmp->instance()->render('backend/login.html'));
			die();
		} else {
			$LOGON_ID  = $this->f3->get('COOKIE.user_id');
			$LOGON_KEY = $this->f3->get('COOKIE.key');
			$LOGONITEM = $this->Svr->getUser($LOGON_ID);
			if ($LOGONITEM != null) {
				if(md5($LOGONITEM->id . $this->f3->get('HASH_SECRET')) == $LOGON_KEY)
				{
					$this->f3->set('LOGON_USER_ID', $LOGONITEM->id);
					$this->f3->set('LOGON_USER_NAME', $LOGONITEM->full_name);
					$this->f3->set('LOGON_USER_ROLE', $LOGONITEM->role);
				} else {
					$this->f3->clear('COOKIE.user_id');
					$this->f3->clear('COOKIE.key');
					echo($this->tmp->instance()->render('backend/login.html'));
					die();
				}
			} else {
				$this->f3->clear('COOKIE.user_id');
				$this->f3->clear('COOKIE.key');
				echo($this->tmp->instance()->render('backend/login.html'));
				die();
			}
		}
	}
}