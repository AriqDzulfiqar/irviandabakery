<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Http\Requests\Admin\ProductRequest;
use App\User;
use App\Category;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            $query = Product::with(['user','category'])->latest()->get();

            return Datatables::of($query)
                ->addIndexColumn()

                ->addColumn('action', function($item) {
                    return'
                    <div class="btn-group">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle mr-1 mb-1"
                                    typer="button"
                                    data-toggle="dropdown">
                                    Aksi
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="' .route('product.edit', $item->id). '">
                                Sunting
                                </a>
                                
                                <form action="'. route('product.destroy', $item->id) .'" method="POST">
                                    '.method_field('delete').csrf_field(). '
                                    <button type="submit" class="dropdown-item text-danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    ';
                })
                ->editColumn('price', function($item) {
                    return number_format($item->price,0,',','.');
                })
                ->rawColumns(['action'])
                ->make();
        }

        return view('pages.admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $categories = Category::all();

        return view('pages.admin.product.create',[
            'users' => $users,
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Str::slug($request->name);

        $data['users_id'] = Auth::user()->id;
        
        Product::create($data);

        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Product::findOrfail($id);
        $users = User::all();
        $categories = Category::all();

        return view('pages.admin.product.edit',[
            'item' => $item,
            'users' => $users,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
         $data = $request->all();
           
        $item = Product::findOrfail($id);

        $data['slug'] = Str::slug($request->name);

        
        $data['users_id'] = Auth::user()->id;

        $item->update($data);
       
        return redirect()->route('product.index')->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::findOrfail($id);
        $item->delete();

         return redirect()->route('product.index');
    }
}
