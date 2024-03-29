<?php

namespace Sequode\Application\Modules\Token\Components;

use Sequode\Application\Modules\FormInput\Modeler as FormInputModeler;

use Sequode\Application\Modules\Token\Module;

class FormInputs{
    
    const Module = Module::class;
    
    public static function name($_model = null){
        extract((static::Module)::variables());
        
        $_model = forward_static_call_array([$modeler, 'model'], ($_model == null) ? [] : [$_model]);
        $_o = (object) null;
        
        FormInputModeler::exists('str','name');
        $_o->name = FormInputModeler::model()->component_object;
        $_o->name->Label = '';
        $_o->name->Value = $_model->name;
        $_o->name->Width = 200;
        $_o->name->CSS_Class = 'focus-input';
        
		return $_o;
        
	}
    
    public static function search(){
        
        $_o = (object) null;
        
        FormInputModeler::exists('str','name');
        $_o->search = FormInputModeler::model()->component_object;
        $_o->search->Label = '';
        $_o->search->Value = '';
        $_o->search->Width = 200;
        $_o->search->CSS_Class = 'focus-input';
        
        FormInputModeler::exists('select','name');
        $_o->position = FormInputModeler::model()->component_object;
        $_o->position->Label = '';
        $_o->position->Values = "[{'value':'=%','printable':'Starts With'},{'value':'%=%','printable':'Contains'},{'value':'%=','printable':'Ends With'},{'value':'=','printable':'Exact'}]";
        $_o->position->Value = '=%';
        $_o->position->Value_Key = 'value';
        $_o->position->Printable_Key = 'printable';
        
		return $_o;
        
	}
}