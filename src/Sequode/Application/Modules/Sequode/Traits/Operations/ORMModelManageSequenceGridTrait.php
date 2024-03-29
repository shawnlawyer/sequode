<?php

namespace Sequode\Application\Modules\Sequode\Traits\Operations;

trait ORMModelManageSequenceGridTrait {
    
	public static function modifyGridAreas($position = 0, $_model = null){
        
        $modeler = static::$modeler;
        $kit = static::$kit;
        
        forward_static_call_array([$modeler, 'model'], ($_model == null) ? [] : [$_model]);
            
		$sequence = $modeler::model()->sequence;
		$position = $kit::getSequencePosition($position, $sequence, 1);
		$grid_areas = $modeler::model()->grid_areas;
		$grid_areas = $kit::modifyGridAreas($position, $grid_areas, $modeler::model());
        
		$modeler::model()->grid_areas = $grid_areas;

        $modeler::model()->save();
        
        self::maintenance();
        
		return $modeler::model();
        
    }
	public static function moveGridArea($grid_area_key = 0, $x = 0, $y = 0, $_model = null){
        
        $modeler = static::$modeler;
        $kit = static::$kit;
        
        forward_static_call_array([$modeler, 'model'], ($_model == null) ? [] : [$_model]);
            
        $grid_area_key = intval($grid_area_key);
		$x = intval($x); 
		$y = intval($y);
        $grid_areas = $modeler::model()->grid_areas;
        
		if(!isset($grid_areas[$grid_area_key])){return $modeler::model();}
        
		$grid_areas = $kit::moveGridArea($grid_area_key, $grid_areas, $x, $y, $modeler::model());

        $modeler::model()->grid_areas = $grid_areas;

        $modeler::model()->save();
        
        self::maintenance();
        
		return $modeler::model();
    }
    
}