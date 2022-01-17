<?php

namespace App\Imports;
use App\Model\Product;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImports
{

    protected $formatStatus = false;
    protected $file;
    protected $csv_header = array();

    public function format1(){

        return [
            "register_number",
            "product_type",
            "scientific_name",
            "scientific_name_arabic",
            "trade_name",
            "trade_name_arabic",
            "strength",
            "strength_unit",
            "size",
            "size_unit",
            "public_price",
            "brand"
        ];
    }

    public function setFile($file){
        $this->file = $file;
        $this->setCsvHeader();
    }

    public function setCsvHeader()
    {
       $csvFile = file($this->file); 
       $this->csv_header = str_getcsv($csvFile[0]);
    }

    public function checkFormat(){

        if ($result = array_diff(array_map('strtolower',$this->csv_header),$this->format1())) {
            if (count($result)>0) {
                $this->formatStatus = false;
            }else{
                $this->formatStatus = true;
            }
        }else{
            $this->formatStatus = true;
        }
    }
    
    public function isFormatCorrect(){
        return $this->formatStatus;
    }

    public function save(){
        $csvFile = file($this->file);
        $data = [];
        foreach ($csvFile as $line) {
            $data[] = str_getcsv($line);
        }
        unset($data[0]);
        foreach ($data as $product) {
            $Product = new Product();
            $Product->register_number = $product[0];
            $Product->product_type = $product[1];
            $Product->scientific_name = $product[2];
            $Product->scientific_name_arabic = $product[3];
            $Product->trade_name = $product[4];
            $Product->trade_name_arabic = $product[5];
            $Product->strength = $product[6];
            $Product->strength_unit = $product[7];
            $Product->size = $product[8];
            $Product->size_unit = $product[9];
            $Product->public_price = $product[10];
            $Product->brand = $product[11];
            $Product->save();
        }
    }
}