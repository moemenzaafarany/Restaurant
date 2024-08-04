<?php 
include 'includes/conn.php';
    require 'fpdf/fpdf.php';

    $pdf = new FPDF('P','mm','A3');

    $pdf->Addpage();

    $pdf->SetFont('Arial','B',15);

    $pdf->Cell(59,5,'Purchases Invoice',0,0);
    $pdf->Cell(59,10,'',0,1);
    
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(15,10,'','',0);

    $pdf->Cell(35,6,'Date',1,0,'c');
    $pdf->Cell(75,6,'Name',1,0,'c');
    $pdf->Cell(35,6,'Item',1,0,'c');
    $pdf->Cell(35,6,'Price',1,0,'c');
    $pdf->Cell(35,6,'quantity',1,0,'c');
    $pdf->Cell(35,6,'Total',1,1,'c');
    $pdf->SetFont('Arial','',10);


        $sql = "SELECT order_list.order_id, users.DeviceName, items.item_name, order_list.qty, items.price, SUM(price * qty) AS total_revenue, order_list.date
                    FROM order_list
                    INNER JOIN users ON order_list.user_id = users.user_id
                    INNER JOIN items ON order_list.item_id = items.item_id
                    WHERE DATE(order_list.date) = DATE(NOW())
                    GROUP BY order_list.order_id
                    ORDER BY order_list.order_id DESC;";

        $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_array($result)) {
                $pdf->Cell(15,10,'','',0);
                $pdf->Cell(35,6, $row[6],1,0);
                $pdf->Cell(75,6, $row[1],1,0);
                $pdf->Cell(35,6, $row[2],1,0);
                $pdf->Cell(35,6, $row[4],1,0);
                $pdf->Cell(35,6, $row[3],1,0);
                $pdf->Cell(35,6, $row[5],1,1);
            }

            $sql = "SELECT SUM(price * qty) AS total_revenue
            FROM order_list
            INNER JOIN users ON order_list.user_id = users.user_id
            INNER JOIN items ON order_list.item_id = items.item_id
            WHERE DATE(order_list.date) = DATE(NOW())
            ORDER BY order_list.order_id DESC;";
            // $pdf->Cell(118,6, '',0,0);
            $result = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_array($result)) {
                $pdf->Cell(15,10,'','',0);
                $pdf->SetFont('Arial','B',12);
                $pdf->Cell(35,6,"subtotal",1,0);
                $pdf->Cell(215,6, $row[0] ,1,0,'C');
            }


    $pdf->Output();
?>