<?php

namespace App\Controller;

use App\Entity\Template;
use App\Service\AnimatedGif;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/counters", name="test")
     * @throws \Exception
     */
    public function index(Request $request)
    {

        $time = $request->get('time', strtotime('tomorrow'));
        $fontFamily = $request->get('font', 'DIGITALDREAM');
        $color = $request->get('color', 'FFFFFF');
        $textColor = $request->get('textColor', 'FFFFFF');
        $template = $request->get('template', 'countdown.png');
        $fontFamily = $request->get('font', 'DIGITALDREAM');
        $size = $request->get('size', 40);
        $offset = $request->get('offset', 10);

        $futureDate = new DateTime();
        $futureDate->setTimestamp($time);
        $timeNow = time();
        $now = new DateTime(date('r', $timeNow));
        $frames = [];
        $delays = [];
        $image = imagecreatefrompng('countdown.png');
        $delay = 100; // milliseconds
        $font = [
            'size'=>$size,
            'angle'=>0,
            'x-offset'=>$offset,
            'y-offset'=>70,
            'file'=> 'fonts/'.$fontFamily.'.ttf',
            'color'=>$this->hexColorAlloc($image, $color),
        ];

        for($i = 0; $i <= 60; $i++){
            $interval = date_diff($futureDate, $now);
            $image = imagecreatefrompng('templates/'.$template);
            if($futureDate < $now){
                $text = $interval->format('00:00:00:00');

                imagettftext ($image , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
                ob_start();
                imagegif($image);
                $frames[]=ob_get_contents();
                $delays[]=$delay;
                $loops = 1;
                ob_end_clean();
            } else {
                $text = $interval->format('%a:%H:%I:%S');
                if(preg_match('/^[0-9]\:/', $text)){
                    $text = '0'.$text;
                }

                imagettftext ($image , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] ,$font['file'], $text );
                ob_start();
                imagegif($image);
                $frames[]=ob_get_contents();
                $delays[]=$delay;
                $loops = 0;
                ob_end_clean();
            }
            $now->modify('+1 second');
        }
        header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
        header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
        header( 'Cache-Control: no-store, no-cache, must-revalidate' );
        header( 'Cache-Control: post-check=0, pre-check=0', false );
        header( 'Pragma: no-cache' );
        
        $gif = new AnimatedGif($frames,$delays,$loops);
        $gif->getAnimation();
        $gif->display();
    }

    private function hexColorAlloc($im,$hex){
        $a = hexdec(substr($hex,0,2));
        $b = hexdec(substr($hex,2,2));
        $c = hexdec(substr($hex,4,2));

        return ImageColorAllocate($im, $a, $b, $c);
    }

}
