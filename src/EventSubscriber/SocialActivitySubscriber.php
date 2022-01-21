<?php

namespace App\EventSubscriber;

use App\Event\AddedLikeEvent;
use App\Repository\PostRepository;
use League\HTMLToMarkdown\HtmlConverter;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SocialActivitySubscriber implements EventSubscriberInterface
{
    private MailerInterface $mailer;
    private PostRepository $postRepository;

    public function __construct(MailerInterface $mailer, PostRepository $postRepository)
    {
        $this->mailer = $mailer;
        $this->postRepository = $postRepository;
    }

    public function onLikeAdded(AddedLikeEvent $event)
    {
        $post = $this->postRepository->find($event->getPostId());

        if (!$post) {
            return;
        }

        $bodyEnHtml = "
                <p>A alguien le ha gustado tu publicacion</p>
                <p>Título: {$post->getTitle()}</p>
                <p>Likes: {$post->getLikes()}</p>
                ";

        $email = new Email();
        $email->from('no-reply@myproject.ext')
            ->to($post->getUser()->getEmail())
            ->subject('A alguien le ha gustado tu publicacion')
            ->text((new HtmlConverter())->convert($bodyEnHtml))
            ->html($bodyEnHtml)
        ;

        $this->mailer->send($email);
    }

    public static function getSubscribedEvents()
    {
        return [
            AddedLikeEvent::NAME => 'onLikeAdded',
        ];
    }
}
