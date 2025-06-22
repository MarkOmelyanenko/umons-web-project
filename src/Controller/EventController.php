<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Event;

class EventController extends AbstractController
{
    #[Route('/events', name: 'event_index')]
    public function index(EventRepository $eventRepository): Response
    {
        $events = $eventRepository->findAll();

        $calendarEvents = array_map(function (Event $event) {
            return [
                'title' => $event->getTitle(),
                'start' => $event->getStartAt()->format('Y-m-d\TH:i:s'),
                'end' => $event->getEndAt()->format('Y-m-d\TH:i:s'),
                'url' => '/event/' . $event->getId(),
            ];
        }, $events);

        return $this->render('event/index.html.twig', [
            'events' => $events,
            'calendarEvents' => $calendarEvents,
        ]);
    }

    #[Route('/events/{id}', name: 'event_show')]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
}