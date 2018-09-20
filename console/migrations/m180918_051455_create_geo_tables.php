<?php

use app\common\models\geo\GeoRegion;
use yii\db\Migration;

/**
 * Class m180918_051455_create_geo_tables
 */
class m180918_051455_create_geo_tables extends Migration
{
    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function safeUp()
    {

        $this->createTable('geo_region', [
            'id'    => $this->primaryKey(),
            'title' => $this->string()->notNull()
        ]);

        $this->batchInsert('geo_region', ['title'], [
            ['Адыгея',],
            ['Алтай',],
            ['Башкортостан',],
            ['Бурятия',],
            ['Дагестан',],
            ['Ингушетия',],
            ['Кабардино-Балкария',],
            ['Калмыкия',],
            ['Карачаево-Черкесия',],
            ['Карелия',],
            ['Коми',],
            ['Крым',],
            ['Марий Эл',],
            ['Мордовия',],
            ['Саха (Якутия)',],
            ['Северная Осетия — Алания',],
            ['Татарстан',],
            ['Тыва',],
            ['Удмуртия',],
            ['Хакасия',],
            ['Чечня',],
            ['Чувашия',],
            ['Алтайский край',],
            ['Забайкальский край',],
            ['Камчатский край',],
            ['Краснодарский край',],
            ['Красноярский край',],
            ['Пермский край',],
            ['Приморский край',],
            ['Ставропольский край',],
            ['Хабаровский край',],
            ['Амурская область',],
            ['Архангельская область',],
            ['Астраханская область',],
            ['Белгородская область',],
            ['Брянская область',],
            ['Владимирская область',],
            ['Волгоградская область',],
            ['Вологодская область',],
            ['Воронежская область',],
            ['Ивановская область',],
            ['Иркутская область',],
            ['Калининградская область',],
            ['Калужская область',],
            ['Кемеровская область',],
            ['Кировская область',],
            ['Костромская область',],
            ['Курганская область',],
            ['Курская область',],
            ['Ленинградская область',],
            ['Липецкая область',],
            ['Магаданская область',],
            ['Московская область',],
            ['Мурманская область',],
            ['Нижегородская область',],
            ['Новгородская область',],
            ['Новосибирская область',],
            ['Омская область',],
            ['Оренбургская область',],
            ['Орловская область',],
            ['Пензенская область',],
            ['Псковская область',],
            ['Ростовская область',],
            ['Рязанская область',],
            ['Самарская область',],
            ['Саратовская область',],
            ['Сахалинская область',],
            ['Свердловская область',],
            ['Смоленская область',],
            ['Тамбовская область',],
            ['Тверская область',],
            ['Томская область',],
            ['Тульская область',],
            ['Тюменская область',],
            ['Ульяновская область',],
            ['Челябинская область',],
            ['Ярославская область',],
            ['Москва',],
            ['Санкт-Петербург',],
            ['Севастополь',],
            ['titleО' => 'Еврейская АО',],
            ['Ненецкий АО',],
            ['Ханты-Мансийский АО — Югра',],
            ['Чукотский АО',],
            ['Ямало-Ненецкий АО']
        ]);



        $this->createTable('geo_city', [
            'id'        => $this->primaryKey(),
            'title'     => $this->string()->notNull(),
            'region_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-geo_city-region_id',
            'geo_city',
            'region_id'
        );

        $this->addForeignKey(
            'fk-geo_city-region_id',
            'geo_city',
            'region_id',
            'geo_region',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $cityFilePath = __DIR__ . '/../storage/vk_cities.json';
        if ( ! file_exists($cityFilePath)) {
            throw new Exception('Файл с городами не найден. Миграция не может быть применена.');
        }

        $regions = [];
        $cities  = [];
        $data    = json_decode(file_get_contents($cityFilePath, 'r'));

        foreach (GeoRegion::find()->all() as $region) {
            $regions[mb_strtolower($region->title)] = $region;
        }

        foreach ($data as $k => $v) {
            $regionId = null;

            switch ($v->id) {
                case 1:
                    $regionId = 78;
                    break;
                case 2:
                    $regionId = 79;
                    break;
                default:
                    $regionTitle = '';
                    if (isset($v->region)) {
                        $regionTitle = mb_strtolower(trim($v->region));
                    }

                    if (isset($regions[$regionTitle])) {
                        $regionId = $regions[$regionTitle]->id;
                    } else {
                        switch ($regionTitle) {
                            case 'татарстан':
                                $regionId = 17;
                                break;
                            case 'башкортостан':
                                $regionId = 3;
                                break;
                            case 'удмуртская':
                                $regionId = 19;
                                break;
                            case 'крым':
                                $regionId = 12;
                                break;
                            case 'чувашская':
                                $regionId = 22;
                                break;
                            case 'бурятия':
                                $regionId = 4;
                                break;
                            case 'дагестан':
                                $regionId = 5;
                                break;
                            case 'ханты-мансийский автономный округ - югра ао':
                                $regionId = 83;
                                break;
                            case 'карелия':
                                $regionId = 10;
                                break;
                            case 'саха /якутия/':
                                $regionId = 15;
                                break;
                            case 'марий эл':
                                $regionId = 13;
                                break;
                            case 'мордовия':
                                $regionId = 14;
                                break;
                            case 'северная осетия - алания':
                                $regionId = 16;
                                break;
                            case 'коми':
                                $regionId = 11;
                                break;
                            case 'чеченская':
                                $regionId = 14;
                                break;
                            case 'хакасия':
                                $regionId = 20;
                                break;
                            case 'кабардино-балкарская':
                                $regionId = 7;
                                break;
                            case 'тыва':
                                $regionId = 18;
                                break;
                            case 'адыгея':
                                $regionId = 1;
                                break;
                            case 'калмыкия':
                                $regionId = 8;
                                break;
                            case 'алтай':
                                $regionId = 2;
                                break;
                            case 'ямало-ненецкий ао':
                                $regionId = 85;
                                break;
                            default:
                                $regionId = null;
                        }
                    }
            }

            $cities[$v->id] = [
                'id'        => $v->id,
                'title'     => $v->title,
                'region_id' => $regionId,
            ];
        }

        ksort($cities);

        $this->batchInsert('geo_city', ['id', 'title', 'region_id'], $cities);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('geo_city');
        $this->dropTable('geo_region');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180918_051455_create_geo_tables cannot be reverted.\n";

        return false;
    }
    */
}
