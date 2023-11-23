<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(){
        $data = [
            'pageTitle' => 'Product',
            'content' => 'This page about all of Our Products.'
        ];

        $data2 = [
            'pageTitle' => 'Stock',
            'content' => 'This page about all Stocks of Our Products .'
        ];

        return view('Product' , compact('data', 'data2'));
    }
}
