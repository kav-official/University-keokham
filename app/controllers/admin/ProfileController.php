<?php
class ProfileController extends ActionController
{
  public $db;
  function __construct()
  {
    $this->db = DBConfig::config();
    $this->secur = new CustomSecurity();
    $this->secur->security();
    parent::__construct('UserServices', 'backend/profile.html', 'profile', 'profile', 'Profile');
  }
}