<?php

namespace App\Enum;

enum InvoicePaymentMethodeEnum: string
{
    case CASH_PAYMENT = 'Cash';
    case PAYPAL_PAYMENT = 'Paypal';
    case MASTER_CARD_PAYMENT = 'Master card';
}
