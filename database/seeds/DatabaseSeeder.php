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
    private $lvl = [
        1,2,2,3,3,4,4,5,5,5,5
    ];
    private $first_layer = [];
    private $second_layer = [];
    private $third_layer = [];
    private $fourth_layer = [];
    private $employee_counter = 1;
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
        $salary = mt_rand(180000,250000);
        $this->second_layer[] = $this->employee_counter;
        $chef = count($this->first_layer) > 1 ? mt_rand(0, count($this->first_layer)-1):0;
        return [

            'surname'       => $fio[1],
            'name'          => $fio[0],
            'secondname'    => $fio[2],
            'position_id'   => $position,
            'date_start_work'=> date("Y-m-d H:i:s"),
            'salary'         => $salary,
            'chef_id'        => $this->first_layer[$chef],
        ];
    }
    private function getThertLayer(){
        $fio = $this->getRandomNames();
        $position = mt_rand(4,5);
        $salary = mt_rand(100000,150000);
        $this->third_layer[] = $this->employee_counter;
        $chef = count($this->second_layer) > 1 ? mt_rand(0,count($this->second_layer)-1):0;
        return [
            'surname'       => $fio[1],
            'name'          => $fio[0],
            'secondname'    => $fio[2],
            'position_id'   => $position,
            'date_start_work'=> date("Y-m-d H:i:s"),
            'salary'         => $salary,
            'chef_id'        => $this->second_layer[$chef],
        ];
    }
    private function getFourthLayer(){
        $fio = $this->getRandomNames();
        $position = mt_rand(6,7);
        $salary = mt_rand(60000,80000);
        $this->fourth_layer[] = $this->employee_counter;
        $chef = count($this->third_layer) > 1 ? mt_rand(0,count($this->third_layer)-1):0;
        return [
            'surname'       => $fio[1],
            'name'          => $fio[0],
            'secondname'    => $fio[2],
            'position_id'   => $position,
            'date_start_work'=> date("Y-m-d H:i:s"),
            'salary'         => $salary,
            'chef_id'        => $this->third_layer[$chef],
        ];
    }
    private function getFifthLayer(){
        $fio = $this->getRandomNames();
        $position = mt_rand(8,11);
        $salary = mt_rand(30000,50000);
        $chef = count($this->fourth_layer) > 1 ? mt_rand(0,count($this->fourth_layer)-1):0;
        return [
            'surname'       => $fio[1],
            'name'          => $fio[0],
            'secondname'    => $fio[2],
            'position_id'   => $position,
            'date_start_work'=> date("Y-m-d H:i:s"),
            'salary'         => $salary,
            'chef_id'        => $this->fourth_layer[$chef],
        ];
    }
    private function getDirectorParameters(){
        $chanse = mt_rand()/mt_getrandmax();
        $fio = $this->getRandomNames();
        $this->first_layer[] = $this->employee_counter;
        return [
            'surname'       => $fio[1],
            'name'          => $fio[0],
            'secondname'    => $fio[2],
            'position_id'   => 1,
            'date_start_work'=> date("Y-m-d H:i:s"),
            'salary'         => 400000,
            'chef_id'        => 0,
        ];
    }
    private function generateFirstEmployee(){
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
            $this->employee_counter++;
        }
    }
    private function generateEmployee(){
        $position_counter = count($this->positions);
        $parameters = [];
        for($i=0;$i<50000;$i++){
            $chance = mt_rand()/mt_getrandmax();
            if($chance <= 0.01){
                $parameters = $this->getDirectorParameters();
            }
            elseif ($chance<=0.06){
                $parameters = $this->getSecondLayer();
            }
            elseif ($chance <=0.2){
                $parameters = $this->getThertLayer();
            }
            elseif ($chance <=0.5){
                $parameters = $this->getFourthLayer();
            }
            else{
                $parameters = $this->getFifthLayer();
            }
            DB::table('employees')->insert($parameters);
            $this->employee_counter++;
        }
    }
    public function run()
    {
        $i=0;
        foreach ($this->positions as $position) {
            DB::table('positions')->insert([
                'denomination' => $position,
                'lvl' => $this->lvl[$i]
            ]);
            $i++;
        }
        $this->generateFirstEmployee();
        $this->generateEmployee();
    }
}
