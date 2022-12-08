<?php

use Faresmts\SafeWords\SafeWords;

require 'vendor/autoload.php';

$text = 'you are a asshole fucker 2g1c';

$safeWords = SafeWords::filter($text)->replace()->get();


echo '<pre>';
var_dump($safeWords);