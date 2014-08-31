<?php

require "Trie.php";

$trie = new Trie();
$words = ["car", "barack obama", "cars", "carsy", "carry", "bee", "bambo", "bird"];

sort($words);

$start = memory_get_usage();
$build = explode(" ", microtime())[1];
foreach($words as $word) {
//for($word = "a"; $word < "zz"; $word++) {
	$trie->add($word);
}
$done = explode(" ", microtime())[1];
$end = memory_get_usage();


echo $done." ".$build."<br/>";

echo $trie->search("apple");