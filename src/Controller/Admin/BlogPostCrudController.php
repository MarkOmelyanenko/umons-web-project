<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use Doctrine\ORM\EntityManagerInterface;

class BlogPostCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return BlogPost::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('author'),
            TextField::new('imageUrl')->setHelp('Optional URL to image'),
            DateTimeField::new('createdAt')->hideOnForm()->setDisabled(),
            TextareaField::new('content'),
        ];
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if ($entityInstance instanceof BlogPost) {
            $entityInstance->setCreatedAt(new \DateTimeImmutable());
        }

        parent::persistEntity($em, $entityInstance);
    }
}
