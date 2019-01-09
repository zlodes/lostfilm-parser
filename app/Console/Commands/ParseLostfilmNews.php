<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ParseLostfilmNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lostfilm:crawl-news-page';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crawls LostFilm.tv news page and update our movies database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // TODO: Write some code here
    }
}
