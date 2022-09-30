<?php

namespace App\Controller\Admin;

use App\Entity\Carousel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarouselCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carousel::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            ImageField::new('imageurl')->setBasePath('uploads/images/')
                                        ->setUploadDir('public/uploads/images')
                                        ->setUploadedFileNamePattern('[randomhash].[extension]')
                                        ->setRequired(false),
            AssociationField::new('carouselPlaces')
                ->setCrudController(CarouselPlaceCrudController::getEntityFqcn())
                ->setFormTypeOption('by_reference', false),
            TextEditorField::new('description'),
        ];
    }
}
