<?php
if(!defined('ABSPATH')){
	exit;
} // Exit if accessed directly

class congoroWidgetFunctions{

	//============================================
	// insert content after nth paragraph
	//============================================
	static public function prefixInsertAfterParagraph($insertion,$paragraph_id,$content){
		$closing_p  = '</p>';
		$paragraphs = explode($closing_p,$content);
		foreach($paragraphs as $index => $paragraph){

			if(trim($paragraph)){
				$paragraphs[ $index ] .= $closing_p;
			}

			if($paragraph_id==$index+1){
				if(self::mbStrWordCount($paragraph)<50){
					$paragraph_id++;
					continue;
				}

				$paragraphs[ $index ] .= $insertion;
			}
		}

		return implode('',$paragraphs);
	}

	//==================================
	//strip backslashes
	//==================================
	static public function stripBackslashes($content){
		return str_replace('\\',"",$content);
	}

	static public function generateRandomString($length = 10){
		$characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString     = '';
		for($i = 0;$i<$length;$i++){
			$randomString .= $characters[ rand(0,$charactersLength-1) ];
		}

		return $randomString;
	}

	static public function adminMenu(){
		add_options_page('تنظیمات ویجت کانگورو','کانگورو','manage_options','congoro.php','congoro_widget_adminPage');
	}

	//==================================
	//Remove wp-widget
	//==================================
	static public function removeWidget(){
		unregister_widget('congoro_wordpress_widget');
	}

	static public function installYoastSuggestionNotice(){
		return '<div class="congoro-notice notice-warning is-dismissible">
                <p> برای اصلاح متاتگ های OGP و کارکرد صحیح ویجت کانگورو، پیشنهاد ما این است که پلاگین <a href="./plugin-install.php?s=Yoast+seo&tab=search&type=term">Yoast Seo</a> را نصب کنید.</p>
           </div>';
	}

	//==================================
	// Register and load the widget
	//==================================
	static public function loadWordpressWidget(){
		//widget class name in widget.php file
		register_widget('congoroWidgetWordpressWidget');
	}

	static public function getWidgets(){
		static $widgets = [];
		if(sizeof($widgets)===0) {
			$widgets = (array)json_decode(get_option('congoro_widgets_settings'));
		}

		return $widgets;
	}

	static public function loadWidgetInContent($content){
		if(is_single() && !is_admin()){
			$activeWidgets = self::getWidgets();

			foreach($activeWidgets as $widget){
				$widget      = (array)$widget;
				$widget_code = self::stripBackslashes($widget['widgetCode']);
				if($widget['displayType']==='content'){
					$content = $content.$widget_code;
				}else if($widget['displayType']==='afterNthParagraph'){
					$content = self::prefixInsertAfterParagraph($widget_code,$widget['nthParagraphValue'],$content);
				}
			}
		}

		return $content;
	}

    static public function loadFixedWidgets(){
	    if(is_single() && !is_admin()){
		    $activeWidgets = self::getWidgets();

		    foreach($activeWidgets as $widget){
			    $widget      = (array)$widget;
			    $widget_code = self::stripBackslashes($widget['widgetCode']);
			    if($widget['displayType']==='endoftheme'){
				    echo $widget_code;
			    }
		    }
	    }
    }

	static public function appendScripts(){
		wp_register_script('congoro-widget-drop-down-script',self::getFullPathUrl('third-party/ms-Dropdown/jquery.dd.min.js'),array('jquery'),'1.0.0',true);
		wp_enqueue_script('congoro-widget-drop-down-script');

		wp_register_script('congoro-widget-scripts',self::getFullPathUrl('admin/admin.js'),array('jquery'),'1.0.0',true);
		wp_enqueue_script('congoro-widget-scripts');
	}

	static public function appendStyles(){
		wp_register_style('congoro-widget-style2',self::getFullPathUrl('admin/animation.css'),array(),'1.0.0','all');
		wp_enqueue_style('congoro-widget-style2');

		wp_register_style('congoro-widget-style3',self::getFullPathUrl('admin/loader.css'),array(),'1.0.0','all');
		wp_enqueue_style('congoro-widget-style3');

		wp_register_style('congoro-widget-style',self::getFullPathUrl('admin/admin.css'),array(),'1.0.1','all');
		wp_enqueue_style('congoro-widget-style');

		wp_register_style('congoro-widget-drop-down-css',self::getFullPathUrl('third-party/ms-Dropdown/dd.css'),array(),'1.0.0','all');
		wp_enqueue_style('congoro-widget-drop-down-css');
	}

	static public function getFullPathUrl($local_url){
		return plugins_url($local_url,__FILE__);
	}


	static function mbStrWordCount($string,$format = 0,$charlist = '[]'){
		mb_internal_encoding('UTF-8');
		mb_regex_encoding('UTF-8');

		$words = mb_split('[^\x{0600}-\x{06FF}]',$string);
		switch($format){
			case 0:
				return count($words);
				break;
			case 1:
			case 2:
				return $words;
				break;
			default:
				return $words;
				break;
		}

	}
}