<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use App\Transaction;
use App\Procurement;

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
