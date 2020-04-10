<?php

namespace App\Console\Commands;

use App\SubCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExpireLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:link';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This expire links';

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
        Log::info('comman_work',['comman_work' => 'working']);
        ///usr/local/bin/php /home/r3t7d120d89b/public_html/admin/artisan schedule:run >> /dev/null 2>&1
        set_time_limit(0);
        try {
            $insert_record = DB::table('record_status')->orderBy('insert_id','DESC')->first();
            if($insert_record) {
                $id = $insert_record->insert_id;
            }
            else {
                $rec = DB::table('sub_categories')->where('link', 'like', '%indeed.com%')->first();
                $id = $rec->id;
            }
            $search = "This job has expired on Indeed";
            $prod_data = DB::table('sub_categories')->where('link', 'like', '%indeed.com%')
                ->where('is_active',1)
                ->take(100)->where('id' ,'>=', $id)->get();
            if($prod_data->count() == 0) {
                Log::info('data finished',['data finished' => 'data finished']);
            }
            foreach($prod_data as $data) {
                DB::table('record_status')->insert(['insert_id' => $data->id]);
                if(isset($data->link) and $data->link != "") {
                    try {
                        $client = new \GuzzleHttp\Client();
                        $response = $client->request('GET', $data->link);
                        $page_data = $response->getBody()->getContents();
                        if(preg_match("/{$search}/i", $page_data)) {
                            echo "<pre>";
                            echo $data->link."<br>";
                            DB::table('sub_categories')->where('id',$data->id)->update(['is_active' => 0]);
                            $arr[] = $data->link;
                        }

                        /*$opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
                        //Basically adding headers to the request
                        $context = stream_context_create($opts);
                        $page_data = file_get_contents($data->link,false,$context);*/
                        //$page_data = file_get_contents($data->link);
                    }
                    catch (\Exception $e) {
                        Log::info('failed_records',['message' => $e->getMessage(),'line' => $e->getLine()]);
                        if($e->getCode() == 404) {
                            DB::table('sub_categories')->where('id',$data->id)->update(['is_active' => 0]);
                        }
                        continue;
                    }
                }
            }
            $record_status = DB::table('record_status')->orderBy('insert_id','DESC')->first();
            return ['inserd_id' => $record_status->insert_id];
        }
        catch(\Exception $e) {
            Log::info('expiredLinks',['message' => $e->getMessage(),'line' => $e->getLine()]);
        }
        //$data = file_get_contents('https://www.indeed.com/viewjob?jk=e5fa1aa7fef745fc&from=serp&vjs=3');
    }
}
