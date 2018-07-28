<?php

namespace App\Controllers;

use App\doador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoadorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new doador.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('doador.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\doador  $doador
     * @return \Illuminate\Http\Response
     */
    public function show(doador $doador)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\doador  $doador
     * @return \Illuminate\Http\Response
     */
    public function edit(doador $doador)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\doador  $doador
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, doador $doador)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\doador  $doador
     * @return \Illuminate\Http\Response
     */
    public function destroy(doador $doador)
    {
        //
    }
}
