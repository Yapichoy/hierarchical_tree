<?php

use Illuminate\Database\Seeder;
use App\NameGenerator;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    private $positions = [
        'Директор',
        'Зам. директора',
        'Исполнительный директор',
        'Руководитель отдела продаж',
        'Сервис-менеджер',
        'Руководитель отдела оформления',
        'Старший продавец консультант',
        'Менеджер по оформлению',
        'Продавец консультант',
        'Матер-приемщик',
        'Инженер по гарантии'
    ];
    private function getRandomNames(){
        $chanse = mt_rand()/mt_getrandmax();
        $fio=[];
        if($chanse<=0.4){
            $fio = [
                NameGenerator::getRandomWomenName(),
                NameGenerator::getRandomWomenSurname(),
                NameGenerator::getRandomWomenSecondname()
            ];
        }
        else{
            $fio = [
                NameGenerator::getRandomMenName(),
                NameGenerator::getRandomMenSurname(),
                NameGenerator::getRandomMenSecondname()
            ];
        }
        return $fio;
    }
    private function getSecondLayer(){
        $fio = $this->getRandomNames();
        $position = mt_rand(2,3);
        $salary = mt_rand(200000,300000);
        return [
            'surname'       => $fio[1],
            'name'          => $fio[0],
            'secondname'    => $fio[2],
            'position_id'   => $position,
            'date_start_work'=> date("Y-m-d H:i:s"),
            'salary'         => $salary,
            'chef_id'        => 1
        ];
    }
    private function getThertLayer(){
        $fio = $this->getRandomNames();
        $position = mt_rand(4,5);
        $salary = mt_rand(150000,200000);
        $chef = mt_rand(2,3);
        return [
            'surname'       => $fio[1],
            'name'          => $fio[0],
            'secondname'    => $fio[2],
            'position_id'   => $position,
            'date_start_work'=> date("Y-m-d H:i:s"),
            'salary'         => $salary,
            'chef_id'        => $chef
        ];
    }
    private function getFourthLayer(){
        $fio = $this->getRandomNames();
        $position = mt_rand(6,7);
        $salary = mt_rand(80000,150000);
        $chef = mt_rand(4,5);
        return [
            'surname'       => $fio[1],
            'name'          => $fio[0],
            'secondname'    => $fio[2],
            'position_id'   => $position,
            'date_start_work'=> date("Y-m-d H:i:s"),
            'salary'         => $salary,
            'chef_id'        => $chef
        ];
    }
    private function getFifthLayer(){
        $fio = $this->getRandomNames();
        $position = mt_rand(8,11);
        $salary = mt_rand(30000,50000);
        $chef = mt_rand(6,7);
        return [
            'surname'       => $fio[1],
            'name'          => $fio[0],
            'secondname'    => $fio[2],
            'position_id'   => $position,
            'date_start_work'=> date("Y-m-d H:i:s"),
            'salary'         => $salary,
            'chef_id'        => $chef
        ];
    }
    private function getDirectorParameters(){
        $chanse = mt_rand()/mt_getrandmax();
        $fio = $this->getRandomNames();
        return [
            'surname'       => $fio[1],
            'name'          => $fio[0],
            'secondname'    => $fio[2],
            'position_id'   => 1,
            'date_start_work'=> date("Y-m-d H:i:s"),
            'salary'         => 400000,
            'chef_id'        => 0
        ];
    }
    private function generateEmployee(){
        $employee_counter = 0;
        $position_counter = count($this->positions);
        $parameters = [];
        for($i=0;$i<30;$i++){
            if($i == 0){
                $parameters = $this->getDirectorParameters();
            }
            elseif ($i<=3){
                $parameters = $this->getSecondLayer();
            }
            elseif ($i <=8){
                $parameters = $this->getThertLayer();
            }
            elseif ($i <=16){
                $parameters = $this->getFourthLayer();
            }
            else{
                $parameters = $this->getFifthLayer();
            }
            DB::table('employees')->insert($parameters);
        }
    }
    public function run()
    {
        /*foreach ($this->positions as $position)
            DB::table('positions')->insert([
                'denomination' => $position
            ]);*/
        $this->generateEmployee();
    }
}
