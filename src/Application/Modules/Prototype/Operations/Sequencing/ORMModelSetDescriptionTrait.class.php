<?php

namespace Sequode\Application\Modules\Prototype\Operations\Sequencing;

trait ORMModelSetDescriptionTrait {
    
    public static function updateDescription($description, $_model = null){
        
        $modeler = static::$modeler;
        $kit = static::$kit;
        
        ($_model == null)
            ? forward_static_call_array(array($modeler, 'model'), array())
            : forward_static_call_array(array($modeler, 'model'), array($_model)) ;
            
        $description = htmlentities(strip_tags($description), ENT_NOQUOTES);
        $description = (strlen($description) <= 1000) ? $description : substr($description, 0, 1000);
        $detail = json_decode($modeler::model()->detail);
        $detail->description = $description;
        
        $modeler::model()->updateField(json_encode($detail),'detail');
            
        return $modeler::model();
            
    }
    
}