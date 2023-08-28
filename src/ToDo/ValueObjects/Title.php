<?php

declare(strict_types=1);

namespace App\ToDo\ValueObjects;

use Funeralzone\ValueObjects\Scalars\StringTrait;
use Funeralzone\ValueObjects\ValueObject;

class Title implements ValueObject
{
    use StringTrait;
}
