<?php

namespace Database\Seeders;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\DokumentenverwaltungController;
use Illuminate\Database\Seeder;
use App\Models\Api;
use App\Models\Documents;
use App\Models\Log;
use App\Models\User;

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documentcontroller = new DokumentenverwaltungController();

        $this->call([
            UsersTableSeeder::class,
            DocumentsTableSeeder::class,
            API_KeySeeder::class
        ]);

        /* 2 Dokumente werden Freigegeben
        */
        $doc2 = Documents::where('id', 2)->first();
        $doc2->release_state = 'Freigegeben';
        $doc2->save();
        $doc5 = Documents::where('id', 5)->first();
        $doc5->release_state = 'Freigegeben';
        $doc5->save();

        $documentcontroller->release($doc2);
        $documentcontroller->release($doc5);
        //API calls
        $api2 = Api::where('id', 2)->first();
        $api2->call = '5432';
        $api2->save();


        $api5 = Api::where('id', 5)->first();
        $api5->call = '5';
        $api5->save();

        //Custom Logs
        Log::Create([
            "name" => "Robert",
            "requestType" => "returnPDF",
            "document" => "Stellenausschreibung"
        ]);
        Log::Create([
            "name" => "Lisa",
            "requestType" => "Search",
            "document" => "-"
        ]);
        Log::Create([
            "name" => "Theo",
            "requestType" => "returnPDF",
            "document" => "Stellenausschreibung"
        ]);
    }
}
