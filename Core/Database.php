<?php

namespace Core;

use PDO;

/**
 * Database wrapper for the framework.
 */
class Database
{
	/**
	 * Properties
	 */
	private $db = null;
	private $stmt = null;


	/**
	 * Constructor creating a PDO object connecting to database
	 * 
	 * @param array $options database connection details
	 */
	public function __construct()
	{
		$this->db = self::getDB();
	}


	/**
	 * Get the database connection
	 * 
	 * @return mixed
	 */
	protected static function getDB() {
		static $db = null;

		if ($db === null) {

			try{
				$db = new PDO(
					DB_DNS, 
					DB_USER,
					DB_PASSWORD,
					DB_DRIVER_OPTIONS 
				);
			} catch (\Exception $e) {
				throw new \PDOException('Could not connect to database');
			}

			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, DB_FETCH_STYLE);
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


			return $db;
		}
	}


	/**
	 * Get table name
	 * 
	 * @return string table name
	 */
	public function getSource()
	{
		return strtolower(implode('', array_slice(explode('\\', get_class($this)), -1))) . "s";
	}


	/**
	 * Find and return all
	 * 
	 * @return default obj, may return other format if PDO fetch style is changed
	 */
	public function findAll($fetchStyle = null)
	{
		$this->select()
			->from($this->getSource());

		$this->execute();
		return $this->fetchAll($fetchStyle);
	}


	/**
	 * Find and return specific record by id
	 * 
	 * @param  integer $id
	 * 
	 * @return default obj, may return other format if PDO fetch style is changed
	 */
	public function find($id)
	{
		$this->select()
			->from($this->getSource())
			->where("id = {$id}");

		$this->execute();
		return $this->fetchOne();
	}


	/**
	 * Creates new or updates record 
	 * 
	 * @param  array $columns key/value columns
	 * 
	 * @return boolean TRUE on success, else FALSE
	 */
	public function save($columns)
	{
		if(isset($columns['id'])) {
			return $this->update($columns);
		} else {
			return $this->create($columns);
		}
	}


	/**
	 * Creates new record 
	 * 
	 * @param  array $columns key/value columns
	 * 
	 * @return boolean TRUE on success, else FALSE
	 */
	public function create($columns)
	{
		$keys	= array_keys($columns);
		$values = array_values($columns);

		$this->buildInsertQuery(
			$this->getSource(),
			$keys
		);

		$result = $this->execute($values);

		return $result;
	}


	/**
	 * Updates record 
	 * 
	 * @param  array $columns key/value columns
	 * 
	 * @return boolean TRUE on success, else FALSE
	 */
	public function update($columns)
	{
		$id = $columns['id'];
		unset($columns['id']);

		$keys	= array_keys($columns);
		$values = array_values($columns);

		$values[] = $id;

		$this->buildUpdateQuery(
			$this->getSource(),
			$keys,
			"id = ?"
		);

		$result = $this->execute($values);

		return $result;
	}


	/**
	 * Fetch all records
	 * 
	 * @param class $fetchStyle pdo fetch style settings
	 * 
	 * @return default obj, may return other format if PDO fetch style is changed
	 */
	public function fetchAll($fetchStyle = null)
	{
		return $this->stmt->fetchAll($fetchStyle);
	}


	/**
	 * Fetch one record
	 * 
	 * @param class $fetchStyle pdo fetch style settings
	 * 
	 * @return default obj, may return other format if PDO fetch style is changed
	 */
	public function fetchOne($fetchStyle = null)
	{
		return $this->stmt->fetch();
	}


	/**
	 * Execute a sql query and ignores the records
	 *
	 * @param  array $params key/value columns
	 * 
	 * @return boolean TRUE on success, else FALSE
	 */
	public function execute($query = null, $params = [])
	{
		if (!$query) {
			$query = $this->getSQL();
		} elseif (is_array($query)) {
			$params = $query;
			$query = $this->getSQL();
		}

		try {
			$this->stmt = $this->db->prepare($query);
			$result = $this->stmt->execute($params);
		} catch (\Exception $e) {
			throw new \PDOException('Could not execute query');
		}

		return $result;
	}


	/**
	 * Get sql
	 * 
	 * @return string sql query
	 */
	public function getSQL()
	{
		if ($this->sql) {
			return $this->sql;
		} else {
			return $this->buildSelectQuery();
		}
	}


	/**
	 * Build sql insert query 
	 * 
	 * @param  string $table table name
	 * @param  array $columns key/value columns
	 * @param  string $where where condition
	 * 
	 * @return void
	 */
	public function buildInsertQuery($table, $columns) {

		$cols = null;
		$vals = null;

		foreach ($columns as $col) {
			$cols .= $col . ', ';
			$vals .= '?, ';
		}

		$cols = substr($cols, 0, -2);
		$vals = substr($vals, 0, -2);

		$this->sql = "INSERT INTO "
			. $table
			. "\n\t("
			. $cols
			. ")\n"
			. "\tVALUES\n\t("
			. $vals
			. ");\n";
	}


	/**
	 * Build sql update query 
	 * 
	 * @param  string $table table name
	 * @param  array $columns key/value columns
	 * @param  string $where where condition
	 * 
	 * @return void
	 */
	public function buildUpdateQuery($table, $columns, $where = null) {

		$cols = null;

		foreach ($columns as $col) {
			$cols .= $col . ' = ?, ';
		}

		$cols = substr($cols, 0, -2);

		$this->sql = "UPDATE "
			. $table
			. "\nSET\n"
			. $cols
			. "\nWHERE "
			. $where
			. "\n;\n";
	}


	/**
	 * Build sql select query 
	 * 
	 * @return string sql query
	 */
	protected function buildSelectQuery()
	{
		$sql = "SELECT\n\t"
			. $this->columns . "\n"
			. $this->from . "\n"
			. ($this->where ? $this->where . "\n" : null)
			. ";";

		return $sql;
	}


	/**
	 * Clear all previous sql code
	 * 
	 * @return void
	 */
	protected function clear()
	{
		$this->sql 		= null;
		$this->columns 	= null;
		$this->from 	= null;
		$this->where 	= null;
	}


	/**
	 * Build a select query
	 * 
	 * @param  string $columns select columns
	 * 
	 * @return $this
	 */
	public function select($columns = '*')
	{
		$this->clear();
		$this->columns = $columns;

		return $this;
	}


	/**
	 * Build the from part, in select query
	 * 
	 * @param  string $table name of table
	 * 
	 * @return $this
	 */
	public function from($table)
	{
		$this->from = "FROM " . $table;

		return $this;
	}


	/**
	 * Build the where part, in select query
	 * 
	 * @param  string $condition
	 * 
	 * @return $this
	 */
	public function where($condition)
	{
		$this->where = "WHERE \n\t(" . $condition . ")";
		
		return $this;
	}
}