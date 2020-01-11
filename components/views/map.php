<?php
use elephantsGroup\mapbox\assets\MapboxAsset;

MapboxAsset::register($this);
$module_base = \Yii::$app->getModule('base');
$module_mapbox = \Yii::$app->getModule('mapbox');
?>

<div class="map" id="<?= $id ?>"></div>
<?php if (isset($modes) && !empty($modes)) : ?>
<div class="map-switch-mode" id="<?= $id ?>-sm">
<?php foreach ($modes as $idx => $mode) : ?>
    <input id="<?= $id ?>-<?= $mode['key'] ?>" type="radio" name="rToggle<?= $id ?>" value="<?= $mode['key'] ?>"<?= $idx == 0 ? ' checked="checked"' : '' ?>>
    <label for="<?= $id ?>-<?= $mode['key'] ?>"><?= $mode['title'] ?></label>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php
if ($firstPointAsCenter && isset($points[0]))
{
    $lat = $points[0]['lat'] ?? 35.6892;
    $long = $points[0]['long'] ?? 51.3890;
}
else
{
    $long = $center[0];
    $lat = $center[1];
}    
$hashStr = $hash ? 'true' : 'false';
$interactiveStr = $interactive ? 'true' : 'false';
$mapCode = <<<EOD
mapboxgl.accessToken = '$module_mapbox->token';
var $id = new mapboxgl.Map({
    container: '$id',
    style: 'mapbox://styles/mapbox/$style',
    center: [$long, $lat],
	zoom: $zoom,
	minZoom: $minZoom,
    maxZoom: $maxZoom,
    pitch: $pitch,
	minPitch: $minPitch,
    maxPitch: $maxPitch,
    hash: $hashStr,
	interactive: $interactiveStr,
	boxZoom: false,
});\n
EOD;

if (isset($modes) && !empty($modes))
{
    $mapCode .= <<<EOD
    var modeList_$id = document.getElementById('$id-sm');
    var inputs_$id = modeList_$id.getElementsByTagName('input');
    
    function switchMode_$id(mode) {
        var modeId = mode.target.value;
        $id.setStyle('mapbox://styles/mapbox/' + modeId);
    }
    
    for (var i = 0; i < inputs_$id.length; i++) {
        inputs_{$id}[i].onclick = switchMode_$id;
    }
    
    $id.addControl(new mapboxgl.NavigationControl());\n
    EOD;
}

if (isset($layers) && !empty($layers))
{
    $mapCode .= "$id.on('style.load', function () {\n";
    foreach ($layers as $layer)
        $mapCode .= "$id.addLayer(" . json_encode($layer) . ");\n";
    $mapCode .= "})\n";
}


$this->registerJs($mapCode, \yii\web\View::POS_END);
?>
