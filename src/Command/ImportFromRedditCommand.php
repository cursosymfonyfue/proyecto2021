<?php

namespace App\Command;

use App\Entity\Post;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportFromRedditCommand extends Command
{
    protected static $defaultName = 'app:import-from:reddit';

    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserRepository  $userRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Import posts from reddit');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $redditData = file_get_contents("https://www.reddit.com/r/talesfromtechsupport.json");
        $redditData = json_decode($redditData, true);
        $redditPosts = $redditData['data']['children'];

        $author = $this->userRepository->find(1);
        $author->setUsername("Sabin v2");

        $this->entityManager->persist($author);

        foreach ($redditPosts as $index => $redditPost) {
            $post = new Post();
            $post->setTitle($redditPost['data']['title']);
            $post->setBody($redditPost['data']['selftext']);
            $post->setUser($author);

            $this->entityManager->persist($post);

            if ($index % 5 === 0) {
                $this->entityManager->flush();
            }
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
