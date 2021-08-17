<?php

class DB
{
	const TABLE_NAME = 'public.conversions';
	private $db;

	public function __construct()
	{
		$dsn = 'pgsql:dbname=testdb;user=testuser;password=testpassword;host=db';
		$this->db = new PDO($dsn);
	}

	public function save($saveData)
	{
		$fieldList = array_keys($saveData);
		array_pop($fieldList);
		$valueList = array_values($saveData);

		if ($saveData['id'] == 0) {
			$countFields = count($fieldList);
			$sql = 'insert into ' . self::TABLE_NAME . ' (' . implode(',', $fieldList) . ') ' .
				'values (' . implode(',', array_fill(0, $countFields, '?')) . ')';
			array_pop($valueList);
		} else {
			$sql = 'update ' . self::TABLE_NAME . ' set ' .
				implode(',', array_map(fn($item) => $item . '=?', $fieldList)) .
				' where id = ?';
		}
		$query = $this->db->prepare($sql);
		$query->execute($valueList);

		return $saveData['id'] != 0 ? $saveData['id'] : $this->db->lastInsertId();
	}
}