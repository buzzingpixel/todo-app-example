<?php

declare(strict_types=1);

namespace App\Authorization\ValueObjects;

use Funeralzone\ValueObjectExtensions\ComplexScalars\EmailTrait;
use Funeralzone\ValueObjects\ValueObject;

class Email implements ValueObject
{
    use EmailTrait;
}
