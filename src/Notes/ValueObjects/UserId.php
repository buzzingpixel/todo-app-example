<?php

declare(strict_types=1);

namespace App\Notes\ValueObjects;

use Funeralzone\ValueObjectExtensions\ComplexScalars\UUIDTrait;
use Funeralzone\ValueObjects\ValueObject;

class UserId implements ValueObject
{
    use UUIDTrait;
}
