<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\CreatePropertyRequest;
use App\Http\Requests\SearchPropertiesRequest;
use App\Models\Property;
use App\Models\User;
use Auth;
use DB;

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
            $results = $results->whereDate('start_date', '<=', $request->startDate);
        }
        if ($request->has('endDate')) {
            $results = $results->whereDate('end_date', '>=', $request->endDate);
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

    /**
     * Create a new user and property at the same time
     */
    public function store(CreatePropertyRequest $request, CreateNewUser $createNewUser)
    {
        return DB::transaction(function () use ($createNewUser, $request) {

            $user = $request->user();
            if (!$user) {
                $request->validate(['email' => 'required|unique:users|email', 'name' => 'required']);
                $user = $createNewUser->create($request->only('email', 'name'));
                Auth::login($user);
            }

            $property = $user->properties()->create(
                array_merge(
                    $request->except('email', 'name', 'startDate', 'endDate'),
                    [
                        'start_date' => $request->startDate,
                        'end_date' => $request->endDate
                    ]
                )
            );

            return ['user' => $user, 'property' => $property];
        });
    }
}
