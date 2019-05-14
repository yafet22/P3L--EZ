<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\Procurement;
use Carbon\Carbon;

class FileController extends Controller
{
    public function generateProcurementDocs($id)
    {
        try {
            $procurement = Procurement::find($id);
            // echo $procurement->date;
            $word = explode(' ',trim($procurement->date));
            $date = $word[0];
            $no = 1;
            $pdf = PDF::loadView('pdf.procurement', compact('procurement', 'no', 'date'))->setPaper('a4', 'portrait');
    
            return $pdf->download('PROC_' . $date . '.pdf'  );
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Generate receipt of Transaction
     *
     * @param string $id
     * @return void
     */
    public function generateWorkOrderDocs($id)
    {
        try {
            $transaction = Transaction::find($id);
            $pdf = PDF::loadView('pdf.workOrder', compact('transaction'))->setPaper('a4', 'portrait');

            return $pdf->download($transaction->transaction_code . '.pdf');
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function generateTransactionPerMonth($year)
    {
        try {
            $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) AS Bulan, COALESCE(SUM(d.detail_sparepart_subtotal),0) AS Sparepart,COALESCE(SUM(e.detail_service_subtotal),0) AS Service,COALESCE(SUM(d.detail_sparepart_subtotal),0)+COALESCE(SUM(e.detail_service_subtotal),0)  AS Total FROM (SELECT '01' AS
            bulan
            UNION SELECT '02' AS
            bulan
            UNION SELECT '03' AS
            bulan
            UNION SELECT '04' AS
            bulan
            UNION SELECT '05' AS
            bulan
            UNION SELECT '06' AS
            bulan
            UNION SELECT '07'AS
            bulan
            UNION SELECT '08'AS
            bulan
            UNION SELECT '09' AS
            bulan
            UNION SELECT '10' AS
            bulan
            UNION SELECT '11' AS
            bulan
            UNION SELECT '12' AS
            bulan
            )AS m LEFT JOIN (SELECT * FROM transactions WHERE YEAR(transaction_date)=$year AND transaction_paid='paid') p ON MONTHNAME(p.transaction_date) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) LEFT JOIN detail_spareparts d ON p.id_transaction=d.id_transaction
            LEFT JOIN detail_services e ON p.id_transaction=e.id_transaction

            GROUP BY YEAR(p.transaction_date),m.bulan
            ORDER by m.bulan");

            // echo $procurement->date;
            $date = Carbon::now();
            $no = 1;
            $pdf = PDF::loadView('pdf.reportPerMonth', compact('report', 'no', 'date', 'year'))->setPaper('a4', 'portrait');

            // return $pdf->stream();
    
            return $pdf->download('REPORTPERMONTH_' . $date . '.pdf'  );
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function generateSparepartBestSeller()
    {
        try {
            $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) as Bulan,(select s.sparepart_name from detail_spareparts t inner join spareparts s on t.id_sparepart = s.id_sparepart where MONTHNAME(t.created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) group by t.id_sparepart order by sum(t.detail_sparepart_amount) DESC LIMIT 1)AS NamaBarang, (select tp.sparepart_type_name from detail_spareparts t inner join spareparts s on t.id_sparepart = s.id_sparepart inner join sparepart_types tp on s.id_sparepart_type = tp.id_sparepart_type where MONTHNAME(t.created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) group by t.id_sparepart order by sum(t.detail_sparepart_amount) DESC LIMIT 1) AS TipeBarang, (select sum(detail_sparepart_amount) from detail_spareparts where MONTHNAME(created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) group by id_sparepart order by sum(detail_sparepart_amount) DESC LIMIT 1) AS JumlahPenjualan
            FROM(
                SELECT '01' AS
                bulan
                UNION SELECT '02' AS
                bulan
                UNION SELECT '03' AS
                bulan
                UNION SELECT '04' AS
                bulan
                UNION SELECT '05' AS
                bulan
                UNION SELECT '06' AS
                bulan
                UNION SELECT '07'AS
                bulan
                UNION SELECT '08'AS
                bulan
                UNION SELECT '09' AS
                bulan
                UNION SELECT '10' AS
                bulan
                UNION SELECT '11' AS
                bulan
                UNION SELECT '12' AS
                bulan
            ) AS m");

            // echo $procurement->date;
            $date = Carbon::now();
            $no = 1;
            $year = 2019;
            $pdf = PDF::loadView('pdf.sparepartBestSeller', compact('report', 'no', 'date', 'year'))->setPaper('a4', 'portrait');

            // return $pdf->stream();
    
            return $pdf->download('SPAREPARTBESTSELLER_' . $date . '.pdf'  );
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function generateServiceSelling($year,$month)
    {
        try {
            $report = DB::select("SELECT motorcycle_brands.motorcycle_brand_name, motorcycle_types.motorcycle_type_name, services.service_name, sum(detail_services.detail_service_amount)as jumlah_jasa
            FROM detail_services
            LEFT JOIN motorcycles on detail_services.id_motorcycle = motorcycles.id_motorcycle
            JOIN motorcycle_types ON motorcycles.id_motorcycle_type = motorcycle_types.id_motorcycle_type
            JOIN motorcycle_brands ON motorcycle_types.id_motorcycle_brand = motorcycle_brands.id_motorcycle_brand
            LEFT JOIN services ON detail_services.id_service = services.id_service
            LEFT JOIN transactions ON detail_services.id_transaction = transactions.id_transaction
            WHERE YEAR(transactions.transaction_date) = $year
            AND Month(transactions.transaction_date) = $month
            AND transactions.transaction_paid = 'paid'
            GROUP BY detail_services.id_service, motorcycles.id_motorcycle
            ORDER BY motorcycles.id_motorcycle");

            $date = Carbon::now();
            $no = 1;
            $monthName = date("F", mktime(0, 0, 0, $month, 1));
            $pdf = PDF::loadView('pdf.serviceSelling', compact('report', 'no', 'date', 'year','monthName'))->setPaper('a4', 'portrait');

         
    
            return $pdf->download('SERVICESELLING_' . $date . '.pdf'  );
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function showProcurement($id)
    {
        $procurement = Procurement::find($id);
        $no = 1;

        return view('pdf.procurement', compact('procurement', 'no'));
    }

    public function showWorkOrder($id)
    {
        $transaction = Transaction::find($id);

        return view('pdf.workOrder', compact('transaction'));
    }
}
