<?php

namespace Sequode\Application\Modules\Session;

use Sequode\Application\Modules\Session\Traits\Operations\ORMModelCreate;
use Sequode\Application\Modules\Session\Traits\Operations\ManageSessionStore;
use Sequode\Application\Modules\Session\Traits\Operations\SetGetSessionCookie;

class Operations {
    
    use ORMModelCreate,
        ManageSessionStore,
        SetGetSessionCookie;
    
    public static $modeler = Modeler::class;
    public static $store = Store::class;
    
}