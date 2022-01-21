<?php

declare(strict_types=1);

namespace App\Command;

use App\Command\Base\ModelBuilderTrait;
use App\Context\Admin\Post\DTO\PostDTO;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

// bin/console csf:email-03

// Hay que modificar mailer.yaml: framework -> mailer -> transports (en lugar de dsn)
// Hay que añadir la cabecera de e-mail X-Transport
final class Email03VariosFromCommand extends Command
{
    use ModelBuilderTrait;

    protected static $defaultName = 'csf:email-03';
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        parent::__construct();
        $this->mailer = $mailer;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $postDTO = self::buildDTO();
        $this->send($postDTO);

        exit(0);
    }

    public function send(PostDTO $postDTO): void
    {
        $context = ['post' => $postDTO];

        $email = (new TemplatedEmail())
            ->from(new Address('support@myproject.ext', 'Support'))
            ->to('admin@myproject.ext')
            ->subject('publicación modificada')
            ->context($context)
            ->htmlTemplate('notification/email_notification.html.twig');

        $email->getHeaders()->addTextHeader('X-Transport', 'support@myproject.ext');
        $this->mailer->send($email);
    }
}
