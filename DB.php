<?php 

class DB {

	private $pdo;

	public function __construct($host, $dbname, $user, $password) {
		$pdo = new PDO ('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $user, $password);
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->pdo = $pdo;
	}

	public function query($query, $params = array(), $post = false) {
		$statement = $this->pdo->prepare($query);
		$ret = $statement->execute($params);
                
                if ($ret and ($post == true)) {
                        return true;
                } else if ($post == true) {
                        return false;
                }

		if (explode(' ', $query)[0] == 'SELECT') {
			$data = $statement->fetchAll(PDO::FETCH_ASSOC);
			return $data;
		}
	}
}