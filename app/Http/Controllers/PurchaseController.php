<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Purchase::query();

        if ($search) {
            // Check if it's a date or purchase ID
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $search)) {
                // Search by date
                $query->whereDate('created_at', $search);
            } else {
                // Search by purchase ID
                $query->where('id', '=', $search);
            }
        }

        $purchases =
            $query->with(['items', 'staff'])->get();

        $locations = Purchase::distinct()->pluck('location');

        return Inertia::render('Purchase/purchase', [
            'purchases' => $purchases,
            'locations' => $locations,
            'search' => $search
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
