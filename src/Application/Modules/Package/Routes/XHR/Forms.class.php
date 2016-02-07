<?php

namespace Sequode\Application\Modules\Package\Routes\XHR;

use Sequode\View\Module\Form as ModuleForm;
use Sequode\Component\DOMElement\Kit\JS as DOMElementKitJS;

class Forms {
    public static $package = 'Package';
    public static $modeler = \Sequode\Application\Modules\Package:Modeler::class;
    public static function name($_model_id, $dom_id){
        $modeler = static::$modeler;
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Auth\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Auth\Authority::isSystemOwner())
        )){return;}
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package,__FUNCTION__), $dom_id);
    }
    public static function packageSequode($_model_id, $dom_id){
        $modeler = static::$modeler;
        if(!(
        $modeler::exists($_model_id,'id')
        && (\Sequode\Application\Modules\Auth\Authority::isOwner( $modeler::model() )
        || \Sequode\Application\Modules\Auth\Authority::isSystemOwner())
        )){return;}
        return DOMElementKitJS::placeForm(ModuleForm::render(self::$package,__FUNCTION__), $dom_id);
    }
}