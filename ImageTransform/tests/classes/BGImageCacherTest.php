<?php
class BGImageCacherTest extends PHPUnit_Framework_TestCase {

	private $sTestImagePath, $sKey, $sTempDir;

	public function setUp() {
		$this->sTempDir = "/tmp/images/";
		$this->sTestImagePath = dirname( __FILE__ ) . "/../test.png";
		$this->sKey = "keyforthe_test.png";
		$this->cleanTempDir();
	}

	private function cleanTempDir() {
		$this->rrmdir( $this->sTempDir );
	}

	private function rrmdir( $sDir ) {
		if ( is_dir( $sDir ) ) {
			$aFiles = scandir( $sDir );
			foreach ( $aFiles as $aFile ) {
				if ( $aFile != "." && $aFile != ".." ) {
					if ( filetype( $sDir . "/" . $aFile ) == "dir" )
						$this->rrmdir( $sDir . "/" . $aFile ); else
						unlink( $sDir . "/" . $aFile );
				}
			}
			reset( $aFiles );
			rmdir( $sDir );
		}
	}

	public function testCacheDirectoryCreation() {
		$oCacher = new BGImageCacher( $this->sTempDir );
		$this->assertTrue( file_exists( $this->sTempDir ) );
	}

	public function testHas() {
		$oCacher = new BGImageCacher( $this->sTempDir );
		$oCacher->set( $this->sKey, file_get_contents( $this->sTestImagePath ) );
		$this->assertTrue( $oCacher->has( $this->sKey ) );
		$this->assertFalse( $oCacher->has( "123" ) );
	}

}

?>
