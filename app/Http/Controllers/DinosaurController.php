<?php

namespace App\Http\Controllers;

use App\Models\Dinosaur;
use Illuminate\Http\Request;

class DinosaurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $dinosaurs = Dinosaur::with(['images']);

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

        if ($request->input('has_wikipedia_entry', false) === true) {
            $dinosaurs->hasWikipediaEntry();
        }

        if ($request->input('has_image', false) === true) {
            $dinosaurs->hasImages();
        }

        if ($request->input('has_article', false) === true) {
            $dinosaurs->hasArticles();
        }

        return $dinosaurs->paginate(30);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dinosaur $dinosaur)
    {
        return $dinosaur->load(['images', 'articles']);
    }
}
