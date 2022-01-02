<?php declare(strict_types=1);

namespace App\Context\ContactForm\ContactForm\Email;

use App\Context\ContactForm\ContactForm\DTO\ContactFormDTO;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class ContactFormEmailSender
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    // Sólo se envía e-mail con texto plano
    public function send(ContactFormDTO $contactFormDTO): void
    {
        $subject = sprintf('Contacto "%s" recibido.', $contactFormDTO->getSubject());

        $bodyEnHtml = sprintf('Full Name: %s %4$s Subject: %s %4$s Body: %s %4$s',
            $contactFormDTO->getFullName(),
            $contactFormDTO->getSubject(),
            $contactFormDTO->getBody(),
            PHP_EOL
        );

        $email = new Email();
        $email->from('no-reply@myproject.ext')
              ->to('admin@myproject.ext')
              ->subject($subject)
              ->text((new HtmlConverter())->convert($bodyEnHtml))
              ->html($bodyEnHtml)
        ;

        $this->mailer->send($email);
    }
}
