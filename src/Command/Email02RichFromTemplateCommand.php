<?php declare(strict_types=1);

namespace App\Command;

use App\Command\Base\ModelBuilderTrait;
use App\Context\Admin\Post\DTO\PostDTO;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

// bin/console csf:email-02
final class Email02RichFromTemplateCommand extends Command
{
    use ModelBuilderTrait;

    protected static        $defaultName = 'csf:email-02';
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
    }

    public function send(PostDTO $postDTO): void
    {
        $context = ['publicacion' => $postDTO];

        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@myproject.ext', 'My Project'))
            ->to('admin@myproject.ext')
            ->subject('publicación modificada')
            ->context($context)
            ->htmlTemplate('notification/email_notification.html.twig');

        $this->mailer->send($email);
    }
}
