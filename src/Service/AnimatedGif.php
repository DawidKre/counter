<?php
namespace App\Service;

use Exception;

class AnimatedGif {

    /**
     * The built gif image
     * @var resource
     */
    private $image = '';

    /**
     * The array of images to stack
     * @var array
     */
    private $buffer = [];

    /**
     * How many times to loop? 0 = infinite
     * @var int
     */
    private $loopsNumber = 0;

    /**
     *
     * @var int
     */
    private $DIS = 2;

    /**
     * @var int
     */
    private $transparentColour = -1;

    /**
     * @var int
     */
    private $firstFrame = true;

    function __construct(array $sourceImages, array $imageDelays, int $loopsNumber) {

        $this->loopsNumber = ( $loopsNumber > -1 ) ? $loopsNumber : 0;
        $this->bufferImages($sourceImages);

        $this->addHeader();
        for ($i = 0; $i < count($this->buffer); $i++) {
            $this->addFrame($i, $imageDelays [$i]);
        }
    }

    /**
     * @param array $sourceImages
     * @throws Exception
     */
    private function bufferImages(array $sourceImages) :void
    {
        for ($i = 0; $i < count($sourceImages); $i++) {
            $this->buffer [] = $sourceImages [$i];
            if (substr($this->buffer [$i], 0, 6) != "GIF87a" && substr($this->buffer [$i], 0, 6) != "GIF89a") {
                throw new Exception('Image at position ' . $i. ' is not a gif');
            }
            for ($j = ( 13 + 3 * ( 2 << ( ord($this->buffer [$i] { 10 }) & 0x07 ) ) ), $k = TRUE; $k; $j++) {
                switch ($this->buffer [$i] { $j }) {
                    case "!":
                        if (( substr($this->buffer [$i], ( $j + 3), 8) ) == "NETSCAPE") {
                            throw new Exception('You cannot make an animation from an animated gif.');
                        }
                        break;
                    case ";":
                        $k = false;
                        break;
                }
            }
        }
    }

    private function addHeader() :void
    {
        $this->image = 'GIF89a';
        if (ord($this->buffer [0] { 10 }) & 0x80) {
            $cmap = 3 * ( 2 << ( ord($this->buffer [0] { 10 }) & 0x07 ) );
            $this->image .= substr($this->buffer [0], 6, 7);
            $this->image .= substr($this->buffer [0], 13, $cmap);
            $this->image .= "!\377\13NETSCAPE2.0\3\1" . $this->word($this->loopsNumber) . "\0";
        }
    }

    private function addFrame(int $frame,int  $delay) :void
    {
        $localsStr = 13 + 3 * ( 2 << ( ord($this->buffer [$frame] { 10 }) & 0x07 ) );

        $localsEnd = strlen($this->buffer [$frame]) - $localsStr - 1;
        $localsTmp = substr($this->buffer [$frame], $localsStr, $localsEnd);

        $globalLen = 2 << ( ord($this->buffer [0] { 10 }) & 0x07 );
        $localsLen = 2 << ( ord($this->buffer [$frame] { 10 }) & 0x07 );

        $globalRgb = substr($this->buffer [0], 13, 3 * ( 2 << ( ord($this->buffer [0] { 10 }) & 0x07 ) ));
        $localsRgb = substr($this->buffer [$frame], 13, 3 * ( 2 << ( ord($this->buffer [$frame] { 10 }) & 0x07 ) ));

        $localsExt = "!\xF9\x04" . chr(( $this->DIS << 2 ) + 0) .
            chr(( $delay >> 0 ) & 0xFF) . chr(( $delay >> 8 ) & 0xFF) . "\x0\x0";

        if ($this->transparentColour > -1 && ord($this->buffer [$frame] { 10 }) & 0x80) {
            for ($j = 0; $j < ( 2 << ( ord($this->buffer [$frame] { 10 }) & 0x07 ) ); $j++) {
                if (
                    ord($localsRgb { 3 * $j + 0 }) == ( ( $this->transparentColour >> 16 ) & 0xFF ) &&
                    ord($localsRgb { 3 * $j + 1 }) == ( ( $this->transparentColour >> 8 ) & 0xFF ) &&
                    ord($localsRgb { 3 * $j + 2 }) == ( ( $this->transparentColour >> 0 ) & 0xFF )
                ) {
                    $localsExt = "!\xF9\x04" . chr(( $this->DIS << 2 ) + 1) .
                        chr(( $delay >> 0 ) & 0xFF) . chr(( $delay >> 8 ) & 0xFF) . chr($j) . "\x0";
                    break;
                }
            }
        }
        switch ($localsTmp { 0 }) {
            case "!":
                $localsImg = substr($localsTmp, 8, 10);
                $localsTmp = substr($localsTmp, 18, strlen($localsTmp) - 18);
                break;
            case ",":
                $localsImg = substr($localsTmp, 0, 10);
                $localsTmp = substr($localsTmp, 10, strlen($localsTmp) - 10);
                break;
        }
        if (ord($this->buffer [$frame] { 10 }) & 0x80 && $this->firstFrame === FALSE) {
            if ($globalLen == $localsLen) {
                if ($this->blockCompare($globalRgb, $localsRgb, $globalLen)) {
                    $this->image .= ( $localsExt . $localsImg . $localsTmp );
                } else {
                    $byte = ord($localsImg { 9 });
                    $byte |= 0x80;
                    $byte &= 0xF8;
                    $byte |= ( ord($this->buffer [0] { 10 }) & 0x07 );
                    $localsImg { 9 } = chr($byte);
                    $this->image .= ( $localsExt . $localsImg . $localsRgb . $localsTmp );
                }
            } else {
                $byte = ord($localsImg { 9 });
                $byte |= 0x80;
                $byte &= 0xF8;
                $byte |= ( ord($this->buffer [$frame] { 10 }) & 0x07 );
                $localsImg { 9 } = chr($byte);
                $this->image .= ( $localsExt . $localsImg . $localsRgb . $localsTmp );
            }
        } else {
            $this->image .= ( $localsExt . $localsImg . $localsTmp );
        }
        $this->firstFrame = FALSE;
    }

    private function addFooter() :void
    {
        $this->image .= ";";
    }

    private function blockCompare($globalBlock, $localBlock, $len): bool
    {
        for ($i = 0; $i < $len; $i++) {
            if (
                $globalBlock { 3 * $i + 0 } != $localBlock { 3 * $i + 0 } ||
                $globalBlock { 3 * $i + 1 } != $localBlock { 3 * $i + 1 } ||
                $globalBlock { 3 * $i + 2 } != $localBlock { 3 * $i + 2 }
            ) {
                return false;
            }
        }

        return true;
    }

    private function word(int $int) :string
    {
        return ( chr($int & 0xFF) . chr(( $int >> 8 ) & 0xFF) );
    }

    function getAnimation() :string
    {
        return $this->image;
    }

    function display() :string
    {
        $this->addFooter();
        header('Content-type:image/gif');

        echo $this->image;
    }
}