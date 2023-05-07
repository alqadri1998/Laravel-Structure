<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToArray,WithHeadingRow
{

    /**
     * @param array $array
     */
    public function array(array $array){
        return $array;
    }

    public function rules()
    {
        return [
            'price' => 'required',
            'quantity' => 'required',
        ];
    }


//    /**
//    * @param array $row
//    *
//    * @return \Illuminate\Database\Eloquent\Model|null
//    */
//    public function model(array $row)
//    {
//        dd($row);
//        return new Product([
//            //
//        ]);
//    }
}
