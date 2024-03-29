<?php

namespace Sequode\Component\DOMElement\Kit;


use Sequode\Component\FormInput as FormInputComponent;
use Sequode\Component\Card\Kit\HTML as CardKitHTML;

class JS {
    
	public static function setValueJS($dom_id, $value){
        $js[] = 'document.getElementById(\''.$dom_id.'\').value = decodeURIComponent(\'';
        $js[] = rawurlencode($value);
        $js[] = '\');';
        return implode('',$js);
    }
	public static function addEventListenerJS($dom_id, $event, $event_js){
        $js[] = '$(\'#'.$dom_id.'\').on(\''.$event.'\',(function(event) {';
        $js[] = $event_js;
        $js[] = '}));';
        return implode('',$js);
    }
    public static function placeForm($form, $dom_id){
        $html = $js = [];
        if(count($form) == 1){
            foreach($form as $key => $object){
                if(isset($object->html)){
                    $html[] = $object->html;
                }
            }
        }else{
            $html[] = CardKitHTML::contentRowDivider();
            foreach($form as $key => $object){
                if(isset($object->html)){
                    $html[] = $object->html;
                    $html[] = CardKitHTML::contentRowDivider();
                }
            }
        }
        $js[] = self::addIntoDom($dom_id,implode('',$html),'replace');
        foreach($form as $key => $object){
            if(isset($object->js)){
                $js[] = $object->js;
            }
        }
        $js[] = '$(\'.focus-input\').focus();';
        $js[] = '$(\'.focus-input\').select();';    
        return implode(' ',$js);
    }
    public static function googleAnalytics(){
        $js = [];
        $js[] = '(function(i,s,o,g,r,a,m){i[\'GoogleAnalyticsObject\']=r;i[r]=i[r]||function(){';
        $js[] = '(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),';
        $js[] = 'm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)';
        $js[] = '})(window,document,\'script\',\'//www.google-analytics.com/analytics.js\',\'ga\');';
        $js[] = 'ga(\'create\', \'UA-55113318-1\', \'auto\');';
        $js[] = 'ga(\'send\', \'pageview\');';
        return implode('',$js);
	}
    public static function forceSSL(){
        $js = [];
        $js[] = 'if(document.location.protocol != "https:"){';
        $js[] = 'document.location = document.URL.replace(/^http:/i, "https:");';
        $js[] = '}';
        return implode('',$js);
	}
    public static function jsQuotedValue($value=''){
        return '\''. $value .'\'';
	}
	public static function documentEventOff($event){
		return '$(document).off(\''.$event.'\');';
	}
    public static function onTapEvents($dom_id, $javascript){
        $js = [];
        $js[] = '$(\'#'.$dom_id.'\').on("click touch", function(){';
        $js[] = $javascript;
        $js[] = '});';
        return implode('',$js);
	}
    public static function onTapEventsXHRCall($dom_id, $xhr_call_object){
        return self::onTapEvents($dom_id, self::xhrCall($xhr_call_object));
	}
	public static function xhrCallObject($route='', $inputs=null, $done_callback=false){
        $object = (object) null;
        $object->route = $route;
        $object->inputs = ($inputs == null) ? [] : $inputs;
        $object->done_callback = $done_callback;
		return $object;
	}
	public static function xhrCall($call_object){
        if(is_array($call_object) && isset($call_object['route'])){
            $call_object = (object) $call_object;
        }
        $js = [];
        $js[] = 'new XHRCall({';
        $js[] = 'route:\''. $call_object->route .'\'';
        if(is_array($call_object->inputs) && count($call_object->inputs) != 0){
            $js[] = ',inputs:['. implode(',',$call_object->inputs) .']';
        }
        if($call_object->done_callback){
            $js[] = ',done_callback:'. $call_object->done_callback;
        }
        $js[] = '});';
        return implode('',$js);
	}
    public static function loadComponentHere($call_object, $contents='', $icon = 'atom'){
        $html = $js = [];
        $dom_id = FormInputComponent::uniqueHash();
        
        $html[] = '<span id="'.$dom_id.'c">';
        $html[] = '<span class="automagic-card-text-button" id="'.$dom_id.'b">';
        $html[] = $contents;
        if($icon != null){
            $html[] = ' <div class="load-here-icon '.$icon.'-icon-background"></div>'; 
        }
        $html[] = '</span>';
        $html[] = '</span>';
        $call_object->inputs = array_merge($call_object->inputs, [self::jsQuotedValue($dom_id.'c')]);
        $js[] = '$(\'#'.$dom_id.'b\').on("click touchend", function(){';
        $js[] = self::xhrCall($call_object);
        $js[] = '});';
        
        $components_object = (object) null;
        $components_object->dom_id = $dom_id;
        $components_object->html = implode('',$html);
        $components_object->js = implode('',$js);
        return $components_object;
	}
    public static function fetchCollection($collection, $key=null){
        return ($key == null) ? 'registry.fetch({collection:\''.$collection.'\'});' : 'registry.fetch({collection:\''.$collection.'\', key:'.$key.'});';
	}
    public static function confirmOperation($route, $id = null, $message = 'Are you sure you want to delete this?'){
        $js = [];
        $js[] = "if(confirm('". self::formatForJS($message) ."')){";
        $js[] = 'new XHRCall({route:"'. $route .'",inputs:[';
        if($id !== null) {
            $js[] = "'" . $id . "', ";
        }
        $js[] = 'true]});';
        $js[] = '}';
        return implode('',$js);
	}
    public static function addIntoDom($element, $code, $mode='replace'){
		$stream = ' ';
		switch($mode){
			case 'append':
				$stream .= 'document.getElementById(\''.$element.'\').innerHTML = document.getElementById(\''.$element.'\').innerHTML + \''.self::formatForJS($code).'\';';
			break;
			case 'prepend':
				$stream .= 'document.getElementById(\''.$element.'\').innerHTML = \''.self::formatForJS($code).'\' + document.getElementById(\''.$element.'\').innerHTML;';
			break;
			case 'replace':
			default:
			
            $stream .= 'document.getElementById(\''.$element.'\').innerHTML = \''.self::formatForJS($code).'\';';
			break;
		}
		return $stream;
	}
	public static function removeInDom($element,$depth=0){
		$stream .= " ";
		$stream .= ' $(\''.$element.'\').parentNode.removeChild(document.getElementById(\''.$element.'\'));';
		return self::depth($stream,$depth);
	}
    public static function formatForJS($input){
		return str_replace("\r",'\r',str_replace("\n",'\n',addslashes($input)));
	}
	public static function registeyTimeout($variable_name, $javascript, $milliseconds=0){
        $js = [];
        $js[] = 'registry.timeout(\''.$variable_name.'\', function(){';
        $js[] = $javascript;
        $js[] = 'registry.timeouts[\''.$variable_name.'\'] = null; },'.$milliseconds.');';
        return implode(' ',$js);
	}
	public static function enterPressed($javascript){
        $js = [];
        $js[] = 'if (event.keyCode == 13){';
        $js[] = $javascript;
        $js[] = '}';
        return implode(' ',$js);
	}
    public static function registrySetContext($context, $raw_members=[]){
        $raw_members = $context->raw_members ?: $raw_members;
        $js[] = ' var context = {';
        $js[] = 'card:\''.$context->card.'\'';
        if($context->collection){
            $js[] = !in_array('collection', $raw_members)
                ? ', collection:\''.$context->collection.'\''
                : ', collection:'.$context->collection;
        }
        if($context->node){

            $node = !in_array('node', $raw_members)
                ? "'" . $context->node . "'"
                : $context->node;

            $js[] = !in_array('node', $raw_members)
                ? ', node:\''.$context->node.'\''
                : ', node:'.$context->node;
        }
        if($context->tearDown){
            $js[] = ',tearDown:'.$context->tearDown;
        }
        $js[] = '};';
        $js[] = 'registry.setContext(context);';
        return implode(' ',$js);
    }
    public static function registryRefreshContext($id=false){

        $js[] = "if(typeof registry.active_context != 'undefined' && typeof registry.active_context.card != 'undefined'){";
        if($id  === false) {
            $js[] = "XHRCall({route:registry.active_context.card, inputs:[]});";
        } else {
            $js[] = "XHRCall({route:registry.active_context.card, inputs:[registry.active_context.node]});";
        }
        $js[] = "}";
        return implode('',$js);
    }
    public static function registrySubscribeToUpdates($subscription, $raw_members=[]){

        $js[] = 'registry.subscribeToUpdates({';
        $js[] = 'type:\''.$subscription->type.'\'';
        if($subscription->collection){
            $js[] = !in_array('collection', $raw_members)
                ? ', collection:\''.$subscription->collection.'\''
                : ', collection:'.$subscription->collection;
        }
        if($subscription->key){
            $js[] = !in_array('key', $raw_members)
                ? ', key:\''.$subscription->key.'\''
                : ', key:'.$subscription->key;
        }
        if($subscription->call){
            $js[] = ',call:'.$subscription->call;
        }
        $js[] = '});';
        return implode(' ',$js);
    }
}