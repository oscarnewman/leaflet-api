<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

/**
 * Class PropertyController
 * @package App\Http\Controllers
 */
class PropertyController extends Controller
{
    public function index(Request $request)
    {
        return Property::orderBy('start_date', 'asc')->paginate(12);
    }

    public function show(Property $property)
    {
        return $property;
    }

    public function create($request)
    {
    }
}
