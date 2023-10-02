<?php

declare(strict_types=1);

namespace Fulll\Infra\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

abstract class AbstractRepository
{
    protected const ENTITY_NAME = '';

    private EntityRepository $entityRepository;

    public function __construct(protected EntityManagerInterface $entityManager)
    {
        if ('' === static::ENTITY_NAME) {
            throw new \LogicException(sprintf('Constant %s::ENTITY_NAME must be defined.', static::class));
        }

        /* @phpstan-ignore-next-line */
        $this->entityRepository = $this->entityManager->getRepository(static::ENTITY_NAME);
    }

    public function save(object $entity): void
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function getRepository(): EntityRepository
    {
        return $this->entityRepository;
    }
}
