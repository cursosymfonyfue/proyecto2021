<?php declare(strict_types=1);

namespace App\Tests\Common\DataFixtures;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;

final class DataBasePurguer
{
    private EntityManagerInterface $em;
    private string                 $env;

    public function __construct(EntityManagerInterface $em, string $kernelEnvironment)
    {
        $this->em = $em;
        $this->env = $kernelEnvironment;
    }

    public function purgue()
    {
        if ($this->env !== 'test') {
            return;
        }

        $schemaTool = new SchemaTool($this->em);
        $schemaTool->dropDatabase();
        $schemaTool->createSchema($this->em->getMetadataFactory()->getAllMetadata());
    }
}
