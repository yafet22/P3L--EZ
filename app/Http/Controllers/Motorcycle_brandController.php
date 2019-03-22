<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Motorcycle_Brand;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Transformers\Motorcycle_brandTransformer;

class Motorcycle_brandController extends RestController
{
    protected $transformer = Motorcycle_brandTransformer::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motorcycle_brands = Motorcycle_Brand::all();
        $response = $this->generateCollection($motorcycle_brands);
        return $this->sendResponse($response);
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
        try {

                $motorcycle_brand = new Motorcycle_Brand;

                $motorcycle_brand->motorcycle_brand_name=$request->get('motorcycle_brand_name');
                $motorcycle_brand->save();

                $response = $this->generateItem($motorcycle_brand);

                return $this->sendResponse($response, 201);
           

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
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
        try {
            $motorcycle_brand=Motorcycle_Brand::find($id);
            $response = $this->generateItem($motorcycle_brand);
            return $this->sendResponse($response);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('motorcycle_brand_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'motorcycle_brand_name' => 'required',
        ]);
        
        try {

            $motorcycle_brand=Motorcycle_Brand::find($id);

            $motorcycle_brand->motorcycle_brand_name=$request->get('motorcycle_brand_name');
            $motorcycle_brand->save();

            $response = $this->generateItem($motorcycle_brand);

            return $this->sendResponse($response, 201);

        }catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('motorcycle_brand_not_found');
        }
        catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
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
        try {
            $motorcycle_brand=Motorcycle_Brand::find($id);
            $motorcycle_brand->delete();
            return response()->json('Success',200);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('motorcycle_brand_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
