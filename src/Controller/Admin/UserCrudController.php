<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            TextField::new('first_name', 'Prénom'),
            EmailField::new('email'),
            TextField::new('password')->hideOnIndex()->hideOnDetail()->hideOnForm(),
            TextField::new('organization', 'Société'),
            UrlField::new('kbis')->hideOnForm()->setTemplatePath('admin/custom_field.html.twig'),
            TextField::new('phone', 'Téléphone'),
            // TextareaField::new('user_token', 'Token'),
            // TextareaField::new('api_access_token', 'Api token'),
            BooleanField::new('is_validated', 'Validité')->hideOnForm(),
            DateTimeField::new('created_at', 'Crée le')->hideOnForm(),
        ];
    }

    public function configureActions(Actions $actions): Actions
{
        $actions->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action){
            $action->displayIf(function(User $entity) {
                $lastId = $this->getDoctrine()->getManager()->getRepository(User::class)->findOneBy([], ['id' => 'DESC'])->getId();
                $id = $entity->getId();
                return $id === $lastId;
            });
            return $action;
        });
        $actions->remove(Crud::PAGE_INDEX, Action::NEW)->add(Crud::PAGE_INDEX, Action::DETAIL);
        return $actions;
}
}
