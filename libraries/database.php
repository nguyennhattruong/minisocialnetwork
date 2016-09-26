<?php

defined('ACCESS_SYSTEM') or die;

import('app/database');

class Database
{
	private $conn;

	/**
	 * Connect to the database
	 *
	 * @return false on failure / MySQLi object on success
	 */
	public function open()
	{
		$this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		$this->conn->set_charset('utf8');
		// Check connection
		if ($this->conn->connect_error) {
		    die('Connection failed: ' . $this->conn->connect_error);
		}
	}

	/**
	 * Query the database
	 *
	 */
	public function executeNonQuery($query)
	{
		// Connect to the database
		$this->open();

		$result = mysqli_query($this->conn, $query);

		$this->close();

		return $result;
	}

	/**
	 * Select query
	 *
	 * @return array
	 */
	public function executeQuery($query)
	{
		$this->open();

		$rows = array();
        $result = mysqli_query($this->conn, $query);
        if ($result === false) {
            return false;
        }
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
        $this->close();
        return $rows;
	}

	public function executeScalar($query)
	{
		$this->open();
		$result = mysqli_query($this->conn, $query);
		$row =  mysqli_fetch_row($result);

		$this->close();
		return $row[0];
	}

	public function quote($value)
	{
        return $this->conn->real_escape_string($value);
    }

	public function close()
	{
		mysqli_close($this->conn);
	}
}

?>