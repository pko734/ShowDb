<?php

namespace ShowDb\Console\Commands;

use Illuminate\Console\Command;
use ShowDb\SetlistItemNote;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ArchiveVideos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:archive-videos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Archive videos';

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
     * @return mixed
     */
    public function handle()
    {
        $notes = SetlistItemNote::where("archived", '=', 0)->get();
	$retval = 0;
	foreach($notes as $Note) {
	    $retval = 0;
	    $remote_dir = "/videos/{$Note->setlistItem->show->date}/{$Note->setlistItem->show->id}";
	    $url = $Note->note;
	    $tmp_dir = tempnam("/tmp/", "video-archive");
	    unlink($tmp_dir);
	    mkdir($tmp_dir);
	    chdir($tmp_dir);
	    $cmd = "youtube-dl '{$Note->note}'";
	    exec($cmd, $result, $retval);
	    if($retval !== 0) {
	      echo "\n{$Note->note}\n{$Note->setlistItem->show->date}\n";
	      var_export($result);
	      echo "\n";
	      exec("rm -rf {$tmp_dir}");
	      continue;
	    }
	    foreach(glob("{$tmp_dir}/*.*") as $file) {
	      Storage::disk('s3')->putFileAs($remote_dir, new File("{$file}"), $Note->id . "@" . basename($file));
	    }
	    exec("rm -rf {$tmp_dir}");
	    echo basename($file), "\n";
	    $Note->archived = 1;
	    $Note->save();
	}
    }
}
