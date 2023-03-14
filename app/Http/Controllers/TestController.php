<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function testData()
    {

       $data = array(
          0 => [
              "id"=> 13,
              "orgUnitId"=> "Z4un9KtL1E6",
              "orgUnitName"=> "CS Mucuali",
              "sive"=> "ERROR",
              "siim"=> null,
              "date"=> "2023-01-19 00:00:00"
          ],
           1=> [
               "id"=> 14,
               "orgUnitId"=> "Z4un9KtL1E6",
               "orgUnitName"=> "CS Mucuali",
               "sive"=> null,
               "siim"=> "ERROR",
               "date"=> "2023-01-19 00:00:00"
           ],
           2=> [
               "id"=> 15,
               "orgUnitId"=> "Z4un9KtL1E62",
               "orgUnitName"=> "CS Mucuali",
               "sive"=> "ERROR",
               "siim"=> null,
               "date"=> "2023-01-19 00:00:00"
           ],
           3=> [
               "id"=> 16,
               "orgUnitId"=> "Z4un9KtL1E62",
               "orgUnitName"=> "CS Mucuali",
               "sive"=> "ERROR",
               "siim"=> null,
               "date"=> "2023-01-19 00:00:00"
           ],
        );

       foreach ($data as $value) {
           if($value['orgUnitId']);
       }

       return array_udiff($data);

    }
}
