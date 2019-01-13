<?php

namespace App\Http\Controllers;

use App\Repositories\EpisodesRepository;
use Illuminate\Http\Request;

class EpisodesController extends Controller
{
    /** @var EpisodesRepository */
    private $repository;

    public function __construct(EpisodesRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $per_page = 10;

        $search = $request->get('q');
        $page = $request->get('page', 1);

        // Get Builder and order by release_date DESC
        $episodesQuery = $this->repository->getBuilder($search)
            ->latest('release_date');

        // Paginate
        $paginator = $episodesQuery
            ->with('season.series')
            ->paginate($per_page, ['*'], 'page', $page);

        // Add search param to paginator
        if ($search) {
            $paginator->appends('q', $search);
        }

        return view('index')->with([
            'episodes' => $paginator,
            'query' => $search ?: '',
        ]);
    }
}