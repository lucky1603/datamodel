<?php

namespace App\Console\Commands;

use App\File;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class replaceUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'files:changeBase {old_url} {new_url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replaces base url with the new base url';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldUrl = $this->argument('old_url');
        $newUrl = $this->argument('new_url');

        // Change report files
        File::all()->each(function($file) use($oldUrl, $newUrl) {
            $filelink = $file->filelink;
            $newLink = str_replace($oldUrl, $newUrl, $filelink);
            $file->filelink = $newLink;
            $file->save();
        });

        // Change argument files
        $fileObjects = DB::table('file_values')->select(['id', 'link'])->get();
        $fileObjects->each(function($fileObject) {
            $link = $fileObject->link;
            $newLink = str_replace("https://platforma.ntpark.rs", "http://localhost", $link);
            DB::table('file_values')->where('id', $fileObject->id)->update(['link' => $newLink]);
        });

        return 0;
    }
}
