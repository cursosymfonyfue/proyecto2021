<?php

declare(strict_types=1);

namespace App\Context\Admin\Post\Email;

use App\Entity\Post;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

final class EmailSender
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    // Sólo se envía e-mail con texto plano
    public function sendNewPostEMail(Post $postEntity): void
    {
        $subject = sprintf('Pulicación "%s" creada.', $postEntity->getTitle());

        $email = new Email();
        $email->from('no-reply@myproject.ext')
              ->to('admin@myproject.ext')
              ->subject($subject)
              ->text('Se ha creado una nueva publicación!')
        ;

        $this->mailer->send($email);
    }

    // Sólo se envía e-mail con texto plano y rico (HTML)
    // Tip: Librería HtmlConverter (convierte html a markdown)
    public function sendModifiedPostEmail(Post $postEntity): void
    {
        $subject = sprintf('Pulicación "%s" modificada.', $postEntity->getTitle());
        $bodyEnHtml = sprintf('<p>Se ha <b>modificado</b> la publicación "%s"!</p>', $postEntity->getTitle());

        $email = new Email();
        $email->from(new Address('no-reply@myproject.ext', 'My Project'))
              ->to('admin@myproject.ext')
              ->subject($subject)
              ->text((new HtmlConverter())->convert($bodyEnHtml))
              ->html($bodyEnHtml)
        ;

        $this->mailer->send($email);
    }
}
