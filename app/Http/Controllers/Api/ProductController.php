<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $product = $this->product->paginate('10');

        return response()->json($product, 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        //
        $data = $request->all();

        try {

            $product = $this->product->create($data);

            $product->history()->create([
                'product_id' => $product['id'],
                'quantity' => $product['quantity']
            ]);

            return response()->json([
                    'data' => [
                        'Message' => 'Product successfully registered',
                        'Product' => $product
                    ]
                ], 200);

        } catch (\Exception $th) {
            //throw $th;
            return response()->json($th->getMessage(), 401);
        }
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
        try {
            
            $product = $this->product->with('history')->findOrFail($id);

            return response()->json([
                'data' => [
                    'Product' => $product
                ]
            ], 200);

        } catch (\Exception $th) {
            //throw $th;
            return response()->json($th->getMessage(), 401);
        }
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
        //
        $data = $request->all();

        try {
            
            $product = $this->product->findOrFail($id);
            $product->update($data);

            $product->history()->create([
                'product_id' => $product['id'],
                'quantity' => $product['quantity']
            ]);

            return response()->json([
                'data' => [
                    'Message' => 'Product successfully updated',
                    'Product' => $product
                ]
            ], 200);
        } catch (\Exception $th) {
            //throw $th;
            return response()->json($th->getMessage(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        try {
            
            $product = $this->product->findOrFail($id);
            $product->history()->where('product_id', $product['id'])->delete();
            $product->delete();

            return response()->json([
                'data' => [
                    'Message' => 'Product successfully deleted'
                ]
            ], 200);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json($e->getMessage(),401);
        }
    }
}
