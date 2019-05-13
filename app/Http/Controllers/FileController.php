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
    
            return $pdf->download('REPORTPERMONTH_' . $date . '.pdf'  );
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
