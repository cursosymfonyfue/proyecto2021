<?php declare(strict_types=1);

namespace App\Tests\Functional\Frontend\BehatMink\HomePageLikes\DataFixtures;

use App\Tests\Common\DataFixtures\DataFixturesLoader;

class DataFixturesInitializer
{
    private DataFixturesLoader $dataFixturesLoader;

    public function __construct(DataFixturesLoader $dataFixturesLoader)
    {
        $this->dataFixturesLoader = $dataFixturesLoader;
    }

    public function initialize(): void
    {
        $files = [
            __DIR__ . '/Data/user.yaml',
            __DIR__ . '/Data/category.yaml',
            __DIR__ . '/Data/post.yaml',
        ];

        $this->dataFixturesLoader->load($files);
    }
}
