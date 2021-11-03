<?php declare(strict_types=1);

namespace App\Context\Admin\Post\Email;

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

    public function sendNewPostEMail(): void
    {
        $email = new Email();

        $email->from('no-reply@myproject.ext')
              ->to('admin@myproject.ext')
              ->subject('nueva publicación')
              ->text('Se ha creado una nueva publicación!')
        ;

        $this->mailer->send($email);
    }

    public function sendModifiedPostEmail()
    {
        $bodyEnHtml = '<p>Se ha <b>modificado</b> una publicación!</p>';

        $email = new Email();
        $email->from(new Address('no-reply@myproject.ext', 'My Project'))
              ->to('admin@myproject.ext')
              ->subject('publicación modificada')
              ->text((new HtmlConverter())->convert($bodyEnHtml))
              ->html($bodyEnHtml)
        ;

        $this->mailer->send($email);
    }
}
