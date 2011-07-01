<?php 
if ( !function_exists( 'ImageTransform_autoload' ) ) {

	//TODO: autoload гемом сделать
	function ImageTransform_autoload( $sClassName ) {
		$aExtensions = explode( ', ', spl_autoload_extensions() );
		$aPaths = explode( PATH_SEPARATOR, get_include_path() );
		foreach ( $aPaths as $sPath ) {
			foreach ( $aExtensions as $sExtension ) {
				$sFile = $sPath . DIRECTORY_SEPARATOR . $sClassName . $sExtension;
				if ( is_readable( $sFile ) ) {
					require_once $sFile;
					return;
				}
			}
		}
	}

}
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/classes/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/lib/sfImageTransformPlugin/lib/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/lib/sfImageTransformPlugin/lib/adapters/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/lib/sfImageTransformPlugin/lib/exceptions/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/lib/sfImageTransformPlugin/lib/transforms/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/lib/sfImageTransformPlugin/lib/transforms/Generic/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/lib/sfImageTransformPlugin/lib/transforms/GD/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/lib/sfImageTransformPlugin/lib/transforms/ImageMagick/" );
spl_autoload_extensions( '.class.php, .interface.php, .php' );
if ( function_exists( "__autoload" ) ) {
	spl_autoload_register( "__autoload" );
}
spl_autoload_register( "ImageTransform_autoload" );
require_once dirname( __FILE__ ) . "/lib/sfImageTransformPlugin/lib/transforms/Generic/sfResizeGeneric.php";

$aConfig = array(
	'default_adapter' => "GD",
	'default_image' => array(
		'mime_type' => 'image/png',
		'filename' => 'Untitled.png',
		'width' => '100',
		'height' => '100',
		'color' => '#FFFFFF',
	),
	'font_dir' => '/usr/share/fonts/truetype/msttcorefonts',
	'mime_type' => array(
		'auto_detect' => true,
		'library' => 'gd_mime_type'
	),
	//где храним кэш картинок?
	'image_cache_dir' => $_SERVER['DOCUMENT_ROOT'] . '/tmp/',
	//пресеты трансформаций
	'presets' => array()
);

sfConfig::init( $aConfig );