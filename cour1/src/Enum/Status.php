<?php

namespace App\Enum;


enum Status: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case EXPIRED = 'expired';
    case REVOKED = 'revoked';
}