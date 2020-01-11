<?php

namespace elephantsGroup\mapbox;

/*
	Mapbox wrapper for Yii2 PHP framework
	Authors : Jalal Jaberi, Arezou Zahedi Majd
	Website : http://elephantsgroup.com
	Revision date : 2020/01/09
*/

use Yii;

class Module extends \yii\base\Module
{
    public $token = "";
    public $zoom = 7;
    public $minZoom = 5;
    public $maxZoom = 17;
    public $pitch = 0;
    public $minPitch = 0;
    public $maxPitch = 60;
    // posiible values: streets-v11, outdoors-v11, light-v10, dark-v10, satellite-v9, satellite-streets-v11,
    //   navigation-preview-day-v4, navigation-preview-night-v4, navigation-guidance-day-v4, navigation-guidance-night-v4
    public $style = 'streets-v11';
    public $hash = false;
    public $interactive = true;
    public $center = [51.3890, 35.6892]; // [lng, lat]
    public $modes = [
        [
            'title' => 'streets',
            'key' => 'streets-v11',
        ],
        [
            'title' => 'satellite',
            'key' => 'satellite-v9',
        ],
    ];
    public $showSymbols = true;
    public $showRoutes = true;

    public function init()
    {
        parent::init();

        if (empty(Yii::$app->i18n->translations['mapbox']))
		{
            Yii::$app->i18n->translations['mapbox'] =
			[
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__ . '/messages',
                //'forceTranslation' => true,
            ];
        }
    }

    public static function t($category, $message, $params = [], $language = null)
    {
        return \Yii::t($category, $message, $params, $language);
    }
}
