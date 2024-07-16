<?php

namespace Src\Infra\Http\Resources\Shared;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginateResource extends JsonResource
{
    protected string $itemResource;

    public function __construct(mixed $output, string $itemResource)
    {
        parent::__construct($output);
        $this->itemResource = $itemResource;
    }

    public function toArray(Request $request): array
    {
        return [
            'currentPage' => $this->currentPage,
            'totalPages' => $this->totalPages,
            'totalRegisters' => $this->totalRegisters,
            'registersPerPage' => $this->registersPerPage,
            'items' => $this->itemResource::collection($this->items),
        ];
    }
}
