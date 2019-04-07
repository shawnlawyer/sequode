<?php

namespace Sequode\Application\Modules\Token\Routes\Collections;

use Sequode\Application\Modules\Session\Store as SessionStore;

use Sequode\Application\Modules\Token\Module;
use Sequode\Application\Modules\Account\Modeler as AccountModeler;
class Collections{
    
    public static $module = Module::class;
    const Module = Module::class;

	public static $merge = false;

	public static $routes = [
		'tokens',
		'token_search'
    ];

	public static $routes_to_methods = [
		'tokens' => 'owned',
		'token_search' => 'search',
    ];

	public static function owned(){

        extract((static::Module)::variables());

        $_model = new $modeler::$model;

        $where = [];

        $where[] = ['field'=>'owner_id','operator'=>'=','value'=> AccountModeler::model()->id];

        $_model->getAll($where, 'id,name');

        $nodes = [];

        foreach($_model->all as $object){

            $nodes[] = '"'.$object->id.'":{"id":"'.$object->id.'","n":"'.$object->name.'"}';

        }

        echo '{'.implode(',', $nodes).'}';
        
        return;
        
	}

	public static function search(){

        extract((static::Module)::variables());

        $collection = 'token_search';

        $nodes = [];

        if(SessionStore::is($collection)){

            $_array = $finder::search(SessionStore::get($collection));

            foreach($_array as $_object){

                $nodes[] = '"'.$_object->id.'":{"id":"'.$_object->id.'","n":"'.$_object->name.'"}';

            }

        }

        echo '{'.implode(',', $nodes).'}';
        
        return;
        
	}
}