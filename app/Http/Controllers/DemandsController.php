<?php

namespace App\Http\Controllers;

use App\Demand;
use App\Category;
use Illuminate\Http\Request;

class DemandsController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:200',
            'email' => 'required|email|max:200',
            'phone' => 'required|numeric|min:9',
            'city' => 'required|min:2|max:200',
            'postal_code' => 'required|numeric',
            'category' => 'required|exists:categories,name',
            'project_delay' => 'required|numeric',
            'description' => 'required',
        ]);

        $category = Category::where('name', $validated['category'])->first();

        $validated['category_id'] = $category->id;

        $demand = new Demand();
        $demand->name = $validated['name'];
        $demand->email = $validated['email'];
        $demand->phone = $validated['phone'];
        $demand->city = $validated['city'];
        $demand->postal_code = $validated['postal_code'];
        $demand->project_delay = $validated['project_delay'];
        $demand->description = $validated['description'];
        $demand->category_id = $category->id;

        // register demand in DB

        if(!$demand->save()){
            return response()->json('Am intampinat probleme inregistrand cererea. Va rugam sa incercati mai tarziu.', 501);
        }

        return response()->json($demand, 201);

        // return response accordingly.


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
