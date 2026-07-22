<?php

namespace MLMendes\LaravelReceitaWS\Enum;

enum Fallback: string
{
    case NO_CACHE = 'noCache';
    case CACHE_ON_ERROR = 'cacheOnError';
}
