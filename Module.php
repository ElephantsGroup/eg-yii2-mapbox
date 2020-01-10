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
