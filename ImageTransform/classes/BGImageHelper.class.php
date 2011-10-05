<?php
/**
 * @uses sfConfig
 */
class BGImageHelper {

	public static function usePreset( $sPath, $sPreset, &$oImage = null ) {
		/**
		 * @todo: возможность скармливать не только абсолютный путь
		 */
		if ( !file_exists( $sPath ) ) {
			return false;
		}
		$oImage = new BGImage( $sPath );
		return $oImage->$sPreset()->Fetch();
	}

	public static function addPreset( $sPresetName, $aPresetConfig ) {
		$aOptions = &sfConfig::getRawOptions();
		$aOptions['presets'][$sPresetName] = $aPresetConfig;
	}

}

?>