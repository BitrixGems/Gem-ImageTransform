<?php
/**
 * Кэшер изображений
 * @todo: очистка кеша
 */
class BGImageCacher {

	protected $sCacheDirPath;

	/**
	 * @param <type> $sCacheDirPath Путь к каталогу, в котором лежат закешированные изображения
	 */
	function __construct( $sCacheDirPath ) {
		if ( !file_exists( $sCacheDirPath ) ) {
			mkdir( $sCacheDirPath, 0777, true );
		}
		$this->sCacheDirPath = $sCacheDirPath;
	}

	public function has( $sKey ) {
		return file_exists( $this->getFilenameByKey( $sKey ) );
	}

	public function get( $sKey ) {
		return $this->getFilenameByKey( $sKey );
	}

	public function set( $sKey, $mData ) {
		$sFilename = $this->getFilenameByKey( $sKey );
		/**
		 * рекурсивно создаем директории
		 */
		if ( !file_exists( dirname( $sFilename ) ) ) {
			mkdir( dirname( $sFilename ), 0777, true );
		}
		return file_put_contents( $sFilename, $mData );
	}

	/**
	 * Получаем имя файла по ключу $sKey
	 * @param <type> $sKey
	 * @return <type> Путь к файлу
	 */
	private function getFilenameByKey( $sKey ) {
		/**
		 * Файлы будем распихивать по подпапкам, дабы фс не подохла от слишком
		 * большого количества файлов в одной директории
		 */
		return $this->sCacheDirPath . substr( $sKey, 0, 3 ) . '/' . substr( $sKey, 3 );
	}

}

?>