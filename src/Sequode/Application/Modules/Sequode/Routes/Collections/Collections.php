<?php

namespace Sequode\Application\Modules\Sequode\Routes\Collections;

use Sequode\Application\Modules\Session\Store as SessionStore;
use Sequode\Application\Modules\Sequode\Module;
use Sequode\Application\Modules\Account\Authority as AccountAuthority;
use Sequode\Application\Modules\Account\Modeler as AccountModeler;
use Sequode\Application\Modules\Traits\Routes\Collections\CollectionsOwnedTrait;
use Sequode\Application\Modules\Traits\Routes\Collections\CollectionsSearchTrait;
use Sequode\Application\Modules\Traits\Routes\Collections\CollectionsFavoritesTrait;

class Collections{

    use CollectionsOwnedTrait,
        CollectionsSearchTrait,
        CollectionsFavoritesTrait;

    const Module = Module::class;

	public static $merge = false;

	public static $routes = [
		'sequodes',
		'sequodes_owned',
		'sequode_search',
		'sequode_favorites',
		'palette',
    ];

    const Routes = [
		'sequodes',
		'sequodes_owned',
		'sequode_search',
		'sequode_favorites',
		'palette',
    ];

	public static $routes_to_methods = [
		'sequodes' => 'sequodes',
		'sequodes_owned' => 'owned',
		'sequode_search' => 'search',
		'sequode_favorites' => 'favorites',
		'palette' => 'palette',
    ];

    const Method_To_Collection = [
        'sequodes' => 'sequodes',
        'owned' => 'sequodes_owned',
        'search' => 'sequode_search',
        'favorites' => 'sequode_favorites',
        'palette' => 'palette'
    ];

	public static function sequodes($key = null){

        extract((static::Module)::variables());

        $_model = new $modeler::$model;
        
        if($key == null){
            
            if(AccountAuthority::isSystemOwner()){
                
                $where = [];

                $_model->getAll($where,'id, process_description_node');

                $nodes = [];

                foreach($_model->all as $object){

                    $nodes[] = '"' . $object->id . '":' . $object->process_description_node;

                }
                
            }else{
                
                $nodes = [];

                $where = [];

                $where[] = ['field'=>'owner_id','operator'=>'!=','value'=>AccountModeler::model()->id];

                $where[] = ['field'=>'shared','operator'=>'=','value'=>'1'];

                $_model->getAll($where,'id, process_description_node');

                foreach($_model->all as $object){

                    $nodes[] = '"' . $object->id . '":' . $object->process_description_node;

                }

                $where = [];

                $where[] = ['field'=>'owner_id','operator'=>'=','value'=>AccountModeler::model()->id];

                $_model->getAll($where,'id, process_description_node');

                foreach($_model->all as $object){

                    $nodes[] = '"' . $object->id . '":' . $object->process_description_node;

                }
                
            }
            
            echo  '{';
            echo  "\n";
            if(0 < count($nodes)){
                echo  implode(",\n", $nodes);
            }
            
            echo  "\n";
            echo  '}';
            return;
            
        }elseif(
            $modeler::exists($key,'id')
            && AccountAuthority::canView($modeler::model())
        ){

            echo json_encode($modeler::model()->process_description_node);
            return;
            
        }else{
            
            echo  '{}';
            return;
            
        }
	}

    /*
	public static function palette(){

        extract((static::Module)::variables());

        if(in_array(SessionStore::get(__FUNCTION__),static::$routes)){
            $method = static::$routes_to_methods[static::$routes];
            self::$method();
            return;
        }
        $nodes = array();
        $collection = __FUNCTION__;
        if(SessionStore::is($collection)){
            $_array = SessionStore::get($collection);
            foreach($_array as $_object){
                $nodes[] = '"'.$_object->id.'":{"id":"'.$_object->id.'","n":"'.$_object->name.'"}';
            }
        }
        echo '{'.implode(',', $nodes).'}';
        return;
	}
    */

	public static function palette(){

        extract((static::Module)::variables());

        if(SessionStore::get('palette') == 'sequode_search'){

            self::search();

        }elseif(SessionStore::get('palette') == 'sequode_favorites'){

            self::favorited();

        }elseif(SessionStore::is('palette')){

            $sequode_model = new $modeler::$model;

            $sequode_model->exists(SessionStore::get('palette'),'id');

            $sequence = array_unique($sequode_model->sequence);

            $nodes = [];

            foreach($sequence as $id){

                $sequode_model->exists($id,'id');

                $nodes[] = '"'.$sequode_model->id.'":{"id":"'.$sequode_model->id.'","n":"'.$sequode_model->name.'"}';

            }

            echo '{'.implode(',', $nodes).'}';

        }else{

            echo '{}';

        }

	}

}