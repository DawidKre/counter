<?php

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test")
     */
    public function index()
    {
        $time = $_GET['time'];
        $future_date = new DateTime(date('r',strtotime($time)));
        $time_now = time();
        $now = new DateTime(date('r', $time_now));
        $frames = array();
        $delays = array();
        $image = imagecreatefrompng('countdown.png');
        $delay = 100; // milliseconds
        $font = array(
            'size'=>40,
            'angle'=>0,
            'x-offset'=>10,
            'y-offset'=>70,
            'file'=>'DIGITALDREAM.ttf',
            'color'=>imagecolorallocate($image, 255, 255, 255),
        );
        for($i = 0; $i <= 60; $i++){
            $interval = date_diff($future_date, $now);
            if($future_date < $now){
                // Open the first source image and add the text.
                $image = imagecreatefrompng('countdown.png');;
                $text = $interval->format('00:00:00:00');
                imagettftext ($image , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
                ob_start();
                imagegif($image);
                $frames[]=ob_get_contents();
                $delays[]=$delay;
                $loops = 1;
                ob_end_clean();
                break;
            } else {
                // Open the first source image and add the text.
                $image = imagecreatefrompng('countdown.png');;
                $text = $interval->format('%a:%H:%I:%S');
                // %a is weird in that it doesn’t give you a two digit number
                // check if it starts with a single digit 0-9
                // and prepend a 0 if it does
                if(preg_match('/^[0-9]\:/', $text)){
                    $text = '0'.$text;
                }
                imagettftext ($image , $font['size'] , $font['angle'] , $font['x-offset'] , $font['y-offset'] , $font['color'] , $font['file'], $text );
                ob_start();
                imagegif($image);
                $frames[]=ob_get_contents();
                $delays[]=$delay;
                $loops = 0;
                ob_end_clean();
            }
            $now->modify('+1 second');
        }

        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }
}
