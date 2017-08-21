<?php

use Phinx\Migration\AbstractMigration;

class AddDataToPrefecturesTable extends AbstractMigration
{
    /**
     * Migrate Up.
     */
    public function up()
    {
        $prefectures = $this->table('prefectures');
        $prefectures->insert([
            ['id' => 1, 'name' => '北海道', 'sort' => 1],
            ['id' => 2, 'name' => '青森県', 'sort' => 2],
            ['id' => 3, 'name' => '岩手県', 'sort' => 3],
            ['id' => 4, 'name' => '宮城県', 'sort' => 4],
            ['id' => 5, 'name' => '秋田県', 'sort' => 5],
            ['id' => 6, 'name' => '山形県', 'sort' => 6],
            ['id' => 7, 'name' => '福島県', 'sort' => 7],
            ['id' => 8, 'name' => '茨城県', 'sort' => 8],
            ['id' => 9, 'name' => '栃木県', 'sort' => 9],
            ['id' => 10, 'name' => '群馬県', 'sort' => 10],
            ['id' => 11, 'name' => '埼玉県', 'sort' => 11],
            ['id' => 12, 'name' => '千葉県', 'sort' => 12],
            ['id' => 13, 'name' => '東京都', 'sort' => 13],
            ['id' => 14, 'name' => '神奈川県', 'sort' => 14],
            ['id' => 15, 'name' => '新潟県', 'sort' => 15],
            ['id' => 16, 'name' => '富山県', 'sort' => 16],
            ['id' => 17, 'name' => '石川県', 'sort' => 17],
            ['id' => 18, 'name' => '福井県', 'sort' => 18],
            ['id' => 19, 'name' => '山梨県', 'sort' => 19],
            ['id' => 20, 'name' => '長野県', 'sort' => 20],
            ['id' => 21, 'name' => '岐阜県', 'sort' => 21],
            ['id' => 22, 'name' => '静岡県', 'sort' => 22],
            ['id' => 23, 'name' => '愛知県', 'sort' => 23],
            ['id' => 24, 'name' => '三重県', 'sort' => 24],
            ['id' => 25, 'name' => '滋賀県', 'sort' => 25],
            ['id' => 26, 'name' => '京都府', 'sort' => 26],
            ['id' => 27, 'name' => '大阪府', 'sort' => 27],
            ['id' => 28, 'name' => '兵庫県', 'sort' => 28],
            ['id' => 29, 'name' => '奈良県', 'sort' => 29],
            ['id' => 30, 'name' => '和歌山県', 'sort' => 30],
            ['id' => 31, 'name' => '鳥取県', 'sort' => 31],
            ['id' => 32, 'name' => '島根県', 'sort' => 32],
            ['id' => 33, 'name' => '岡山県', 'sort' => 33],
            ['id' => 34, 'name' => '広島県', 'sort' => 34],
            ['id' => 35, 'name' => '山口県', 'sort' => 35],
            ['id' => 36, 'name' => '徳島県', 'sort' => 36],
            ['id' => 37, 'name' => '香川県', 'sort' => 37],
            ['id' => 38, 'name' => '愛媛県', 'sort' => 38],
            ['id' => 39, 'name' => '高知県', 'sort' => 39],
            ['id' => 40, 'name' => '福岡県', 'sort' => 40],
            ['id' => 41, 'name' => '佐賀県', 'sort' => 41],
            ['id' => 42, 'name' => '長崎県', 'sort' => 42],
            ['id' => 43, 'name' => '熊本県', 'sort' => 43],
            ['id' => 44, 'name' => '大分県', 'sort' => 44],
            ['id' => 45, 'name' => '宮崎県', 'sort' => 45],
            ['id' => 46, 'name' => '鹿児島県', 'sort' => 46],
            ['id' => 47, 'name' => '沖縄県', 'sort' => 47],
        ])->saveData();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->execute('DELETE FROM prefectures;');
    }
}
