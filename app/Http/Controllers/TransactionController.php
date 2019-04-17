<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaction;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Transformers\TransactionTransformer;

class TransactionController extends RestController
{
    protected $transformer = TransactionTransformer::class;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::all();
        $response = $this->generateCollection($transactions);
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

            $service = $request->get('service');
            $sparepart = $request->get('sparepart');

            $transaction = new Transaction;
            $count = Transaction::get()
            ->count()
            + 1;

            if($request->get('transaction_type')=='Service')
            {
                $transaction->id_transaction='SV'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            else if($request->get('transaction_type')=='Sparepart')
            {
                $transaction->id_transaction='SP'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            else if($request->get('transaction_type')=='Service And Sparepart')
            {
                $transaction->id_transaction='SS'.'-'.date("d").date("m").date("y").'-'.$count;
            }
            $transaction->transaction_date=date("Y-m-d").' '.date('H:i:s');
            $transaction->transaction_status=$request->get('transaction_status');
            $transaction->transaction_paid="unpaid";
            $transaction->transaction_type=$request->get('transaction_type');
            $transaction->transaction_discount=0;
            $transaction->transaction_total=$request->get('transaction_total');
            $transaction->id_customer=$request->get('id_customer');
            $transaction->save();

            $transaction = DB::transaction(function () use ($transaction,$service) {
                $transaction->detail_services()->createMany($service);
                return $transaction;
            });

            $transaction = DB::transaction(function () use ($transaction,$sparepart) {
                $transaction->detail_spareparts()->createMany($sparepart);
                return $transaction;
            });

            $response = $this->generateItem($transaction);

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
            $transaction=Transaction::find($id);
            $response = $this->generateItem($transaction);
            return $this->sendResponse($response);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('$transaction_not_found');
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

            date_default_timezone_set('Asia/Jakarta');

            $service = $request->get('service');
            $sparepart = $request->get('sparepart');

            $transaction = Transaction::find($id);

            $transaction->detail_services()->delete();
            $transaction->detail_spareparts()->delete();

            if($request->get('transaction_type')!=$transaction->transaction_type)
            {
                $count = Transaction::get()
                ->count();
    
                if($request->get('transaction_type')=='Service')
                {
                    $transaction->id_transaction='SV'.'-'.date("d").date("m").date("y").'-'.$count;
                }
                else if($request->get('transaction_type')=='Sparepart')
                {
                    $transaction->id_transaction='SP'.'-'.date("d").date("m").date("y").'-'.$count;
                }
                else if($request->get('transaction_type')=='Service And Sparepart')
                {
                    $transaction->id_transaction='SS'.'-'.date("d").date("m").date("y").'-'.$count;
                }
            }         
            // $transaction->transaction_date=date("Y-m-d").' '.date('H:i:s');
            $transaction->transaction_status=$request->get('transaction_status');
            $transaction->transaction_paid="unpaid";
            $transaction->transaction_type=$request->get('transaction_type');
            $transaction->transaction_discount=0;
            $transaction->transaction_total=$request->get('transaction_total');
            $transaction->id_customer=$request->get('id_customer');
            $transaction->save();

            $transaction = DB::transaction(function () use ($transaction,$service) {
                $transaction->detail_services()->createMany($service);
                return $transaction;
            });

            $transaction = DB::transaction(function () use ($transaction,$sparepart) {
                $transaction->detail_spareparts()->createMany($sparepart);
                return $transaction;
            });

            $response = $this->generateItem($transaction);

            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
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
            $transaction=Transaction::find($id);
            $transaction->delete();
            return response()->json('Success',200);
        } catch (ModelNotFoundException $e) {
            return $this->sendNotFoundResponse('Transaction_not_found');
        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }
}
