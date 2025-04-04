<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class CreditController extends Controller
{
    public function show()
    {
        return view('products.insufficient_credit');
    }
}
