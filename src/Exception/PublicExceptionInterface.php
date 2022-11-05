<?php declare(strict_types=1);


namespace App\Exception;


interface PublicExceptionInterface
{
    public function getData(): array;

    public function getCode();
}
