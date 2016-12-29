<?php

namespace Sequode\Application\Modules\Sequode\Routes\XHR;

use Sequode\Model\Module\Registry as ModuleRegistry;
use Sequode\View\Module\Card as ModuleCard;
use Sequode\Component\Card\Kit\JS as CardKitJS;

use Sequode\Application\Modules\Sequode\Module;

class Cards {
    
    public static $module = Module::class;
    
    public static function componentSettings($type = false, $member=null, $_model_id=0, $dom_id = 'CardsContainer'){
       
        $module = static::$module;
        $modeler = $module::model()->modeler;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Account\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Account\Authority::isSystemOwner())
        )){return;}
        return CardKitJS::placeCard(ModuleCard::render($module::$registry_key, __FUNCTION__, array($type, $member)), $dom_id);
    }
    public static function details($_model_id=0, $dom_id = 'CardsContainer'){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Account\Authority::canView()
        )){return;}
        return CardKitJS::placeCard(ModuleCard::render($module::$registry_key, __FUNCTION__), $dom_id);
    }
    public static function internalForms($_model_id=0, $dom_id = 'CardsContainer'){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Account\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Account\Authority::isSystemOwner())
        )){return;}
        return CardKitJS::placeCard(ModuleCard::render($module::$registry_key, __FUNCTION__), $dom_id);
    }
    public static function internalPositionForms($_model_id=0, $position=0, $dom_id = 'CardsContainer'){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Account\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Account\Authority::isSystemOwner())
        )){return;}
        return CardKitJS::placeCard(ModuleCard::render($module::$registry_key, __FUNCTION__, array($position)), $dom_id);
    }
    public static function chart($_model_id=0, $dom_id = 'CardsContainer'){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Account\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Account\Authority::isSystemOwner())
        )){return;}
        return CardKitJS::placeCard(ModuleCard::render($module::$registry_key, __FUNCTION__), $dom_id);
    }
    public static function sequencer($_model_id=0, $dom_id = 'CardsContainer'){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Account\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Account\Authority::isSystemOwner())
        )){return;}
        return CardKitJS::placeCard(ModuleCard::render($module::$registry_key, __FUNCTION__), $dom_id);
    }
    public static function search($dom_id = 'CardsContainer'){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        
        return CardKitJS::placeCard(ModuleCard::render($module::$registry_key, __FUNCTION__), $dom_id);
    }
    public static function my($dom_id = 'CardsContainer'){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        
        return CardKitJS::placeCard(ModuleCard::render($module::$registry_key, __FUNCTION__), $dom_id);
    }
    public static function favorites($dom_id = 'CardsContainer'){
        
        $module = static::$module;
        $modeler = $module::model()->modeler;
        
        return CardKitJS::placeCard(ModuleCard::render($module::$registry_key, __FUNCTION__), $dom_id);
    }
}