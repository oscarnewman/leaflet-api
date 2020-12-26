<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Http\Requests\CreatePropertyRequest;
use App\Http\Requests\SearchPropertiesRequest;
use App\Models\Property;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Auth\Events\Registered;
use Laravel\Fortify\Contracts\CreatesNewUsers;

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
        $results = Property::orderBy('start_date', 'asc')
            ->whereHas('user', fn ($q) => $q->whereNotNull('email_verified_at'));

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
    public function store(CreatePropertyRequest $request, CreatesNewUsers $creator)
    {
        return DB::transaction(function () use ($creator, $request) {

            $user = $request->user();
            if (!$user) {
                event(new Registered($user = $creator->create($request->all())));
                Auth::login($user);
            }

            $property = $user->properties()->create(
                array_merge(
                    $request->except('email', 'name', 'startDate', 'endDate', 'images'),
                    [
                        'start_date' => $request->startDate,
                        'end_date' => $request->endDate
                    ]
                )
            );

            foreach ($request->images as $index => $imageId) {
                $property->images()->attach($imageId, ['order' => $index]);
            }

            return ['user' => $user, 'property' => $property];
        });
    }
}
