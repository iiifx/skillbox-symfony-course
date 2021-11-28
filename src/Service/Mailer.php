<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer
{
    public function __construct(
        protected MailerInterface $mailer
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendWelcome(User $user): void
    {
        $email = $this->createFor($user, 'Добро пожаловать')
            ->htmlTemplate('email/welcome.html.twig');

        $this->mailer->send($email);
    }

    /**
     * @param Article[] $articles
     *
     * @throws TransportExceptionInterface
     */
    public function sendNewsletter(User $user, array $articles): void
    {
        $email = $this->createFor($user, 'Еженедельная рассылка статей')
            ->htmlTemplate('email/weekly-newsletter.html.twig')
            ->context([
                'articles' => $articles,
            ])
            ->attach('Это содержимое вложенного документа', 'document.txt');

        $this->mailer->send($email);
    }

    public function sendAdminNotice(Article $article): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('noreply@symfony.skillbox', 'Project'))
            ->to('admin@symfony.skillbox')
            ->subject('Создана новая статья')
            ->htmlTemplate('email/admin-notice.html.twig')
            ->context([
                'article' => $article,
            ]);

        $this->mailer->send($email);
    }

    private function createFor(User $user, string $subject): TemplatedEmail
    {
        return (new TemplatedEmail())
            ->from(new Address('noreply@symfony.skillbox', 'Spill-Coffee-On-The-Keyboard'))
            ->to(new Address($user->getEmail(), $user->getFirstName()))
            ->subject($subject);
    }
}
