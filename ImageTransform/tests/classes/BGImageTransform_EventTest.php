<?php
class ImageTransformEventTestHelper_eventOwner {

	public $onCounterChange;
	private $iCounter;

	public function __construct() {
		$this->onCounterChange = new BGImageTransform_Event();
	}

	public function setCounter( $iValue ) {
		$this->iCounter = $iValue;
		$this->onCounterChange();
	}

	private function onCounterChange() {
		$this->onCounterChange->fire( $this->iCounter );
	}

}

class ImageTransformEventTestHelper_eventSubscriber {

	public $iCounter;

	public function setCounter( $iValue ) {
		$this->iCounter = $iValue;
	}

}

class BGImageTransform_EventTest extends PHPUnit_Framework_TestCase {

	public function testRegister() {
		$oEventOwner = new ImageTransformEventTestHelper_eventOwner();
		$oEventSubscriber = new ImageTransformEventTestHelper_eventSubscriber();
		$oEventOwner->onCounterChange->Register( array($oEventSubscriber, "setCounter") );
		$oEventSubscriber->setCounter( 0 );
		$oEventOwner->setCounter( 5 );
		$this->assertEquals( $oEventSubscriber->iCounter, 5 );
	}

	public function testUnRegister() {
		$oEventOwner = new ImageTransformEventTestHelper_eventOwner();
		$oEventSubscriber = new ImageTransformEventTestHelper_eventSubscriber();
		$oEventOwner->onCounterChange->Register( array($oEventSubscriber, "setCounter") );
		$oEventSubscriber->setCounter( 0 );
		$oEventOwner->setCounter( 5 );
		$oEventOwner->onCounterChange->unRegister( array($oEventSubscriber, "setCounter") );
		$oEventOwner->setCounter( 10 );
		$this->assertEquals( $oEventSubscriber->iCounter, 5 );
	}

	public function testUnRegisterOnEmpty() {
		$oEventOwner = new ImageTransformEventTestHelper_eventOwner();
		$oEventSubscriber = new ImageTransformEventTestHelper_eventSubscriber();
		$oEventOwner->onCounterChange->unRegister( array($oEventSubscriber, "setCounter") );
	}

	public function testRegisterMultiple() {
		$oEventOwner = new ImageTransformEventTestHelper_eventOwner();
		$oEventSubscriber = new ImageTransformEventTestHelper_eventSubscriber();
		$oEventSubscriber2 = new ImageTransformEventTestHelper_eventSubscriber();
		$oEventOwner->onCounterChange->Register( array($oEventSubscriber, "setCounter") );
		$oEventOwner->onCounterChange->Register( array($oEventSubscriber2, "setCounter") );
		$oEventSubscriber->setCounter( 0 );
		$oEventSubscriber2->setCounter( 0 );
		$oEventOwner->setCounter( 5 );
		$this->assertEquals( $oEventSubscriber->iCounter, 5 );
		$this->assertEquals( $oEventSubscriber2->iCounter, 5 );
	}

}

?>