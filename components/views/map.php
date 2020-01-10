<?php
use elephantsGroup\mapbox\assets\MapbpxAsset;

MaoboxAsset::register($this);
$module = \Yii::$app->getModule('base');
$module_mapbox = \Yii::$app->getModule('mapbox');
?>

<div class="map" id="map"></div>

<?php
$mapCode = "mapboxgl.accessToken = '" . $module_mapbox->token . "';";

$this->registerJs($mapCode, \yii\web\View::POS_END);
?>
