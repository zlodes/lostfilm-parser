<?php

namespace App\Console\Commands;

use App\Exceptions\OldEpisodeFoundException;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use DB;
use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Console\Command;
use Log;
use LogicException;
use Symfony\Component\DomCrawler\Crawler;

class ParseLostfilmNews extends Command
{
    protected $signature = 'lostfilm:crawl-news-page {--first-run}';
    protected $description = 'Crawls LostFilm.tv news page and update our movies database (use with --first-run for first run)';

    public function handle()
    {
        Log::info("Started lostfilm crawling command");

        $http = new GuzzleHttpClient([
            "base_uri" => config("crawling.lostfilm_base_uri"),
            "headers" => [
                "User-Agent" => config("crawling.user-agent"),
                "Cache-Control" => "no-cache",
                "Pragma" => "no-cache",
            ],
        ]);

        $is_first_run = $this->option('first-run');

        $current_page_number = 1;
        $last_page_number = null;
        $progressBar = null;

        try {
            // Iterate pages
            do {
                $page_html_content = $http->get("/new/page_{$current_page_number}")->getBody()->getContents();

                // Create Symfony DOM Crawler instance from html content
                $pageDOM = new Crawler();
                $pageDOM->addHtmlContent($page_html_content);

                // Set pages count on first iteration
                if ($current_page_number === 1) {
                    $paginationContainer = $pageDOM->filter('.pagging-pane.bottom');

                    if ($paginationContainer->count() === 0) {
                        throw new LogicException("There is no bottom pagination. Maybe page markup changed?");
                    }

                    $pages_count_raw = $paginationContainer->filter('.item')->last()->text();

                    if ( ! is_numeric($pages_count_raw)) {
                        throw new LogicException("Bad last page number: expected numeric but `{$pages_count_raw}` given");
                    }

                    $last_page_number = (int) $pages_count_raw;

                    // Create progress bar for first run
                    $this->line("Pages progress:");
                    $progressBar = $this->output->createProgressBar($last_page_number);
                }

                // Iterate news page rows
                $pageDOM->filter('.content .body .row')->each(function (Crawler $row) use ($is_first_run) {
                    DB::transaction(function () use ($row, $is_first_run) {
                        $episode_url = $row->filter('a')->first()->attr('href');

                        // Split url by "/" and remove empty parts
                        $episode_url_parts = array_values(array_filter(explode('/', $episode_url)));

                        // Fill slug variables
                        [, $series_slug, $season_slug, $episode_slug] = $episode_url_parts;

                        $series_name = $row->filter('.name-ru')->text();

                        // Get series by slug or create if not exists
                        /** @var Series $series */
                        $series = Series::query()
                            ->firstOrCreate([
                                'slug' => $series_slug,
                            ], [
                                'name' => $series_name,
                                'original_name' => $row->filter('.name-en')->text() ?: null,
                            ]);

                        // Replace "N сезон M серия" with "N сезон" or skip for other season name structure (e.g. one word)
                        $season_name = preg_replace('/^(\d{1,5}\s.+)\s(\d{1,5}\s.+)$/', '$1', $row->filter('.picture-box .left-part')->text());

                        // Get season by series and slug or create if not exists
                        /** @var Season $season */
                        $season = $series->seasons()->firstOrCreate([
                            'series_id' => $series->getKey(),
                            'slug' => $season_slug,
                        ], [
                            'name' => $season_name,
                            'original_name' => null, // TODO: do something with it...
                        ]);

                        // Check episode exists or not. Create if not exists otherwise throw exception (break all iterations)
                        /** @var Episode $episode */
                        if ( ! $is_first_run && $episode = $season->episodes()->where('slug', $episode_slug)->first()) {
                             throw new OldEpisodeFoundException($episode);
                        }

                        $release_date = preg_replace('/^.+(\d\d)\.(\d\d)\.(\d{4})$/', '$3-$2-$1', $row->filter('.details-pane .alpha')->last()->text());

                        // Create episode
                        $episode = Episode::create([
                            'season_id' => $season->getKey(),
                            'name' => $row->filter('.details-pane .alpha')->first()->text(),
                            'original_name' => $row->filter('.details-pane .beta')->first()->text(),
                            'slug' => $episode_slug,
                            'lostfilm_url' => config("crawling.lostfilm_base_uri").$episode_url,
                            'release_date' => $release_date,
                        ]);

                        Log::info("Created new {$series_name} episode: {$episode->name} (ID: {$episode->getKey()})", [
                            /* here can be model-associated log context like Episode_2 */
                        ]);
                    });
                });

                // Update progress bar for first run
                if ($is_first_run) {
                    $progressBar->advance();
                }

                $current_page_number++;
            } while ($current_page_number <= $last_page_number);
        } catch (OldEpisodeFoundException $e) {
            Log::info($e->getMessage());
        } catch (BadResponseException $e) {
            Log::error("An error occurred: {$e->getMessage()} ".PHP_EOL."{$e->getTraceAsString()}");
        }

        Log::info("Finished lostfilm crawling command");
    }
}
