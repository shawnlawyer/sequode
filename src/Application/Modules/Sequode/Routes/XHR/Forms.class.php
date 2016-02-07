<?php

namespace Sequode\Application\Modules\Sequode\Routes\XHR;

use Sequode\View\Module\Form as ModuleForm;
use Sequode\Component\DOMElement\Kit\JS as DOMElementKitJS;

class Forms {
    public static $package = 'Sequode';
    public static $modeler = \Sequode\Application\Modules\Sequode\Modeler::class;
    public static function name($_model_id, $dom_id){
        $modeler = static::$modeler;
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Auth\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Auth\Authority::isSystemOwner())
        )){return;}
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package,__FUNCTION__), $dom_id);
    }
    public static function description($_model_id, $dom_id){
        $modeler = static::$modeler;
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Auth\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Auth\Authority::isSystemOwner())
        )){return;}
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package,__FUNCTION__), $dom_id);
    }
    public static function component($type, $_model_id, $map_key, $dom_id){
        $modeler = static::$modeler;
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Auth\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Auth\Authority::isSystemOwner())
        && in_array($type, array('input','property'))
        )){return;}
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package, __FUNCTION__, array($type, $map_key)), $dom_id);
    }
    public static function componentSettings($type, $member, $_model_id, $dom_id){
        $modeler = static::$modeler;
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Auth\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Auth\Authority::isSystemOwner())
        && in_array($type, array('input','property'))
        )){return;}
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package, __FUNCTION__, array($type, $member, $dom_id)), $dom_id);
    }
    public static function sequode($_model_id, $dom_id){
        $modeler = static::$modeler;
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Auth\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Auth\Authority::isSystemOwner())
        )){return;}
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package, __FUNCTION__), $dom_id);
    }
    public static function updateIsPalette($_model_id, $dom_id){
        $modeler = static::$modeler;
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Auth\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Auth\Authority::isSystemOwner())
        )){return;}
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package, __FUNCTION__), $dom_id);
    }
    public static function updateIsPackage($_model_id, $dom_id){
        $modeler = static::$modeler;
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Auth\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Auth\Authority::isSystemOwner())
        )){return;}
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package, __FUNCTION__), $dom_id);
    }
    public static function sharing($_model_id, $dom_id){
        $modeler = static::$modeler;
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Auth\Authority::isSystemOwner()
        )){return;}
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package, __FUNCTION__), $dom_id);
    }
    public static function selectPalette($dom_id){
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package, __FUNCTION__), $dom_id);
    }
    public static function tenancy($_model_id, $dom_id){
        $modeler = static::$modeler;
        if(!(
        $modeler::exists($_model_id,'id')
        && \Sequode\Application\Modules\Auth\Authority::isSystemOwner()
        )){return;}
        if(!(
            \Sequode\Application\Modules\Auth\Authority::isSystemOwner()
            && \Sequode\Application\Modules\Sequode\Modeler::exists($_model_id, 'id')
        )){return;}
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package, __FUNCTION__), $dom_id);
    }
}