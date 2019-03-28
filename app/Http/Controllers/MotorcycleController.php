<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Motorcycle;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Transformers\MotorcycleTransformer;

class MotorcycleController extends RestController
{
    protected $transformer = MotorcycleTransformer::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motorcycles = Motorcycle::all();
        $response = $this->generateCollection($motorcycles);
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
        $this->validate($request,[
            'license_number' => 'required',
            'id_motorcycle_type' => 'required',
            'id_customer' => 'required',
        ]);   

        try {

                $motorcycle = new Motorcycle;

                $motorcycle->license_number=$request->get('license_number');
                $motorcycle->id_motorcycle_type=$request->get('id_motorcycle_type');
                $motorcycle->id_customer=$request->get('id_customer');
                $motorcycle->save();

                $response = $this->generateItem($motorcycle);

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
            $motorcycle=Motorcycle::find($id);
            $response = $this->generateItem($motorcycle);
            return $this->sendResponse($response);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('motorcycle_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function showByUser($id)
    {
        try {
            $motorcycle=Motorcycle::where('id_customer',$id)->get();
            $response = $this->generateCollection($motorcycle);
            return $this->sendResponse($response);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('motorcycle_not_found');
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
        
        try {

            $motorcycle=Motorcycle::find($id);

            $motorcycle->license_number=$request->get('license_number');
            $motorcycle->id_motorcycle_type=$request->get('id_motorcycle_type');
            $motorcycle->id_customer=$request->get('id_customer');
            $motorcycle->save();

            $response = $this->generateItem($motorcycle);

            return $this->sendResponse($response, 201);

        }catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('motorcycle_not_found');
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
            $motorcycle=Motorcycle::find($id);
            $motorcycle->delete();
            return response()->json('Success',200);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('motorcycle_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
