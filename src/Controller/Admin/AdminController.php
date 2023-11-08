<?php

namespace App\Controller\Admin;

use App\Form\EditEmployesFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrdinateurPortableRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{

    #[Route('/admin/', name: 'admin_index')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    #[Route('/admin/liste_ordinateurs', name: 'admin_liste_ordinateurs')]
    public function liste_ordinateurs(OrdinateurPortableRepository $ordinateurPortableRepository): Response
    {
        $ordinateurs = $ordinateurPortableRepository->findAll();

        return $this->render('admin/listeOrdinateurs.html.twig', [
            'ordinateurs' => $ordinateurs,
        ]);
    }

    #[Route('/admin/liste_employes', name: 'admin_liste_employes')]
    public function liste_employes(UserRepository $userRepository): Response
    {
        $employes = $userRepository->findAll();

        return $this->render('admin/listeEmployes.html.twig', [
            'employes' => $employes,
        ]);
    }

    

    #[Route('/admin/edit_employes/{id}', name: 'admin_edit_employes')]
     // id pour pouvoir pointer ici ds route + ds path ds templatelisteEmployes
    public function edit_employe(UserRepository $userRepository, int $id, Request $request, EntityManagerInterface $em): Response
    {
        $employe = $userRepository->find($id);
        $form = $this->createForm(EditEmployesFormType::class, $employe);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $data = $form->getData();

            $employe->setNom($data->getNom());
            $employe->setPrenom($data->getPrenom());
            $employe->setMail($data->getMail());

            $em->persist($employe);
            $em->flush();

            return $this->redirectToRoute('admin_liste_employes');
        }

        return $this->render('admin/editEmployes.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    #[Route('/admin/delete_employes/{id}', name: 'admin_delete_employes')]
    public function delete_employe(UserRepository $userRepository, int $id, EntityManagerInterface $em): Response
    {
        $employe = $userRepository->find($id);
        $em->remove($employe);
        $em->flush();

        return $this->redirectToRoute('admin_liste_employes');
    }
 //TODO ajouter, édition, suppression ordinateurs + r

}
