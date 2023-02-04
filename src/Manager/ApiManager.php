<?php

namespace Mubiridziri\Crud\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Mubiridziri\Crud\Context\ContextInterface;
use Mubiridziri\Crud\QueryModifier\QueryModifierInterface;

class ApiManager
{
    private EntityManagerInterface $em;

    /**
     * @var array<QueryModifierInterface>
     */
    private array $modifiers;

    public function __construct(EntityManagerInterface $em, ...$modifiers)
    {
        $this->em = $em;
        $this->modifiers = $modifiers;
    }

    public function getEntries(string $entityName, ContextInterface $context): array
    {
        $queryBuilder = $context->getQueryBuilder();
        if (!$queryBuilder) {
            $queryBuilder = $this->em->getRepository($entityName)->createQueryBuilder($context->getAlias());
        }

        foreach ($this->modifiers as $modifier) {
            if ($modifier::supports($context)) {
                $modifier->modify($queryBuilder, $context);
            }
        }
        //TODO сейчас не будет работать, нужно придумать как считать всего (умеет пагинатор)
        return [
            'total' => count($queryBuilder),
            'entries' => $queryBuilder->getQuery()->getResult()
        ];
    }

}