<?php declare(strict_types=1);

namespace App\Command;

use App\Context\Admin\Post\DTO\PostDTO;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

// bin/console csf:email-01
final class Email01RichCommand extends Command
{
    protected static        $defaultName = 'csf:email-01';
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
        $bodyEnHtml = "
                <p>Resumen de publicación</p>
                <p>Título: {$postDTO->getTitle()}</p>
                <p>Descripción: {$postDTO->getBody()}</p>
                <p>Fecha de Publicación: {$postDTO->getAvailableAt()->format('Y-m-d')}</p>
                ";

        $email = new Email();
        $email->from(new Address('no-reply@myproject.ext', 'My Project'))
              ->to('admin@myproject.ext')
              ->subject('Resumen de publicación')
              ->text((new HtmlConverter())->convert($bodyEnHtml))
              ->html($bodyEnHtml)
        ;

        $this->mailer->send($email);
    }

    private static function buildDTO(): PostDTO
    {
        $postDTO = PostDTO::create();
        $postDTO->setAvailableAt(new \DateTime());
        $postDTO->setTitle('Título del post');
        $postDTO->setBody('<b>Aquí vendría el mensaje del post<b><hr>aquí más info');

        return $postDTO;
    }
}
