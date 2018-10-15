<?php
/**
 * Created by PhpStorm.
 * User: fedorgorskij
 * Date: 11.10.2018
 * Time: 14:51
 */

namespace app\console\controllers;


use app\common\models\District;
use app\common\models\geo\GeoCity;
use app\common\models\Metro;
use app\common\models\MetroLine;
use yii\console\Controller;
use yii\helpers\Json;
use yii\httpclient\Client;

class GeoController extends Controller
{

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     */
    public function actionImport()
    {
        $client = new Client();
        $response = $client->createRequest()
                           ->setMethod('GET')
                           ->setUrl('https://api.hh.ru/metro')
                           ->send();

        $imports = Json::decode($response->content);

        foreach ($imports as $importCity) {
            $city = GeoCity::find()->where(['title' => $importCity['name']])->one();
            if ($city == null) {
                $city = new GeoCity();
                $city->title = $importCity['name'];

                $city->save();
                echo 'Save new city '.$city->title."\n";
            }

            foreach ($importCity['lines'] as $importLine) {
                $line = MetroLine::find()->where(['title' => $importLine['name']])->one();
                if ($line == null) {
                    $line = new MetroLine();
                    $line->title = $importLine['name'];
                    $line->color = $importLine['hex_color'];
                    $line->city_id = $city->id;
                    $line->save();
                    echo 'Save new line '.$line->title."\n";
                }

                foreach ($importLine['stations'] as $station) {
                    $metro = Metro::find()->where(['title' => $station['name'], 'line_id' => $line->id])->one();
                    if ($metro == null) {
                        $metro = new Metro();
                        $metro->line_id = $line->id;
                        $metro->title = $station['name'];
                        $metro->save();
                        echo 'Save new station '.$metro->title."\n";
                    }
                }
            }

            $url = null;
            switch ($city->region_id) {
                case 78 : {
                    $url = 'https://banket.ru/site/listRegion?term=';
                    break;
                }
                case 79 : {
                    $url = 'https://spb.banket.ru/site/listRegion?term=';
                    break;
                }
                case 57 : {
                    $url = 'https://nsk.banket.ru/site/listRegion?term=';
                    break;
                }
                case 20 : {
                    $url = 'https://abakan.banket.ru/site/listRegion?term=';
                    break;
                }
            }

            if ($url !== null) {
                $regions = Json::decode(file_get_contents($url));
                foreach ($regions['items'] as $region) {
                    $district = District::findOne(['title' => $region['text']]);
                    if ($district === null) {
                        $district          = new District();
                        $district->city_id = $city->id;
                        $district->title   = $region['text'];
                        $district->save();
                        echo 'Import district '.$district->title."\n";
                    }
                }
            }
        }
    }

}