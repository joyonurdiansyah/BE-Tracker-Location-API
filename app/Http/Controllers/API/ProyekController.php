<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\proyek;
use App\Http\Resources\ProyekResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ProyekController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proyek = proyek::all();
        return response(['proyek' => ProyekResource::collection($proyek), 'message' => 'Data berhasil ditampilkan'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'nama' => 'required|max:255',
            'intro' => 'required',
            'lokasi' => 'required',
            'harga' => 'required|integer',
        ]);

        if($validator->fails()){
            return response(['error' => $validator->errors(), 'Validation Error']);
        }

        $proyek = proyek::create($data);
        return response(['proyek' => new ProyekResource($proyek), 'message' => 'Data berhasil ditambahkan'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(proyek $proyek)
    {
        return response(['proyek' => new ProyekResource($proyek), 'message' => 'Data proyek berhasil diambil'], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, proyek $proyek)
    {
        $proyek->update($request->all());
        return response(['proyek' => new ProyekResource($proyek), 'message' => 'Data berhasil diubah'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(proyek $proyek)
    {
        $proyek->delete();
        return response(['message' => 'Data berhasil dihapus'], 200);
    }
}
