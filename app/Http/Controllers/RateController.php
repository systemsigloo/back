<?php
namespace App\Http\Controllers;

use App\Models\Rate;
use App\Models\DetallePedido;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Mail\PedidoCreado;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class RateController extends Controller
{  
    public function getRateBCV(){
       return Rate::all();
    }
}