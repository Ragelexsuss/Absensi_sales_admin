<?php

namespace App\Http\Controllers;

use App\Models\lokasi;
use Illuminate\Http\Request;

class LokasiMap extends Controller
{
    public function index()
    {
        // Get all locations with their missions and sales orders
        $lokasis = lokasi::all();

        // Transform data for the map
        $mapData = $lokasis->map(function ($lokasi) {
            return [
                'id' => $lokasi->id_lokasi,
                'namaToko' => $lokasi->namaToko,
                'address' => $lokasi->address,
                'latitude' => $lokasi->latitude,
                'longitude' => $lokasi->longitude,
                'radius' => $lokasi->radius,
                'image_url' => $lokasi->image_url,
                'status' => $lokasi->status,
            ];
        });

        return view('map', [
            'lokasis' => $lokasis,
            'mapData' => $mapData,
        ]);
    }
}
