<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Invoice</title>
    <style>
        body { font-family: sans-serif; }
        .container { width: 100%; margin: 0 auto; }
        .header, .footer { text-align: center; }
        .header h1 { margin: 0; }
        .details { margin-top: 20px; border-collapse: collapse; width: 100%; }
        .details th, .details td { border: 1px solid #ddd; padding: 8px; }
        .details th { background-color: #f2f2f2; text-align: left; }
        .total-section { margin-top: 20px; float: right; width: 50%; }
        .total-section td { text-align: right; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Booking Invoice</h1>
            <p><strong>Porjotok Travel Agency</strong></p>
        </div>
        <hr>
        <p><strong>Billed To:</strong> {{customer_name}} ({{customer_email}})</p>
        <p><strong>Invoice ID:</strong> TMS-{{invoice_id}}</p>
        <p><strong>Date:</strong> {{invoice_date}}</p>
        
        <h3>Booking Details</h3>
        <table class="details">
            <tr><th>Package Name</th><td>{{package_name}}</td></tr>
            <tr><th>Trip Date</th><td>{{trip_date}}</td></tr>
            <tr><th>Number of People</th><td>{{num_people}}</td></tr>
        </table>

        <h3>Payment Summary</h3>
        <table class="details">
            <tr><th>Package Price (Per Person)</th><td style="text-align:right;">BDT {{package_price}}/-</td></tr>
            <tr><th>Total Package Cost</th><td style="text-align:right;">BDT {{total_cost}}/-</td></tr>
            <tr><th>Amount Paid</th><td style="text-align:right;">BDT {{paid_amount}}/-</td></tr>
            <tr><th style="background-color: #e8f5e9;">Balance Due</th><td style="text-align:right; font-weight:bold;">BDT {{balance_due}}/-</td></tr>
        </table>

        <div class="footer" style="margin-top: 40px;">
            <p>Thank you for booking with us!</p>
        </div>
    </div>
</body>
</html>