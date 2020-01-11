<?php

namespace elephantsGroup\mapbox\components;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class Map extends Widget
{
	public $language;
	public $view_file = 'map';
	public $id = '';
	public $points = [];
	public $zoom;
	public $minZoom;
	public $maxZoom;
	public $pitch;
	public $minPitch;
	public $maxPitch;
	public $style;
	public $hash;
	public $interactive;
	public $center;
	public $firstPointAsCenter = false;
	public $modes;
	public $layers;
	public $showSymbols;
	public $showRoutes;

	public function init()
	{
		$module = \Yii::$app->getModule('mapbox');

		if (!isset($this->language) || !$this->language)
			$this->language = Yii::$app->language;

		if (!isset($this->id) || empty($this->id))
			$this->id = 'map' . rand();

		if (!isset($this->zoom) || empty($this->zoom))
			$this->zoom = $module->zoom;

		if (!isset($this->minZoom) || empty($this->minZoom))
			$this->minZoom = $module->minZoom;

		if (!isset($this->maxZoom) || empty($this->maxZoom))
			$this->maxZoom = $module->maxZoom;

		if (!isset($this->pitch) || empty($this->pitch))
			$this->pitch = $module->pitch;

		if (!isset($this->minPitch) || empty($this->minPitch))
			$this->minPitch = $module->minPitch;

		if (!isset($this->maxPitch) || empty($this->maxPitch))
			$this->maxPitch = $module->maxPitch;

		if (!isset($this->style) || empty($this->style))
			$this->style = $module->style;

		if (!isset($this->hash))
			$this->hash = $module->hash;

		if (!isset($this->interactive))
			$this->interactive = $module->interactive;

		if (!isset($this->center) || empty($this->center))
			$this->center = $module->center;

		if (!isset($this->modes) || empty($this->modes))
			$this->modes = $module->modes;

		if (!isset($this->showSymbols))
			$this->showSymbols = $module->showSymbols;

		if (!isset($this->showRoutes) || empty($this->showRoutes))
			$this->showRoutes = $module->showRoutes;

		if (isset($this->points) && !empty($this->points))
		{
			$coordinates = [];
			$features = [];
			foreach ($this->points as $point)
			{
				$coordinates[] = [ $point['long'], $point['lat']];

				$features[] = [
					'type' => 'Feature',
					'properties' => [],
					'geometry' => [
						'type' => 'Point',
						'coordinates' => [ $point['long'], $point['lat'] ]
					]
				];
			}
			
			if ($this->showSymbols)
				$this->layers[] = [
					'id' => 'symbols',
					'type' => 'symbol',
					'source' => [
						'type' => 'geojson',
						'data' => [
							'type' => 'FeatureCollection',
							'features' => $features
						]
					],
					'layout' => [
						'icon-image' => 'embassy-15'
					]
				];

			if ($this->showRoutes)
				$this->layers[] = [
					'id' => 'route',
					'type' => 'line',
					'source' => [
						'type' => 'geojson',
						'data' => [
							'type' => 'Feature',
							'properties' => [],
							'geometry' => [
								'type' => 'LineString',
								'coordinates' => $coordinates
							]
						]
					],
					'layout' => [
						'line-join' => 'round',
						'line-cap' => 'round'
					],
					'paint' => [
						'line-color' => '#888',
						'line-width' => 2
					]
				];
		}

		if (!isset($this->points[0]) && $this->firstPointAsCenter)
			$this->firstPointAsCenter = false;
	}

    public function run()
	{
        return $this->render($this->view_file,[
			'id' => $this->id,
			'points' => $this->points,
			'zoom' => $this->zoom,
			'minZoom' => $this->minZoom,
			'maxZoom' => $this->maxZoom,
			'pitch' => $this->pitch,
			'minPitch' => $this->minPitch,
			'maxPitch' => $this->maxPitch,
			'style' => $this->style,
			'modes' => $this->modes,
			'layers' => $this->layers,
			'hash' => $this->hash,
			'interactive' => $this->interactive,
			'center' => $this->center,
			'firstPointAsCenter' => $this->firstPointAsCenter,
		]);
	}
}
