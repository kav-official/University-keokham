<?php
class BaseServiceReadBean extends DB\SQL\Mapper
{
	
	private $f3;
	function __construct($db,$tableName)
	{
		$this->f3 = Base::instance();
		parent::__construct($db,$tableName);
	}

	public function getAll($filters, $options) {
        $this->load($filters, $options);
        return $this->query;
    }

	public function getFind($options) {
        return $this->find($options);
    }

	public function getCustom($options) {
        return $this->load($options);
    }

	function getByOne($options)
	{
		return $this->load($options);
	}

	public function getSQL($sql,$options=array()) {
		if(count($options) > 0)
		{
			return $this->db->exec($sql,$options);
		} else {
			return $this->db->exec($sql);
		}
    }

	public function countAll($filters) {
        $data = $this->find($filters);
        return count($data);
    }

	public function getById($id) {
        return $this->load(array('id = ?',$id));
    }

	public function delete($id)
	{
		$this->load(array('id = ?',$id));
		return $this->erase();
	}

	function publish($id,$publish)
	{
		$this->load(array('id = ?',$id));
		$this->publish_status = $publish;
		return $this->update();
	}

	public function addOrderNum() {
        $order_num = $this->f3->get('POST.order_num');
        $response = array();
        foreach ($order_num as $key => $value) {
            if(preg_match('/^\d+$/',$value))
            {
              $this->load(['id=?',$key]);
              $this->order_num = $value;
              $this->update();
            }
          }
        $response["success"] = true;
        echo(json_encode($response)); 
    }

}