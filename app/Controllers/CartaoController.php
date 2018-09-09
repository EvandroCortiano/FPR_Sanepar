<?php

namespace App\Controllers;

class CartaoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //recebe doacoes
        return view('cartaoPro.dashboard');
    }

}