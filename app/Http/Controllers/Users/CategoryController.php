<?php

namespace App\Http\Controllers\Users;

use App\Helpers\ExcelfileValidator  ;
use App\Http\Controllers\UserController;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use App\Repositories\ExcelRepository;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Product;
use yajra\Datatables\Datatables;
use Sentinel;
use DB;

class CategoryController extends UserController
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    
    /**
     * @var ExcelRepository
     */
    private $excelRepository;

    public function __construct(CategoryRepository $categoryRepository ,
                                ExcelRepository $excelRepository
                                )
    {
        parent::__construct();

        $this->categoryRepository = $categoryRepository;
        $this->excelRepository = $excelRepository;

        view()->share('type', 'category');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = trans('category.categories');
        return view('user.category.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = trans('category.new');
		 $allProducts = DB::table('products')->select('id', 'product_name')->get();
        return view('user.category.create', compact('title','allProducts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->create($request->all());
		/*$id = DB::table('categories')->insertGetId(
						['name' => $request->name,'description' => $request->description,'user_id'=>1]
					);
					DB::table('products')
						->where('id', $request->sp)
						->update(['category_id' => $id]		
						);*/
        return redirect("category");
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $title = trans('category.details');
        $action = 'show';
        return view('user.category.show', compact('title', 'category', 'action'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $title = trans('category.edit');
		$this->generateParams($category);
        return view('user.category.edit', compact('title', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
		/*DB::table('categories')
            ->where('id', $category->id)
            ->update(['name' => $request->name],['description' => $request->description]		
			);
		DB::table('products')
            ->where('id', $request->sp)
            ->update(['category_id' => $category->id]		
			);*/
		//die('sdasa');
        $category->update($request->all());
        return redirect('category');
    }

    public function delete(Category $category)
    {
        $action = '';
        $title = trans('category.delete');
        return view('user.category.delete', compact('title', 'category','action'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('category');
    }

    public function data()
    {
        $categories = $this->categoryRepository->getAll()
            ->with('products')
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'count_uses' => $category->products->count(),
                ];
            });

        return Datatables::of($categories)
            ->add_column('actions', '<a href="{{ url(\'category/\' . $id . \'/edit\' ) }}"  title="{{ trans(\'table.edit\') }}">
                                            <i class="fa fa-fw fa-pencil text-warning"></i> </a>
                                     @if($count_uses==0)
                                     <a href="{{ url(\'category/\' . $id . \'/delete\' ) }}"  title="{{ trans(\'table.delete\') }}">
                                            <i class="fa fa-fw fa-times text-danger"></i> </a>
                                     @endif')
            ->remove_column('id')
            ->remove_column('count_uses')
            ->make();

    }
    
    public function getImport()
    {
        $title = trans('category.import');
     //  return 'jimmy';
      return view('user.category.import', compact('title'));
    }
    
     public function downloadExcelTemplate()
    {
		 //return 'jimmy';
        return response()->download(base_path('resources/excel-templates/category.xlsx'));
    }
    public function postImport(Request $request)
    {
        
        
        ExcelfileValidator::validate($request);

        $reader = $this->excelRepository->load($request->file('file'));

        $categorys = $reader->all()->map(function ($row) {
            return [
               'name'           => $row->name
            ];
        });


        return response()->json(compact('categorys'), 200);
    }

    public function postAjaxStore(CategoryRequest $request)
    {
        $this->categoryRepository->create($request->except('created', 'errors', 'selected'));

        return response()->json([], 200);
    }
	 private function generateParams($category)
    {
        //$countries = ['' => trans('company.select_country')] + Country::orderBy("name", "asc")->lists('name', 'id')->toArray();
       //echo $category;die;
	  $products = DB::table('products')->select('id', 'product_name', 'category_id')->get();
	   $category_decode = json_decode($category);
        view()->share('category_data', $category_decode);
		view()->share('allProducts', $products);
    }
}

