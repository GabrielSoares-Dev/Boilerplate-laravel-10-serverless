<?php

namespace Src\Application\Dtos\Mappers\Pagination;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginationMapperInputDto
{
    public function __construct(
        public readonly LengthAwarePaginator $paginator
    ) {}
}
