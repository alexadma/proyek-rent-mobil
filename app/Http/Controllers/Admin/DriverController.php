<?php

namespace App\Http\Controllers\Admin;

use App\Driver;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DriverController extends Controller
{
    public function index()
    {
        $driver = Driver::all();
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('cars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // Validation rules here
        ]);

        Driver::create($request->all());

        return redirect()->route('admin.cars.index')->with('success', 'Car created successfully');
    }

    public function edit(Driver $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Driver $car)
    {
        $request->validate([
            // Validation rules here
        ]);

        $car->update($request->all());

        return redirect()->route('admin.cars.index')->with('success', 'Car updated successfully');
    }

    public function destroy(Driver $car)
    {
        $car->delete();

        return redirect()->route('admin.cars.index')->with('success', 'Car deleted successfully');
    }
}
