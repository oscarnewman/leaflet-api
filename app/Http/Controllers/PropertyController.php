<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchProperties;
use App\Http\Requests\SearchPropertiesRequest;
use App\Models\Property;
use Illuminate\Http\Request;

/**
 * Class PropertyController
 * @package App\Http\Controllers
 */
class PropertyController extends Controller
{
    /**
     * Show all public properties based on a query
     */
    public function index(SearchPropertiesRequest $request)
    {
        $results = Property::orderBy('start_date', 'asc');

        if ($request->has('bedrooms')) {
            $results = $results->whereBedrooms($request->bedrooms);
        }

        if ($request->has('startDate')) {
            $results = $results->whereDate('start_date', '>=', $request->startDate);
        }
        if ($request->has('endDate')) {
            $results = $results->whereDate('end_date', '<=', $request->endDate);
        }

        if ($request->has('rentMin')) {
            $results = $results->where('rent', '>=', $request->rentMin);
        }
        if ($request->has('rentMax')) {
            $results = $results->where('rent', '<=', $request->rentMax);
        }

        return $results->paginate(9);
    }

    /**
     * Show a specific property with its images
     */
    public function show(Property $property)
    {
        return $property->load('images');
    }

    public function create($request)
    {
    }
}
