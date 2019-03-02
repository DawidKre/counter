<?php

namespace App\Controller;

use App\Entity\Counter;
use App\Service\CreateCounter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/script")
 */
class CounterController extends AbstractController
{

    /**
     * @Route("/identifier/{identifier}", name="show-identifier")
     * @throws \Exception
     */
    public function showByIdentifier($identifier, CreateCounter $createCounter )
    {
        try {
            $counter = $this->getDoctrine()->getRepository(Counter::class)->findOneBy(['identifier' => $identifier]);
            if($counter) {
                $params['fontSize'] = $counter->getFontSize();
                $params['templateImage'] = $counter->getTemplate() ? $counter->getTemplate()->getImage() : null;
                $params['color'] = $counter->getColor();
                $params['font'] = $counter->getFont();
                $params['angle'] = $counter->getAngle();
                $params['xOffset'] = $counter->getXOffset();
                $params['yOffset'] = $counter->getYOffset();
                $params['time'] = $counter->getTime();

                $createCounter->createCounterGif($params);
            } else {
                return new Response('Script not found', Response::HTTP_NOT_FOUND);
            }

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @Route("/show", name="show-params")
     * @throws \Exception
     */
    public function showByParams(Request $request, CreateCounter $createCounter )
    {
        $params = $request->query->all();
        $createCounter->createCounterGif($params);
        try {
            $params = $request->query->all();
            $createCounter->createCounterGif($params);

        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * @Route("/image-upload", name="counter_image_upload", methods={"POST"})
     */
    public function uploadImage(Request $request): JsonResponse
    {
        $file = $request->request->get('file');
//        $normalizer = new DataUriNormalizer();
//        $avatar = $normalizer->denormalize($file, 'SplFileObject');
        $this->base64ToJpeg($file, 'upload/counter.gif');
//        $avatar->move('upload', 'counter.jpg');

        return new JsonResponse(['status' => $file]);
    }

    private function base64ToJpeg($base64_string, $output_file)
    {
        $ifp = fopen( $output_file, 'wb' );
        $data = explode( ',', $base64_string );

        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
        fclose( $ifp );

        return $output_file;
    }
}
