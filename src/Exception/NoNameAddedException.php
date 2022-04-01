<?php

declare(strict_types=1);

namespace App\Exception;

class NoNameAddedException extends \Exception
{
    protected $message = 'No name added';
}