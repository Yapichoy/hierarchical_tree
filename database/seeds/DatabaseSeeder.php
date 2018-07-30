<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
            'denomination' => 'Директор'
        ]);
        DB::table('positions')->insert([
            'denomination' => 'Зам. директора'
        ]);
        DB::table('positions')->insert([
            'denomination' => 'Исполнительный директор'
        ]);
        DB::table('positions')->insert([
            'denomination' => 'Руководитель отдела продаж'
        ]);
        DB::table('positions')->insert([
            'denomination' => 'Сервис-менеджер'
        ]);
        DB::table('positions')->insert([
            'denomination' => 'Руководитель отдела оформления'
        ]);
        DB::table('positions')->insert([
            'denomination' => 'Старший продавец консультант'
        ]);
        DB::table('positions')->insert([
            'denomination' => 'Менеджер по оформлению'
        ]);
        DB::table('positions')->insert([
            'denomination' => 'Продавец консультант'
        ]);
        DB::table('positions')->insert([
            'denomination' => 'Матер-приемщик'
        ]);
        DB::table('positions')->insert([
            'denomination' => 'Инженер по гарантии'
        ]);
    }
}
