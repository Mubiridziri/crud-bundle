<?php

namespace Mubiridziri\Crud\Manager;

use Mubiridziri\Crud\Context\ContextInterface;
use Mubiridziri\Crud\Filtrator\FiltratorInterface;
use Mubiridziri\Crud\Paginator\PaginatorInterface;
use Mubiridziri\Crud\Sorter\SorterInterface;

class ApiManager
{
    private PaginatorInterface $paginator;

    private FiltratorInterface $filtrator;

    private SorterInterface $sorter;

    public function __construct(PaginatorInterface $paginator, FiltratorInterface $filtrator, SorterInterface $sorter)
    {
        $this->paginator = $paginator;
        $this->filtrator = $filtrator;
        $this->sorter = $sorter;
    }

    public function getEntries(string $entityName, ContextInterface $context)
    {

    }

}