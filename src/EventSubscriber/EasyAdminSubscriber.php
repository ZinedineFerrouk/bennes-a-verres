<?php 

namespace App\EventSubscriber;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EasyAdminSubscriber implements EventSubscriberInterface 
{
    /**
     * @var UserPasswordHasherInterface
     */
    private $passwordEncoder;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
       
    public static function getSubscribedEvents()
    {
        return [
            BeforeEntityPersistedEvent::class => ['setDataUser']
        ];
    } 
    
    public static function setDataUser(BeforeEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();
        if (!($entity instanceof User)) {
            return;
        }
        
        $pass = $entity->getPassword();
        $encode_pass = password_hash($pass, PASSWORD_DEFAULT);
        $entity->setPassword($encode_pass);
    }
}