<?php

 namespace  App\Http\Requests;

 use Illuminate\Support\Facades\Request;

 class ContactRequests extends  Request {

     public function authorize(){
         return true;
     }
     public function rules(){
         return [
//             'name' =>'required',
//             'email' => 'required|email|unique:users',
//             'password' =>'required'
         ];
     }
     public  function  messages(){
         return [
             'name.required' =>'this field required'
         ];
     }
 }
