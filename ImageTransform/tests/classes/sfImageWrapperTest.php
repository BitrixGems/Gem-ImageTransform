<?php

class sfImageWrapperTest extends PHPUnit_Framework_TestCase {

    private $oImage;

    public function setUp() {
        sfConfig::init(array(
                    'default_adapter' => 'GD',
                    'default_image' =>
                    array(
                        'mime_type' => 'image/png',
                        'filename' => 'Untitled.png',
                        'width' => '100',
                        'height' => '100',
                        'color' => '#FFFFFF',
                    ),
                    'font_dir' => '/usr/share/fonts/truetype/ttf-dejavu',
                    'mime_type' =>
                    array(
                        'auto_detect' => true,
                        'library' => 'gd_mime_type',
                    ),
                ));
        $oCacher = new BGImageCacher("/tmp/images");
        $this->aImageInfo = array(
            'width' => 1002,
            'height' => 668
        );
        $this->oImage = new sfImageWrapper($oCacher, dirname(__FILE__) . "/../test.png");
    }

    public function testFetch() {
        $this->assertTrue(file_exists($this->oImage->Fetch()));
        unlink($this->oImage->Fetch());
    }

    public function testToString() {
        $sPath = "" . $this->oImage;
        $this->assertEquals($this->oImage->Fetch(), $sPath);
        unlink($sPath);
    }

    /**
     * тестируем getimagesize^^
     */
    public function testImageInfo() {
        $this->assertEquals($this->oImage->width, $this->aImageInfo['width']);
        $this->assertEquals($this->oImage->height, $this->aImageInfo['height']);
    }

    /**
     * @todo протестировать тут sfImage ?
     */
}
?>