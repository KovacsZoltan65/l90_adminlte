<?php

namespace App\Http\Controllers;

use App\Http\Requests\PersonRequest;
use App\Models\Person;
use App\Repositories\PersonRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PersonController extends Controller{

    protected $repository;

    function __construct(PersonRepository $repository){
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        
        if( $request->has('view_deleted') ){
            // Csak a törölteket
            $persons = $this->repository
                ->scopeQuery(function($query){
                    return $query->onlyTrashed()
                        ->paginate(config('app.paginate_number'));
                })->all();
        }else{
            // Csak az aktívak
            $persons = $this->repository
                ->scopeQuery(function($query){
                    return $query
                        ->paginate(config('app.paginate_number'));
                })->all();
        }

        return view('persons.index', compact('persons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('persons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PersonRequest $request){

        $person = $this->repository->create($request->all());

        if( empty($person) ){
            return Redirect::to('persons')
                ->withErrors([
                    'error' => 'Hiba a mentés közben'
            ]);
        }

        /*
        $request->validate([
            'name' => 'required'
        ]);
        $this->repository
            ->create($request->post());
        
        //Person::create($request->post());
        */        
        return redirect()
            ->route('persons.index')
            ->with('success', 'Person has been created successfully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        return view('persons.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id){
        $person = $this->repository->findWithoutFail($id);

        if(empty($person)){
            return Redirect::to('persons')
                ->withErrors(['error' => 'Nincs meg a rekord']);
        }
        /*
        $person = Person::find($id);
        */
        return view('persons.edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(PersonRequest $request, Person $person){

        $person = $this->repository->findWithoutFail($person->id);

        if( empty($person) ){
            return Redirect::to('persons')
                ->withErrors([
                    'error' => 'Nincs meg a rekord'
                ]);
        }

        $person = $this->repository
            ->update(
                $request->all(), 
                $person->id
        );

        if( !$person ){
            return Redirect::to('persons')
                ->withErrors([
                    'error' => 'Hiba mentés közben'
                ]);
        }

        return Redirect::to('persons')
            ->withErrors([
                'success' => 'Sikeres frissítés'
            ]);

        /*
        $request->validate([
            'name' => 'required'
        ]);

        $this->repository->update($request->post(), $person->id);
        
        return redirect()
            ->route('persons.index')
            ->with('success', 'Person has been updated successfully');
        */
    }

    /**
     * Távolítsa el a megadott erőforrást a tárhelyről.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person){

        if( $person->isSoftDelete() ){
            $this->repository->update(['status' => 0], $person->id);
        }else{
            $this->repository->delete($person->id);
        }
        
        // Átirányítás a "persons" oldalra üzenettel.
        return redirect()
            ->route('persons.index')
            ->with('success', 'Person has been deleted successfully.');
    }
    
    /**
     * Rekord visszaállítása
     * 
     * @param int $id
     */
    public function restore(int $id){
        //dd('restore');
        $person = Person::withTrashed()
            ->find($id)
            ->update(['status' => 1]);

        return back();
    }

    /**
     * Összes törölt rekord visszaállítása
     */
    public function restoreAll(){

        Person::onlyTrashed()
            ->update(['status' => 1]);

        return back();
    }
}
