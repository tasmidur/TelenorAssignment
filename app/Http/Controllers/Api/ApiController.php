<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;

class ApiController extends Controller
{
   //The function works on GET Request
   //It return all requested value

   public function get(Request $request){

    $expiresAt = now()->addMinutes(5);    //Assign TTL as 5 minutes

    $response_data=[];    // store response data

    $key_array=[];    //store the key value which store in cache memory

    //return value based on requested key

    if($request->has("keys"))    //check for the specific requested key and value return keywise
    {
        $requested_key=explode(",",$request->input("keys"));

           foreach($requested_key as $key){

                  if(Cache::has($key)){

                    $response_data[$key]=Cache::get($key);

                    Cache::put($key,Cache::get($key),$expiresAt); //Reset the TTL

                  }
           }

    }else //otherwise return all values
    {

    if(Cache::has("temp_key"))     //check the existing key value in cache memory
    {
        $key_array=Cache::get("temp_key");    //assign the value in key_array that stores in temp_key of cache
        
          foreach($key_array as $key){

              if(Cache::has($key)){

                $response_data[$key]=Cache::get($key);

                Cache::put($key,Cache::get($key),$expiresAt); //Reset The TTL

              }
             
          }     
        }
    }

    return $response_data;
   
   
}//end of the function



    // The function works on Post Request.
    // It Stores the request value based on key.
    // It return all value that store in Cache memory.

    public function store(Request $request){

        $expiresAt = now()->addMinutes(5); //Assign TTL as 5 minutes

        $key_array=[]; //the array key value that store in cache memory.

        $response_data=[]; //The array the respose data

        $request_data=$request->input(); //The array store the request data

        foreach($request_data as $key=>$value) //Store requested key in cache memory.
        {
            Cache::put($key,$value,$expiresAt);

            array_push($key_array,$key);
        }

        if(Cache::has("temp_key")) //check the existing key in cache memory
        {

            $store_key=Cache::get("temp_key");

            Cache::put("temp_key",array_unique(array_merge($store_key,$key_array))); //Temporary key merge with new key and store it.
        }
        else{

            Cache::put("temp_key",array_unique($key_array)); //Store temp_key value in cache memory.

        }
        
        $keys=Cache::get("temp_key");

        foreach($keys as $key) //Response value assign in response_data array for responsing
        {
            if(Cache::has($key)){
                $response_data[$key]=Cache::get($key);
            }
              
        }

        return $response_data;
       
    }//end of the function.

    



    // the function works on PATCH request
    //It update values

    public function update(Request $request){

        $expiresAt = now()->addMinutes(5);    //Assign TTL as 5 minutes

        $response_data=[];    // store response data
    
        $key_array=[];    //store the key value which store in cache memory

        //update Values
        foreach($request->input() as $key=>$value){
            if(Cache::has($key)){
                Cache::put($key,$value,$expiresAt);
            }
        }



        //Return all Values with updated values
        if(Cache::has("temp_key"))     //check the existing key value in cache memory
        {
            $key_array=Cache::get("temp_key");    //assign the value in key_array that stores in temp_key of cache
            
              foreach($key_array as $key){
    
                  if(Cache::has($key)){
    
                    $response_data[$key]=Cache::get($key);
    
                  }
                 
              }     
            }
        return $response_data;
    }
  
}
