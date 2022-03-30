<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Http\JsonResponse;

class CovidDataController extends Controller
{
    public function __construct()
    {
        $this->yesterdayDate = date('Y-m-d', strtotime("-1 day"));
        $this->filePath = storage_path("app/public/covid_data" . $this->yesterdayDate . ".txt");
        $this->oldFilePath = storage_path("app/public/covid_data" . date('Y-m-d', strtotime("-2 day")) . ".txt");
        $this->fetchCovidData();
    }

    public function show($city): JsonResponse
    {
        $city = ucwords(implode(' ', explode('-', $city)));
        $file = fopen($this->filePath, 'r');
        while($line = fgets($file)) {
            if (str_contains($line, 'nome_munic')) {
                $title = explode(';', $line);
                continue;
            }
            $cityName = ucwords(str_replace(['á', 'Á', 'ã', 'â', 'é', 'ç', 'ó'], ['a', 'A', 'a', 'a', 'e', 'c', 'o'], explode(';', $line)[0]));
            if ($cityName === $city) {
                $cityCovidData = explode(';', str_replace("\n", '', $line));
            }
        }
        fclose($file);

        if (!isset($cityCovidData)) {
            return response()->json(['error' => 'Could not find city with the name ' . $city], 404);
        }
    
        foreach($title as $i => $t) {
            $covidData[$t] = $cityCovidData[$i];
        }
    
        return response()->json($covidData, 200, ['Charset' => 'utf-8'],
        JSON_UNESCAPED_UNICODE);
    }

    private function fetchCovidData(): void
    {
        if(!file_exists($this->filePath)) {
            $url = "https://raw.githubusercontent.com/seade-R/dados-covid-sp/master/data/dados_covid_sp.csv";
            $data = Http::get($url);
            File::put($this->filePath, $data);

            // Remove lines with informations that are not from `$this->yesterdayDate`
            $file = fopen($this->filePath, 'r');
            $lines = [];
            while($line = fgets($file)) {
                if (str_contains($line, 'nome_munic')) {
                    $title = explode(';', $line);
                    $lines[] = implode(";", $title);
                }
                if(str_contains($line, $this->yesterdayDate)) {
                    $lines[] = $line;
                }
            }
            fclose($file);

            File::put($this->filePath, $lines);
        }

        if(file_exists($this->oldFilePath)) {
            unlink($this->oldFilePath);
        }
    }
}
