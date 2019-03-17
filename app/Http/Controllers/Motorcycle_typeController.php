<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Motorcycle_Type;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Transformers\Motorcycle_typeTransformer;

class Motorcycle_typeController extends RestController
{
    protected $transformer = Motorcycle_typeTransformer::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motorcycle_types = Motorcycle_Type::all();
        $response = $this->generateCollection($motorcycle_types);
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
            'motorcycle_type_name' => 'required',
            'id_motorcycle_brand' => 'required',
        ]);   

        try {

                $motorcycle_type = new Motorcycle_Type;

                $motorcycle_type->motorcycle_type_name=$request->get('motorcycle_type_name');
                $motorcycle_type->id_motorcycle_brand=$request->get('id_motorcycle_brand');
                $motorcycle_type->save();

                $response = $this->generateItem($motorcycle_type);

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
            $motorcycle_type=Motorcycle_Type::find($id);
            $response = $this->generateItem($motorcycle_type);
            return $this->sendResponse($response);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('motorcycle_type_not_found');
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
            'motorcycle_type_name' => 'required',       
            'id_motorcycle_brand' => 'required',
        ]);
        
        try {

            $motorcycle_type=Motorcycle_Type::find($id);

            $motorcycle_type->motorcycle_type_name=$request->get('motorcycle_type_name');
            $motorcycle_type->id_motorcycle_brand=$request->get('id_motorcycle_brand');
            $motorcycle_type->save();

            $response = $this->generateItem($motorcycle_type);

            return $this->sendResponse($response, 201);

        }catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('motorcycle_type_not_found');
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
            $motorcycle_type=Motorcycle_Type::find($id);
            $motorcycle_type->delete();
            return response()->json('Success',200);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('motorcycle_type_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
