<?php

declare(strict_types=1);

namespace App\Context\Admin\Post\Repository;

use App\Entity\Post;
use App\Exception\UserDeleteForbiddenException;
use App\Security\Voter\PostVoter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

final class PostPersister
{
    private EntityManagerInterface $em;
    private AuthorizationCheckerInterface $authorizationChecker;

    public function __construct(EntityManagerInterface $em, AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->em = $em;
        $this->authorizationChecker = $authorizationChecker;
    }

    public function persist(Post $postEntity): void
    {
        $this->em->persist($postEntity);
        $this->em->flush();
    }

    public function delete(int $id): void
    {
        $postEntity = $this->em->getReference(Post::class, $id);

        if (!$this->authorizationChecker->isGranted(PostVoter::DELETE, $postEntity)) {
            throw new UserDeleteForbiddenException('No puedes borrar este post porque no te pertenece');
        }

        $this->em->remove($postEntity);
        $this->em->flush();
    }
}
