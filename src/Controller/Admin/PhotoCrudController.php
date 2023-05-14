<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class PhotoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Photo::class;
    }

    // Optional: Customize the CRUD configuration if needed
    // ...

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            ImageField::new('imagePath')
                ->setBasePath('/uploads/photos') // Adjust the base path to match your upload directory
                ->setUploadDir('public/uploads/photos') // Adjust the upload directory path
        ];
    }
}
