<?php

namespace Sequode\Application\Modules\Auth\Routes\XHR;

use Sequode\View\Module\Card as ModuleCard;
use Sequode\Component\Card\Kit\JS as CardKitJS;

class Cards {
    public static $registry_key = 'Auth';
    public static function login($dom_id = 'CardsContainer'){
        return CardKitJS::placeCard(ModuleCard::render(static::$registry_key,__FUNCTION__), $dom_id);
    }
}