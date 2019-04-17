<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Sparepart;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
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

                $motorcyle_types = explode(",",trim($request->motorcycleTypes));

                $sparepart->id_sparepart=$request->get('id_sparepart');
                $sparepart->sparepart_name=$request->get('sparepart_name');
                $sparepart->merk=$request->get('merk');
                $sparepart->stock=$request->get('stock');
                $sparepart->min_stock=$request->get('min_stock');
                $sparepart->purchase_price=$request->get('purchase_price');
                $sparepart->sell_price=$request->get('sell_price');
                $sparepart->placement=$request->get('placement');
                $sparepart->id_sparepart_type=$request->get('id_sparepart_type');
                $sparepart->save();

                if($request->has('motorcycleTypes'))
                {
                    $sparepart = DB::transaction(function () use ($sparepart,$motorcyle_types) {
                        $sparepart->motorcycleTypes()->sync($motorcyle_types);
                        return $sparepart;
                    });
                }
                

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

        try {

            $sparepart=Sparepart::find($id);


            if($request->hasfile('image'))
            {
                // File::delete(public_path().'/images/'.$sparepart->image);
                $file = $request->file('image');
                $name=time().$file->getClientOriginalName();
                $file->move(public_path().'/images/', $name);
                $sparepart->image=$name;
            }

            $motorcyle_types = explode(",",trim($request->motorcycleTypes));

            $sparepart->sparepart_name=$request->get('sparepart_name');
            $sparepart->merk=$request->get('merk');
            $sparepart->stock=$request->get('stock');
            $sparepart->min_stock=$request->get('min_stock');
            $sparepart->purchase_price=$request->get('purchase_price');
            $sparepart->sell_price=$request->get('sell_price');
            $sparepart->placement=$request->get('placement');
            $sparepart->id_sparepart_type=$request->get('id_sparepart_type');
            $sparepart->save();

            if($request->has('motorcycleTypes'))
            {
                $sparepart = DB::transaction(function () use ($sparepart,$motorcyle_types) {
                    $sparepart->motorcycleTypes()->sync($motorcyle_types);
                    return $sparepart;
                });
            }

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
            // File::delete(public_path().'/images/'.$sparepart->image);
            $sparepart->delete();
            return response()->json('Success',200);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('sparepart_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function updateSparepart(Request $request, $id)
    {
        try {

            $sparepart=Sparepart::find($id);

            $motorcyle_types = explode(",",trim($request->motorcycleTypes));

            if($request->hasfile('image'))
            {
                // File::delete(public_path().'/images/'.$sparepart->image);
                $file = $request->file('image');
                $name=time().$file->getClientOriginalName();
                $file->move(public_path().'/images/', $name);
                $sparepart->image=$name;
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

            if($request->has('motorcycleTypes'))
            {
                $sparepart = DB::transaction(function () use ($sparepart,$motorcyle_types) {
                    $sparepart->motorcycleTypes()->sync($motorcyle_types);
                    return $sparepart;
                });
            }

            $response = $this->generateItem($sparepart);

            return $this->sendResponse($response, 201);

        }catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('sparepart_not_found');
        }
        catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function sparepartVerification(Request $request)
    {
        try {
            $spareparts = $request->get('spareparts');
            foreach($spareparts as $sparepart)
            {
                $data=Sparepart::find($sparepart['id_sparepart']);
                $data->stock = $data->stock + $sparepart['amount'];
                $data->purchase_price = $sparepart['price'];
                $data->sell_price = $sparepart['sell_price'];
                $data->save();
                //DB::table('spareparts')->where('id_sparepart',$sparepart->id_sparepart)->increment('stock',$sparepart->stock)->update('purchase_price',$sparepart->purchase_price);
            }
            return response()->json('Success',200);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('sparepart_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
