<?php

namespace App\Controller\Admin;

use App\Entity\Benne;
use App\Repository\BenneRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;



class BenneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Benne::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('address', 'Adresse'),
            TextField::new('commune'),
            TextField::new('model', 'Modèle'),
            NumberField::new('quartier', 'Quartier'),
            NumberField::new('latitude'),
            NumberField::new('longitude'),
            DateTimeField::new('created_at', 'Crée le')->hideOnForm(),
            DateTimeField::new('updated_at', 'Modifié le')->hideOnForm()
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
            $actions->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action){
                $action->displayIf(function(Benne $entity) {
                    $lastId = $this->getDoctrine()->getManager()->getRepository(Benne::class)->findOneBy([], ['id' => 'DESC'])->getId();
                    $id = $entity->getId();
                    return $id === $lastId;
                });
                return $action;
            });
            $actions->remove(Crud::PAGE_INDEX, Action::NEW)->add(Crud::PAGE_INDEX, Action::DETAIL);
            
            return $actions;
    }
    
    
}
