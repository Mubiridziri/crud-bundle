<?php

namespace Mubiridziri\Crud\Controller;

interface CrudControllerInterface
{
    /**
     * Return Entity::class
     * @return mixed
     */
    public static function getEntityName();

    public function getDefaultContext(): array;
}