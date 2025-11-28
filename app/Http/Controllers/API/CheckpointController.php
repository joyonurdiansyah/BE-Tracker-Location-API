<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Checkpoint;
use App\Models\CheckpointLog;
use App\Http\Resources\CheckpointResource;
use Illuminate\Support\Facades\Validator;

class CheckpointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Checkpoint::all();

        return response(['checkpoints' => CheckpointResource::collection($data), 'message' => 'Data berhasil ditampilkan'], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_titik' => 'required|max:255',
            'kode_qr' => 'required|string|max:255|unique:checkpoints,kode_qr',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors(), 'Validation Error'], 422);
        }

        $checkpoint = Checkpoint::create($request->all());

        return response(['checkpoint' => new CheckpointResource($checkpoint), 'message' => 'Data berhasil ditambahkan'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Checkpoint $checkpoint)
    {
        return response()->json([
            'data'    => $checkpoint,
            'message' => 'Detail checkpoint',
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checkpoint $checkpoint)
    {
        $validator = Validator::make($request->all(), [
            'nama_titik' => 'sometimes|required|string|max:255',
            'kode_qr'    => 'sometimes|required|string|max:255|unique:checkpoints,kode_qr,' . $checkpoint->id,
            'lokasi'     => 'nullable|string|max:255',
            'deskripsi'  => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validasi gagal',
            ], 422);
        }

        $checkpoint->update($validator->validated());

        return response()->json([
            'data'    => $checkpoint,
            'message' => 'Checkpoint berhasil diupdate',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checkpoint $checkpoint)
    {
        $checkpoint->delete();

        return response()->json([
            'message' => 'Checkpoint berhasil dihapus',
        ], 200);
    }
}
