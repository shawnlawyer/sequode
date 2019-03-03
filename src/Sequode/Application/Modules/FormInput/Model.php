<?php

namespace Sequode\Application\Modules\FormInput;

use Sequode\Model\Database\SQL\ORM;

class Model extends ORM {
    
    public $database_connection     =   'system_database';
	public $table 				    =	'components';
	public function __construct() {
		parent::__construct();
		return true;
	}
    
	public function create($name = '', $printable_name = '', $usage_type = ''){
		$sql = "
			INSERT INTO {$this->table}
			(`id`,`name`,`printable_name`,`usage_type`)
			VALUES
		 	(''
			,".$this->database->safeData($name, "text")."
			,".$this->database->safeData($printable_name, "text")."
			";
		$this->database->query($sql);
        $this->__set('id', $this->database->insertId);
        return $this;
	}
    
}
