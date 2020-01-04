<?php

namespace ShowDb\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use ShowDb\SetlistItemNote;

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
        $notes = SetlistItemNote::where('archived', '=', 0)->get();
        $retval = 0;
        foreach ($notes as $Note) {
            $retval = 0;
            $remote_dir = "/videos/{$Note->setlistItem->show->date}/{$Note->setlistItem->show->id}";
            $url = $Note->note;
            $tmp_dir = tempnam('/tmp/', 'video-archive');
            unlink($tmp_dir);
            mkdir($tmp_dir);
            chdir($tmp_dir);            
            $cmd = env('YOUTUBE_DL_CMD');
            $cmd .= " '{$Note->note}'";
            echo $cmd, "\n";
            passthru($cmd, $retval);
            if ($retval !== 0) {
                echo "\n{$Note->note}\n{$Note->setlistItem->show->date}\n";
                echo "\n";
                exec("rm -rf {$tmp_dir}");
                continue;
            }
            $ok = 0;
            foreach (glob("{$tmp_dir}/*.*") as $file) {
                Storage::disk('s3')->putFileAs($remote_dir, new File("{$file}"), $Note->id.'@'.basename($file));
                $ok = 1;
            }
            if($ok == 0) {
                echo "download failed? {$tmp_dir}\n";
                exit(1);
            }
            exec("rm -rf {$tmp_dir}");
            echo basename($file), "\n";
            $Note->archived = 1;
            $Note->save();
        }
    }
}
