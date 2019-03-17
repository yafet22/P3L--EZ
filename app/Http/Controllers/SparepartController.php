<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sparepart;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Transformers\SparepartTransformer;

class SparepartController extends RestController
{
    protected $transformer = SparepartTransformer::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $spareparts = Sparepart::all();
        $response = $this->generateCollection($spareparts);
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
            'sparepart_name' => 'required',
            'merk' => 'required',
            'stock' => 'required',
            'min_stock' => 'required',
            'purchase_price' => 'required',
            'sell_price' => 'required',
            'placement' => 'required',
            'image' => 'required',
            'id_sparepart_type' => 'required',
        ]);   

        try {
                $sparepart = new Sparepart;

                if($request->hasfile('image'))
                {
                    $file = $request->file('image');
                    $name=time().$file->getClientOriginalName();
                    $file->move(public_path().'/images/', $name);
                    $sparepart->image=$name;
                }
                else{
                    $sparepart->image=NULL;
                }

                $sparepart->sparepart_name=$request->get('sparepart_name');
                $sparepart->merk=$request->get('merk');
                $sparepart->stock=$request->get('stock');
                $sparepart->min_stock=$request->get('min_stock');
                $sparepart->purchase_price=$request->get('purchase_price');
                $sparepart->sell_price=$request->get('sell_price');
                $sparepart->placement=$request->get('placement');
                $sparepart->id_sparepart_type=$request->get('id_sparepart_type');
                $sparepart->save();

                $response = $this->generateItem($sparepart);

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
            $sparepart=Sparepart::find($id);
            $response = $this->generateItem($sparepart);
            return $this->sendResponse($response);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('sparepart_not_found');
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
            'sparepart_name' => 'required',
            'merk' => 'required',
            'stock' => 'required',
            'min_stock' => 'required',
            'purchase_price' => 'required',
            'sell_price' => 'required',
            'placement' => 'required',
            'image' => 'required',
            'id_sparepart_type' => 'required',
        ]); 

        try {

            $sparepart=Sparepart::find($id);


            if($request->hasfile('image'))
            {
                $file = $request->file('image');
                $name=time().$file->getClientOriginalName();
                $file->move(public_path().'/images/', $name);
                $sparepart->image=$name;
            }
            else{
                $sparepart->image=NULL;
            }

            $sparepart->sparepart_name=$request->get('sparepart_name');
            $sparepart->merk=$request->get('merk');
            $sparepart->stock=$request->get('stock');
            $sparepart->min_stock=$request->get('min_stock');
            $sparepart->purchase_price=$request->get('purchase_price');
            $sparepart->sell_price=$request->get('sell_price');
            $sparepart->placement=$request->get('placement');
            $sparepart->id_sparepart_type=$request->get('id_sparepart_type');
            $sparepart->save();

            $response = $this->generateItem($sparepart);

            return $this->sendResponse($response, 201);

        }catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('sparepart_not_found');
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
            $sparepart=Sparepart::find($id);
            $sparepart->delete();
            return response()->json('Success',200);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('sparepart_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
