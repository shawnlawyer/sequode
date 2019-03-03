<?php

namespace Sequode\Application\Modules\Package;

use Sequode\Model\Database\SQL\ORM;

class Model extends ORM {
    public $database_connection     =   'accounts_database';
	public $table 					=	'packages';
	public function __construct() {
		parent::__construct();
		return true;
	}
	public function create(){
		$sql = "
			INSERT INTO {$this->table}
		 	(`id`,`sequode_id`,`owner_id`,`name`,`token`,`routes`)
			VALUES
		 	(0
			,0
			,0
			,'New Package'
            ,".$this->safedSQLData(sha1(substr(md5(uniqid(rand(), true)), 0, 25)), 'text')."
            ,'{}'
            )
			";
		$this->database->query($sql);
        $this->__set('id', $this->database->insertId);
        return $this;
	}
}