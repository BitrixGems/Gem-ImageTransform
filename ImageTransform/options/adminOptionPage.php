<?
/*
function parseFile( $sPath ) {
	$oContent = file_get_contents( $sPath );
	$aMatches = array();
	preg_match( "/__construct\((.*)\)/", $oContent, $aMatches );
	$aParams = $aMatches[1];
	preg_match( "/class sfImage(.*?)\s/", $oContent, $aMatches );
	$sClassName = $aMatches[1];
	return array(
		'name' => $sClassName,
		'args' => $aParams
		);
	//@todo распарсить параметры и php-doc стырить, где есть
}

//возможные трансформации
$sDirectory = dirname( __FILE__ ) . "/../lib/sfImageTransformPlugin/lib/transforms/";
$oIterator = new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $sDirectory ) );
$aTransforms = array();
foreach ( $oIterator as $oFile ) {
	$sFilename = $oFile->getFilename();
	if ( (strpos( $sFilename, "GD" ) !== false || strpos( $sFilename, "ImageMagick" ) !== false) && strpos( $sFilename, "svn" ) === false ) {
		$aTransforms[] = parseFile( $oFile->getRealPath() );
	}
}

var_dump( $aTransforms );

$aPresets = $aOptions['presets']['value'];*/


CAdminMessage::ShowMessage(
	array(
		'TYPE'=>'OK',
		'MESSAGE' => 'Внимание<br />Гем в первую очередь предназначен для разработчиков, поэтому все настройки на текущий момент находятся в options.php.<br />Подробнее можно посмотреть в прилагаемом файле readme.odt, либо на <a href="http://bitrixgems.ru/gems/ImageTransform/">страничке гема</a>',
		'HTML' => true
	)
);
?>
