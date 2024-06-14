<?php
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
class APIController{
    function __construct(){
        $this->f3   = Base::instance();
        $this->db   = DBConfig::config();
        $this->help = new HelpFunctions();
    }
}
