<?php

namespace Mubiridziri\Crud\QueryModifier;

use Doctrine\DBAL\Query\QueryBuilder;
use Mubiridziri\Crud\Context\ContextInterface;

class SortingModifier implements QueryModifierInterface
{

    public function modify(QueryBuilder $queryBuilder, ContextInterface $context): QueryBuilder
    {
        return $queryBuilder;
    }

    public static function supports(ContextInterface $context): bool
    {
        retrun (null !== $context->getColumn() && null !== $context->getSort());
    }
}