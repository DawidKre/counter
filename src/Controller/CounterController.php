<?php

namespace App\Controller;

use App\Entity\Counter;
use App\Form\CounterType;
use App\Repository\CounterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DataUriNormalizer;
/**
 * @Route("/counter")
 */
class CounterController extends AbstractController
{
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

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
        // clean up the file resource
        fclose( $ifp );

        return $output_file;
    }
}
