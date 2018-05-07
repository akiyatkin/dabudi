<?php
namespace akiyatkin\dabudi;

use infrajs\each\Each;
use infrajs\path\Path;
/*
	На основе данных из разных источников может быть создана структура данных с которой будет работать интерфейс.
	
	Артикул
	Производитель
	Группа
	
	Модель

*/
class Dabudi {
	public static $conf;
	public static function propget($model, $prop, $item = array()) {
		if ($item) {
			if (isset($item[$prop])) return $item[$prop];
			if (isset($item['more'][$prop])) return $item['more'][$prop];
		}
		if (isset($model[$prop])) return $model[$prop];
		if (isset($model['more'][$prop])) return $model['more'][$prop];
	}
	public static function propset($model, $prop, $val) {
		if (isset($model[$prop])) $model[$prop] = $val;
		if (isset($model['more'][$prop])) $model['more'][$prop] = $val;
	}
	public static $propmainident = []; //Идентифицирующие указываем из списка известных, остальные там описательные
	public static $propmoredescr = []; //Описательные свойства указываем из списка more, остальные в more идентифицирующие
	public static $idrows = [];
	public static function runItems(&$pos, $call) {
		$call($pos, $pos);
		return Each::exec($pos['items'], function &($item) use ($call){
			$r = $call($item);
			if (!is_null($r)) return $r;
			return $r;
		});
	}
	public static function getIdRows($model) {
		$type = (isset($model['type']))? $model['type'] : '';
		if ($type && isset(Model::$idrows[$type])) return Model::$idrows[$type];
		$rows = [];

		foreach ($model['itemrows'] as $prop => $one) {
			if ($prop == 'more') continue;
			if (isset($model[$prop]) && !in_array($prop, Model::$propmainident)) continue;
			if (isset($model['more'][$prop]) && in_array($prop, Model::$propmoredescr)) continue;
			$rows[] = $prop;
		}
		if ($type) Model::$idrows[$type] = $rows;
		return $rows;
	}
	public static function getId($model, $item = array()) {
		$rows = Model::getIdRows($model);
		$id = [];
		foreach ($rows as $prop) {
			$id[] = Model::propget($model, $prop, $item);
		}
		$id = implode(' ', $id);
		$id = Path::encode($id);
		return $id;
	}
}