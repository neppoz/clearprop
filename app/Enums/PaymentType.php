<?php

namespace App\Enums;

enum PaymentType: int
{
    case Deposit = 1;
    case Fee = 0;
}
