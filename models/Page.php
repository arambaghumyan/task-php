<?php 

namespace models;

use \PDO;

class Page {
	public $DB;

	public function setDatabase($DB) {
		$this->DB = $DB;
		return $this;
	}
	
	public function getAll(){
        $query = $this->DB->prepare('select * from pages');
        $query->execute([]);
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
        return $data;
	}
}