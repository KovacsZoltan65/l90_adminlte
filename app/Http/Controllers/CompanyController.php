<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Repositories\CompanyRepository;
use App\Requests\CompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller{

    protected $repository;

    function __construct(CompanyRepository $repository){
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
            $companies = $this->repository
                ->scopeQuery(function($query){
                    return $query->onlyTrashed()
                        ->paginate(config('app.paginate_number'));
                })->all();
        }else{
            // Csak az aktívak
            $companies = $this->repository
                ->scopeQuery(function($query){
                    return $query
                        ->paginate(config('app.paginate_number'));
                })->all();
        }

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request){

        $company = $this->repository->create($request->all());

        if( empty($company) ){
            return Redirect::to('companies')
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
        
        //Company::create($request->post());
        */        
        return redirect()
            ->route('companies.index')
            ->with('success', 'Company has been created successfully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        return view('companies.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id){
        $company = $this->repository->findWithoutFail($id);

        if(empty($company)){
            return Redirect::to('companies')
                ->withErrors(['error' => 'Nincs meg a rekord']);
        }
        /*
        $company = Company::find($id);
        */
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, Company $company){

        $company = $this->repository->findWithoutFail($company->id);

        if( empty($company) ){
            return Redirect::to('companies')
                ->withErrors([
                    'error' => 'Nincs meg a rekord'
                ]);
        }

        $company = $this->repository
            ->update(
                $request->all(), 
                $company->id
        );

        if( !$company ){
            return Redirect::to('companies')
                ->withErrors([
                    'error' => 'Hiba mentés közben'
                ]);
        }

        return Redirect::to('companies')
            ->withErrors([
                'success' => 'Sikeres frissítés'
            ]);

        /*
        $request->validate([
            'name' => 'required'
        ]);

        $this->repository->update($request->post(), $company->id);
        
        return redirect()
            ->route('companies.index')
            ->with('success', 'Company has been updated successfully');
        */
    }

    /**
     * Távolítsa el a megadott erőforrást a tárhelyről.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company){

        if( $company->isSoftDelete() ){
            $this->repository->update(['status' => 0], $company->id);
        }else{
            $this->repository->delete($company->id);
        }
        
        // Átirányítás a "companies" oldalra üzenettel.
        return redirect()
            ->route('companies.index')
            ->with('success', 'Company has been deleted successfully.');
    }
    
    /**
     * Rekord visszaállítása
     * 
     * @param int $id
     */
    public function restore(int $id){
        //dd('restore');
        $company = Company::withTrashed()
            ->find($id)
            ->update(['status' => 1]);

        return back();
    }

    /**
     * Összes törölt rekord visszaállítása
     */
    public function restoreAll(){

        Company::onlyTrashed()
            ->update(['status' => 1]);

        return back();
    }
}
