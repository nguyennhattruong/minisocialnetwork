<?php

defined('ACCESS_SYSTEM') or die;

class Model
{
	private $builder;

    public  $table   = '';
    public  $pk      = '';

    public  $obj;
    public  $attr    = array();

    public function __construct() 
    {
        $arr = $this->info();

        $this->table = $arr['table'];
        $this->pk = $arr['pk'];

        $this->builder = new QueryBuilder();
    }

    public function attr($name, $value) 
    {
        $this->attr[$name] = $value;
    }

    /**
     * Store info table
     * @return array
     */
    public function info() 
    {
    }

    public function enableCreateTime(){
        return true;
    }

	public function __destruct() 
    {
		unset($this->builder);
	}

    public function query($sql) 
    {
        $this->obj = $this->builder->query($sql);
        return $this->obj;
    }

    public function select() 
    {
        $arr = func_get_args();
        call_user_func_array(array($this->builder, 'select'), $arr);
    }

    /*-------------------- Where ----------------------*/
    public function where($var, $var1 = null, $var2 = null) 
    {
        $this->builder->where($var, $var1, $var2);
    }

    public function whereRaw($str) 
    {
        $this->builder->whereRaw($str);
    }

    public function scalar() 
    {
        return $this->builder->scalar($this->table);
    }

    public function has() 
    {
        return $this->builder->has($this->table);
    }

    public function find($id) 
    {
        $this->obj = $this->builder->find($this->table, $this->pk, $id);
        return $this->obj;
    }

    public function findBy() 
    {
        return $this->builder->findBy($this->table);
    }

    public function findSingle() 
    {
        $this->obj = $this->builder->findSingle($this->table);
        return $this->obj;
    }

    /**
     * Save object to Database
     *
     * After execute find function then using save 
     * 
     * @return bool
     */
    public function save() 
    {
        $id = 0;

        if (!empty($this->obj)) {
            $id = $this->obj[$this->pk];
        }

        if ($id == 0) {
            if ($this->enableCreateTime()) {
                $this->attr['regist_datetime'] = date('Y-m-d H:i:s');
            }
            return $this->builder->insert($this->table, $this->attr);
        } else {
            return $this->builder->update($this->table, $this->attr, $this->pk, $id);
        }
    }

    public function destroy() 
    {
        $id = $this->obj[$this->pk];
        return $this->builder->delete($this->table, $this->pk, $id);
    }

    public static function delete($table, $pk, $id) 
    {
        $builder = new QueryBuilder();
        return $builder->delete($table, $pk, $id);
    }

    public function getSQL() 
    {
        return $this->builder->getSQL($this->table);
    }

    public function getSingle($result) 
    {
        if (!empty($result)) {
            return $result[0];
        }
        return null;
    }
}

?>