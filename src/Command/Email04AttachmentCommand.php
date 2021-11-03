<?php declare(strict_types=1);

namespace App\Command;

use App\Command\Base\ModelBuilderTrait;
use App\Context\Admin\Post\DTO\PostDTO;
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
        $postDTO = self::buildDTO();
        $this->send($postDTO);

        exit(0);
    }

    public function send(PostDTO $postDTO): void
    {
        $context = ['post' => $postDTO];

        $email = (new TemplatedEmail())
            ->from('support@myproject.ext')
            ->to('admin@myproject.ext')
            ->subject('publicación modificada')
            ->text('Email with attachment');

        $email->attachFromPath($this->kernelProjectDir . '/data/attachments/email_attachment_1.txt');
        $email->attachFromPath($this->kernelProjectDir . '/data/attachments/email_attachment_2.txt');
        $email->attach(file_get_contents($this->kernelProjectDir . '/data/img/cat.jpg'), 'one-cat.jpg', 'image/jpeg');

        $email->getHeaders()->addTextHeader('X-Transport', 'support@myproject.ext');
        $this->mailer->send($email);
    }
}
