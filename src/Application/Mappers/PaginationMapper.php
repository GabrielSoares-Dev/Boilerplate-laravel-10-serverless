<?php

namespace Src\Application\Mappers;

use Src\Application\Dtos\Mappers\Pagination\PaginationMapperInputDto;
use Src\Application\Dtos\Mappers\Pagination\PaginationMapperOutputDto;

class PaginationMapper
{
    public static function map(PaginationMapperInputDto $input): PaginationMapperOutputDto
    {
        $paginator = $input->paginator;

        return new PaginationMapperOutputDto(
            $paginator->currentPage(),
            $paginator->lastPage(),
            $paginator->total(),
            $paginator->perPage(),
            $paginator->items()
        );
    }
}
