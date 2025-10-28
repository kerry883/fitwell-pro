<?php

namespace App\Enums;

enum ProgramAssignmentStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case DEACTIVATED = 'deactivated';
    case COMPLETED = 'completed';
    case REJECTED = 'rejected';
    case PENDING_PAYMENT = 'pending_payment';
    case CANCELLED = 'cancelled';
    case WITHDRAWN = 'withdrawn'; // Client voluntarily withdrew from program
}
