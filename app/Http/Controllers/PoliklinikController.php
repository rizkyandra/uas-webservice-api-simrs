<?php

namespace App\Http\Controllers;

use App\Poliklinik;
use Illuminate\Http\Request;

class PoliklinikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $poli = Poliklinik::all();
        return response()->json([
            "metadata" => [
                "code" => 200,
                "message" => "Success"
            ],
            "response" => $poli
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $poli = new Poliklinik();
        $poli->nama_poli = $request->nama_poli;
        $poli->save();

        return response()->json([
            "metadata" => [
                "code" => 200,
                "message" => "Success"
            ],
            "response" => $poli
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $poli = Poliklinik::find($id);
        if (empty($poli)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data poli tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            return response()->json([
                "metadata" => [
                    "code" => 200,
                    "message" => "Success"
                ],
                "response" => $poli
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $poli = Poliklinik::find($id);

        if (empty($poli)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data poli tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            $poli->nama_poli = $request->nama_poli;
            $poli->save();

            return response()->json([
                "metadata" => [
                    "code" => 200,
                    "message" => "Success"
                ],
                "response" => $poli
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $poli = Poliklinik::findOrFail($id);

        if (empty($poli)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data poli tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            $poli->delete();
            return response()->json([
                "metadata" => [
                    "code" => 200,
                    "message" => "Success"
                ],
                "response" => ""
            ]);
        }
    }
}
