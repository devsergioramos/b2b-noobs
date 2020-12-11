<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    protected $model;

    public function __construct(Category $model){
        $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::all();

        return response()->json($items);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
            'color' => ['required'],
            'status' => ['required']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['status'=>false,'msg'=>$validator->errors()]);
        }

        try {

            $slug = str_slug($request->name);

            $model = new $this->model;

            $model->name = $request->name;
            $model->color = $request->color;
            $model->status = $request->status;
            $model->slug = $slug;
            $save = $model->save();

            $response = 'Categoria';

            $response .= ' Cadastrada com Sucesso!';

            return response()->json(['status'=>true,'msg'=>$response]);

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            return response()->json(['status'=>false,'msg'=>$response]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $categoria)
    {
        try {

            $item = $categoria;

            return response()->json($item);

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
            }

            return response()->json(['status'=>false,'msg'=>$response]);

        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $categoria)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($request->id)],
            'color' => ['required'],
            'status' => ['required']
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['status'=>false,'msg'=>$validator->errors()]);
        }

        try {            

            $slug = str_slug($request->name);

            $model = $categoria;

            $model->name = $request->name;
            $model->color = $request->color;
            $model->status = $request->status;
            $model->slug = $slug;
            $save = $model->save();

            $response = 'Categoria';

            $response .= ' Editada com Sucesso!';

            return response()->json(['status'=>true,'msg'=>$response]);

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }

            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);

            return response()->json(['status'=>false,'msg'=>$response]);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $categoria)
    {
        try {
         
            $model = $categoria;

            $deleted = $model->delete();

            $response = 'Categoria Deletada com Sucesso!';

            return response()->json(['status'=>true,'msg'=>$response]);

        } catch (\Exception $e) {//errors exceptions

            $response = null;

            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
            }

            return response()->json(['status'=>false,'msg'=>$response]);

        }
    }
}
