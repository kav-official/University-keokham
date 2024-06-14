<?php
use \RedBeanPHP\R as R;
class DBConfig {
    public static function config() {
        $f3=Base::instance();
        $db=new DB\SQL(
            $f3->get('db_dns') . $f3->get('db_name'),
            $f3->get('db_user'),
            $f3->get('db_pass')
        );
       return $db;
    }
}
