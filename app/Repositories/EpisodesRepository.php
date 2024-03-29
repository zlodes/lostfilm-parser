<?php

namespace App\Repositories;

use App\Models\Episode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class EpisodesRepository extends Repository
{
    public function getModel(): Model
    {
        return new Episode();
    }

    public function getBuilder(?string $search_string = null): Builder
    {
        $episodesQuery = $this->query();

        if ($search_string) {
            $episodesQuery->search($search_string);
        }

        return $episodesQuery;
    }
}