<?php 

defined('ACCESS_SYSTEM') or die;

class QueryBuilder
{
	private $db;
	private $_sql     = '';
    private $_select  = 'SELECT * FROM ';
    private $_join    = '';
    private $_where   = '';
    private $_set     = '';
    private $_orderBy = '';
    private $_limit   = '';

    public function __construct() 
    {
        $this->db = new Database();
    }

    /* Execute Query */
    protected function executeNonQuery($query) 
    {
        //echo $query;
    	$result = $this->db->executeNonQuery($query);
        $this->clean();
        return $result;
    }

    protected function executeQuery($query) 
    {
        //echo $query . '<br><br>';
    	$result = $this->db->executeQuery($query);
        $this->clean();
        return $result;
    }

    protected function executeScalar($query) 
    {
    	$result = $this->db->executeScalar($query);
        $this->clean();
        return $result;
    }

	/* Simple Query */
	public function getItem($list)
    {
        if (count($list) > 0)
            return $list[0];

        return null;
    }

    public function select()
    {
    	$arr = func_get_args();

        $this->_select = 'SELECT ';
        if (count($arr) > 0)
        {
            foreach ($arr as $item)
            {
                $this->_select .= '' . $item . ', ';
            }
            $len = strlen($this->_select);
            $this->_select = substr($this->_select, 0, $len - 2) . ' FROM ';
        }
        else 
        {
            $this->_select = 'SELECT * FROM ';
        }
    }

    protected function getOperator($var) 
    {
        $arr = array();
        $arr[0] = $var[0];
        $arr[1] = '=';

        if (isset($var[2])) {
            $arr[1] = $var[1];
            $arr[2] = $var[2];
        } else {
            $arr[2] = $var[1];
        }
        return $arr;
    }

    public function where($var, $var1 = null, $var2 = null)
    {
        $field = '';
    	$operator = '=';
        $value = '';

    	if (trim($this->_where) == '')
        	$this->_where = ' WHERE 1 = 1 ';

        if (!is_array($var)) {
            $oper = $this->getOperator([$var, $var1, $var2]);
        	$this->_where .= sprintf(" AND %s %s '%s'", $oper[0], $oper[1], $oper[2]);
        } else {
            foreach ($var as $item) {
                $oper = $this->getOperator($item);
                $this->_where .= sprintf(" AND %s %s '%s'", $oper[0], $oper[1], $oper[2]);
            }
        }
    }

    public function whereRaw($str)
    {
        if (trim($this->_where) == '')
            $this->_where = ' WHERE 1 = 1 ';
        $this->_where .= ' ' . $str;
    }

    public function join($table, $id1, $id2)
    {
        $this->_join .= ' INNER JOIN `' . $table . '` ON ' . $id1 . ' = ' . $id2 . ' ';
    }

    public function limit($start, $limit)
    {
        $this->_limit = ' LIMIT ' . $start . ',' . $limit;
    }

    public function orderBy($var, $var1 = null)
    {
    	$str = '';
    	$arr = array();

    	if (isset($var1)) {
        	$this->_orderBy = sprintf(" ORDER BY %s %s", $var, $var1);
        } else {
            foreach ($var as $item)
            {
                $arr[] = sprintf(" %s %s", $item[0], $item[1]);
            }

            $this->_orderBy = sprintf(" ORDER BY %s", implode(',', $arr));
        }
    }

    public function set($var, $var1 = null)
    {
        $arr = array();
        
        if (isset($var1)) {
        	$this->_set = sprintf(" SET `%s` = '%s' ", $var, $var1);
        } else {
        	foreach ($var as $key => $value)
            {
                $arr[] = sprintf("`%s` = '%s'", $key, $this->quote($value));
            }

            $this->_set = sprintf(" SET %s", implode(',', $arr));
        }
    }

    public function setRaw($str)
    {
        if (trim($this->_set) == '')
            $this->_where = ' SET ';
        $this->_where .= $str . ' ';
    }

    /* Query */
    public function scalar($table)
    {
        $query = 'SELECT COUNT(*) FROM ' . $table . $this->_where;
        return $this->executeScalar($query);
    }

    public function find($table, $pk, $id)
    {
        $query = $this->_select . $table . ' WHERE ' . $pk . ' = ' . $id;
        $list = $this->executeQuery($query);
        return $this->getItem($list);
    }

    public function findBy($table)
    {
        $query = $this->_select . $table. $this->_join . $this->_where . $this->_orderBy . $this->_limit;
        return $this->executeQuery($query);
    }

    public function findSingle($table)
    {
        $query = $this->_select . $table. $this->_join . $this->_where . $this->_orderBy . $this->_limit;
        $list = $this->executeQuery($query);
        return $this->getItem($list);
    }

    public function query($query) 
    {
        return $this->executeQuery($query);
    }

    public function getSQL($table)
    {
        return $this->_select . $table. $this->_join . $this->_where . $this->_orderBy . $this->_limit;
    }

    public function findFirst($table)
    {
        $query = $this->_select . $table . ' WHERE 1';
        $list = $this->executeQuery($query);
        return $this->getItem($list);
    }

    public function findAll($table)
    {
        $query = $this->_select . $table . $this->_orderBy;
        return $this->executeQuery($query);
    }

    public function has($table)
    {
        $query = $this->_select . $table. $this->_join . $this->_where . ' LIMIT 1';
        $result = $this->executeQuery($query);
        if (empty($result)) {
            return false;
        } else {
            return true;
        }
    }

    public function insert($table, $arr)
    {
    	$query = '';
    	
		$into = array();
        $values = array();

        foreach ($arr as $key => $value)
        {
            $into[]   = '`' . $key . '`';
            $values[] = "'" . $this->quote($value) . "'";
        }

        $query = sprintf('INSERT INTO %s (%s) VALUES (%s)', $table, implode(',', $into), implode(',', $values));
	    return $this->executeNonQuery($query);
    }

    /**
     * Update
     * @param  array   $arr Array field and value belong
     * @param  integer $id  Primary. If 0 then update the first record
     * @return bool
     */
    public function update($table, $arr, $pk, $id = 0)
    {
        $this->set($arr);
        $query = 'UPDATE ' . $table . $this->_set;
        if ($id == 0)
            $query .= ' WHERE 1';
        else
            $query .= ' WHERE ' . $pk . ' = ' . $this->quote($id);
        return $this->executeNonQuery($query);
    }

    /**
     * Delete
     * @param  string  $table
     * @param  string  $field
     * @param  id 	   $param
     * @return bool
     */
    public function delete($table, $field, $param)
    {
        $pa = $this->quoteList($table, $field, $param);
        $query = sprintf('DELETE FROM %s WHERE `%s` = %s', $pa[0], $pa[1], $pa[2]);
        return $this->executeNonQuery($query);
    }

    /**
     * Clean attributes after each query
     */
    public function clean()
    {
        $this->_sql = '';
        $this->_select = 'SELECT * FROM ';
        $this->_join = '';
        $this->_where = '';
        $this->_set = '';
        $this->_orderBy = '';
        $this->_limit = '';
    }

    public function quoteList() 
    {
        $arr = func_get_args();
        foreach ($arr as $item) {
            $item = $this->quote($item);
        }
        return $arr;
    }

    public function quote($value) 
    {
        return htmlentities((addslashes(trim($value))));
    }
}

?>