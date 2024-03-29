<?php

namespace Sequode\Application\Modules\Package\Components;

use Sequode\Application\Modules\Package\Module;
use Sequode\Component\Form as FormComponent;

class Forms {
    
    const Module = Module::class;

    public static function name($_model = null){

        extract((static::Module)::variables());
        
        $_o = FormComponent::formObject();
        $_o->form_inputs = FormComponent::formInputs($component_form_inputs, __FUNCTION__, func_get_args());
        $_o->submit_xhr_call_route = $module::xhrOperationRoute('updateName');
        $_o->auto_submit_time = 2000;
        $_o->submit_xhr_call_parameters = [];
        $_o->submit_xhr_call_parameters[] = $modeler::model()->id;
        $_o->submit_xhr_call_parameters[] = FormComponent::Input_Object_Placeholder;
        
		return $_o;
        
	}
    
    public static function packageSequode($_model = null){

        extract((static::Module)::variables());

        $_o = FormComponent::formObject();
        $_o->form_inputs = FormComponent::formInputs($component_form_inputs, __FUNCTION__, func_get_args());
        $_o->submit_xhr_call_route = $module::xhrOperationRoute('updatePackageSequode');;
        $_o->auto_submit_time = 1;
        $_o->submit_xhr_call_parameters = [];
        $_o->submit_xhr_call_parameters[] = $modeler::model()->id;
        $_o->submit_xhr_call_parameters[] = FormComponent::Input_Object_Placeholder;
        
		return $_o;
        
	}
    
    public static function search(){

        extract((static::Module)::variables());

        $_o = FormComponent::formObject();
        $_o->form_inputs = FormComponent::formInputs($component_form_inputs, __FUNCTION__, func_get_args());
        $_o->submit_xhr_call_route = $module::xhrOperationRoute(__FUNCTION__);
        $_o->auto_submit_time = 1;
        
		return $_o;
        
	}

}