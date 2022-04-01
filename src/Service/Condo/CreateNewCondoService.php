<?php

declare(strict_types=1);

namespace App\Service\Condo;

use App\Repository\CondoRepository;

class CreateNewCondoService
{
    public function __construct(private CondoRepository $condoRepository)
    {
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }
}