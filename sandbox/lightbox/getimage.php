<?php
require 'phar://libs/imagine.phar';
$imagine = new Imagine\Gd\Imagine();

$height = 300;
$width = 500;
$size = new Imagine\Image\Box($width, $height);

$color = new Imagine\Image\Color('0000FF', 0);
$image = $imagine->create($size, $color);

header('Content-Type: image/png');
echo $image;

