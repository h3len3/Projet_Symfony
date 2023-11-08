<?php

namespace App\Controller;

use App\Entity\OrdinateurPortable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrdinateurPortableRepository;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AccueilController extends AbstractController
{
    

    #[Route('/accueil', name: 'accueil')]
    public function afficherTous(ManagerRegistry $doctrine, OrdinateurPortableRepository $repository, Request $request)
    {
        $em = $doctrine->getManager();
        $rep = $em->getRepository(OrdinateurPortable::class);

        // notez que findBy renverra toujours un array même s'il trouve qu'un objet
        $ordis = $rep->findAll();

//        $form = $this->createForm()
//
//        if($form->isSubmitted() && $form->isValid())
//        {
//            $data = $form->getData();
//            $repository->findOneByBrand($data['brand']);
//        }


        // creates a task object and initializes some data for this example
        
        //pas cette partie
        /* $task = new Task();
        $task->setTask('Write a blog post');
        $task->setDueDate(new \DateTimeImmutable('tomorrow'));
 */
        $form = $this->createFormBuilder() //()vide
    /*      ->add('task', TextType::class)
            ->add('dueDate', DateType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Task'])
            ->getForm(); */

            ->add(
                'marque', ChoiceType::class, 
                [
                'choices' => OrdinateurPortable::MARQUE,
                'multiple' => 'true',
                'expanded' => 'true',
                ]
                )
            ->add('prix_min', MoneyType::class, 
                [
                'label' => 'Prix minimum',
                'required' => false,
                ]
                )
            ->add('prix_max', MoneyType::class, 
                [
            'label' => 'Prix maximum',
            'required' => false,
                ]
                )
            ->add('processeur', ChoiceType::class, 
                [
                'choices' => OrdinateurPortable::PROCESSEUR,
                'multiple' => true,
                'expanded' => 'true',
                ]
                )
            ->add('systemeExploitation', ChoiceType::class, 
                [
                    'choices' => OrdinateurPortable::SYSTEME_EXPLOITATION,
                    'multiple' => true,
                    'expanded' => 'true',
                ]
                )
            
            ->add('Filtrer', SubmitType::class)

            ->getForm();

        // ...

        //$form = $this->createForm(TaskType::class, $task);
        //return cfr plus bas

        // traitement doc

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //TODO - A REFAIRE 
        }

        
        return $this->render(
            "accueil/index.html.twig",
            [
                'ordis' => $ordis,
            'formFiltre' => $form
            ]
        );
    }


}

