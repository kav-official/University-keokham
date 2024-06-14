<?php
class HelpFunctions
{

    private $f3;
    public $db;
    function __construct()
	{
		$this->f3 = Base::instance();
        $this->db = DBConfig::config();
	}

    function getByOne($serviceName,$options)
    {
        $objectReflection = new ReflectionClass($serviceName);
		$Svr = $objectReflection->newInstanceArgs(array($this->db));
        return $Svr->load($options);
    }

     public function getById($serviceName,$id) {
        $objectReflection = new ReflectionClass($serviceName);
        $Svr = $objectReflection->newInstanceArgs(array($this->db));
    	return $Svr->load(array('id = ?',$id));
    }
    
    function getTitle($serviceName,$options,$callback)
    {
        $objectReflection = new ReflectionClass($serviceName);
		$Svr = $objectReflection->newInstanceArgs(array($this->db));
        $item = $Svr->load($options);
        return $item->$callback;
    }

    function getFind($serviceName,$options)
    {
        $objectReflection = new ReflectionClass($serviceName);
		$Svr = $objectReflection->newInstanceArgs(array($this->db));
        return $Svr->find($options);
    }

    function getSQL($sql,$options=array())
    {
        return $this->db->exec($sql,$options);
    }

}
