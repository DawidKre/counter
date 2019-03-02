<?php

namespace App\Service;

use DateTime;
use Exception;

class CreateCounter {

    private $counterParams;

    private $counterIntParams;

    /**
     * CreateCounter constructor.
     */
    public function __construct()
    {
        $this->counterParams = [
            'font' => 'DIGITALDREAM.ttf',
            'templateImage' => 'countdown.png',
            'color' => 'FFFFFF',
        ];

        $this->counterIntParams = [
            'fontSize' => 40,
            'angle' => 0,
            'xOffset' => 10,
            'yOffset' => 70,
            'time' => strtotime('tomorrow'),
        ];
    }

    /**
     * @param array $params
     * @return string
     * @throws Exception
     */
    public function createCounterGif(array $params) :string
    {
        foreach ($params as $key => $param) {
            if(isset($this->counterParams[$key]) && $param) {
                $this->counterParams[$key] = $param;
            }
            if(isset($this->counterIntParams[$key]) && $param) {
                $this->counterIntParams[$key] = intval($param);
            }
        }

        $futureDate = new DateTime();
        $futureDate->setTimestamp($this->counterIntParams['time']);
        $timeNow = time();
        $now = new DateTime(date('r', $timeNow));
        $frames = $delays = [];
        $delay = 100;
        $loops = 0;
        for($i = 0; $i <= 60; $i++){
            $interval = date_diff($futureDate, $now);
            $image = imagecreatefrompng('templates/'.$this->counterParams['templateImage']);
            if($futureDate < $now){
                $text = $interval->format('00:00:00:00');
                $loops = 1;
            } else {
                $text = $interval->format('%a:%H:%I:%S');
                if(preg_match('/^[0-9]\:/', $text)){
                    $text = '0'.$text;
                }
            }

            imagettftext(
                $image,
                $this->counterIntParams['fontSize'],
                $this->counterIntParams['angle'],
                $this->counterIntParams['xOffset'],
                $this->counterIntParams['yOffset'],
                $this->hexColorAlloc($image, $this->counterParams['color']),
                'fonts/'.$this->counterParams['font'],
                $text
            );

            ob_start();
            imagegif($image);
            $frames[] = ob_get_contents();
            $delays[] = $delay;
            ob_end_clean();
            $now->modify('+1 second');
        }

        header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
        header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
        header( 'Cache-Control: no-store, no-cache, must-revalidate' );
        header( 'Cache-Control: post-check=0, pre-check=0', false );
        header( 'Pragma: no-cache' );

        $gif = new AnimatedGif($frames,$delays,$loops);

        return $gif->display();
    }

    private function hexColorAlloc($im,$hex){
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));

        return ImageColorAllocate($im, $r, $g, $b);
    }
}