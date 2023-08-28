<?php

declare(strict_types=1);

namespace App\ToDo\ValueObjects;

use Funeralzone\ValueObjects\Scalars\BooleanTrait;
use Funeralzone\ValueObjects\ValueObject;

class IsDone implements ValueObject
{
    use BooleanTrait;
}
