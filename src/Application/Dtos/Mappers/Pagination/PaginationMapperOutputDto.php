<?php

namespace Src\Application\Dtos\Mappers\Pagination;

class PaginationMapperOutputDto
{
    public function __construct(
        public readonly int $currentPage,
        public readonly int $totalPages,
        public readonly int $totalRegisters,
        public readonly int $registersPerPage,
        public readonly array $items,
    ) {}
}
