<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(is_admin()){
	add_action('admin_menu', 'congoroWidgetFunctions::adminMenu');
}

function congoro_widget_adminPage()
{
	//add scripts
	congoroWidgetFunctions::appendScripts();

	//add scripts
	congoroWidgetFunctions::appendStyles();

	$warning_html = '';
    //warn install yoast if yoast is not installed.
    if (!is_plugin_active('wordpress-seo/wp-seo.php')) {
        $warning_html = congoroWidgetFunctions::installYoastSuggestionNotice();
    }

    $active_widgets = array();

    //create option for first time
    $default_code = '<script data-cfasync="false" src="http://widget.congoro.com/widget/script?l=a&fn=a&fs=13&rt=0&tt=a&wt=0"></script>';
    $default_setting = array(
        'widgetCode' => $default_code,
        'fontSize' => 14,
        'imageType' => 2,
        'itemsCount' => 'a',
        'widgetTitle' => 'a',
        'displayType' => 'content',
        'fontFamily' => 'a',
        'nthParagraphValue' => 2,
        'widgetType' => 0,
        'colorSet' => 'a',
        'widgetPosition' => 'b',
        'widgetId' => congoroWidgetFunctions::generateRandomString(30)
    );

    //get all active/saved widgets
    if ($widget_settings = get_option('congoro_widgets_settings')) {
        $active_widgets = (array) json_decode($widget_settings);
    } else {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $active_widgets[$default_setting['widgetId']] = $default_setting;
        }
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $result = false;

        //==============================
        //Remove congoro widget from db
        //==============================
        if ($_POST['remove_widget'] == true) {
            $widgetId = $_POST['widgetId'];

            if (isset($active_widgets[$widgetId])) {
                unset($active_widgets[$widgetId]);

                update_option('congoro_widgets_settings', json_encode($active_widgets));
            }

            die();
        }

        //==============================
        //Save or edit congoro widget
        //==============================

        //un-register widget
        if ($_POST['displayType'] !== 'widget') {
            add_action('widgets_init', 'congoroWidgetFunctions::removeWidget');
        }

        //update widget setting
        $active_widgets[$_POST['widgetId']] = array(
	        'widgetCode' => congoroWidgetFunctions::stripBackslashes($_POST['congoro_widget_code']),
	        'fontSize' => $_POST['fontSize'],
	        'fontFamily' => $_POST['fontFamily'],
	        'imageType' => $_POST['imageType'],
	        'itemsCount' => $_POST['itemsCount'],
	        'widgetTitle' => $_POST['widgetTitle'],
	        'displayType' => $_POST['widgetType']!=2?$_POST['displayType']:'endoftheme',
	        'nthParagraphValue' => $_POST['nthParagraphValue'],
	        'widgetType' => $_POST['widgetType'],
	        'colorSet' => $_POST['colorSet'],
	        'widgetPosition' => $_POST['widgetPosition'],
	        'widgetId' => $_POST['widgetId']
        );

        update_option('congoro_widgets_settings', json_encode($active_widgets));

        //is ajax request
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            ob_clean();

            echo $result;
            die(); // this is required to terminate immediately and return a proper response
        }
    }

    require "form.php";
}
