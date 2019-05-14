<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Transaction;
use App\Procurement;

class ReportController extends Controller
{
    public function TransactionperYear($year)
    {
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

        return response()->json($report, 200, [], JSON_NUMERIC_CHECK);
    }

    public function ExpenseperYear($year)
    {
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
        return response()->json($report, 200, [], JSON_NUMERIC_CHECK);
    }

    public function TransactionbyBranch()
    {
        $report = DB::select("SELECT YEAR(c.transaction_date) AS Tahun, d.branch_name AS Cabang, SUM(c.transaction_total) AS Total FROM employee_onduties a join employees b on b.id_employee=a.id_employee JOIN transactions c on c.id_transaction=a.id_transaction
        join branches d on d.id_branch=b.id_branch
        WHERE b.id_role = 1 or b.id_role = 2
        GROUP BY YEAR(c.transaction_date),d.branch_name");
        // return ($report);
        return response()->json($report, 200, [], JSON_NUMERIC_CHECK);
    }

    public function BestSellerSparepart()
    {
        $report = DB::select("SELECT MONTHNAME(STR_TO_DATE((m.bulan), '%m')) as Bulan, Coalesce((select s.sparepart_name from detail_spareparts t inner join spareparts s on t.id_sparepart = s.id_sparepart where MONTHNAME(t.created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) group by t.id_sparepart order by sum(t.detail_sparepart_amount) DESC LIMIT 1),'-') AS NamaBarang, Coalesce((select tp.sparepart_type_name from detail_spareparts t inner join spareparts s on t.id_sparepart = s.id_sparepart inner join sparepart_types tp on s.id_sparepart_type = tp.id_sparepart_type where MONTHNAME(t.created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) group by t.id_sparepart order by sum(t.detail_sparepart_amount) DESC LIMIT 1),'-') AS TipeBarang, Coalesce((select sum(detail_sparepart_amount) from detail_spareparts where MONTHNAME(created_at) = MONTHNAME(STR_TO_DATE((m.bulan), '%m')) group by id_sparepart order by sum(detail_sparepart_amount) DESC LIMIT 1),'-') AS JumlahPenjualan
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
        return response()->json($report, 200, [], JSON_NUMERIC_CHECK);
    }

    public function ServiceSelling($year,$month)
    {
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
        return response()->json($report, 200, [], JSON_NUMERIC_CHECK);
    }
}
