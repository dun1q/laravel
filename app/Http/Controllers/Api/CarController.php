<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Resources\CarResource;

class CarController extends Controller
{
    // Список всех машин
    public function index()
    {
        return CarResource::collection(Car::with('user')->get());
    }

    // Получить одну машину
    public function show(Car $car)
    {
        $car->load('user');
        return new CarResource($car);
    }

    // Создать новую машину
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:1900|max:2030',
            'price' => 'required|numeric|min:0',
            'mileage_km' => 'required|integer|min:0',
            'image_path' => 'required|string|max:255'
        ]);

        $validated['user_id'] = $request->user()->id; // Возьмём пользователя из токена

        $car = Car::create($validated);

        return new CarResource($car);
    }

    // Обновить машину
    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'year' => 'required|integer|min:1900|max:2030',
            'price' => 'required|numeric|min:0',
            'mileage_km' => 'required|integer|min:0',
            'image_path' => 'required|string|max:255'
        ]);
        $car->update($validated);

        return new CarResource($car);
    }

    // Удалить машину
    public function destroy(Car $car)
    {
        $car->delete();
        return response()->json(['message' => 'Машина удалена']);
    }
}

