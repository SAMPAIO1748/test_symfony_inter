<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use App\Form\MediaType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminMediaController extends AbstractController
{
    /**
     * @Route("admin/create/media", name="admin_create_media")
     */
    public function adminCreateMedia(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        SluggerInterface $sluggerInterface
    ) {
        $media = new Media();

        $mediaForm = $this->createForm(MediaType::class, $media);

        $mediaForm->handleRequest($request);

        if ($mediaForm->isSubmitted() && $mediaForm->isValid()) {

            // On récupère le fichier que l'on veut enregistrer
            $mediaFile = $mediaForm->get('src')->getData();

            if ($mediaFile) {

                // On va crée un nom unique et valide à notre fichier à partir du nom original
                // pour éviter tout problème de confusion.

                // On récupère le nom original du fichier.
                $originalFielname = pathinfo($mediaFile->getClientOriginalName(), PATHINFO_FILENAME);

                // On utilise le slug sur le nom originzl pour avoir un nom valide du fichier.
                $safeFilename = $sluggerInterface->slug($originalFielname);

                // On ajoute un id unique au nom du fichier
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $mediaFile->guessExtension();

                // On déplace le fichier dans le dossier public/media
                // la destination du fichier est enregistré dans 'images_directory'
                // qui est défini dans la fichier config\services.yaml.

                $mediaFile->move(
                    $this->getParameter('images_directory'),
                    $newFilename
                );

                $media->setSrc($newFilename);
            }

            $entityManagerInterface->persist($media);

            $entityManagerInterface->flush();

            return $this->redirectToRoute("admin_product_list");
        }

        return $this->render("admin/media_form.html.twig", ['mediaForm' => $mediaForm->createView()]);
    }
}
