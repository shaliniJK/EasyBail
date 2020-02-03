<?php

namespace App\Http\Controllers;

use App\Location;
use App\Locataire;
use App\Property;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        $properties = $user->properties;
        $locataires = $user->locataires;
        $locations = $user->locations;

        return view('locations.index')->with(compact('user', 'properties', 'locataires', 'locations'));
    }

    // show a single ressource
    public function show(Location $location)
    {
        $property = Property::find($location->property_id);
        $locataire = Locataire::find($location->locataire_id);

        return view('locations.show', ['user' => auth()->user(), 'property' => $property, 'locataire' => $locataire, 'location' => $location]);
    }

    /**
     * Show a view to create a new location.
     */
    public function create()
    {
        $user = auth()->user();

        return view('locations.create', [
            'user' => $user,
            'properties' => $user->properties,
            'locataires' => $user->locataires,
        ]);
    }

    /**
     * Creates a new location.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        $location = $this->validateLocation();

        $user = $request->user();

        $user->locations()->create($location);

        return redirect(route('locations.index'))->with('success', 'Votre location a bien été crée !');
    }

    // Show a view to edit
    public function edit(Location $location)
    {
        return view('locations.edit', [
            'user' => auth()->user(),
            'location' => $location,
        ]);
    }

    public function update(Location $location)
    {
        $location->update($this->validateLocation());

        return redirect($location->path());
    }

    protected function validateLocation()
    {
        return request()->validate([
            'property_id' => 'required|exists:properties,id',
            'locataire_id' => 'required|exists:locataires,id',
            'loyer' => 'required',
            'charges' => 'required',
            'preavis' => 'required',
            'date_signature_bail' => 'required|date',
            'date_entree' => 'required|date',
        ]);
    }

    /**
     * Destroys a location.
     *
     * @param Location $location
     */
    public function destroy(Location $location)
    {
    }
}
