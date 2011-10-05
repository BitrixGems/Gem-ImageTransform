<?php
/**
 * Притворяемся, что у нас есть sfConfig
 * Необходим, посколько sfImageTransformPlugin привязан к sfConfig
 * @todo Если кто-то замыслит обернуть еще одну плагину к симфони, завязанную на sfConfig, случится нехорошее :)
 */
class sfConfig {

	private static $aOptions;

	/**
	 * Подсовываем объект, из которого будем дергать значения конфига
	 * @param BGImageTransform_Options $aOptions
	 * @todo завязан на BGImageTransform_Options, но в данном случае сойдет
	 */
	public static function init( array $aOptions ) {
		self::$aOptions = $aOptions;
	}

	/**
	 * Заставляем вызывающего думать, что возвращаем значения из ветки app/sfImageTransformPlugin
	 * @param <type> $sPath ключ
	 * @param <type> $aDefaults значение, которое вернется, если не существует записи по пути $sPath
	 * @return <type> значение по пути $sPath
	 */
	public static function get( $sPath, $aDefaults=null ) {
		$sKey = str_replace( 'app_sfImageTransformPlugin_', '', $sPath );
		if ( !isset( self::$aOptions[$sKey] ) ) {
			return $aDefaults;
		}
		return self::$aOptions[$sKey];
	}

	public function &getRawOptions() {
		return self::$aOptions;
	}

}

?>