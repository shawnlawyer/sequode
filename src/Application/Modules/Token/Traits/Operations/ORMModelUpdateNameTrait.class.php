<?php

namespace Sequode\Application\Modules\Token\Traits\Operations;

trait ORMModelUpdateNameTrait {
    
    public static function updateName($name, $_model = null){
        
        $modeler = static::$modeler;
        
        ($_model == null)
            ? forward_static_call_array(array($modeler, 'model'), array())
            : forward_static_call_array(array($modeler, 'model'), array($_model)) ;
            
        $modeler::model()->updateField(str_replace(" ","_",$name),'name');
        
        return $modeler::model();
        
    }
    
}