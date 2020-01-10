<?php

namespace elephantsGroup\mapbox\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Comments extends Widget
{
    public $token = "";
	public $language;
    public $view_file = 'map';

	public function init()
	{
		$module = \Yii::$app->getModule('mapbox');

		if(!isset($this->language) || !$this->language)
			$this->language = Yii::$app->language;
	}

    public function run()
	{
        return $this->render($this->view_file);
	}
}
