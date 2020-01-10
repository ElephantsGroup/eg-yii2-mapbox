<?php

namespace elephantsGroup\mapbox\assets;

use yii\web\AssetBundle;
use yii\web\View;

class MapboxAsset extends AssetBundle
{
    public $sourcePath = '@vendor/elephantsgroup/eg-yii2-mapbox/assets';
   
    public function init() {
        $this->jsOptions['position'] = View::POS_END;
        parent::init();
    }

	public $css = [
        'css/mapbox-gl.css',
        'css/mapbox-gl-geocoder.css',
	];
    public $js = [
        'js/mapbox-gl.js',
        'js/mapbox-gl-geocoder.min.js',
	];
    public $depends = [
    ];
}
