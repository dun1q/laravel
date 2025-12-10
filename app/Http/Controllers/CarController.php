<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::latest()->get();
        return view('cars.index', compact('cars'));
    }

    public function create()
    {
        return view('cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:1900|max:2030',
            'price' => 'required|numeric|min:0',
            'mileage_km' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date_format:Y-m-d\TH:i',
        ]);
        
        if ($validated['published_at'] ?? null) {
            $validated['published_at'] = \Carbon\Carbon::createFromFormat(
                'Y-m-d\TH:i', $validated['published_at']
            );
        }
        
        $image = $request->file('image');
        $filename = 'car_' . time() . '.' . $image->getClientOriginalExtension();

        $manager = new ImageManager(new Driver());

        $img = $manager->read($image)->resize(600, 400, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        Storage::disk('public')->put('cars/' . $filename, $img->toPng());

        $car = Car::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'year' => $validated['year'],
            'price' => $validated['price'],
            'mileage_km' => $validated['mileage_km'],
            'image_path' => 'cars/' . $filename,
            'published_at' => $validated['published_at'] ?? null,
        ]);

        return redirect()->route('cars.index')->with('success', 'Автообъявление добавлено');
    }

    public function show(Car $car)
    {
        return view('cars.show', compact('car'));
    }

    public function edit(Car $car)
    {
        return view('cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:1900|max:2030',
            'price' => 'required|numeric|min:0',
            'mileage_km' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'published_at' => 'nullable|date_format:Y-m-d\TH:i',
        ]);

        if ($validated['published_at'] ?? null) {
            $validated['published_at'] = \Carbon\Carbon::createFromFormat(
                'Y-m-d\TH:i', $validated['published_at']
            );
        }
        if ($request->hasFile('image')) {
            if ($car->image_path) {
                Storage::disk('public')->delete($car->image_path);
            }

            $image = $request->file('image');
            $filename = 'car_' . time() . '.' . $image->getClientOriginalExtension();

            $manager = new ImageManager(new Driver());

            $img = $manager->read($image)->resize(600, 400, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            Storage::disk('public')->put('cars/' . $filename, $img->toPng());

            $validated['image_path'] = 'cars/' . $filename;
        }

        $car->update($validated);

        return redirect()->route('cars.index')->with('success', 'Автообъявление обновлено');
    }

    public function destroy(Car $car)
    {
        $car->delete();
        return redirect()->route('cars.index')->with('success', 'Автообъявление удалено');
    }
}