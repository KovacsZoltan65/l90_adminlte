<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        if( $request->has('view_deleted') )
        {
            $persons = Person::onlyTrashed()
                ->orderBy('id', 'desc')
                ->paginate(config('app.paginate_number'));
        }else{
            $persons = Person::orderBy('id', 'desc')
                ->paginate(config('app.paginate_number'));
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
    public function store(Request $request){
        $request->validate([
            'name' => 'required',
        ]);

        Person::create($request->post());

        return redirect()
            ->route('persons.index')
            ->with('success', 'Person has been created successfullí');
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
        $person = Person::find($id);
        return view('persons.edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person){
        
        $request->validate([
            'name' => 'required',
        ]);
        
        $person->fill($request->post())->save();

        return redirect()
            ->route('persons.index')
            ->with('succcess', 'Person has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person){

        if( $person->isSoftDelete() ){
            $person->update(['status' => 0]);
        }else{
            //
            $person->delete();
        }

        return redirect()
            ->route('persons.index')
            ->with('success', 'Person has been deleted succesfully');
        
    }

    public function restore(int $id){
        Person::onlyTrashed()
            ->find($id)
            ->update(['status' => 1]);

        return back();
    }

    public function restoreAll(){
        Person::onlyTrashed()
            ->update(['status' => 1]);

        return back();
    }
}
