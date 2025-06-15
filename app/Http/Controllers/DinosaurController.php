<?php

namespace App\Http\Controllers;

use App\Models\Dinosaur;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class DinosaurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $dinosaurs = Dinosaur::with(['images', 'articles']);

        // Set whether searches on string fields will be 'like' or '=' (exact match)
        $whereOperator = 'like';
        if ($request->boolean('exact_match', false) === true) {
            $whereOperator = '=';
        }

        // Filter on dinosaur name
        if ($request->has('name')) {
            $nameSearch = ($whereOperator === '=') ? $request->name : '%'.$request->name.'%';
            $dinosaurs->where('name', $whereOperator, $nameSearch);
        }

        if ($request->boolean('has_wikipedia_entry', false) === true) {
            $dinosaurs->hasWikipediaEntry();
        }

        if ($request->boolean('has_image', false) === true) {
            $dinosaurs->hasImages();
        }

        if ($request->boolean('has_article', false) === true) {
            $dinosaurs->hasArticles();
        }

        return response($dinosaurs->paginate(30));
    }

    /**
     * Display the specified resource.
     */
    public function show(Dinosaur $dinosaur): Response
    {
        return response($dinosaur->load(['images', 'articles']));
    }
}
