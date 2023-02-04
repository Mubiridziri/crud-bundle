<?php

namespace Mubiridziri\Crud\QueryModifier;


use Doctrine\ORM\QueryBuilder;
use Mubiridziri\Crud\Context\ContextInterface;

interface QueryModifierInterface
{
    public function modify(QueryBuilder $queryBuilder, ContextInterface $context): QueryBuilder;

    public static function supports(ContextInterface $context): bool;
}