<?php

namespace Mubiridziri\Crud\Context;

interface ContextInterface
{
    public function getPage(): int;

    public function getLimit(): int;

    public function getWhere(): array;

    public function getColumn(): string;

    public function getSort(): string;
}