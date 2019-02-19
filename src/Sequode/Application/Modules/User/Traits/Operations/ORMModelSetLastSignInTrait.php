<?php

namespace Sequode\Application\Modules\User\Traits\Operations;

trait ORMModelSetLastSignInTrait {
    
    public static function updateLastSignIn($time=false, $_model = null){
        $modeler = static::$modeler;
        
        forward_static_call_array([$modeler, 'model'], ($_model == null) ? [] : [$_model]);
            
        $modeler::model()->updateField(($time === false) ? time() : $time ,'last_sign_in');
        
        return $modeler::model();
    }
    
}