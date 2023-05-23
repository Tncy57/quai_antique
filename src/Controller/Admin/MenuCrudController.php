<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class MenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Menu::class;
    }

    // Optional: Customize the CRUD configuration if needed
    // ...

    public function configureFields(string $pageName): iterable
    {
            yield TextField::new('title');
            yield TextField::new('description');
            yield MoneyField::new('price')
              ->setCurrency('EUR')
              ->setStoredAsCents(false)
              ->setFormTypeOptions([
              'currency' => 'EUR',
              ]);
    }
}
