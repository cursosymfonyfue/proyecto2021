<?php declare(strict_types=1);

namespace App\Tests\Common\DataFixtures;

use Fidry\AliceDataFixtures\LoaderInterface;

class DataFixturesLoader
{
    private LoaderInterface $loader;
    private DataBasePurguer $dataBasePurguer;

    public function __construct(LoaderInterface $loader, DataBasePurguer $dataBasePurguer)
    {
        $this->loader = $loader;
        $this->dataBasePurguer = $dataBasePurguer;
    }

    public function load(array $dataFixtureFiles): void
    {
        $this->dataBasePurguer->purgue();
        $this->loader->load($dataFixtureFiles);
    }
}

