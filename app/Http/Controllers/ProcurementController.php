<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Procurement;
use App\Procurement_detail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Transformers\ProcurementTransformer;
use App\Transformers\Procurement_detailTransformer;

class ProcurementController extends RestController
{
    protected $transformer = ProcurementTransformer::class;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $procurement = Procurement::all();
        $response = $this->generateCollection($procurement);
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

            date_default_timezone_set('Asia/Jakarta');

            $detail = $request->get('detail');

            $procurement = new Procurement;

            $procurement->date=$request->get('date').' '.date('H:i:s');
            $procurement->procurement_status=$request->get('procurement_status');
            $procurement->id_sales=$request->get('id_sales');
            $procurement->save();

            if($request->has('detail'))
            {
                $procurement = DB::transaction(function () use ($procurement,$detail) {
                    $procurement->procurementdetails()->createMany($detail);
                    return $procurement;
                });
            }
            
            $response = $this->generateItem($procurement);

            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function storeDetail(Request $request)
    {
        try {


            $detail = new Procurement_detail;

            $detail->id_procurement=$request->get('id_procurement');
            $detail->price=$request->get('price');
            $detail->amount=$request->get('amount');
            $detail->subtotal=$request->get('subtotal');
            $detail->id_sparepart=$request->get('id_sparepart');
            $detail->save();

            $response = $this->generateItem($detail, Procurement_detailTransformer::class);

            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function updateDetail(Request $request,$id)
    {
        try {


            $detail = Procurement_detail::find($id);

            $detail->price=$request->get('price');
            $detail->amount=$request->get('amount');
            $detail->subtotal=$request->get('subtotal');
            $detail->save();

            $response = $this->generateItem($detail, Procurement_detailTransformer::class);

            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function showdetail($id)
    {
        try {
            $detail=Procurement_detail::where("id_procurement",$id)->get();
            $response = $this->generateCollection($detail,Procurement_detailTransformer::class);
            return $this->sendResponse($response);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('procurement_detail_not_found');
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
            $procurement=Procurement::find($id);
            $response = $this->generateItem($procurement);
            return $this->sendResponse($response);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('procurement_not_found');
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
        // $this->validate($request,[
        //     'sales_name' => 'required',
        //     'id_supplier' => 'required',
        //     'sales_phone_number' => 'required',
        // ]);   
        
        try {
            date_default_timezone_set('Asia/Jakarta');

            $detail = $request->get('detail');
            
            $procurement=Procurement::find($id);

            $procurement->procurementdetails()->delete();

            $procurement->date=$request->get('date').' '.date('H:i:s');
            $procurement->procurement_status=$request->get('procurement_status');
            $procurement->id_sales=$request->get('id_sales');
            $procurement->save();

            if($request->has('detail'))
            {
                $procurement = DB::transaction(function () use ($procurement,$detail) {
                    $procurement->procurementdetails()->createMany($detail);
                    return $procurement;
                });
            }

            $response = $this->generateItem($procurement);

            return $this->sendResponse($response, 201);

        }catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('procurement_not_found');
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
            $procurement=Procurement::find($id);
            $procurement->delete();
            return response()->json('Success',200);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('Procurement_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
