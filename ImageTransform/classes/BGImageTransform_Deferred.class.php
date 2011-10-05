<?php
/**
 * Объект хранит цепочку вызовов методов
 * Метод Apply служит для применения сохраненной цепочки к какому-либо объекту
 * в режиме Deferred::CHAIN методы применяются к результату выполнения предыдущего метода
 * в режиме Deferred::SERIAL методы применяются к исходному объекту (имеет смысл, если они изменяют его состояние)
 */
class BGImageTransform_Deferred {

	private $aCallbacks;
	public $onCallChainChange;

	function __construct() {
		$this->aCallbacks = array();
		$this->onCallChainChange = new BGImageTransform_Event();
	}

	private function onCallChainChange() {
		$this->onCallChainChange->Fire( $this->getCallChain() );
	}

	public function reset() {
		$this->aCallbacks = array();
	}

	public function __call( $sMethodName, $aArgs ) {
		return $this->addCallbackArray( $sMethodName, $aArgs );
	}

	public function addCallbackArray( $sMethodName, $aArgs ) {
		$aCallbackInfo = array(
			"method" => $sMethodName,
			"args" => $aArgs,
		);
		$this->aCallbacks[] = $aCallbackInfo;
		$this->onCallChainChange();
		return $this;
	}

	public function apply( $oTarget, $sMode = BGImageTransform_Deferred::CHAIN ) {
		$mResult = $oTarget;
		foreach ( $this->aCallbacks as $aCallbackInfo ) {
			$aCallback = array($mResult, $aCallbackInfo['method']);
			if ( !is_callable( $aCallback ) ) {
				throw new InvalidArgumentException();
			}
			switch ($sMode) {
				case BGImageTransform_Deferred::CHAIN:
					$mResult = call_user_func_array( $aCallback, $aCallbackInfo['args'] );
					break;
				case BGImageTransform_Deferred::SERIAL:
					call_user_func_array( $aCallback, $aCallbackInfo['args'] );
					break;
				default:
					throw new Exception( "Unknown execution mode" );
			}
		}
		return $mResult;
	}

	public function getCallChain() {
		return $this->aCallbacks;
	}

	//Execution modes
	const CHAIN = "chain";
	const SERIAL = "serial";
}

?>