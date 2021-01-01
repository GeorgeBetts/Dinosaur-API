<?php

namespace App\Http\Controllers;

use App\Library\PrehistoricDate;
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

        //Retrieve and paginate the data
        $dinosaurs = $dinosaurs->paginate(30);

        //Transform the data to include human readable dates
        $dinosaurs->transform(function ($dinosaur, $key) {
            if (isset($dinosaur->start_time)) {
                $startTime = new PrehistoricDate($dinosaur->start_time);
                $dinosaur->start_time_human_readable = $startTime->humanReadable();
            } else {
                $dinosaur->start_time_human_readable = null;
            }

            if (isset($dinosaur->end_time)) {
                $endTime = new PrehistoricDate($dinosaur->end_time);
                $dinosaur->end_time_human_readable = $endTime->humanReadable();
            } else {
                $dinosaur->end_time_human_readable = null;
            }

            return $dinosaur;
        });

        return $dinosaurs;
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
