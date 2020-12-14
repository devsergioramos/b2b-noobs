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

        try {

            $items = $this->model::with('category')->get();

            return response()->json(['status'=>true,'items'=>$items]);

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
            'imagem' => ['required|image|mimes:jpeg,png,jpg,gif,svg|max:1500']
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

            if($file   =   $request->file('image')) {
                
                $image_name      =   time().time().'.'.$file->getClientOriginalExtension();  
                  try{
                      $target_path    =   public_path('images/products');
                      
                      $is_uploaded = $file->move($target_path, $image_name);
  
                      if ($is_uploaded) {
                            //Save image name into db
                            $update_model = $this->model->findOrFail($model->id);
                            $update_model->image = $image_name;
                            $update_model->save();

                            $model->image = $image_name;  
                                                  
                          
                      } else {
                          $response .= ' (a imagem não foi salva)';
                      }
                  } catch (\Exception $e){
                      $response .= ' (Erro: '.$e->getMessage().')';
                  }
  
              }else{
               
                $response .= ' (a imagem não foi salva)';
               
              }

            $category = \App\Models\Category::find($request->category_id);
            $model->category = $category;

            return response()->json(['status'=>true,'msg'=>$response,'item'=>$model]);

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
    public function show($produto)
    {
        try {

            $item = $this->model::findOrFail($produto);

            return response()->json(['item'=>$item]);

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
    public function edit(Product $produto)
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
    public function update(Request $request, $produto)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required'],
            'price' => ['required'],
            'status' => ['required'],
            'imagem' => ['required|image|mimes:jpeg,png,jpg,gif,svg|max:1500'],
        ];

        $re = $request->all();

        //return response()->json($re);


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return response()->json(['status'=>false,'msg'=>$validator->errors()]);
        }

        try {

            $model = $this->model::findOrFail($produto);

            $image_before_update = $model->image;            

            $model->category_id = $request->category_id;
            $model->name = $request->name;
            $model->price = $request->price;
            $model->status = $request->status;
            $model->image = $request->image;
            $save = $model->save();

            $response = 'Produto';

            $response .= ' Editado com Sucesso!';

            if($file   =   $request->file('image')) {
                
                $image_name      =   time().time().'.'.$file->getClientOriginalExtension();  
                  try{
                      $target_path    =   public_path('images/products');
                      
                      $is_uploaded = $file->move($target_path, $image_name);
  
                      if ($is_uploaded) {
                            //Save image name into db
                            $update_model = $this->model->findOrFail($model->id);
                            $update_model->image = $image_name;
                            $update_model->save();

                            $model->image = $image_name;  
                          
                            $storage = Storage::disk('public');
                            if(\File::exists('images/products/'.$image_before_update)) {
                                \File::delete('images/products/'.$image_before_update);
                            }
                          
                      } else {
                          $response .= ' (a imagem não foi salva)';
                      }
                  } catch (\Exception $e){
                      $response .= ' (Erro: '.$e->getMessage().')';
                  }
  
              }else{
               
                  if(strlen($image_before_update)>0){
  
                    if(!\File::exists('images/products/'.$image_before_update)) {
                        $response .= ' (a imagem não foi salva)';
                    }
                  }else{
                    $response .= ' (a imagem não foi salva)';
                  }
               
              }

            $category = \App\Models\Category::find($request->category_id);
            $model->category = $category;

            return response()->json(['status'=>true,'msg'=>$response,'item'=>$model]);

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
    public function destroy($produto)
    {
        try {
         
            $produto = $this->model::findOrFail($produto);

            $image = $produto->image;

            if($produto->delete()){

                if(\File::exists('images/products/'.$image)) {
                    \File::delete('images/products/'.$image);
                }
            }

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
