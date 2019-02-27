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
     * @Route("/", name="counter_index", methods={"GET"})
     */
    public function index(CounterRepository $counterRepository): Response
    {
        return $this->render('counter/index.html.twig', [
            'counters' => $counterRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="counter_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $counter = new Counter();
        $form = $this->createForm(CounterType::class, $counter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($counter);
            $entityManager->flush();

            return $this->redirectToRoute('counter_index');
        }

        return $this->render('counter/new.html.twig', [
            'counter' => $counter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="counter_show", methods={"GET"})
     */
    public function show(Counter $counter): Response
    {
        return $this->render('counter/show.html.twig', [
            'counter' => $counter,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="counter_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Counter $counter): Response
    {
        $form = $this->createForm(CounterType::class, $counter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('counter_index', [
                'id' => $counter->getId(),
            ]);
        }

        return $this->render('counter/edit.html.twig', [
            'counter' => $counter,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="counter_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Counter $counter): Response
    {
        if ($this->isCsrfTokenValid('delete'.$counter->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($counter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('counter_index');
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

        // we could add validation here with ensuring count( $data ) > 1
        fwrite( $ifp, base64_decode( $data[ 1 ] ) );
        // clean up the file resource
        fclose( $ifp );

        return $output_file;
    }
}
