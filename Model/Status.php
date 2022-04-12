<?php

declare(strict_types=1);

namespace OH\AbandonedCart\Model;

class Status
{
    const PENDING = 0;
    const SENT_1 = 1;
    const SENT_2 = 2;
    const SENT_3 = 3;
    const FAILED = 5;

    public static function getSentStatuses()
    {
        return [self::SENT_1, self::SENT_2, self::SENT_3];
    }
}