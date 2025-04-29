<?php

use App\Models\Report;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->foreignId('creator_id')->references('id')->on('users')->default(0);
            $table->string('status', 1); //Talált, Keresett, Látott, Menhely
            $table->timestamps();
            $table->string('address', 255);
            $table->float('lat')->nullable(); //szelessegi_fok
            $table->float('lon')->nullable(); //hosszusagi_fok */
            $table->string('color');
            $table->string('pattern');
            $table->string('other_identifying_marks', 250)->nullable();
            $table->string('health_status', 250)->nullable();
            $table->string('photo', 2048)->nullable();
            $table->bigInteger('chip_number')->nullable();
            $table->string('circumstances', 250)->nullable();
            $table->integer('number_of_individuals')->nullable()->default(1);
            $table->date('event_date')->nullable();
            $table->integer('activity')->default(1);// 1 aktiv, 0 nem aktiv
        });


        Report::create([
            'creator_id' => 6,
            'status' => 'k',
            'address' => 'Budapest, Andrássy út 60.',
            'lat' => 47.5076,
            'lon' => 19.0655,
            'color' => "fehér-bézs",
            'pattern' => "egyszínű",
            'other_identifying_marks' => 'MIÓ',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c1.jpg',
            'chip_number' => 123456789876543,
            'circumstances' => 'játszott a parkban',
            'number_of_individuals' => 1,
            'event_date' => "2025.04.29.",
        ]);

        Report::create([
            'creator_id' => 7,
            'status' => 'k',
            'address' => 'Budapest, Váci utca 12.',
            'lat' => 47.4947,
            'lon' => 19.0538,
            'color' => "vörör",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'Safraneknek',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c2.jpg',
            'chip_number' => null,
            'circumstances' => 'udvaron ült',
            'number_of_individuals' => 1,
            'event_date' => "2025.04.29.",
        ]);

        Report::create([
            'creator_id' => 8,
            'status' => 't',
            'address' => 'Budapest, Oktogon tér 1.',
            'lat' => 47.5064,
            'lon' => 19.0629,
            'color' => "fekete-fehér",
            'pattern' => "foltos",
            'other_identifying_marks' => 'zöld szem',
            'health_status' => 'beteg',
            'photo' => 'http://localhost:8000/uploads/c3.jpg',
            'chip_number' => null,
            'circumstances' => 'forgalmas úton látták',
            'number_of_individuals' => 1,
            'event_date' => "2025.03.20.",
        ]);

        Report::create([
            'creator_id' => 6,
            'status' => 'l',
            'address' => 'Budapest, Rákóczi út 10.',
            'lat' => 47.4975,
            'lon' => 19.0663,
            'color' => "barna",
            'pattern' => "foltos",
            'other_identifying_marks' => 'sántít',
            'health_status' => 'sérült',
            'photo' => 'http://localhost:8000/uploads/c4.jpg',
            'chip_number' => null,
            'circumstances' => 'bolt előtt kóborolt',
            'number_of_individuals' => 1,
            'event_date' => "2025.02.10.",
        ]);

        Report::create([
            'creator_id' => 7,
            'status' => 't',
            'address' => 'Budapest, Király utca 8.',
            'lat' => 47.5002,
            'lon' => 19.0594,
            'color' => "fehér",
            'pattern' => "egyszínű",
            'other_identifying_marks' => 'pici kölyök',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c5.jpg',
            'chip_number' => null,
            'circumstances' => 'játszótéren találták',
            'number_of_individuals' => 1,
            'event_date' => '2024-05-15',
        ]);

        Report::create([
            'creator_id' => 8,
            'status' => 't',
            'address' => 'Budapest, Kossuth Lajos utca 5.',
            'lat' => 47.4958,
            'lon' => 19.0552,
            'color' => "barna",
            'pattern' => "egyszínű",
            'other_identifying_marks' => 'kis seb a fülén',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c6.jpg',
            'chip_number' => null,
            'circumstances' => 'parkolóban kóborolt',
            'number_of_individuals' => 1,
            'event_date' => "2025.04.29.",
        ]);

        Report::create([
            'creator_id' => 6,
            'status' => 'k',
            'address' => 'Budapest, Üllői út 4.',
            'lat' => 47.4856,
            'lon' => 19.0747,
            'color' => "barna-bézs",
            'pattern' => "foltos",
            'other_identifying_marks' => 'sziámi kölyök',
            'health_status' => 'sérült',
            'photo' => 'http://localhost:8000/uploads/c7.jpg',
            'chip_number' => null,
            'circumstances' => 'tegnap elszökött',
            'number_of_individuals' => 1,
            'event_date' => "2025.04.09.",
        ]);

        Report::create([
            'creator_id' => 7,
            'status' => 'k',
            'address' => 'Budapest, Bartók Béla út 62.',
            'lat' => 47.4774,
            'lon' => 19.0437,
            'color' => "fehér",
            'pattern' => "egyszínű",
            'other_identifying_marks' => 'zöld nyakörv',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c8.jpg',
            'chip_number' => null,
            'circumstances' => 'terasz alatt feküdt',
            'number_of_individuals' => 1,
            'event_date' => '2024-03-12',
        ]);

        Report::create([
            'creator_id' => 8,
            'status' => 't',
            'address' => 'Budapest, Dózsa György út 41.',
            'lat' => 47.5202,
            'lon' => 19.0728,
            'color' => "fehér",
            'pattern' => "egyszínű",
            'other_identifying_marks' => 'karmolt szem',
            'health_status' => 'beteg',
            'photo' => 'http://localhost:8000/uploads/c9.jpg',
            'chip_number' => null,
            'circumstances' => 'forgalmas tér',
            'number_of_individuals' => 1,
            'event_date' => "2025.04.02.",
        ]);

        Report::create([
            'creator_id' => 6,
            'status' => 'l',
            'address' => 'Budapest, Váci út 30.',
            'lat' => 47.5291,
            'lon' => 19.0706,
            'color' => "barna",
            'pattern' => "foltos",
            'other_identifying_marks' => 'hosszú bajusz',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c10.jpg',
            'chip_number' => null,
            'circumstances' => 'kávézó előtt feküdt',
            'number_of_individuals' => 1,
            'event_date' => '2024-02-20',
        ]);

        Report::create([
            'creator_id' => 7,
            'status' => 't',
            'address' => 'Budapest, Vámház körút 5.',
            'lat' => 47.4888,
            'lon' => 19.0586,
            'color' => "vörös",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'fél farka hiányzik',
            'health_status' => 'sérült',
            'photo' => 'http://localhost:8000/uploads/c11.jpg',
            'chip_number' => null,
            'circumstances' => 'bolt előtt látták',
            'number_of_individuals' => 1,
            'event_date' => "2025.03.30.",
        ]);

        Report::create([
            'creator_id' => 8,
            'status' => 'l',
            'address' => 'Budapest, Haller utca 27.',
            'lat' => 47.4758,
            'lon' => 19.0715,
            'color' => "vörös",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'sebes láb',
            'health_status' => 'sérült',
            'photo' => 'http://localhost:8000/uploads/c12.jpg',
            'chip_number' => null,
            'circumstances' => 'áruház udvarán',
            'number_of_individuals' => 1,
            'event_date' => "2025.04.05.",
        ]);

        Report::create([
            'creator_id' => 6,
            'status' => 'k',
            'address' => 'Budapest, Széll Kálmán tér 1.',
            'lat' => 47.5075,
            'lon' => 19.0267,
            'color' => "fehér",
            'pattern' => "egyszínű",
            'other_identifying_marks' => 'három lába van',
            'health_status' => 'beteg',
            'photo' => 'http://localhost:8000/uploads/c13.jpg',
            'chip_number' => null,
            'circumstances' => 'elszökött otthonról',
            'number_of_individuals' => 1,
            'event_date' => "2025.04.11.",
        ]);

        Report::create([
            'creator_id' => 7,
            'status' => 'l',
            'address' => 'Budapest, Lövőház utca 2.',
            'lat' => 47.5083,
            'lon' => 19.0274,
            'color' => "fekete-fehér-vörös",
            'pattern' => "kalokó",
            'other_identifying_marks' => 'nagy tappancsok',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c14.jpg',
            'chip_number' => null,
            'circumstances' => 'játszott más macskákkal',
            'number_of_individuals' => 1,
            'event_date' => '2024-01-01',
        ]);

        Report::create([
            'creator_id' => 8,
            'status' => 'k',
            'address' => 'Budapest, Alkotás utca 1.',
            'lat' => 47.4956,
            'lon' => 19.0225,
            'color' => "fehér-szürke",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'sebes fül',
            'health_status' => 'sérült',
            'photo' => 'http://localhost:8000/uploads/c15.jpg',
            'chip_number' => 123454321234543,
            'circumstances' => 'udvarban feküdt',
            'number_of_individuals' => 1,
            'event_date' => "2025.01.29.",
        ]);

        Report::create([
            'creator_id' => 6,
            'status' => 'l',
            'address' => 'Budapest, Margit körút 50.',
            'lat' => 47.5116,
            'lon' => 19.0357,
            'color' => "teknöctarka",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'napozott',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c16.jpg',
            'chip_number' => null,
            'circumstances' => 'háztetőn látták',
            'number_of_individuals' => 1,
            'event_date' => "2025.04.21.",
        ]);


        Report::create([
            'creator_id' => 7,
            'status' => 'k',
            'address' => 'Budapest, Pesti út 40.',
            'lat' => 47.4873,
            'lon' => 19.2459,
            'color' => "barna-bézs",
            'pattern' => "foltos",
            'other_identifying_marks' => 'nagy kék szemek',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c17.jpg',
            'chip_number' => null,
            'circumstances' => 'játszótér közelében',
            'number_of_individuals' => 1,
            'event_date' => '2024-04-02',
        ]);

        Report::create([
            'creator_id' => 8,
            'status' => 't',
            'address' => 'Budapest, József körút 10.',
            'lat' => 47.4916,
            'lon' => 19.0722,
            'color' => "teknőctarka",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'fehér csík a hasán',
            'health_status' => 'sérült',
            'photo' => 'http://localhost:8000/uploads/c18.jpg',
            'chip_number' => null,
            'circumstances' => 'a kertemben láttam',
            'number_of_individuals' => 1,
            'event_date' => "2024-11-11",
        ]);

        Report::create([
            'creator_id' => 6,
            'status' => 'k',
            'address' => 'Budapest, Erzsébet körút 30.',
            'lat' => 47.4991,
            'lon' => 19.0657,
            'color' => "fehér-barna",
            'pattern' => "foltos",
            'other_identifying_marks' => 'csonka farok',
            'health_status' => 'beteg',
            'photo' => 'http://localhost:8000/uploads/c19.jpg',
            'chip_number' => null,
            'circumstances' => 'kirakat előtt feküdt',
            'number_of_individuals' => 1,
            'event_date' => "2025-03-11",
        ]);

        Report::create([
            'creator_id' => 7,
            'status' => 't',
            'address' => 'Budapest, Mester utca 22.',
            'lat' => 47.4787,
            'lon' => 19.0695,
            'color' => "vörös",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'hosszú szőrű',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c20.jpg',
            'chip_number' => null,
            'circumstances' => 'udvaron pihent',
            'number_of_individuals' => 3,
            'event_date' => "2025-02-21",
        ]);

        Report::create([
            'creator_id' => 8,
            'status' => 't',
            'address' => 'Budapest, Árpád út 90.',
            'lat' => 47.5558,
            'lon' => 19.0786,
            'color' => "teknőctarka",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'bal szeme sérült',
            'health_status' => 'sérült',
            'photo' => 'http://localhost:8000/uploads/c21.jpg',
            'chip_number' => null,
            'circumstances' => 'piacon kóborolt',
            'number_of_individuals' => 1,
            'event_date' => "2025-04-21",
        ]);

        Report::create([
            'creator_id' => 6,
            'status' => 'l',
            'address' => 'Budapest, Zrínyi utca 5.',
            'lat' => 47.5003,
            'lon' => 19.0488,
            'color' => "teknőctarka",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'kis fekete folt a fülén',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c22.jpg',
            'chip_number' => null,
            'circumstances' => 'iskola előtt ült',
            'number_of_individuals' => 1,
            'event_date' => '2024-05-10',
        ]);

        Report::create([
            'creator_id' => 7,
            'status' => 't',
            'address' => 'Budapest, Nagykörút 88.',
            'lat' => 47.4939,
            'lon' => 19.0702,
            'color' => "teknőctarka",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'zöld szemek',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c23.jpg',
            'chip_number' => null,
            'circumstances' => 'buszmegálló mellett',
            'number_of_individuals' => 1,
            'event_date' => "2025.04.13.",
        ]);

        Report::create([
            'creator_id' => 8,
            'status' => 'l',
            'address' => 'Budapest, Bajcsy-Zsilinszky út 17.',
            'lat' => 47.5011,
            'lon' => 19.0536,
            'color' => "fehér-teknőctarka",
            'pattern' => "kalikó",
            'other_identifying_marks' => 'kis vágás az oldalán',
            'health_status' => 'sérült',
            'photo' => 'http://localhost:8000/uploads/c24.jpg',
            'chip_number' => null,
            'circumstances' => 'üzlet mögött látták',
            'number_of_individuals' => 1,
            'event_date' => "2025.04.04.",
        ]);

        Report::create([
            'creator_id' => 6,
            'status' => 'k',
            'address' => 'Budapest, Thököly út 150.',
            'lat' => 47.5098,
            'lon' => 19.1084,
            'color' => "szürke",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'egy egész alomnyi cica',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c25.jpg',
            'chip_number' => null,
            'circumstances' => 'parkoló autók alatt bújkáltak',
            'number_of_individuals' => 5,
            'event_date' => '2024-02-18',
        ]);

        Report::create([
            'creator_id' => 7,
            'status' => 'l',
            'address' => 'Budapest, Szentendrei út 1.',
            'lat' => 47.5505,
            'lon' => 19.0467,
            'color' => "vörös",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'kis heg a bal oldalán',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c26.jpg',
            'chip_number' => null,
            'circumstances' => 'kertben játszott',
            'number_of_individuals' => 1,
            'event_date' => "2025.04.21.",
        ]);

        Report::create([
            'creator_id' => 8,
            'status' => 't',
            'address' => 'Budapest, Bécsi út 52.',
            'lat' => 47.5382,
            'lon' => 19.0344,
            'color' => "szürke-fehér",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'sérült jobb fül',
            'health_status' => 'sérült',
            'photo' => 'http://localhost:8000/uploads/c27.jpg',
            'chip_number' => null,
            'circumstances' => 'egy fán találták',
            'number_of_individuals' => 1,
            'event_date' => "2025.03.21.",
        ]);

        Report::create([
            'creator_id' => 6,
            'status' => 'k',
            'address' => 'Budapest, Kőbányai út 48.',
            'lat' => 47.4875,
            'lon' => 19.1162,
            'color' => "teknőctarka",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'nagy tappancs',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c28.jpg',
            'chip_number' => null,
            'circumstances' => 'vasútállomásnál látták',
            'number_of_individuals' => 1,
            'event_date' => "2025.03.12.",
        ]);

        Report::create([
            'creator_id' => 7,
            'status' => 'l',
            'address' => 'Budapest, Hungária körút 2.',
            'lat' => 47.5009,
            'lon' => 19.0970,
            'color' => "vörös-fehér",
            'pattern' => "cirmos",
            'other_identifying_marks' => 'fehér csík az orrán',
            'health_status' => 'egészséges',
            'photo' => 'http://localhost:8000/uploads/c29.jpg',
            'chip_number' => null,
            'circumstances' => 'bokorba bújt',
            'number_of_individuals' => 1,
            'event_date' => '2023-11-11',
        ]);

        Report::create([
            'creator_id' => 8,
            'status' => 't',
            'address' => 'Budapest, Szépvölgyi út 5.',
            'lat' => 47.5367,
            'lon' => 19.0369,
            'color' => "fekete-fehér",
            'pattern' => "foltos",
            'other_identifying_marks' => 'ketten kóborolnak',
            'health_status' => 'sérült',
            'photo' => 'http://localhost:8000/uploads/c30.jpg',
            'chip_number' => null,
            'circumstances' => 'parkoló közelében',
            'number_of_individuals' => 2,
            'event_date' => "2025.03.12",
        ]);

        
    }

    
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
