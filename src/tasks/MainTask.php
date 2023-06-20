<?php

declare(strict_types=1);

namespace MyApp\Tasks;

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo 'This is the default task and the default action' . PHP_EOL;
    }
    public function importingAction()
    {
        if (($open = fopen(BASE_PATH . "/file/sample.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $array[] = $data;
            }
            fclose($open);
        }
        foreach ($array as $value) {
            $this->mongo->data->insertOne($value);
        }
        
    }
    public function exportingAction()
    {
        $data = $this->mongo->data->find();

        $file = fopen(BASE_PATH . "/file/sample2.csv", "w");

        foreach ($data as $value) {
            $arr = [$value[0],$value[1],$value[2]];
            fputcsv($file, $arr);
        }
        fclose($file);
    }
}
