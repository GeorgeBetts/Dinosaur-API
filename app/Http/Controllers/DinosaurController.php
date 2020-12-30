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
    public function index(Request $request)
    {
        $dinosaurs = Dinosaur::with(['images', 'articles']);

        //Set whether searches on string fields will be 'like' or '=' (exact match)
        $whereOperator = 'like';
        if ($request->has('exact_match') && $request->exact_match === 'true') {
            $whereOperator = '=';
        }

        //Filter on dinosaur name
        if ($request->has('name')) {
            $nameSearch = ($whereOperator == '=') ? $request->name : '%' . $request->name . '%';
            $dinosaurs->where('name', $whereOperator, $nameSearch);
        }

        //Filter records that have/don't have a wikipedia entry
        if ($request->has('has_wikipedia_entry')) {
            if ($request->has_wikipedia_entry === 'true') {
                $dinosaurs->whereNotNull('wikipedia_entry');
            } else {
                $dinosaurs->whereNull('wikipedia_entry');
            }
        }

        //Filter records that have at least one image
        if ($request->has('has_image')) {
            if ($request->has_image === 'true') {
                $dinosaurs->has('images');
            } else {
                $dinosaurs->doesntHave('images');
            }
        }

        //Filter records that have at least one article
        if ($request->has('has_article')) {
            if ($request->has_article === 'true') {
                $dinosaurs->has('articles');
            } else {
                $dinosaurs->doesntHave('articles');
            }
        }

        return $dinosaurs->paginate(30);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Dinosaur $dinosaur)
    {
        return $dinosaur->load(['images', 'articles']);
    }
}
