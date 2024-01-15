<?php

namespace App\Http\Controllers;

use App\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dokter = Dokter::all();
        return response()->json([
            "metadata" => [
                "code" => 200,
                "message" => "Success"
            ],
            "response" => $dokter
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
        $dokter = new Dokter();
        $dokter->nama_dokter = $request->nama_dokter;
        $dokter->nik = $request->nik;
        $dokter->alamat = $request->alamat;
        $dokter->no_telp = $request->no_telp;
        $dokter->save();

        return response()->json([
            "metadata" => [
                "code" => 200,
                "message" => "Success"
            ],
            "response" => $dokter
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
        $dokter = Dokter::find($id);

        if (empty($dokter)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data dokter tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            return response()->json([
                "metadata" => [
                    "code" => 200,
                    "message" => "Success"
                ],
                "response" => $dokter
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
        $dokter = Dokter::find($id);

        if (empty($dokter)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data dokter tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            $dokter->nama_dokter = $request->nama_dokter;
            $dokter->nik = $request->nik;
            $dokter->alamat = $request->alamat;
            $dokter->no_telp = $request->no_telp;
            $dokter->save();

            return response()->json([
                "metadata" => [
                    "code" => 200,
                    "message" => "Success"
                ],
                "response" => $dokter
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
        $dokter = Dokter::find($id);

        if (empty($dokter)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data dokter tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            $dokter->delete();
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
