<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function getContact(Request $request, EntityManagerInterface $em, Contact $contact): Response
    {
        $form = $this->createForm(ContactTypeForm::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $contact->setCreatedAt(new \DateTimeImmutable());

            $em->persist($contact);
            $em->flush();
            $this->addFlash('success', 'Votre message a été enregistré !');

            return $this->redirectToRoute('app_contact');

        }
        return $this->render('partials/contact.html.twig', [
            'contact_form' => $form->createView(),
        ]);
    }
}



