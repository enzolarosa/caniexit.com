<?php

use App\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CountriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'name' => 'Italia',
                'slug' => Str::slug('Italy'),
                'source' => [
                    'region' => 'https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-json/dpc-covid19-ita-regioni-latest.json',
                    'province' => 'https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-json/dpc-covid19-ita-province-latest.json',
                ],
                'mapping' => [
                    'region' => [
                        //source => destination
                        'data' => 'date',
                        'codice_regione' => 'region_code',
                        'denominazione_regione' => 'region_name',
                        'ricoverati_con_sintomi' => 'hospitalized_with_symptoms',
                        'terapia_intensiva' => 'intensive_therapy',
                        'totale_ospedalizzati' => 'total_hospitalized',
                        'isolamento_domiciliare' => 'home_insulation',
                        'totale_attualmente_positivi' => 'total_currently_positive',
                        'nuovi_attualmente_positivi' => 'new_currently_positive',
                        'dimessi_guariti' => 'healed',
                        'deceduti' => 'deceased',
                        'totale_casi' => 'total_cases',
                        'tamponi' => 'swabs',
                    ],
                    'province' => [
                        //source => destination
                        'data' => 'date',
                        'codice_regione' => 'region_code',
                        'codice_provincia' => 'province_code',
                        'denominazione_regione' => 'region_name',
                        'denominazione_provincia' => 'province_name',
                        'sigla_provincia' => 'province_slug',
                        'totale_casi' => 'total_cases',
                    ],
                ],
            ],
        ])->each(function ($country) {
            Country::query()->create($country);
        });
    }
}
