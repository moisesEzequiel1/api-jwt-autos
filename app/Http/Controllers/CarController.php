<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;

use App\Helpers\JwtAuth;

use App\Http\Requests\CarStoreRequest;
use App\Http\Requests\CarUpdateRequest;

use Auth;

class CarController extends Controller
{
    //
    public function index(Request $request){
        $cars = Car::all()->load('user');
        return response()->json([
            'cars' => $cars, 
            'status' => 'succes'
        ], 200);

    }
    public function show($id){
        $car = Car::findOrFail($id);
        return response()->json([
            'cars' => $car, 
            'status' => 'succes'
        ], 200);
    }

    public function store(CarStoreRequest $request){
        $user = Auth::User();     
        $user_id = [
            'user_id' => $user->id,
        ];
        $car = array_merge($request->all(), $user_id);
        $car = Car::create($car);
        $data = [
            'car' => $car, 
            'status' => 'success',
            'code' => 200,
        ];
        return  response()->json($data, 200);

    }
    public function update(CarUpdateRequest $request, $id){
        $car = Car::findOrFail($id);
        // Guardar el carro
        $car->fill($request->all());
        $car->saveOrFail();
        $data = [
            'car' => $car, 
            'status' => 'success',
            'code' => 200,
        ];
        return  response()->json($data, 200);

    }
    public function destroy(Request $request, $id){
        $car = Car::findOrFail($id);
        $car->delete();
        $data = [
            'car' => $car, 
            'status' => 'success',
            'code' => 200,
        ];
        return  response()->json($data, 200);
    }
}
