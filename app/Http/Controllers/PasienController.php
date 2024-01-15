<?php

namespace App\Http\Controllers;

use App\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pasien = Pasien::all();
        return response()->json([
            "metadata" => [
                "code" => 200,
                "message" => "Success"
            ],
            "response" => $pasien
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
        $pasien = new Pasien();
        $pasien->nama_pasien = $request->nama_pasien;
        $pasien->nik = $request->nik;
        $pasien->tgl_lahir = date('Y-m-d', strtotime($request->tgl_lahir));
        $pasien->alamat = $request->alamat;
        $pasien->no_telp = $request->no_telp;
        $pasien->save();

        return response()->json([
            "metadata" => [
                "code" => 200,
                "message" => "Success"
            ],
            "response" => $pasien
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
        $pasien = Pasien::find($id);

        if (empty($pasien)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data pasien tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            return response()->json([
                "metadata" => [
                    "code" => 200,
                    "message" => "Success"
                ],
                "response" => $pasien
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
        $pasien = Pasien::find($id);

        if (empty($pasien)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data pasien tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            $pasien->nama_pasien = $request->nama_pasien;
            $pasien->nik = $request->nik;
            $pasien->tgl_lahir = date('Y-m-d', strtotime($request->tgl_lahir));
            $pasien->alamat = $request->alamat;
            $pasien->no_telp = $request->no_telp;
            $pasien->save();

            return response()->json([
                "metadata" => [
                    "code" => 200,
                    "message" => "Success"
                ],
                "response" => $pasien
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
        $pasien = Pasien::find($id);

        if (empty($pasien)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data pasien tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            $pasien->delete();
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
