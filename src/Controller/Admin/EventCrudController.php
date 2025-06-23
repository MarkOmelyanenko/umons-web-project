<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class EventCrudController extends AbstractCrudController
{
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setFormOptions(['csrf_protection' => false]);
    }

    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            TextField::new('location'),
            TextareaField::new('description'),
            IntegerField::new('maxParticipants'),
            DateTimeField::new('startAt')->setFormat('short'),
            DateTimeField::new('endAt')->setFormat('short'),
        ];
    }


    public function configureActions(Actions $actions): Actions
    {
        $exportPdf = Action::new('export_pdf', 'Export Participants PDF')
            ->linkToUrl(function (Event $event) {
                return $this->generateUrl('admin_event_export_pdf', ['id' => $event->getId()]);
            })
            ->setCssClass('btn btn-info');

        return $actions
            ->add('detail', $exportPdf)
            ->add('index', Action::DETAIL);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Event) return;

        $entityInstance->setCreatedAt(new \DateTimeImmutable());

        parent::persistEntity($entityManager, $entityInstance);
    }
}
