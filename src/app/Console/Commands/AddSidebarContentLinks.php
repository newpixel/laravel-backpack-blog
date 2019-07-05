<?php

namespace Newpixel\BlogCRUD\app\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class AddSidebarContentLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:add-sidebar-content-link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add links for article, category and tag CRUD to the Backpack sidebar_content file';

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
        $path = 'resources/views/vendor/backpack/base/inc/sidebar_content.blade.php';
        $disk_name = config('backpack.base.root_disk_name');
        $disk = Storage::disk($disk_name);
        $code = '
{{-- Blog tree links --}}
<li class="treeview">
    <a href="#"><i class="fa fa-globe"></i> <span>Blog</span> <i class="fa fa-angle-left pull-right"></i></a>
    <ul class="treeview-menu">
        <li><a href="{{ backpack_url(config(\'blogcrud.route_prefix\') ."/". config(\'blogcrud.route_prefix\', \'blog\') . \'/article\') }}"><span>Article</span></a></li>
        <li><a href="{{ backpack_url(config(\'blogcrud.route_prefix\') ."/". config(\'blogcrud.route_prefix\', \'blog\') . \'/category\') }}"><span>Category</span></a></li>
        <li><a href="{{ backpack_url(config(\'blogcrud.route_prefix\') ."/". config(\'blogcrud.route_prefix\', \'blog\') . \'/tag\') }}"><span>Tags</span></a></li>
    </ul>
</li>';

        if ($disk->exists($path)) {
            $contents = Storage::disk($disk_name)->get($path);

            if ($disk->put($path, $contents.PHP_EOL.$code)) {
                $this->info('Successfully added links tree to sidebar_content file.');
            } else {
                $this->error('Could not write to sidebar_content file.');
            }
        } else {
            $this->error("The sidebar_content file does not exist. Make sure Backpack\Base is properly installed.");
        }
    }
}
