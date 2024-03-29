<?php
namespace Sequode\Application\Modules\User;

use Sequode\Application\Modules\User\Traits\Operations\ORMModelCreateTrait;
use Sequode\Application\Modules\User\Traits\Operations\ORMModelSetNameTrait;
use Sequode\Application\Modules\User\Traits\Operations\ORMModelSetEmailTrait;
use Sequode\Application\Modules\User\Traits\Operations\ORMModelSetPasswordTrait;
use Sequode\Application\Modules\User\Traits\Operations\ORMModelDeleteTrait;
use Sequode\Application\Modules\User\Traits\Operations\ORMModelSetLastSignInTrait;
use Sequode\Application\Modules\User\Traits\Operations\ORMModelSetActiveTrait;
use Sequode\Application\Modules\User\Traits\Operations\ORMModelOwnedModuleModelsTrait;
use Sequode\Application\Modules\User\Traits\Operations\ORMModelFavoritedModuleModelsTrait;
use Sequode\Application\Modules\User\Traits\Operations\ORMModelSignInTrait;
use Sequode\Application\Modules\User\Traits\Operations\ORMModelSetRoleTrait;

class Operations {
   
    use ORMModelCreateTrait,
        ORMModelSetNameTrait,
        ORMModelSetEmailTrait,
        ORMModelSetPasswordTrait,
        ORMModelDeleteTrait,
        ORMModelSetLastSignInTrait,
        ORMModelSetActiveTrait,
        ORMModelOwnedModuleModelsTrait,
        ORMModelFavoritedModuleModelsTrait,
        ORMModelSignInTrait,
        ORMModelSetRoleTrait;
    
    public static $modeler = Modeler::class;
    
}