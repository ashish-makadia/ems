<?php

namespace App\Imports;

use App\Models\Agents;
use App\Models\Region;
use App\Models\Country;
use App\Models\Municipality;
use App\Models\Provinces;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class AgentsImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {   

        $length = strlen((string)$row[2]);
        if($length == 5){
            $postcode = $row[2];
        }else if($length == 4){
             $postcode = (int)"0".$row[2];
        }else if($length == 3){
             $postcode = (int)"00".$row[2];
        }else if($length == 2){
             $postcode = (int)"000".$row[2];
        }
        //$ch = curl_init("https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDfTgIlHBDlK1IyWDqj9eIeH6SjT7peMqM&address=".$row[2]."&language=it");
        $ch = curl_init("https://maps.google.com/maps/api/geocode/json?key=AIzaSyDfTgIlHBDlK1IyWDqj9eIeH6SjT7peMqM&language=it&components=country:IT|postal_code:".$postcode."&sensor=false");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        // $response will be false if the curl call failed
        if($response) {
           $result = json_decode($response, true);
        }
        //echo "<pre>";print_r($result);die();
        if($result['status'] == "OK"){
            /*$lat = $result['results'][0]['geometry']['location']['lat'];
            $long = $result['results'][0]['geometry']['location']['lng'];
            $agent = [
                'lat' => $lat,
                'long' => $long,
            ];
            $agentData = Agents::where('company_name',$row[0])->update($agent);*/
            $data = $result['results'][0]['address_components'];
            $data = array_reverse($data);
            //echo "<pre>";print_r($data);
            //for ($x = 4; $x >= count($data); $x--) {
                
            //echo "<pre>";print_r($data);die();
            $last_region_id = 0;
            $last_province_id = 0;
            $last_country_id = 0;
            foreach ($data as $data_key => $data_value) {
                //echo "<pre>";print_r($data_value);
                $addressType = $data_value['types'][0];
                if($addressType == "country"){

                    //region name
                    $country_name = $data_value['long_name'];
                    $count_country = Country::where('name', '=', $country_name)->first();
                    if(empty($count_country)){
                        $country = new Country;
                        $country->name = $country_name;
                        $country->save();
                        $last_country_id = $country->id;
                        //echo "case1".$last_region_id;

                    }else
                    {
                        $last_country_id = $count_country->id;
                       // echo "case2".$last_region_id;
                    }
                }
                if($addressType == "administrative_area_level_1"){

                    //region name
                    $region_name = $data_value['long_name'];
                    $count_region = Region::where('region_name', '=', $region_name)->first();
                    if(empty($count_region)){
                        $region = new Region;
                        $region->region_name = $region_name;
                        $region->country_id = $last_country_id;
                        $region->save();
                        $last_region_id = $region->id;
                        //echo "case1".$last_region_id;
                    }else
                    {
                        $last_region_id = $count_region->id;
                       // echo "case2".$last_region_id;
                    }
                }   
               // echo "case3".$last_region_id;
                if($addressType == "administrative_area_level_2"){
                    //province name
                    $province_name = $data_value['long_name'];
                    $province_short_code_name =  $data_value['short_name'];
                    if($province_short_code_name){
                        $code = $province_short_code_name;
                    }else{
                        $code = $row[3];
                    }
                    $count_province = Provinces::where('province_name', '=', $province_name)->first();
                    if(empty($count_province)){
                        $Provinces = new Provinces;
                        $Provinces->province_name = $province_name;
                        $Provinces->region_id = $last_region_id;
                        $Provinces->p_code = $code;
                        $Provinces->save();
                        $last_province_id = $Provinces->id;
                    }else{
                        $last_province_id = $count_province->id;
                    }
                }
               
                /*if($addressType == "administrative_area_level_3"){
                    //municipality name
                    $minicipality_name = $data_value['long_name'];  
                    $count_mun = Municipality::Where('municipality_name', 'like', '%' . $minicipality_name . '%')->first();
                    if(empty($count_mun)){
                        $mun = new Municipality;
                        $mun->municipality_name = $minicipality_name;
                        $mun->province_id = $last_province_id;
                        $mun->region_id = $last_region_id;
                        $mun->save();
                    } 
                }*/
            }

       }
       //check province code
        $minicipality_name = $row[4];
        $check_province_code = Provinces::where('p_code',$row[3])->first();
        $count_mun = Municipality::Where('municipality_name',$minicipality_name)->first();
        if(empty($count_mun) && !empty($check_province_code)){
            $mun = new Municipality;
            $mun->municipality_name = $minicipality_name;
            $mun->province_id = $check_province_code->id;
            $mun->region_id = $check_province_code->region_id;
            $mun->save();
        } 
        $municipality_data = Municipality::where('municipality_name',$row[4])->first();

        $agent_data = [ 
            'company_name'     => $row[0],
            'email' => $row[6],
            'mobile'     => $row[1],
            'zipcode'     => $postcode,
            'address'     => $row[5],
            'municipality'     => isset($municipality_data->id) && !empty($municipality_data) ? $municipality_data->id : NULL,
            'province'     => isset($municipality_data->province_id) && !empty($municipality_data) ? $municipality_data->province_id : NULL,
            'region'     => isset($municipality_data->region_id) && !empty($municipality_data) ? $municipality_data->region_id : NULL,
        ];
        if(Agents::where('company_name', '=', $row[0])->exists() && Agents::where('email', '=', $row[6])->exists()){
            $addAgent = Agents::where('company_name', '=', $row[0])->update($agent_data);
        }else{
            return new Agents([
                'company_name'     => $row[0],
                'email' => $row[6],
                'mobile'     => $row[1],
                'zipcode'     => $postcode,
                'address'     => $row[5],
                'municipality'     => isset($municipality_data->id) && !empty($municipality_data) ? $municipality_data->id : NULL,
                'province'     => isset($municipality_data->province_id) && !empty($municipality_data) ? $municipality_data->province_id : NULL,
                'region'     => isset($municipality_data->region_id) && !empty($municipality_data) ? $municipality_data->region_id : NULL,
            ]);
        }
       
    }

    //ingoreheading from csv file
    public function startRow(): int
    {
        return 2;
    }
}
