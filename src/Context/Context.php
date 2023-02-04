<?php

namespace Mubiridziri\Crud\Context;

use Symfony\Component\HttpFoundation\Request;

class Context implements ContextInterface
{

    private int $page;

    private int $limit;

    private array $where;

    private string $column;

    private string $sort;

    public function __construct(int $page, int $limit, array $where, string $column, string $sort)
    {
        $this->page = $page;
        $this->limit = $limit;
        $this->where = $where;
        $this->column = $column;
        $this->sort = $sort;
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getWhere(): array
    {
        return $this->where;
    }

    public function getColumn(): string
    {
        return $this->column;
    }

    public function getSort(): string
    {
        return $this->sort;
    }

    public static function Factory(Request $request): Context
    {
        //TODO use config variables for default values
        $page = $request->query->getInt('page', 1);
        $limit = $request->query->getInt('limit', 10);
        $where = $request->query->get('where', []);
        $column = $request->query->get('column', 'id');
        $sort = $request->query->get('sort', 'desc');
        return new Context($page, $limit, $where, $column, $sort);
    }

}