<?php

namespace App\Http\Controllers;

use App\Models\Estimate;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    public function index()
    {
        // Mengambil daftar proyek untuk filter pilihan proyek
        $estimates = Estimate::all();

        return view('designs.index', compact('estimates'));
    }
}