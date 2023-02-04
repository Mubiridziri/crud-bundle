<?php

namespace Mubiridziri\Crud\Context;

use Doctrine\ORM\QueryBuilder;

interface ContextInterface
{
    public function getPage(): int;

    public function getLimit(): int;

    public function getWhere(): array;

    public function getColumn(): string;

    public function getSort(): string;

    public function getQueryBuilder(): ?QueryBuilder;

    public function setCustomAlias(string $alias);

    public function getAlias(): string;
}