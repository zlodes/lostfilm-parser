<?php

namespace App\Exceptions;

use App\Models\Episode;
use Exception;

class OldEpisodeFoundException extends Exception
{
    public function __construct(Episode $episode)
    {
        parent::__construct("Existed episode found: {$episode->name}", 0, null);
    }
}