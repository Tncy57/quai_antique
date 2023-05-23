<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Schedule::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('day');
        yield DateField::new('date');
        yield TimeField::new('lunchOpening')
              ->renderAsChoice();              
        yield TimeField::new('lunchClosing')
              ->renderAsChoice();
        yield TimeField::new('dinnerOpening')
              ->renderAsChoice();
        yield TimeField::new('dinnerClosing')
              ->renderAsChoice();
    }
}
