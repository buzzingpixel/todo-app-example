<?php

declare(strict_types=1);

namespace App\Authorization\ValueObjects;

use Funeralzone\ValueObjects\Scalars\StringTrait;
use Funeralzone\ValueObjects\ValueObject;

class ReturnTo implements ValueObject
{
    use StringTrait;
}
