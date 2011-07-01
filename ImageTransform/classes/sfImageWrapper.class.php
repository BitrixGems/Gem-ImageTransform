<?php
/**
 * Обертка над sfImage с поддержкой кеширования и пресетов
 * @todo sfConfig обязан быть инициализирован перед использованием этого класса
 * @todo кэшер для пресетов?
 * @todo закрыть/реализовать "опасные" методы из sfImage (setFilename и т.п.)
 * @uses BGImageTransform_Deferred
 * @uses sfConfig
 */
class sfImageWrapper {

	protected $oImageCacher, $sFilename;
	protected $sKey, $bKeyIsDirty;
	protected $oImage;
	protected $oCallChain;

	public function __construct( $oImageCacher, $filename='', $mime='', $adapter='' ) {
		$this->oImageCacher = $oImageCacher;
		$this->oCallChain = new BGImageTransform_Deferred();
		$this->sFilename = $filename;
		$this->oImage = new sfImage( $filename, $mime, $adapter );
		$this->bKeyIsDirty = true;
		$this->oCallChain->onCallChainChange->Register( array($this, "markKeyDirty") );
	}

	/**
	 * Отложенный вызов трансформации или пресета.
	 * @param <type> $sMethodName
	 * @param <type> $aArgs
	 * @return sfImageWrapper
	 */
	public function __call( $sMethodName, $aArgs ) {
		$aPresetsConfig = sfConfig::get( 'presets' );				

		if ( isset( $aPresetsConfig[$sMethodName] ) ) {
			$aPresetConfig = $aPresetsConfig[$sMethodName];
			//transformations
			$aTransformations = $aPresetConfig['transformations'];
			foreach ( $aTransformations as $aPreset ) {
				$this->oCallChain->addCallbackArray( $aPreset['transformation'], $aPreset['args'] );
			}
			//quality
			if ( is_numeric( $aPresetConfig['quality'] ) ) {
				$this->oCallChain->setQuality( $aPresetConfig['quality'] );
			}
		} else {
			$this->oCallChain->addCallbackArray( $sMethodName, $aArgs );
		}

		return $this;
	}

	/**
	 * Получение ссылки на файл.
	 * @return <string> абсолютный путь к файлу
	 */
	public function Fetch() {
		if ( !$this->oImageCacher->has( $this->getKey() ) ) {
			$this->oImageCacher->set(
				$this->getKey(),
				$this->oCallChain->Apply( $this->oImage, BGImageTransform_Deferred::SERIAL )->toString()
			);
			$this->oCallChain->reset();
		}
		return $this->oImageCacher->get( $this->getKey() );
	}

	protected function getKey() {
		if ( $this->bKeyIsDirty ) {
			/**
                         * @todo: сейчас можно подменить файлик, хеш останется прежним
                         * @todo: если не считать md5 от файла, то кэширование излишне. можно избавить от эвента в Deferred
                         */
			$this->sKey = md5( serialize( $this->oCallChain ) . $this->sFilename ) . "_" . basename( $this->sFilename );
			$this->bKeyIsDirty = false;
		}
		return $this->sKey;
	}

	public function markKeyDirty() {
		$this->bKeyIsDirty = true;
	}

	public function __toString() {
		return $this->Fetch();
	}

	private function getImageInfo() {
		$aKeyReplacement = array(0 => 'width', 1 => 'height', 2 => 'type', 3 => 'attr');
		$aInfo = getimagesize( $this->sFilename );
		$aResult = array();
		foreach ( $aInfo as $sKey => $mValue ) {
			if ( isset( $aKeyReplacement[$sKey] ) ) {
				$sKey = $aKeyReplacement[$sKey];
			}
			$aResult[$sKey] = $mValue;
		}
		return $aResult;
	}

	public function getWidth() {
		$aInfo = $this->getImageInfo();
		return $aInfo['width'];
	}

	public function getHeight() {
		$aInfo = $this->getImageInfo();
		return $aInfo['height'];
	}

	public function __get( $sPropertyName ) {
		$sFuncName = "get" . $sPropertyName;
		return $this->$sFuncName();
	}
}

?>