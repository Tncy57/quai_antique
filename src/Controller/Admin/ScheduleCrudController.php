<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Schedule::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('day');
        yield DateTimeField::new('lunchOpening') 
            ->setTimezone('Europe/Paris');
        yield DateTimeField::new('lunchClosing')
            ->setTimezone('Europe/Paris');
        yield DateTimeField::new('dinnerOpening')
            ->setTimezone('Europe/Paris');
        yield DateTimeField::new('dinnerClosing')
            ->setTimezone('Europe/Paris');
    }
}
