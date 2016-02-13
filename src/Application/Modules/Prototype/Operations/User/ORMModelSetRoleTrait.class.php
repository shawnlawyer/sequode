<?php

namespace Sequode\Application\Modules\Prototype\Operations\User;

trait ORMModelSetRoleTrait {
    
    public static function updateRole($role_model = null, $_model = null){
        $modeler = static::$modeler;
        
        if($role_model == null ){ $role_model = \SQDE_Role::model(); }
        
        ($_model == null)
            ? forward_static_call_array(array($modeler,'model'),array())
            : forward_static_call_array(array($modeler,'model'),array($_model)) ;
            
        $modeler::model()->updateField($role_model->id, 'role_id')
        
        return $modeler::model();
    }
    
}