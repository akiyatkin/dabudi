<?php
use infrajs\template\Template;
use akiyatkin\dabudi\Model;

Template::$scope['Dabudi'] = array();
Template::$scope['Dabudi']['propget'] = function ($pos, $prop, $item = array()) {
	
	return Model::propget($pos, $prop, $item);
};