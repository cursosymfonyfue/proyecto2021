<?php declare(strict_types=1);

namespace App\Command;

use App\Context\Admin\Publicacion\DTO\PublicacionDTO;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\MailerInterface;
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
        $publicacionDTO = self::buildDTO();
        $this->send($publicacionDTO);
    }

    public function send(PublicacionDTO $publicacionDTO): void
    {
        $bodyEnHtml = "
                <p>Resumen de publicación</p>
                <p>Título: {$publicacionDTO->getNombre()}</p>
                <p>Descripción: {$publicacionDTO->getDescripcion()}</p>
                <p>Fecha de Publicación: {$publicacionDTO->getFechaDePublicacion()->format('Y-m-d')}</p>
                ";

        $email = new Email();
        $email->from(new NamedAddress('no-reply@myproject.ext', 'My Project'))
              ->to('admin@myproject.ext')
              ->subject('Resumen de publicación')
              ->text((new HtmlConverter())->convert($bodyEnHtml))
              ->html($bodyEnHtml)
        ;

        $this->mailer->send($email);
    }

    private static function buildDTO(): PublicacionDTO
    {
        $publicacionDTO = PublicacionDTO::create();
        $publicacionDTO->setFechaDePublicacion(new \DateTime());
        $publicacionDTO->setNombre('Título del post');
        $publicacionDTO->setDescripcion('<b>Aquí vendría el mensaje del post<b><hr>aquí más info');

        return $publicacionDTO;
    }
}
