<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    protected $model;

    public function __construct(Product $model){
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
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required'],
            'price' => ['required'],
            'status' => ['required'],
            'image' => ['required', 'string', 'max:255'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['status'=>false,'msg'=>$validator->errors()]);
        }

        try {

            $model = new $this->model;

            $model->category_id = $request->category_id;
            $model->name = $request->name;
            $model->price = $request->price;
            $model->status = $request->status;
            $model->image = $request->image;
            $save = $model->save();

            $response = 'Produto';

            $response .= ' Cadastrado com Sucesso!';

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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $id)
    {
        try {

            $item = $id;

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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $id)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required'],
            'price' => ['required'],
            'status' => ['required'],
            'image' => ['required', 'string', 'max:255'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['status'=>false,'msg'=>$validator->errors()]);
        }

        try {

            $model = $id;

            $model->category_id = $request->category_id;
            $model->name = $request->name;
            $model->price = $request->price;
            $model->status = $request->status;
            $model->image = $request->image;
            $save = $model->save();

            $response = 'Produto';

            $response .= ' Editado com Sucesso!';

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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $id)
    {
        try {
         
            $model = $id;

            $deleted = $model->delete();

            $response = 'Produto Deletado com Sucesso!';

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
