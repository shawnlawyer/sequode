<?php

namespace Sequode\Application\Modules\Sequode\Routes\XHR;

use Sequode\Application\Modules\Session\Store as SessionStore;
use Sequode\Model\Module\Registry as ModuleRegistry;
use Sequode\Component\DOMElement\Kit\JS as DOMElementKitJS;

use Sequode\Application\Modules\Sequode\Module;

class Operations {
    
    public static $module = Module::class;
    
    public static function updateValue($type, $_model_id, $map_key, $json){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
        && \Sequode\Application\Modules\Account\Authority::canEdit()
        )){ return; }
        $input = json_decode($json);
        if (!is_object($input)){ return; }
        switch($type){
            case 'input':
            case 'property':
                $model_member = $type.'_object_map';
                break;
            default:
                return false;
        }
        $object_map = json_decode($modeler::model()->$model_member);
        forward_static_call_array(array($operations, __FUNCTION__), array($type, $map_key, rawurldecode($input->location)));
        if(empty($object_map[$map_key]->Value)){
			$js = array();
            $collection = 'sequodes';
            $js[] = DOMElementKitJS::fetchCollection($collection, $modeler::model()->id);
			return implode(' ',$js);
        }
    }
    public static function updateComponentSettings($type, $member, $member_json, $_model_id, $dom_id='FormsContainer'){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Account\Authority::canEdit()
        )){ return; }
        $form_member_object = json_decode(stripslashes($member_json));
        if(!is_object($form_member_object)){return;}
        foreach($form_member_object as $key => $value){
            $form_member_object->$key = urldecode($value);
        }
        switch($type){
            case 'input':
            case 'property':
                $model_member = $type.'_form_object';
                break;
            default:
                return;
        }
        $previous_form_object = json_decode($modeler::model()->$model_member);
        forward_static_call_array(array($operations, __FUNCTION__), array($type, $member, $form_member_object));
        if($previous_form_object->$member->Component != $form_member_object->Component){
            
            $js = array();
            $js[] = 'new XHRCall({route:"forms/sequode/componentSettings",inputs:[\''.$type.'\', \''.$member.'\', '.$modeler::model()->id.', \''.$dom_id.'\']});';
			return implode(' ',$js);
            
        }
    }
    public static function cloneSequence($_model_id){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        $xhr_cards = $module::model()->xhr->cards;
        
        if(!(
        \Sequode\Application\Modules\Account\Authority::canCreate()
        && $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
        && \Sequode\Application\Modules\Account\Authority::canCopy()
        )){ return; }
        forward_static_call_array(array($operations, 'makeSequenceCopy'), array(\Sequode\Application\Modules\Account\Modeler::model()->id));
        $js = array();
        $collection = 'sequodes';
        $js[] = DOMElementKitJS::fetchCollection($collection, $modeler::model()->id);
        $js[] = forward_static_call_array([$xhr_cards, 'card'], ['details',[$modeler::model()->id]]);
        return implode(' ', $js);
    }
    public static function newSequence(){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        $xhr_cards = $module::model()->xhr->cards;
        $cards = $module::model()->xhr->cards;

        if(!(
        \Sequode\Application\Modules\Account\Authority::canCreate()
        )){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array(\Sequode\Application\Modules\Account\Modeler::model()->id));
        $js = array();
        $collection = 'sequodes';
        $js[] = DOMElementKitJS::fetchCollection($collection, $modeler::model()->id);
        $js[] = forward_static_call_array([$xhr_cards, 'card'], ['details',[$modeler::model()->id]]);
        return implode(' ', $js);
    }
    public static function updateName($_model_id, $json){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        $xhr_cards = $module::model()->xhr->cards;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Account\Authority::canEdit()
        )){ return; }
        $_o = json_decode($json);
        $name = trim(str_replace('-','_',str_replace(' ','_',urldecode($_o->name))));
        if(strlen($name)==0){
            return ' alert(\'Name cannot be empty\');';
        }
        if(!preg_match("/^([A-Za-z0-9_])*$/i",$name)){
            return ' alert(\'Name can be alphanumeric and contain spaces only\');';
        }
        if(!\Sequode\Application\Modules\Account\Authority::canRename($name)){
            return ' alert(\'Name already exists\');';
        }
        $modeler::exists($_model_id,'id');
        forward_static_call_array(array($operations, __FUNCTION__), array($name));
        $js = array();
        $js[] = forward_static_call_array([$xhr_cards, 'card'], ['details',[$modeler::model()->id]]);
    
        return implode(' ', $js);

    }
    public static function deleteSequence($_model_id,$confirmed=false){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        $xhr_cards = $module::model()->xhr->cards;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
        && \Sequode\Application\Modules\Account\Authority::canDelete()
        )){ return; }
        $sequence = json_decode($modeler::model()->sequence);
        if ($confirmed===false && is_array($sequence) && count(json_decode($modeler::model()->sequence)) != 0){
            $js = array();
			$js[] = 'if(';
			$js[] = 'confirm(\'Are you sure you want to delete this?\')';
			$js[] = '){';
            $js[] = 'new XHRCall({route:"operations/sequode/deleteSequence",inputs:['.$modeler::model()->id.', true]});';
			$js[] = '}';
			return implode(' ',$js);
        }else{
            forward_static_call_array(array($operations, __FUNCTION__), array());
            $js = array();
            $collection = 'sequodes';
            $js[] = DOMElementKitJS::fetchCollection($collection, $modeler::model()->id);
            $js[] = forward_static_call_array([$xhr_cards, 'card'], ['my']);
            return implode(' ', $js);
        }
    }
    public static function formatSequence($_model_id,$confirmed=false){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
        
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
        && \Sequode\Application\Modules\Account\Authority::canRun()
        
        )){ return; }
        
        $js = array();
        if ($confirmed===false){
			$js[] = 'if(';
			$js[] = 'confirm(\'Are you sure you want to format '.$modeler::model()->id.'?\')';
			$js[] = '){';
            $js[] = 'new XHRCall({route:"operations/sequode/formatSequence",inputs:['.$modeler::model()->id.', true]});';
			$js[] = '}';
        }else{
            forward_static_call_array(array($operations, 'makeDefaultSequencedSequode'), array());
            $collection = 'sequodes';
            $js[] = DOMElementKitJS::fetchCollection($collection, $modeler::model()->id);
            $js[] = 'if(typeof registry.active_context != \'undefined\' && typeof registry.active_context.card != \'undefined\'){';
            $js[] = 'new XHRCall({route:registry.active_context.card, inputs:['.$modeler::model()->id.']});';
            $js[] = '}';
        }
        return implode(' ',$js);
    }
	public static function addToSequence($_model_id, $add_model_id, $position=0, $position_tuner = null, $grid_modifier = null){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
		$modeler::exists($add_model_id,'id')
		&& \Sequode\Application\Modules\Account\Authority::canRun()
		&& $modeler::exists($_model_id,'id')
		&& \Sequode\Application\Modules\Account\Authority::canEdit()
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
        && !\Sequode\Application\Modules\Sequode\Authority::isFullSequence()
		)){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array($add_model_id, $position, $position_tuner, $grid_modifier));
		return;
	}
	public static function reorderSequence($_model_id, $from_position=0, $to_position=0, $position_tuner = null, $grid_modifier = null){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
		$modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
		&& \Sequode\Application\Modules\Account\Authority::canEdit()
		)){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array($from_position, $to_position, $position_tuner, $grid_modifier));
		return;
	}
	public static function removeFromSequence($_model_id, $position){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
		$modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
		&& \Sequode\Application\Modules\Account\Authority::canEdit()
		)){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array($position));
		return;
	}
	public static function modifyGridAreas($_model_id, $position){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
		$modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
		&& \Sequode\Application\Modules\Account\Authority::canEdit()
		)){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array($position));
		return;
	}
	public static function emptySequence($_model_id){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
        && \Sequode\Application\Modules\Account\Authority::canEdit()
        )){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array());
        $collection = 'sequodes';
        $js[] = DOMElementKitJS::fetchCollection($collection, $modeler::model()->id);
        $js[] = 'if(registry.active_context != false && registry.active_context.card != \'\' && registry.active_context.node != \'\'){';
        $js[] = 'new XHRCall({route:registry.active_context.card, inputs:[registry.active_context.node]});';
        $js[] = '}';
        return implode('',$js);
	}
	public static function moveGridArea($_model_id, $grid_area_key = 0, $x = 0, $y = 0){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
        && \Sequode\Application\Modules\Account\Authority::canEdit()
        )){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array($grid_area_key, $x, $y));
		return;
	}
	public static function addInternalConnection($_model_id, $receiver_type = false, $transmitter_key = 0, $receiver_key = 0){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
        && \Sequode\Application\Modules\Account\Authority::canEdit()
        )){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array($receiver_type, $transmitter_key, $receiver_key));
		return;
	}
	public static function addExternalConnection($_model_id, $receiver_type = false, $transmitter_key = 0, $receiver_key = 0){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
        && \Sequode\Application\Modules\Account\Authority::canEdit()
        )){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array($receiver_type, $transmitter_key, $receiver_key));
		return;
	}
	public static function removeReceivingConnection($_model_id, $connection_type = false, $restore_key = 0){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Sequode\Authority::isSequence()
        && \Sequode\Application\Modules\Account\Authority::canEdit()
        )){ return; }
        $_o = json_decode($json);
        if (!is_object($_o)){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array($connection_type, $restore_key));
		return;
	}
	public static function updateSharing($_model_id,$json){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Account\Authority::canShare()
        )){ return; }
        $_o = json_decode($json);
        if (!is_object($_o)){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array(rawurldecode($_o->sharing)));
		return;
	}
	public static function updateIsPalette($_model_id,$json){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
            $modeler::exists($_model_id,'id')
            && \Sequode\Application\Modules\Account\Authority::canEdit()
        )){return;}
        $_o = json_decode($json);
        if (!is_object($_o)){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array(rawurldecode($_o->palette)));
		return;
	}
	public static function updateIsPackage($_model_id,$json){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
            $modeler::exists($_model_id,'id')
            && \Sequode\Application\Modules\Account\Authority::canEdit()
        )){return;}
        $_o = json_decode($json);
        if (!is_object($_o)){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array(rawurldecode($_o->package)));
		return;
	}
	public static function updateDescription($_model_id, $json){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        $operations = $module::model()->operations;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Account\Authority::canEdit()
        )){ return; }
        $_o = json_decode($json);
        if (!is_object($_o)){ return; }
        forward_static_call_array(array($operations, __FUNCTION__), array(rawurldecode($_o->description)));
		return;
	}
    public static function search($json){
        $_o = json_decode(stripslashes($json));
        $_o = (!is_object($_o) || (trim($_o->search) == '' || empty(trim($_o->search)))) ? (object) null : $_o;
        $collection = 'sequode_search';
        SessionStore::set($collection, $_o);
		$js=array();
        if(SessionStore::get('palette') == $collection){
            $js[] = DOMElementKitJS::fetchCollection('palette');
        }
        $js[] = DOMElementKitJS::fetchCollection($collection);
        return implode('',$js);
    }
    public static function selectPalette($json){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        
        $_o = json_decode(stripslashes($json));
        if(!is_object($_o) || (trim($_o->palette) == '' || empty(trim($_o->palette)))){
            
            SessionStore::set('palette', false);
            
        }else{
            
            switch($_o->palette){
                
                case 'sequode_search':
                case 'sequode_favorites':
                    SessionStore::set('palette', $_o->palette);
                    break;
                default:
                    if((
                    $modeler::exists($_o->palette, 'id')
                    && \Sequode\Application\Modules\Account\Authority::canView()
                    )){
                    SessionStore::set('palette', $_o->palette);
                    }
                    break;
                    
            }
            
        }
        $js[]=  DOMElementKitJS::fetchCollection('palette');
        return implode(' ',$js);
    }
}