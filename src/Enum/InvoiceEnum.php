<?php

namespace App\Enum;

enum InvoiceEnum: string
{
    case PAID = 'paid';
    case PENDING = 'pending';
    case REJECTED = 'rejected';
}
