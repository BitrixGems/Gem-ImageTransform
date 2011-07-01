<?php
class ImageTransformDeferredTestHelper{

	public $calls;

	public function foo(){
		$this->calls[] = "foo";
		return $this;
	}

	public function bar(){
		$this->calls[] = "bar";
		return $this;
	}

	public function baz(){
		$this->calls[] = "baz";
		return 100;
	}
}

class BGImageTransform_DeferredTest extends PHPUnit_Framework_TestCase {

	public function testNewObjectsCallChainIsEmpty() {
		$oDeferred = new BGImageTransform_Deferred();
		$aCallChain = $oDeferred->getCallChain();
		$this->assertTrue( empty( $aCallChain ) );
	}

	public function testCallSingleMethod() {
		$oDeferred = new BGImageTransform_Deferred();
		$oDeferred->foo();
		$this->assertEquals(
			$oDeferred->getCallChain(),
			array(
				array(
					'method' => 'foo',
					'args' => array()
				)
			)
		);
	}

	public function testCallSingleMethodWithArgument() {
		$oDeferred = new BGImageTransform_Deferred();
		$oDeferred->foo( 0 );
		$this->assertEquals(
			$oDeferred->getCallChain(),
			array(
				array(
					'method' => 'foo',
					'args' => array(0)
				)
			)
		);
	}

	public function testCallSingleMethodWithArguments() {
		$oDeferred = new BGImageTransform_Deferred();
		$oDeferred->foo( 0, 1, 2, 3, 4, 5 );
		$this->assertEquals(
			$oDeferred->getCallChain(),
			array(
				array(
					'method' => 'foo',
					'args' => array(0, 1, 2, 3, 4, 5)
				)
			)
		);
	}

	public function testCallSingleMethodWithArrayArgument() {
		$oDeferred = new BGImageTransform_Deferred();
		$oDeferred->foo( array(123) );
		$this->assertEquals(
			$oDeferred->getCallChain(),
			array(
				array(
					'method' => 'foo',
					'args' => array(array(123))
				)
			)
		);
	}

	public function testCallMultipleMethods() {
		$oDeferred = new BGImageTransform_Deferred();
		$oDeferred->foo()->bar()->baz();
		$this->assertEquals(
			$oDeferred->getCallChain(),
			array(
				array(
					'method' => 'foo',
					'args' => array()
				),
				array(
					'method' => 'bar',
					'args' => array()
				),
				array(
					'method' => 'baz',
					'args' => array()
				)
			)
		);
	}

	public function testReset() {
		$oDeferred = new BGImageTransform_Deferred();
		$oDeferred->foo()->bar();
		$oDeferred->reset();
		$oDeferred->baz();
		$this->assertEquals(
			$oDeferred->getCallChain(),
			array(
				array(
					'method' => 'baz',
					'args' => array()
				),
			)
		);
	}

	public function testApplySerial() {
		$oHelper = new ImageTransformDeferredTestHelper();
		$oDeferred = new BGImageTransform_Deferred();
		$oDeferred->foo()->bar()->baz();
		$mResult = $oDeferred->Apply( $oHelper, BGImageTransform_Deferred::SERIAL );
		$this->assertEquals( $mResult, $oHelper );
		$this->assertEquals( $oHelper->calls, array("foo", "bar", "baz") );
	}

	public function testApplyChain() {
		$oHelper = new ImageTransformDeferredTestHelper();
		$oDeferred = new BGImageTransform_Deferred();
		$oDeferred->foo()->bar()->baz();
		$mResult = $oDeferred->Apply( $oHelper, BGImageTransform_Deferred::CHAIN );
		$this->assertEquals( $mResult, $oHelper->foo()->bar()->baz() );
	}
}

?>