<?php

Class Node {
	public $char;
	public $children;
	public $is_entry;
	
	public function __construct($char) {
		$this->char = $char;
		$this->children = [];
		$this->is_entry = 0;
	}
}