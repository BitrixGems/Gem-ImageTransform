<?php
if ( !function_exists( 'ImageTransform_autoload' ) ) {
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
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/../classes/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/../lib/sfImageTransformPlugin/lib/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/../lib/sfImageTransformPlugin/lib/adapters/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/../lib/sfImageTransformPlugin/lib/exceptions/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/../lib/sfImageTransformPlugin/lib/transforms/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/../lib/sfImageTransformPlugin/lib/transforms/Generic/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/../lib/sfImageTransformPlugin/lib/transforms/GD/" );
set_include_path( get_include_path() . PATH_SEPARATOR . dirname( __FILE__ ) . "/../lib/sfImageTransformPlugin/lib/transforms/ImageMagick/" );
spl_autoload_extensions( '.class.php, .interface.php, .php' );
if ( function_exists( "__autoload" ) ) {
	spl_autoload_register( "__autoload" );
}
spl_autoload_register( "ImageTransform_autoload" );
require_once dirname( __FILE__ ) . "/../lib/sfImageTransformPlugin/lib/transforms/Generic/sfResizeGeneric.php";
?>