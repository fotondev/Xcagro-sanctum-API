<?php

declare(strict_types=1);

namespace App\Enums;

use Illuminate\Validation\Rules\Enum;

enum OrderStatus: string
{

    case Pending = 'pending';

    case Processing = 'processing';

    case Shipped = 'shipped';

}
