<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\Sparepart;
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
            $employee = $request->get('employee');

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

            $transaction = DB::transaction(function () use ($transaction,$employee) {
                $transaction->employees()->attach($employee);
                return $transaction;
            });

            $transaction = DB::transaction(function () use ($transaction,$service) {
                $transaction->detail_services()->createMany($service);
                return $transaction;
            });

            $transaction = DB::transaction(function () use ($transaction,$sparepart) {
                $transaction->detail_spareparts()->createMany($sparepart);
                return $transaction;
            });

            foreach($sparepart as $value)
            {
                $data = Sparepart::find($value['id_sparepart']);
                $data->stock = $data->stock - $value['detail_sparepart_amount'];
                $data->save();
                if($data->stock<$data->min_stock)
                {
                    $token=['cBy9I4NDXro:APA91bF0sDMutZo5aQo4VY9hMfmoOvY3mUjSXWwdZaGsKNVRgOtWRgVyBGX-SIAWRdbFLnURZQ-boB9_p3MaN03DUxKyyN-helrFnDgig_UdH2ffIGWCNSTsvdQ_FAbu42B-iPbzkvaK','fzQS5wVJYt4:APA91bG8Ldrp_8ksxZyC446z1TkPkux5_a8bpRkAwIDhEh7exYw6n4WoYUesq9EAKoUWG6FS5xHp1DxoVBU2andL1elkCqB4IpmTLIAYGVkOUEAMAGOR1XJ9DH6HoR6-A72K3O0rFLrd','cpb9nmgdPwg:APA91bFB2HkGGRhaPmzhkrAq7g2TjFsrYvTJ_S6DrjVhLGWaG7sy2S8nqIMi5JfAkX96Er-WvXdMbhrycSbRY4L49P_BUDW32nrzDJinUMW-UgfZqTEi8OfeQOnUBqv869Hdf_Yw-ybd','evv7Xzo4w_Y:APA91bEz8LNHRLzG4hqOY5ExDoF_50uy9dQdnCpt3bCGf-LezeUgGtzLXzLCx2wrTSfuRV6hSKr7tDEz8pYg0uZwHSG6JLWPrkzkKBWbSxsLAkT6Kp4R-1fRsRAyXkgYg6q81LwhPgxa'];

                    // $notification = [
                    //     'body' => 'this is test',
                    //     'sound' => true,
                    // ];
                    
                    $data = array('title' => $data->sparepart_name ,'body' => 'kurang dari jumlah stock minimal');
                    $fcmNotification = [
                        'registration_ids' => $token, 
                        // 'to'        => $token, //single token
                        'priority' => "high",
                        'notification' => $data,
                    ];
                
                    
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $server_key = "AAAA49vwxPw:APA91bGsqHe9cRCcMcU2X47Tao1GWIDbA029PnPxgXaSL5wEvia2mJJiuINEV0dt-Wy9e2Jls8OV3T87h6SsH70DmitZg8J0f3aeENRCuoLDIWH58o9lXNKNc_4wSZ35Ya8cXwiNq0jX";

                    $headers = [
                        'Authorization: key='.$server_key,
                        'Content-Type: application/json'
                    ];


                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                    $result = curl_exec($ch);
                    if ($result === FALSE) {
                        return curl_error($ch);
                    }
                    curl_close($ch);
                }
            }


            // return $result;

            $response = $this->generateItem($transaction);

            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function notification($token, $title)
    {

        $token=$token;

        // $notification = [
        //     'title' => $title,
        //     'sound' => true,
        // ];
        
        // $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];

        // $fcmNotification = [
        //     //'registration_ids' => $tokenList, //multple token array
        //     'to'        => $token, //single token
        //     'notification' => $notification,
        //     'data' => $extraNotificationData
        // ];

        $res = array();
        $res['body'] = $title;

        $fields = array(
            'to' => $token,
            'notification' => $res,
        );
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        $server_key = "AIzaSyCSJo9-q8CzX6QTqXgbuAnJAixFl-XKbrQ";

        $headers = [
            'Authorization: key='.$server_key,
            'Content-Type: application/json'
        ];


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            echo 'Curl failed: ' . curl_error($ch);
        }
        curl_close($ch);
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

            $t= Transaction::with('detail_spareparts')->get();

            foreach($t as $value )
            {
                if($value->id_transaction==$id)
                {
                    $sparepart2=$value->detail_spareparts;
                }
            }
            // $sparepart2 = $t->detail_spareparts;

            foreach($sparepart2 as $value)
            {
                $data = Sparepart::find($value->id_sparepart);
                $data->stock = $data->stock + $value->detail_sparepart_amount;
                $data->save();
            }

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

            foreach($sparepart as $value)
            {
                $data = Sparepart::find($value['id_sparepart']);
                $data->stock = $data->stock - $value['detail_sparepart_amount'];
                $data->save();
                if($data->stock<$data->min_stock)
                {
                    $token=['cBy9I4NDXro:APA91bF0sDMutZo5aQo4VY9hMfmoOvY3mUjSXWwdZaGsKNVRgOtWRgVyBGX-SIAWRdbFLnURZQ-boB9_p3MaN03DUxKyyN-helrFnDgig_UdH2ffIGWCNSTsvdQ_FAbu42B-iPbzkvaK','fzQS5wVJYt4:APA91bG8Ldrp_8ksxZyC446z1TkPkux5_a8bpRkAwIDhEh7exYw6n4WoYUesq9EAKoUWG6FS5xHp1DxoVBU2andL1elkCqB4IpmTLIAYGVkOUEAMAGOR1XJ9DH6HoR6-A72K3O0rFLrd','cpb9nmgdPwg:APA91bFB2HkGGRhaPmzhkrAq7g2TjFsrYvTJ_S6DrjVhLGWaG7sy2S8nqIMi5JfAkX96Er-WvXdMbhrycSbRY4L49P_BUDW32nrzDJinUMW-UgfZqTEi8OfeQOnUBqv869Hdf_Yw-ybd','evv7Xzo4w_Y:APA91bEz8LNHRLzG4hqOY5ExDoF_50uy9dQdnCpt3bCGf-LezeUgGtzLXzLCx2wrTSfuRV6hSKr7tDEz8pYg0uZwHSG6JLWPrkzkKBWbSxsLAkT6Kp4R-1fRsRAyXkgYg6q81LwhPgxa'];

                    // $notification = [
                    //     'body' => 'this is test',
                    //     'sound' => true,
                    // ];
                    
                    $data = array('title' => $data->sparepart_name ,'body' => 'kurang dari jumlah stock minimal');
                    $fcmNotification = [
                        'registration_ids' => $token, 
                        // 'to'        => $token, //single token
                        'priority' => "high",
                        'notification' => $data,
                    ];
                
                    
                    $url = 'https://fcm.googleapis.com/fcm/send';
                    $server_key = "AAAA49vwxPw:APA91bGsqHe9cRCcMcU2X47Tao1GWIDbA029PnPxgXaSL5wEvia2mJJiuINEV0dt-Wy9e2Jls8OV3T87h6SsH70DmitZg8J0f3aeENRCuoLDIWH58o9lXNKNc_4wSZ35Ya8cXwiNq0jX";

                    $headers = [
                        'Authorization: key='.$server_key,
                        'Content-Type: application/json'
                    ];


                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,$url);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
                    $result = curl_exec($ch);
                    if ($result === FALSE) {
                        return curl_error($ch);
                    }
                    curl_close($ch);
                }
            }

            $response = $this->generateItem($transaction);

            return $this->sendResponse($response, 201);

        } catch (\Exception $e) {
            return $this->sendIseResponse($e->getMessage());
        }
    }

    public function payment(Request $request, $id)
    {
        try {


            $transaction = Transaction::find($id);

            $transaction->transaction_paid="paid";
            $transaction->transaction_discount=$request->get('discount');;
            $transaction->transaction_total=$request->get('transaction_total');
            $transaction->save();

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
