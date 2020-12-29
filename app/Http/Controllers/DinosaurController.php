<?php

namespace App\Http\Controllers;

use App\Models\Dinosaur;
use Illuminate\Http\Request;

class DinosaurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Dinosaur::with(['images', 'articles'])->paginate(30);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Dinosaur::with(['images', 'articles'])->find($id);
    }
}
