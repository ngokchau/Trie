<?php

require "Node.php";

Class Trie {
	private $root;
	private $size;
	private $suggestions;
	
	public function __construct() { 
		$this->root = new Node("*");
		$this->size = 0;
		$this->suggestions = [];
	}
	
	public function add($entry) {
		$letters = str_split($entry);
		
		$this->_add($this->root, $letters, 0);
	}
	
	private function _add($current, $letters, $index) {
		if($index < count($letters)) {
			if(!array_key_exists($letters[$index], $current->children)) {
				$current->children[$letters[$index]] = new Node($letters[$index]);
			}

			$this->_add($current->children[$letters[$index]], $letters, $index + 1);
		}
		else {
			$current->is_entry = 1;
			$this->size++;
		}
	}
	
	public function retrieve($prefix, $qty) {
		$letters = str_split($prefix);
		
		$this->_retrieve($this->root, $letters, $qty, 0, "");
		
		return $this->suggestions;
	}
	
	private function _retrieve($current, $letters, $qty, $index, $word) {
		if(
			$index < count($letters) &&
			array_key_exists($letters[$index], $current->children)
		) {
			$this->_retrieve($current->children[$letters[$index]], $letters, $qty, $index + 1, $word.$letters[$index]);
		}
		else if(
			$index >= count($letters)
		) {
			for($i = 0; $i < count($current->children); $i++) {
				$this->_retrieve($current->children[array_keys($current->children)[$i]], $letters, $qty, $index + 1, $word.array_keys($current->children)[$i]);
			}
			if($current->is_entry && count($this->suggestions) < $qty) {
				$this->suggestions[] = $word;
			}
		}
	}
	
	public function remove($entry) {
		$letters = str_split($entry);
		
		$this->_remove($this->root, $letters, 0);
	}
	
	private function _remove($current, $letters, $index) {
		if(
			$index < count($letters) - 1 && 
			array_key_exists($letters[$index], $current->children)
		) {
			$this->_remove($current->children[$letters[$index]], $letters, $index + 1);
		}
		
		if($index == count($letters) - 1) {
			$current->children[$letters[$index]]->is_entry = 0;
		}
		
		if(
			array_key_exists($letters[$index], $current->children) &&
			empty($current->children[$letters[$index]]->children) &&
			!$current->children[$letters[$index]]->is_entry
		) {
			unset($current->children[$letters[$index]]);
		}
	}
	
	public function search($entry) {
		$letters = str_split($entry);
		
		return $this->_search($this->root, $letters, 0);
	}
	
	private function _search($current, $letters, $index) {
		if(
			$index < count($letters) &&
			array_key_exists($letters[$index], $current->children)
		) {
			return $this->_search($current->children[$letters[$index]], $letters, $index + 1);
		}
		else if($index == count($letters)) {
			return $current->is_entry;
		}
		else {
			return 0;
		}
		
	}
	
	public function size() {
		return $this->size;
	}
}