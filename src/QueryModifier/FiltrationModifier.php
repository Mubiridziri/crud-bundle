<?php

namespace Mubiridziri\Crud\QueryModifier;

use Doctrine\DBAL\Query\QueryBuilder;
use Mubiridziri\Crud\Context\ContextInterface;

class FiltrationModifier implements QueryModifierInterface
{

    public function modify(QueryBuilder $queryBuilder, ContextInterface $context): QueryBuilder
    {
        return $queryBuilder;
    }

    public static function supports(ContextInterface $context): bool
    {
        return !empty($context->getWhere());
    }
}