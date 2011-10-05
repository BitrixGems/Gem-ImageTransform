<?
/**
 * Событие
 */
class BGImageTransform_Event implements BGImageTransform_IObservable {

	private $aCallbacks;

	function __construct() {
		$this->aCallbacks = array();
	}

	public function register( array $aCallback ) {
		if ( !is_callable( $aCallback ) ) {
			throw new Exception( var_export( $aCallback, true ) . "is not callable!" );
		}
		$this->aCallbacks[] = $aCallback;
	}

	public function unRegister( array $aCallback ) {
		if ( !is_callable( $aCallback ) ) {
			throw new Exception( var_export( $aCallback, true ) . "is not callable!" );
		}
		$this->aCallbacks = array_diff( $this->aCallbacks, array($aCallback) );
	}

	public function fire( $oNotifyObject ) {
		foreach ( $this->aCallbacks as $aCallback ) {
			call_user_func_array( $aCallback, array($oNotifyObject) );
		}
	}

}

?>