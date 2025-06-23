<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PdfExportController extends AbstractController
{
    #[Route('/admin/event/{id}/export-pdf', name: 'admin_event_export_pdf')]
    public function export(Event $event): Response
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($pdfOptions);
        $html = $this->renderView('event/participants_pdf.html.twig', [
            'event' => $event,
            'participants' => $event->getRegistrations(),
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="participants_event_' . $event->getId() . '.pdf"',
            ]
        );
    }
}
