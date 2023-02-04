<?php

namespace Mubiridziri\Crud\QueryModifier;

use Doctrine\DBAL\Query\QueryBuilder;
use Mubiridziri\Crud\Context\ContextInterface;

class PaginationModifier implements QueryModifierInterface
{

    public function modify(QueryBuilder $queryBuilder, ContextInterface $context): QueryBuilder
    {
        return $queryBuilder;
    }

    public static function supports(ContextInterface $context): bool
    {
        return (null !== $context->getPage() && null !== $context->getLimit());
    }
}