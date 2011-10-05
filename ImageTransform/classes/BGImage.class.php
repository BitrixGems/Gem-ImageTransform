<?php
/**
 * Шоткат к врапперу sfImage
 * Кешер, url относительно корня сайта
 * @todo: url относительно корня - !Ъ
 */
class BGImage extends sfImageWrapper {

	public function __construct( $sFilename='', $sMime='', $sAdapter='' ) {
		/**
		 * Создаем кэшер файлов
		 */
		$oImageCacher = new BGImageCacher( sfConfig::get('image_cache_dir') );
		parent::__construct( $oImageCacher, $sFilename, $sMime, $sAdapter );
	}

	/**
	 * Получаем url изображения относительно корня сайта
	 * @return <string> url изображения
	 */
	public function Fetch() {
		return str_replace( $_SERVER['DOCUMENT_ROOT'], "", parent::Fetch() );
	}

}

?>