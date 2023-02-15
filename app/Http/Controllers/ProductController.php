<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\ProductRepository;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller{

    protected $repository;

    function __construct(ProductRepository $repository){
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
            $products = $this->repository
                ->scopeQuery(function($query){
                    return $query->onlyTrashed()
                        ->paginate(config('app.paginate_number'));
                })->all();
        }else{
            // Csak az aktívak
            $products = $this->repository
                ->scopeQuery(function($query){
                    return $query
                        ->paginate(config('app.paginate_number'));
                })->all();
        }

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request){

        $product = $this->repository->create($request->all());

        if( empty($product) ){
            return Redirect::to('products')
                ->withErrors([
                    'error' => 'Hiba a mentés közben'
            ]);
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been created successfully');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        return view('products.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id){
        $product = $this->repository->findWithoutFail($id);

        if(empty($product)){
            return Redirect::to('products')
                ->withErrors(['error' => 'Nincs meg a rekord']);
        }
        /*
        $product = Product::find($id);
        */
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product){

        $product = $this->repository->findWithoutFail($product->id);

        if( empty($product) ){
            return Redirect::to('products')
                ->withErrors([
                    'error' => 'Nincs meg a rekord'
                ]);
        }

        $product = $this->repository
            ->update(
                $request->all(), 
                $product->id
        );

        if( !$product ){
            return Redirect::to('products')
                ->withErrors([
                    'error' => 'Hiba mentés közben'
                ]);
        }

        return Redirect::to('products')
            ->withErrors([
                'success' => 'Sikeres frissítés'
            ]);

        /*
        $request->validate([
            'name' => 'required'
        ]);

        $this->repository->update($request->post(), $product->id);
        
        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been updated successfully');
        */
    }

    /**
     * Távolítsa el a megadott erőforrást a tárhelyről.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product){

        if( $product->isSoftDelete() ){
            $this->repository->update(['status' => 0], $product->id);
        }else{
            $this->repository->delete($product->id);
        }
        
        // Átirányítás a "products" oldalra üzenettel.
        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been deleted successfully.');
    }
    
    /**
     * Rekord visszaállítása
     * 
     * @param int $id
     */
    public function restore(int $id){
        //dd('restore');
        $product = Product::withTrashed()
            ->find($id)
            ->update(['status' => 1]);

        return back();
    }

    /**
     * Összes törölt rekord visszaállítása
     */
    public function restoreAll(){

        Product::onlyTrashed()
            ->update(['status' => 1]);

        return back();
    }
}
