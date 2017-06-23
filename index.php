<?php

class dbConfig
{
	private $host = "localhost";
	private $username = "root";
	private $password = "";
	private $database = "test";

	protected $connection;

	public function __construct()
	{
		$this->connection = new mysqli($this->host,$this->username,$this->password,$this->database);
		if (!$this->connection) {
			echo "tidak bisa terhubung ke database";
			exit;
		}
		return $this->connection;
	}
}

class crud extends dbConfig
{
	public function __construct()
	{
		parent::__construct();
	}

	public function create($table,$data)
	{
		$data = array_map("mysql_escape_string", $data);
		$columns = implode(",",array_keys($data));
		$values = implode("','",array_values($data));
		$query = "INSERT INTO $table ($columns) VALUES ('$values')";
		$result = $this->connection->query($query);
		if (!$result) {
			echo "Tidak bisa memasukan data ke database";
			return false;
		}
		else{
			echo "Sukses memasukan data ke database";
			return true;
		}
	}

	public function read($query)
	{
		$result = $this->connection->query($query);
		if (!$result) {
			echo "Tidak bisa mengambil data";
			return false;
		}

		$rows = array();

		while ($row = $result->fetch_array())
		{
			$rows[] = $row;
		}
		return $rows;
	}

	public function update($table,$id,$data)
	{
		$data = array_map("mysql_escape_string", $data);
		$query = "UPDATE $table SET ";
		foreach ($data as $key => $value) {
			$query .= $key."='".$value."',";
		}
		$query = trim($query,',');
		$query .= " WHERE id = $id";
		$result = $this->connection->query($query);
		if (!$result) {
			echo "Tidak bisa mengupdate data ke database";
			return false;
		}
		else{
			echo "Sukses mengupdate data ke database";
			return true;
		}
	}
	
	public function delete($table,$id)
	{
		$query = "DELETE FROM $table where id = $id";
		$result = $this->connection->query($query);
		if (!$result) {
			echo "Gagal menghapus data";
			return false;
		}
		else{
			echo "Sukses menghapus data";
			return true;
		}
	}
}

$crud = new crud();

// CREATE
// $table = "users";
// $data = array(
// 	'id' => 100,
// 	'name' => 'umaru',
// 	'age' => 17,
// 	'email' => 'umaru@unpak.ac.id'
// 	);
// $crud->create($table,$data);

// READ
// $query = "SELECT * FROM users";
// $result = $crud->read($query);
// foreach ($result as $key => $data) {
// 	echo $data['id']." ".$data['name']." ".$data['age'].'<br>';
// }

// UPDATE
// $table = "users";
// $id = 100;
// $data = array(
// 	'name' => 'update',
// 	'age' => 99,
// 	'email' => 'update'
// 	);
// $crud->update($table,$id,$data);

// DELETE
// $table = "users";
// $id = 100;
// $crud->delete($table,$id);

//jondes2017 1.0
?>