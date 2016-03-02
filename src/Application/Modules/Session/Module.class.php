<?php

namespace Sequode\Application\Modules\Session;

class Module {
    public static $registry_key = 'Session';
	public static function model(){
        $_o = (object) array (
            'context' => 'session',
            'modeler' => Modeler::class,
            'operations' => Operations::class,
            'components' => (object) array (
                'form_inputs' => Components\FormInputs::class,
                'forms' => Components\Forms::class,
                'cards' => Components\Cards::class,
            ),
            'finder' => Collections::class,
            'collections' => Routes\Collections\Collections::class,
            'xhr' => (object) array (
                'operations' => Routes\XHR\Operations::class,
                'forms' => Routes\XHR\Forms::class,
                'cards' => Routes\XHR\Cards::class
            )
        );
		return $_o;
	}
}