<?php

namespace App\Http\Controllers;

use App\Dokter;
use App\JadwalDokter;
use App\Poliklinik;
use Illuminate\Http\Request;

class JadwalDokterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jadwal_dokter = JadwalDokter::select('jadwal_dokter.*', 'd.nama_dokter', 'p.nama_poli')
            ->join('poliklinik as p', 'p.id_poli', 'jadwal_dokter.id_poli')
            ->join('dokter as d', 'd.id_dokter', 'jadwal_dokter.id_dokter')
            ->get();

        return response()->json([
            "metadata" => [
                "code" => 200,
                "message" => "Success"
            ],
            "response" => $jadwal_dokter
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
        $cek_dokter = Dokter::find($request->id_dokter);
        $cek_poli = Poliklinik::find($request->id_poli);

        if (empty($cek_dokter) || empty($cek_poli)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Dokter atau Poliklinik tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            $jadwal = new JadwalDokter();
            $jadwal->id_dokter = $request->id_dokter;
            $jadwal->id_poli = $request->id_poli;
            $jadwal->jam_mulai = $request->jam_mulai;
            $jadwal->jam_selesai = $request->jam_selesai;
            $jadwal->save();

            $jadwal_dokter = JadwalDokter::select('jadwal_dokter.*', 'p.nama_poli', 'd.nama_dokter')
                ->join('poliklinik as p', 'p.id_poli', 'jadwal_dokter.id_poli')
                ->join('dokter as d', 'd.id_dokter', 'jadwal_dokter.id_dokter')
                ->where('id_jadwal', $jadwal->id_jadwal)
                ->first();

            return response()->json([
                "metadata" => [
                    "code" => 200,
                    "message" => "Success"
                ],
                "response" => $jadwal_dokter
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jadwal_dokter = JadwalDokter::select('jadwal_dokter.*', 'd.nama_dokter', 'p.nama_poli')
            ->join('poliklinik as p', 'p.id_poli', 'jadwal_dokter.id_poli')
            ->join('dokter as d', 'd.id_dokter', 'jadwal_dokter.id_dokter')
            ->where('id_jadwal', $id)
            ->first();

        if (empty($jadwal_dokter)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data jadwal dokter tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            return response()->json([
                "metadata" => [
                    "code" => 200,
                    "message" => "Success"
                ],
                "response" => $jadwal_dokter
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
        $jadwal = JadwalDokter::find($id);

        if (empty($jadwal)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data jadwal dokter tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            $cek_dokter = Dokter::find($request->id_dokter);
            $cek_poli = Poliklinik::find($request->id_poli);

            if (empty($cek_dokter) || empty($cek_poli)) {
                return response()->json([
                    "metadata" => [
                        "code" => 201,
                        "message" => "Failed! Dokter atau Poliklinik tidak ditemukan."
                    ],
                    "response" => ""
                ]);
            } else {
                $jadwal->id_dokter = $request->id_dokter;
                $jadwal->id_poli = $request->id_poli;
                $jadwal->jam_mulai = $request->jam_mulai;
                $jadwal->jam_selesai = $request->jam_selesai;
                $jadwal->save();

                $jadwal_dokter = JadwalDokter::select('jadwal_dokter.*', 'p.nama_poli', 'd.nama_dokter')
                    ->join('poliklinik as p', 'p.id_poli', 'jadwal_dokter.id_poli')
                    ->join('dokter as d', 'd.id_dokter', 'jadwal_dokter.id_dokter')
                    ->where('id_jadwal', $id)
                    ->first();

                return response()->json([
                    "metadata" => [
                        "code" => 200,
                        "message" => "Success"
                    ],
                    "response" => $jadwal_dokter
                ]);
            }
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
        $jadwal = JadwalDokter::find($id);

        if (empty($jadwal)) {
            return response()->json([
                "metadata" => [
                    "code" => 201,
                    "message" => "Failed! Data jadwal dokter tidak ditemukan."
                ],
                "response" => ""
            ]);
        } else {
            $jadwal->delete();
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
