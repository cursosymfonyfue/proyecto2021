<?php declare(strict_types=1);

namespace App\Command;

use App\Command\Base\ModelBuilderTrait;
use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;

// bin/console csf:email-04
final class Email04AttachmentCommand extends Command
{
    use ModelBuilderTrait;

    protected static        $defaultName = 'csf:email-04';
    private MailerInterface $mailer;
    private string          $kernelProjectDir;

    public function __construct(MailerInterface $mailer, string $kernelProjectDir)
    {
        parent::__construct();

        $this->mailer = $mailer;
        $this->kernelProjectDir = $kernelProjectDir;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $publicacionDTO = self::buildDTO();

        $this->send($publicacionDTO);
    }

    public function send(PublicacionDTO $publicacionDTO): void
    {
        $context = ['publicacion' => $publicacionDTO];

        $email = (new TemplatedEmail())
            ->from('support@myproject.ext')
            ->to('admin@myproject.ext')
            ->subject('publicación modificada')
            ->text('Email with attachment');

        $email->attachFromPath($this->kernelProjectDir . '/data/email_attachment_1.txt');
        $email->attachFromPath($this->kernelProjectDir . '/data/email_attachment_2.txt');

        $email->getHeaders()->addTextHeader('X-Transport', 'support@myproject.ext');
        $this->mailer->send($email);
    }
}
