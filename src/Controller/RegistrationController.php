<?php

namespace App\Controller;

use Exception;
use App\Entity\User;
use DateTimeImmutable;
use PhpParser\Node\Stmt\Return_;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Service\Email\EmailService;
use App\Service\Upload\UploadService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\Security\ApiTokenAccessService;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\VerifyEmailHelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationController extends AbstractController
{
    // POUR LA VERIFICATION D'USER PAR MAIL
    private $mailer;
    private $apiTokenService;

    public function __construct(EmailService $mailer, UserPasswordHasherInterface $userPasswordHasherInterface, UserRepository $userRepository, ApiTokenAccessService $apiTokenService)
    {
        $this->mailer = $mailer;
        $this->userPasswordHasherInterface = $userPasswordHasherInterface;
        $this->userRepository = $userRepository;
        $this->apiTokenService = $apiTokenService;
    }

    /**
     * @Route("/inscription", name="app_inscription")
     */
    public function register(Request $request, UploadService $upload): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $kbis = $form->get('kbis')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword($this->userPasswordHasherInterface->hashPassword($user, $form->get('password')->getData()));
            
            // L'user a besoin de valider son compte afin que setValidated soit a True
            $user->setIsValidated(false);
            $user->setRoles(['ROLE_USER']);
            
            $user->setUserToken($this->apiTokenService->generateToken(['user' => $user->getName(), 'email' => $user->getEmail(), 'datetime' => new DateTimeImmutable]));
            $user->setApiAccessToken($this->apiTokenService->generateToken(['id'=> $user->getId() ,'user' => $user->getName(), 'email' => $user->getEmail()]));
            
            // Vérification pour le PDF se fait dans l'uploadService
            $user->setKbis($upload->processFile($kbis));
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            
            // Envoi du Mail de confirmation
            $this->mailer->sendCustomEmail($user->getEmail(), 'Validation de votre compte.', 'emails/validation.html.twig', 'token', $user->getUserToken());

            $this->addFlash('success', 'Votre compte a été crée, veuillez vérifier votre boîte mail afin de le validé.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/confirmer-mon-compte/{token}", name="app_confirm_account")
     */
    public function confirmAccount(string $token)
    {
        $user = $this->userRepository->findOneBy(['user_token' => $token]);

        if (!$user) {
            throw new Exception("Vous ne pouvez pas accéder à cette page.", 1);
        };

        $user->setIsValidated(true);
        $user->setUserToken(null);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre compte est désormais validé ! Vous pouvez vous connecter ;)');
        return $this->redirectToRoute('app_login');
    }
}
