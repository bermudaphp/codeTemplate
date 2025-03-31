<?php

namespace Bermuda\CodeTemplate\Module;

use Bermuda\CodeTemplate\Template;

class EntityRepositoryTemplate extends Template
{
    protected function getBaseTemplate(): string
    {
        return <<<'EOD'
<?php
%namespace%

use api\uuid\UuidFactoryAwareInterface;
use Cycle\ORM\ORMInterface;
use Bermuda\Cycle\Repository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Ramsey\Uuid\UuidFactoryInterface;

class %EntityClass%Repository extends Repository implements %EntityClass%RepositoryInterface, %EntityClass%FactoryInterface
{
    use UuidFactoryAwareTrait;

    /**
     * @throws \Throwable
     */
    public function save(%EntityClass% $entity, bool $cascade = true): void
    {
        $this->entityManager->persist($entity, $cascade);
        $this->entityManager->run();
    }

    public function make%EntityClass%(%EntityClass%Data $data): %EntityClass%
    {
        return %EntityClass%::fromData($data, $this->uuidFactory);
    }
    
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function createFromContainer(ContainerInterface $container): %EntityClass%Repository
    {
        $repository = $container->get(ORMInterface::class)->getRepository(%EntityClass%::class);
        if ($repository instanceof UuidFactoryAwareInterface) {
            $repository->setUuidFactory($container->get(UuidFactoryInterface::class));
        }

        return $repository;
    }
}
EOD;
    }
}