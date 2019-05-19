<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\Sparepart_type;
use App\Procurement;
use Carbon\Carbon;

// require '/path/to/your/vendor/autoload.php';

use CpChart\Chart\Pie;
use CpChart\Data;
use CpChart\Image;

class FileController extends Controller
{
    public function generateProcurementDocs($id)
    {
        date_default_timezone_set('Asia/Jakarta');
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

    public function generateReceipt($id)
    {
        date_default_timezone_set('Asia/Jakarta');
        try {
            $transaction = Transaction::find($id);
            $date = Carbon::now();

            $service_details = $transaction->detail_services
                ->map(function ($item) {
                    return $item;
            });

            $sparepart_details = $transaction->detail_spareparts
                ->map(function ($item){
                    return $item;
            });

            $mechanics=[];
            $servicemotorcycles=[];
            $sparepartmotorcycles=[];
            $temp = 0;

            foreach($service_details as $detail)
            {
                if($mechanics!=NULL)
                {
                    foreach($mechanics as $mechanic)
                    {
                        if($mechanic!=$detail->mechanics->name)
                        {
                            $temp = 1;
                        }
                        else{
                            $temp = 0;
                        }
                        
                    }
                    if($temp==1)
                    {
                        array_push($mechanics,$detail->mechanics->name);
                    }
                }
                else{
                    array_push($mechanics,$detail->mechanics->name);
                }
            }

            foreach($sparepart_details as $detail)
            {
                if($detail->id_employee!=NULL)
                {
                    if($mechanics!=NULL)
                    {
                        foreach($mechanics as $mechanic)
                        {
                            if($mechanic!=$detail->mechanics->name)
                            {
                                $temp = 1;
                            }
                            else{
                                $temp = 0;
                            }
                        }
                        if($temp==1)
                        {
                            array_push($mechanics,$detail->mechanics->name);
                        }
                    }
                    else{
                        array_push($mechanics,$detail->mechanics->name);
                    }
                }
            }

            foreach($service_details as $detail)
            {
                if($servicemotorcycles!=NULL)
                {
                    foreach($servicemotorcycles as $motorcycle)
                    {
                        if($motorcycle!=$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number)
                        {
                            $temp = 1;
                        } 
                        else{
                            $temp = 0;
                        }
                    }
                    if($temp==1)
                    {
                        array_push($servicemotorcycles,$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number);
                    }
                }
                else{
                    array_push($servicemotorcycles,$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number);
                }
            }

            foreach($sparepart_details as $detail)
            {
                if($detail->id_motorcycle!=NULL)
                {
                    if($sparepartmotorcycles!=NULL)
                    {
                        foreach($sparepartmotorcycles as $motorcycle)
                        {
                            if($motorcycle!=$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number)
                            {
                                $temp = 1;
                            } 
                            else{
                                $temp = 0;
                            }
                        }
                        if($temp==1)
                        {
                            array_push($sparepartmotorcycles,$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number);
                        }
                    }
                    else{
                        array_push($sparepartmotorcycles,$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number);
                    }
                }
            }

            // return view('pdf.receipt',compact('transaction','mechanics','servicemotorcycles','sparepartmotorcycles','date'));
            $pdf = PDF::loadView('pdf.receipt', compact('transaction','mechanics','servicemotorcycles','sparepartmotorcycles','date'))->setPaper('a4', 'portrait');

            return $pdf->download('RECEIPT_' . $transaction->id_transaction . '.pdf');
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
        date_default_timezone_set('Asia/Jakarta');
        try {
            $transaction = Transaction::find($id);
            $date = Carbon::now();

            $service_details = $transaction->detail_services
                ->map(function ($item) {
                    return $item;
            });

            $sparepart_details = $transaction->detail_spareparts
                ->map(function ($item){
                    return $item;
            });

            $mechanics=[];
            $motorcycles=[];
            $temp = 0;

            foreach($service_details as $detail)
            {
                if($mechanics!=NULL)
                {
                    foreach($mechanics as $mechanic)
                    {
                        if($mechanic!=$detail->mechanics->name)
                        {
                            $temp = 1;
                        }
                        else{
                            $temp = 0;
                        }
                        
                    }
                    if($temp==1)
                    {
                        array_push($mechanics,$detail->mechanics->name);
                    }
                }
                else{
                    array_push($mechanics,$detail->mechanics->name);
                }
            }

            foreach($sparepart_details as $detail)
            {
                if($detail->id_employee!=NULL)
                {
                    if($mechanics!=NULL)
                    {
                        foreach($mechanics as $mechanic)
                        {
                            if($mechanic!=$detail->mechanics->name)
                            {
                                $temp = 1;
                            }
                            else{
                                $temp = 0;
                            }
                        }
                        if($temp==1)
                        {
                            array_push($mechanics,$detail->mechanics->name);
                        }
                    }
                    else{
                        array_push($mechanics,$detail->mechanics->name);
                    }
                }
            }

            foreach($service_details as $detail)
            {
                if($motorcycles!=NULL)
                {
                    foreach($motorcycles as $motorcycle)
                    {
                        if($motorcycle!=$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number)
                        {
                            $temp = 1;
                        } 
                        else{
                            $temp = 0;
                        }   
                        
                    }
                    if($temp == 1)
                    {
                        array_push($motorcycles,$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number);
                    }
                }
                else{
                    array_push($motorcycles,$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number);
                }
            }

            foreach($sparepart_details as $detail)
            {
                if($detail->id_motorcycle!=NULL)
                {
                    if($motorcycles!=NULL)
                    {
                        foreach($motorcycles as $motorcycle)
                        {
                            if($motorcycle!=$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number)
                            {
                                $temp = 1;
                            } 
                            else{
                                $temp = 0;
                            }
                        }
                        if($temp == 1)
                        {
                            array_push($motorcycles,$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number);
                        }
                    }
                    else{
                        array_push($motorcycles,$detail->motorcycles->motorcycle_types->motorcycle_brands->motorcycle_brand_name.' '.$detail->motorcycles->motorcycle_types->motorcycle_type_name.' '.$detail->motorcycles->license_number);
                    }
                }
            }

            // return view('pdf.workOrder',compact('transaction','date'));
            $pdf = PDF::loadView('pdf.workOrder', compact('transaction','mechanics','motorcycles','date'))->setPaper('a4', 'portrait');

            return $pdf->download($transaction->id_transaction . '.pdf');
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function generateTransactionPerMonth($year)
    {
        date_default_timezone_set('Asia/Jakarta');
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

    public function generateExpenseReport($year)
    {
        date_default_timezone_set('Asia/Jakarta');
        try {
            $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) AS Bulan,  COALESCE(SUM(d.subtotal),0) AS Total FROM (SELECT '01' AS
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
            )AS m LEFT JOIN (SELECT * FROM procurements WHERE YEAR(date)=$year)as p ON MONTHNAME(p.date) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) LEFT JOIN
            procurement_details d ON d.id_procurement = p.id_procurement
          
            GROUP BY YEAR(p.date),m.bulan
            ORDER by m.bulan");

            // echo $procurement->date;
            $date = Carbon::now();
            $no = 1;
            $pdf = PDF::loadView('pdf.expense', compact('report', 'no', 'date', 'year'))->setPaper('a4', 'portrait');

            // return $pdf->stream();
    
            return $pdf->download('EXPENSEPERMONTH_' . $date . '.pdf'  );
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function generateSparepartBestSeller()
    {
        date_default_timezone_set('Asia/Jakarta');
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
        date_default_timezone_set('Asia/Jakarta');
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

    public function generateRemainingStock($year,$sparepart)
    {
        date_default_timezone_set('Asia/Jakarta');
        try {
            $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) as 'Bulan', COALESCE((select (
                (select stock + (select sum(detail_sparepart_amount) from detail_spareparts join spareparts on detail_spareparts.id_sparepart=spareparts.id_sparepart
                where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(YEAR FROM detail_spareparts.created_at) = $year)
                 - (select sum(amount) from procurement_details join spareparts on procurement_details.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(YEAR FROM procurement_details.created_at) = $year) from spareparts where id_sparepart_type = '$sparepart')
                 - (select sum(detail_sparepart_amount) from detail_spareparts join spareparts on detail_spareparts.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(Month FROM detail_spareparts.created_at) = bulan) 
                + (select sum(amount) from procurement_details join spareparts on procurement_details.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '$sparepart' and EXTRACT(Month FROM procurement_details.created_at) = bulan))  AS 'Jumlah Sparepart Sisa' 
                from spareparts where id_sparepart_type = '$sparepart'),'0') AS 'JumlahStokSisa'
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
            $type= Sparepart_type::find($sparepart)->first();
            $type = $type->sparepart_type_name;
            // echo $procurement->date;
            $date = Carbon::now();
            $no = 1;
            $pdf = PDF::loadView('pdf.remainingStock', compact('report', 'no', 'date', 'year', 'type'))->setPaper('a4', 'portrait');

            // return $pdf->stream();
    
            return $pdf->download('REMAININGSTOCK_' . $date . '.pdf'  );
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), $e->getCode());
        }
    }

    public function generateTransactionPerYear()
    {
        date_default_timezone_set('Asia/Jakarta');
        try {
            $report = DB::select("SELECT YEAR(c.transaction_date) AS Tahun, d.branch_name AS Cabang, SUM(c.transaction_total) AS Total FROM employee_onduties a join employees b on b.id_employee=a.id_employee JOIN transactions c on c.id_transaction=a.id_transaction
            join branches d on d.id_branch=b.id_branch
            WHERE b.id_role = 1 or b.id_role = 2
            GROUP BY YEAR(c.transaction_date),d.branch_name");
            // echo $procurement->date;
            $date = Carbon::now();
            $no = 1;
            $pdf = PDF::loadView('pdf.reportPerYear', compact('report', 'no', 'date'))->setPaper('a4', 'portrait');

            // return $pdf->stream();
    
            return $pdf->download('TRANSACTIONPERYEAR_' . $date . '.pdf'  );
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

    public function chartRemainingStock()
    {
        $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) as 'Bulan', COALESCE((select (
            (select stock + (select sum(detail_sparepart_amount) from detail_spareparts join spareparts on detail_spareparts.id_sparepart=spareparts.id_sparepart
            where spareparts.id_sparepart_type = '3' and EXTRACT(YEAR FROM detail_spareparts.created_at) = 2019)
             - (select sum(amount) from procurement_details join spareparts on procurement_details.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '3' and EXTRACT(YEAR FROM procurement_details.created_at) = 2019) from spareparts where id_sparepart_type = '3')
             - (select sum(detail_sparepart_amount) from detail_spareparts join spareparts on detail_spareparts.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '3' and EXTRACT(Month FROM detail_spareparts.created_at) = bulan) 
            + (select sum(amount) from procurement_details join spareparts on procurement_details.id_sparepart=spareparts.id_sparepart where spareparts.id_sparepart_type = '3' and EXTRACT(Month FROM procurement_details.created_at) = bulan))  AS 'Jumlah Sparepart Sisa' 
            from spareparts where id_sparepart_type = '3'),'0') AS 'JumlahStokSisa'
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
        $dataset=[];
        $label=[];
        foreach($report as $detail)
        {
            array_push($dataset,$detail->JumlahStokSisa);
            array_push($label,$detail->Bulan);        
        }
        
        $data = new Data();
        $data->addPoints($dataset, "ScoreA");
        $data->setSerieDescription("ScoreA", "Application A");

        // Define the absissa serie
        $data->addPoints($label, "Labels");
        $data->setAbscissa("Labels");

        // Create the image
        $image = new Image(700, 230, $data);

        // Draw a solid background
        $backgroundSettings = [
            "R"     => 173,
            "G"     => 152,
            "B"     => 217,
            "Dash"  => 1,
            "DashR" => 193,
            "DashG" => 172,
            "DashB" => 237
        ];
        $image->drawFilledRectangle(0, 0, 700, 230, $backgroundSettings);

        //Draw a gradient overlay
        $gradientSettings = [
            "StartR" => 209,
            "StartG" => 150,
            "StartB" => 231,
            "EndR"   => 111,
            "EndG"   => 3,
            "EndB"   => 138,
            "Alpha"  => 50
        ];
        $image->drawGradientArea(0, 0, 700, 230, DIRECTION_VERTICAL, $gradientSettings);
        $image->drawGradientArea(0, 0, 700, 20, DIRECTION_VERTICAL, [
            "StartR" => 0,
            "StartG" => 0,
            "StartB" => 0,
            "EndR"   => 50,
            "EndG"   => 50,
            "EndB"   => 50,
            "Alpha"  => 100
        ]);

        // Add a border to the picture
        $image->drawRectangle(0, 0, 699, 229, ["R" => 0, "G" => 0, "B" => 0]);

        // Write the picture title
        $image->setFontProperties(["FontName" => "Silkscreen.ttf", "FontSize" => 6]);
        $image->drawText(10, 13, "pPie - Draw 2D pie charts", ["R" => 255, "G" => 255, "B" => 255]);

        // Set the default font properties
        $image->setFontProperties(["FontName" => "Forgotte.ttf", "FontSize" => 10, "R" => 80, "G" => 80, "B" => 80]);

        // Enable shadow computing
        $image->setShadow(true, ["X" => 2, "Y" => 2, "R" => 150, "G" => 150, "B" => 150, "Alpha" => 100]);
        $image->drawText(140, 200, "Single AA pass", ["R" => 0, "G" => 0, "B" => 0, "Align" => TEXT_ALIGN_TOPMIDDLE]);

        // Create and draw the chart
        $pieChart = new Pie($image, $data);
        $pieChart->draw2DPie(140, 125, ["SecondPass" => false]);
        $pieChart->draw2DPie(340, 125, ["DrawLabels" => true, "Border" => true]);
        $pieChart->draw2DPie(540, 125, [
            "DataGapAngle"  => 10,
            "DataGapRadius" => 6,
            "Border" => true,
            "BorderR" => 255,
            "BorderG" => 255,
            "BorderB" => 255
        ]);
        $image->drawText(540, 200, "Extended AA pass / Splitted", ["R" => 0, "G" => 0, "B" => 0, "Align" => TEXT_ALIGN_TOPMIDDLE]);

        $pieChart->pChartObject->autoOutput("example.draw2DPie.png");

      
    }
}
