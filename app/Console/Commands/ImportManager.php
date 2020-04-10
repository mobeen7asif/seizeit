<?php

namespace App\Console\Commands;

use App\SubCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportManager extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This imports data';

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

        Log::info('handle()',['handle()' => 'handle()']);
        for($i = 0; $i < 200; $i++) {
            $temp = [
                'link' => 'test',
                'title' => 'test',
                'description' => 'test',
                'summary' => 'test',
                'email' => 'test',
                'address' => 'test',
                'category_id' => '4',
                'major_id' => '4',
                'uni_id' => '4',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $sub_arr[] = $temp;
        }
        try{
            SubCategory::insert($sub_arr);
        }
        catch (\Exception $e){
            Log::info('subcategory error',['data_input' => $sub_arr]);
        }
    }
}
