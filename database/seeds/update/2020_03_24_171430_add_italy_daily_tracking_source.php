<?php

use App\Country;
use Illuminate\Database\Seeder;

/**
 * Class AddItalyDailyTrackingSource
 */
class AddItalyDailyTrackingSource extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var Country $country */
        $country = Country::query()->where('slug', 'italy')->first();

        $country->source = collect($country->source)->put('tracking', 'https://raw.githubusercontent.com/pcm-dpc/COVID-19/master/dati-json/dpc-covid19-ita-andamento-nazionale.json',);
        $country->mapping = collect($country->mapping)->put('tracking', [
            //source => destination
            'data' => 'date',
            'codice_regione' => 'region_code',
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
        ]);
        $country->save();
    }
}
