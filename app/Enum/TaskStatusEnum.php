<?php

namespace App\Enum;

enum TaskStatusEnum:string {

    use EnumToArray;

    case TODO = 'todo';
    case IN_PROGRESS = 'in_progress';
    case DONE = 'done';
}
