<?php

namespace Sequode\Application\Modules\Sequode\Components;

use Sequode\Application\Modules\FormInput\Modeler as FormInputModeler;
use Sequode\Application\Modules\Sequode\Kits\Operations as SequodeOperationsKit;

use Sequode\Application\Modules\Sequode\Authority as SequodeAuthority;
use Sequode\Application\Modules\Sequode\Modeler as SequodeModeler;
use Sequode\Application\Modules\Account\Modeler as AccountModeler;
class FormInputs {
    
    public static function name($sequode_model = null){
        
        if($sequode_model != null ){
            SequodeModeler::model($sequode_model);
        }
        
        $components_object = (object) null;
        
        FormInputModeler::exists('str','name');
        $components_object->name = FormInputModeler::model()->component_object;
        $components_object->name->Label = '';
        $components_object->name->Value = SequodeModeler::model()->name;
        $components_object->name->Width = 200;
        $components_object->name->CSS_Class = 'focus-input';
        
		return $components_object;
        
	}
    
    public static function description($sequode_model = null){
        
        if($sequode_model != null ){
            SequodeModeler::model($sequode_model);
        }
        
        $components_object = (object) null;
        
        FormInputModeler::exists('text','name');
        $components_object->description = FormInputModeler::model()->component_object;
        $components_object->description->Label = '';
        $components_object->description->Value = SequodeModeler::model()->detail->description ?: '';
        $components_object->description->Width = 30;
        $components_object->description->Height = 20;
        $components_object->description->CSS_Class = 'focus-input';
        
		return $components_object;
        
	}
    
    public static function search(){
        
        $components_object = (object) null;
        
        FormInputModeler::exists('str','name');
        $components_object->search = FormInputModeler::model()->component_object;
        $components_object->search->Label = '';
        $components_object->search->Value = '';
        $components_object->search->Width = 200;
        $components_object->search->CSS_Class = 'search-sequodes-input';
        
        FormInputModeler::exists('select','name');
        $components_object->position = FormInputModeler::model()->component_object;
        $components_object->position->Label = '';
        $components_object->position->Values = "[{'value':'=%','printable':'Starts With'},{'value':'%=%','printable':'Contains'},{'value':'%=','printable':'Ends With'},{'value':'=','printable':'Exact'}]";
        $components_object->position->Value = '=%';
        $components_object->position->Value_Key = 'value';
        $components_object->position->Printable_Key = 'printable';
        
        FormInputModeler::exists('checkboxSwitch','name');
        $components_object->coded = FormInputModeler::model()->component_object;
        $components_object->coded->Label = '';
        $components_object->coded->On_Text = 'Coded';
        $components_object->coded->On_Value = 1;
        $components_object->coded->Off_Text = 'Coded';
        $components_object->coded->Off_Value = 0;
        $components_object->coded->Value = 1;
        
        $components_object->sequenced = FormInputModeler::model()->component_object;
        $components_object->sequenced->Label = '';
        $components_object->sequenced->On_Text = 'Sequenced';
        $components_object->sequenced->On_Value = 1;
        $components_object->sequenced->Off_Text = 'Sequenced';
        $components_object->sequenced->Off_Value = 0;
        $components_object->sequenced->Value = 1;
        
        $components_object->sequodes_owned = FormInputModeler::model()->component_object;
        $components_object->sequodes_owned->Label = '';
        $components_object->sequodes_owned->On_Text = 'Owned Sequodes';
        $components_object->sequodes_owned->On_Value = 1;
        $components_object->sequodes_owned->Off_Text = 'Owned Sequodes';
        $components_object->sequodes_owned->Off_Value = 0;
        $components_object->sequodes_owned->Value = 1;
        
        $components_object->shared_sequodes = FormInputModeler::model()->component_object;
        $components_object->shared_sequodes->Label = '';
        $components_object->shared_sequodes->On_Text = 'Shared Sequodes';
        $components_object->shared_sequodes->On_Value = 1;
        $components_object->shared_sequodes->Off_Text = 'Shared Sequodes';
        $components_object->shared_sequodes->Off_Value = 0;
        $components_object->shared_sequodes->Value = 1;
        
		return $components_object;
        
	}
    
    public static function component($type, $map_key, $sequode_model = null){
        
        if($sequode_model != null ){
            SequodeModeler::model($sequode_model);
        }
        
        $default_map = SequodeOperationsKit::makeDefaultSequenceObjectMap($type, SequodeModeler::model()->sequence);
        $sequence =  SequodeModeler::model()->sequence;
        $location_object = $default_map[$map_key];
		$sequence_key = $location_object->Key - 1;
        $member = $location_object->Member;
        $temp_model = new SequodeModeler::$model;
		$temp_model->exists($sequence[$sequence_key],'id');
		$components_object = (object) null;
		$model_member = $type.'_form_object';
		$components_object->location = $temp_model->$model_member->$member;
		$model_member = $type.'_object_map';
		$components_object->location->Value = SequodeModeler::model()->$model_member[$map_key]->Value;
        
		return $components_object;
        
    }
    
	public static function componentSettings($type, $member, $dom_id, $sequode_model = null){
        
        if($sequode_model == null ){
            $sequode_model = SequodeModeler::model();
        }
        
        $components_object = (object) null;
        switch($type){
                case 'input':
                case 'property':
                    $model_member = $type.'_form_object';
                    $values_object = $sequode_model->$model_member->$member;
                    break;
            default:
                return;
        }
		
		FormInputModeler::exists($values_object->Component,'name');
		$components_object = FormInputModeler::model()->component_form_object;
		foreach($components_object as $component_member => $component_object){
			if(isset($values_object->$component_member)){
				$components_object->$component_member->Value = $values_object->$component_member;
			}
		}
        
		return $components_object;
        
	}
    
    public static function sequode($dom_id, $sequode_model = null){
        
        if($sequode_model == null ){
            $sequode_model = SequodeModeler::model();
        }
        
        return $sequode_model->input_form_object;
        
	}
    
    public static function sharing($sequode_model = null){
        
        if($sequode_model == null ){
            $sequode_model = SequodeModeler::model();
        }
        
        $components_object = (object) null;
        FormInputModeler::exists('checkboxSwitch','name');
        $components_object->sharing = FormInputModeler::model()->component_object;
        $components_object->sharing->Label = '';
        $components_object->sharing->On_Text = 'Publicly Shared';
        $components_object->sharing->On_Value = 1;
        $components_object->sharing->Off_Text = 'Private Restricted';
        $components_object->sharing->Off_Value = 0;
        $components_object->sharing->Value = (SequodeAuthority::isShared($sequode_model)) ? 1 : 0;
        
		return $components_object;
        
	}
    
    public static function updateIsPalette($sequode_model = null){
        
        if($sequode_model == null ){
            $sequode_model = SequodeModeler::model();
        }
        
        $components_object = (object) null;
        FormInputModeler::exists('checkboxSwitch','name');
        $components_object->palette = FormInputModeler::model()->component_object;
        $components_object->palette->Label = '';
        $components_object->palette->On_Text = 'Shown in Palettes';
        $components_object->palette->On_Value = 1;
        $components_object->palette->Off_Text = 'Hidden from Palettes';
        $components_object->palette->Off_Value = 0;
        $components_object->palette->Value = (SequodeAuthority::isPalette($sequode_model)) ? 1 : 0;
        
		return $components_object;
        
	}
    
    public static function updateIsPackage($sequode_model = null){
        
        if($sequode_model == null ){
            $sequode_model = SequodeModeler::model();
        }
        
        $components_object = (object) null;
        FormInputModeler::exists('checkboxSwitch','name');
        $components_object->package = FormInputModeler::model()->component_object;
        $components_object->package->Label = '';
        $components_object->package->On_Text = 'Useable As Package';
        $components_object->package->On_Value = 1;
        $components_object->package->Off_Text = 'Not Used As Package';
        $components_object->package->Off_Value = 0;
        $components_object->package->Value = (SequodeAuthority::isPackage($sequode_model)) ? 1 : 0;
        
		return $components_object;
        
	}
    
    public static function selectPalette($user_model = null){
        
        if($user_model == null ){
            $user_model = AccountModeler::model();
        }
        
        $components_object = (object) null;
        $values = $where = [];
        
        $values[] = '{\'value\':\'0\',\'printable\':\'Select Sequodes Palette\'}';
        //$values[] = '{\'value\':\'sequode_search\',\'printable\':\'Sequode Search Results\'}';
        $values[] = '{\'value\':\'sequode_favorites\',\'printable\':\'My Sequode Favorites\'}';
        
        $where[] = ['field'=>'owner_id','operator'=>'=','value'=>5];
        $where[] = ['field'=>'shared','operator'=>'=','value'=>1];
        $where[] = ['field'=>'palette','operator'=>'=','value'=>1];
        $sequodes_model = new SequodeModeler::$model;
        $sequodes_model->getAll($where);
        foreach( $sequodes_model->all as $object){
            $values[] = '{\'value\':\''.$object->id.'\',\'printable\':\''.$object->name.'\'}';
        }
        $where = [];
        $where[] = ['field'=>'owner_id','operator'=>'=','value'=>AccountModeler::model()->id];
        $where[] = ['field'=>'palette','operator'=>'=','value'=>1];
        $sequodes_model->getAll($where);
        foreach( $sequodes_model->all as $object){
            $values[] = '{\'value\':\''.$object->id.'\',\'printable\':\''.$object->name.'\'}';
        }
        FormInputModeler::exists('select','name');
        $components_object->palette = FormInputModeler::model()->component_object;
        $components_object->palette->Label = '';
        $components_object->palette->Values = '[' . implode(',',$values) . ']';
        $components_object->palette->Value = '0';
        $components_object->palette->Value_Key = 'value';
        $components_object->palette->Printable_Key = 'printable';
        
		return $components_object;
        
	}
}