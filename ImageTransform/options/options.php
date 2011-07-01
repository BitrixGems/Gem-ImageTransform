<?php return array (
  'default_adapter' => 'GD',
  'default_image' => 
  array (
    'mime_type' => 'image/png',
    'filename' => 'Untitled.png',
    'width' => '100',
    'height' => '100',
    'color' => '#FFFFFF',
  ),
  'font_dir' => dirname( __FILE__ ).'/../fonts/dejavu-fonts-ttf-2.33/ttf/',
  'mime_type' => 
  array (
    'auto_detect' => true,
    'library' => 'gd_mime_type',
  ),
  'image_cache_dir' => $_SERVER['DOCUMENT_ROOT'].'/upload/images/',
  'presets' => 
  array (),
);?>