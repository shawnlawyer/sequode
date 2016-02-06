<?php

namespace Sequode\Application\Modules\Account\Routes\XHR;

use Sequode\Model\Module\Registry as ModuleRegistry;
use Sequode\View\Module\Card as ModuleCard;
use Sequode\Component\Card\Kit\JS as CardKitJS;

class Cards {
    public static $package = 'Account';
	public static $merge = false;
	public static $routes = array(
		'details',
		'updatePassword',
		'updateEmail'
	);
	public static $routes_to_methods = array(
		'details' => 'details',
		'updatePassword' => 'updatePassword',
		'updateEmail' => 'updateEmail'
    );
    public static function updatePassword($dom_id = 'CardsContainer'){
        $dialog = ModuleRegistry::model(static::$package)->xhr->dialogs[__FUNCTION__];
        if(!\Sequode\Application\Modules\Session\Modeler::is($dialog['session_store_key'])){
            \Sequode\Application\Modules\Session\Modeler::set($dialog['session_store_key'], $dialog['session_store_setup']);
        }
        return CardKitJS::placeCard(ModuleCard::render(self::$package,__FUNCTION__), $dom_id);
    }
    public static function updateEmail($dom_id = 'CardsContainer'){
        $dialog = ModuleRegistry::model(static::$package)->xhr->dialogs[__FUNCTION__];
        if(!\Sequode\Application\Modules\Session\Modeler::is($dialog['session_store_key'])){
            \Sequode\Application\Modules\Session\Modeler::set($dialog['session_store_key'], $dialog['session_store_setup']);
        }
        return CardKitJS::placeCard(ModuleCard::render(self::$package,__FUNCTION__), $dom_id);
    }
    public static function details($dom_id = 'CardsContainer'){
        return CardKitJS::placeCard(ModuleCard::render(self::$package,__FUNCTION__), $dom_id);
    }
}