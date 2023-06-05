<?php

namespace App\Service\Email;

use Exception;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendCustomEmail($email, string $subject, string $template, string $tokenKey, $token)
    {
        // Envoi d'email de confirmation
        $email = (new TemplatedEmail())
            ->from(new Address('benaverre@contact.com', 'Securité'))
            ->to(new Address($email))
            ->subject($subject)
            ->htmlTemplate($template)
            ->priority(1)
            ->context([
                $tokenKey => $token
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new Exception("Une erreur est survenue. Veuillez réessayer plus tard.", 1);
        }
    }

    public function sendContactEmail($data)
    {
        // Envoi d'email de confirmation
        $email = (new TemplatedEmail())
            ->from($data['email'], 'Securité')
            ->to('contact.example360@gmail.com')
            ->subject('Message d\'un utilisateur')
            ->htmlTemplate('emails/contact.html.twig')
            ->priority(1)
            ->context([
                'user_email' => $data['email'],
                'nom' => $data['lastName'],
                'prenom' => $data['firstName'],
                'sujet' => $data['subject'],
                'message' => nl2br($data['message'])
            ]);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new CustomUserMessageAuthenticationException(
                'Une erreur est survenue lors de l\'envoi. Veuillez réessayer plus tard.'
            );
        }
    }

    // GENERATION D'UN TOKEN
    /**
     * @return string
     * @throws \Exception
     */
    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
