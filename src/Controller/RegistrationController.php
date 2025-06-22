<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends AbstractController
{
    #[Route('/event/{id}/join', name: 'event_join')]
    #[IsGranted('ROLE_USER')]
    public function join(Event $event, EntityManagerInterface $em): RedirectResponse
    {
        $user = $this->getUser();

        // is there already a registration?
        foreach ($event->getRegistrations() as $registration) {
            if ($registration->getUser() === $user) {
                $this->addFlash('warning', 'You are already registered for this event.');
                return $this->redirectToRoute('event_show', ['id' => $event->getId()]);
            }
        }

        if (
            $event->getMaxParticipants() !== null &&
            $event->getRegistrations()->count() >= $event->getMaxParticipants()
        ) {
            $this->addFlash('warning', 'This event is already full.');
            return $this->redirectToRoute('event_show', ['id' => $event->getId()]);
        }

        // creating a new registration
        $registration = new Registration();
        $registration->setEvent($event);
        $registration->setUser($user);
        $registration->setRegisteredAt(new \DateTimeImmutable());

        $em->persist($registration);
        $em->flush();

        $this->addFlash('success', 'You have successfully registered for this event!');
        return $this->redirectToRoute('event_show', ['id' => $event->getId()]);
    }

    #[Route('/my-events', name: 'my_events')]
    #[IsGranted('ROLE_USER')]
    public function myEvents(): Response
    {
        $user = $this->getUser();
        $registrations = $user->getRegistrations();

        return $this->render('event/my_events.html.twig', [
            'registrations' => $registrations,
        ]);
    }

    #[Route('/event/{id}/unregister', name: 'event_unregister')]
    #[IsGranted('ROLE_USER')]
    public function unregister(Event $event, EntityManagerInterface $em): RedirectResponse
    {
        $user = $this->getUser();
        $registration = $em->getRepository(Registration::class)->findOneBy([
            'event' => $event,
            'user' => $user,
        ]);

        if (!$registration) {
            $this->addFlash('warning', 'You are not registered for this event.');
        } else {
            $em->remove($registration);
            $em->flush();
            $this->addFlash('success', 'You have successfully unregistered from the event.');
        }

        return $this->redirectToRoute('my_events');
    }
}
