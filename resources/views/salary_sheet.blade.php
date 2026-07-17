<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Sheet - {{$agency->name}} ({{$agency->code}})</title>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            background: linear-gradient(135deg, #66757a 0%, #2d3e45 100%);
            font-family: 'Inter', Arial, sans-serif;
            min-height: 100vh;
            padding: 30px 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: #e8edf0;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
            overflow: hidden;
            border: 1px solid #a0b3b8;
            padding: 30px;
        }
        
        /* Header Section */
        .salary-header {
            background: #2c3e50;
            color: #ecf0f1;
            padding: 25px 30px;
            border-radius: 16px;
            margin-bottom: 30px;
            border-bottom: 4px solid #95a5a6;
            box-shadow: 0 5px 15px rgba(44,62,80,0.3);
        }
        
        .salary-header h1 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 12px;
            letter-spacing: 1px;
            color: #ecf0f1;
        }
        
        .agency-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px dashed #4a6373;
        }
        
        .agency-badge {
            background: #405b6d;
            padding: 10px 20px;
            border-radius: 40px;
            font-weight: 500;
            color: #e0e7e9;
            border: 1px solid #6b8a9c;
        }
        
        .date-range {
            background: #34495e;
            padding: 10px 25px;
            border-radius: 30px;
            font-size: 16px;
            font-weight: 500;
            color: #bdd3dc;
            border: 1px solid #5d7e92;
        }
        
        /* Summary Cards */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background: #b0c7d2;
            padding: 20px 15px;
            border-radius: 16px;
            box-shadow: 0 8px 16px rgba(44,62,80,0.15);
            border: 1px solid #8aa7b3;
            transition: all 0.3s ease;
            text-align: center;
        }
        
        .card:hover {
            transform: translateY(-5px);
            background: #9fb9c5;
            box-shadow: 0 12px 20px rgba(44,62,80,0.25);
        }
        
        .card-label {
            color: #1e2f3a;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
        }
        
        .card-value {
            color: #1e2f3a;
            font-size: 28px;
            font-weight: 700;
            line-height: 1.2;
        }
        
        .card-sub {
            color: #334e5e;
            font-size: 13px;
            margin-top: 8px;
            font-weight: 500;
        }
        
        /* Status Bar */
        .status-bar {
            background: #d0dde5;
            border-radius: 50px;
            padding: 15px 25px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            border: 1px solid #a3bcc8;
            box-shadow: inset 0 2px 5px rgba(44,62,80,0.1);
        }
        
        .status-indicator {
            width: 16px;
            height: 16px;
            background: #f39c12;
            border-radius: 50%;
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.6; transform: scale(1.2); }
            100% { opacity: 1; transform: scale(1); }
        }
        
        .status-text {
            color: #2c3e50;
            font-weight: 600;
            font-size: 16px;
        }
        
        .status-badge {
            background: #00e508;
            color: #1e2b36;
            padding: 6px 18px;
            border-radius: 30px;
            font-weight: 700;
            font-size: 14px;
            border: 1px solid #b86d0e;
        }
        
        /* Table Section */
        .table-section {
            background: #d5e0e5;
            border-radius: 20px;
            padding: 25px;
            margin-bottom: 30px;
            border: 1px solid #9bb3bf;
            box-shadow: 0 5px 15px rgba(44,62,80,0.2);
        }
        
        .table-title {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #8aa7b3;
        }
        
        .table-title h2 {
            color: #1e2f3a;
            font-size: 24px;
            font-weight: 600;
        }
        
        .table-title span {
            background: #9bb3bf;
            padding: 8px 20px;
            border-radius: 30px;
            color: #1e2f3a;
            font-weight: 600;
            border: 1px solid #6d8c9b;
        }
        
        .table-responsive {
            overflow-x: auto;
            border-radius: 16px;
            background: #f5f8fa;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1000px;
        }
        
        table thead {
            background: #34495e;
            color: #ecf0f1;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        table th {
            padding: 16px 12px;
            border: 1px solid #4a6373;
            white-space: nowrap;
        }
        
        table td {
            padding: 14px 12px;
            border: 1px solid #bdd3dc;
            color: #2c3e50;
            font-size: 14px;
            white-space: nowrap;
        }
        
        table tbody tr {
            background: #f5f8fa;
            transition: background 0.2s ease;
        }
        
        table tbody tr:nth-child(even) {
            background: #dee9ef;
        }
        
        table tbody tr:hover {
            background: #cbdbe5;
        }
        
        /* Total Row */
        .total-row {
            background: #2c3e50 !important;
            font-weight: 700;
            border-top: 3px solid #1e2f3a;
        }
        
        .total-row td {
            background: #2c3e50;
            color: white !important;
            font-weight: 700;
            border: 1px solid #dee9ef;
        }
        
        .total-row td strong {
            color: white;
        }
        
        /* Salary Preparing Badge */
        .preparing-badge {
            background: #00e508;
            color: #ffffff;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 18px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: 1px solid #00e508;
        }
        
        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 30px;
        }
        
        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid transparent;
        }
        
        .btn-primary {
            background: #2c3e50;
            color: #ecf0f1;
            border: 1px solid #4a6373;
        }
        
        .btn-primary:hover {
            background: #1e2f3a;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(44,62,80,0.4);
        }
        
        .btn-disabled {
            background: #95a5a6;
            color: #2c3e50;
            cursor: not-allowed;
            opacity: 0.7;
        }
        
        /* Footer */
        .salary-footer {
            background: #2c3e50;
            color: #95a5a6;
            padding: 20px 25px;
            border-radius: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            border: 1px solid #4a6373;
        }
        
        .footer-note {
            font-size: 14px;
            color: #bdd3dc;
        }
        
        .footer-version {
            background: #34495e;
            padding: 6px 15px;
            border-radius: 30px;
            font-size: 13px;
            border: 1px solid #5d7e92;
        }
        
        /* Host Type Badge */
        .host-type-audio {
            background: #3498db;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .host-type-video {
            background: #e74c3c;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        /* Day-Time Container */
        .day-time-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
        }
        
        .day-badge {
            background: #2c3e50;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            width: fit-content;
        }
        
        .time-badge {
            background: #7f8c8d;
            color: white;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            width: fit-content;
        }
        
        /* Bonus Column Highlight */
        .bonus-column {
            background: #fef9e7;
            font-weight: 600;
            color: #d35400;
        }
        
        /* Hidden Column Class */
        .hidden-column {
            display: none;
        }
        
        /* Info Box */
        .info-box {
            background: #fff3cd;
            border: 2px solid #dc3545;
            border-radius: 12px;
            padding: 15px 20px;
            margin: 20px 0;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 4px 8px rgba(220,53,69,0.2);
        }
        
        .info-icon {
            font-size: 28px;
            color: #dc3545;
        }
        
        .info-text {
            color: #721c24;
            font-size: 16px;
            font-weight: 500;
        }
        
        .info-text strong {
            color: #dc3545;
            font-size: 18px;
        }
        
        .highlight-red {
            color: #dc3545;
            font-weight: 700;
            background: #ffe6e6;
            padding: 2px 8px;
            border-radius: 4px;
        }
        
        /* Zero Basic Salary Row Style */
        .zero-basic-row {
            opacity: 0.7;
            background: #f0f0f0;
        }
        
        .zero-basic-row td {
            color: #7f8c8d;
        }
        
        /* Responsive */
        @media (max-width: 1000px) {
            .summary-cards {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .container {
                padding: 20px;
            }
        }
        
        @media (max-width: 700px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .agency-info {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .action-buttons {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
            
            .salary-footer {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
        
        /* Print Styles */
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .container {
                box-shadow: none;
                border: none;
            }
            .btn, .action-buttons, .status-bar {
                display: none;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>
<body>
    <div class="container">
        <!-- Header with Agency Info -->
        <div class="salary-header">
            <h1>💰 SALARY PREPARATION SHEET</h1>
            <div class="agency-info">
                <div class="agency-badge">🏢 {{$agency->name}} | Code: {{$agency->code}}</div>
                <div class="date-range">📅 Period: {{$start_date}} to {{$end_date}}</div>
                <div class="preparing-badge">
                    <span>⏳</span> SALARY READY
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        @php
            $summary = $summary ?? [
                'totalGift' => 0,
                'totalBasicPoint' => 0,
                'totalExtraPoint' => 0,
                'totalBasicSalary' => 0,
                'totalExtraBonus' => 0,
                'totalFinalSalary' => 0,
                'totalHosts' => count($data),
                'hasExtraBonus' => false,
                'hasBasicSalary' => false,
            ];
            $totalGift = $summary['totalGift'];
            $totalBasicPoint = $summary['totalBasicPoint'];
            $totalExtraPoint = $summary['totalExtraPoint'];
            $totalBasicSalary = $summary['totalBasicSalary'];
            $totalExtraBonus = $summary['totalExtraBonus'];
            $hasExtraBonus = $summary['hasExtraBonus'];
            $hasBasicSalary = $summary['hasBasicSalary'];
            $totalFinalSalary = $summary['totalFinalSalary'];
        @endphp
        
        <div class="summary-cards">
            <div class="card">
                <div class="card-label">Total Hosts</div>
                <div class="card-value">{{ $summary['totalHosts'] ?? count($data) }}</div>
                <div class="card-sub">Active members</div>
            </div>
            <div class="card">
                <div class="card-label">Total Coin</div>
                <div class="card-value">{{ number_format($summary['totalGift']) }}</div>
                <div class="card-sub">Gross earnings</div>
            </div>
            <div class="card">
                <div class="card-label">Basic Points</div>
                <div class="card-value">{{ number_format($summary['totalBasicPoint']) }}</div>
                <div class="card-sub">Base calculation</div>
            </div>
            <div class="card">
                <div class="card-label">Extra Points</div>
                <div class="card-value">{{ number_format($summary['totalExtraPoint']) }}</div>
                <div class="card-sub">Bonus eligible</div>
            </div>
            <div class="card">
                <div class="card-label">Extra Bonus</div>
                <div class="card-value">BDT {{ number_format($totalExtraBonus) }}</div>
                <div class="card-sub">600/100k points</div>
            </div>
            <div class="card">
                <div class="card-label">Total Salary</div>
                <div class="card-value">BDT {{ number_format($totalFinalSalary) }}</div>
                <div class="card-sub">Basic + Bonus</div>
            </div>
        </div>

        <!-- Status Bar - Preparing -->
        <div class="status-bar">
            <div class="status-indicator"></div>
            <div class="status-text">Salary is being calculated - Based on previous month ({{$start_date}} to {{$end_date}})</div>
            <div class="status-badge">⏳ READY</div>
        </div>

        <!-- Info Box - Shows when Extra Bonus columns are hidden -->
        @if(!$hasExtraBonus && $hasBasicSalary)
        <div class="info-box">
            <div class="info-icon">⚠️</div>
            <div class="info-text">
                <strong>EXTRA BONUS COLUMNS HIDDEN</strong><br>
                No hosts have reached the <span class="highlight-red">100,000 extra points</span> threshold.<br>
                Extra Bonus column is hidden because all values are <span class="highlight-red">0</span>.
                <br><small>Note: Extra Bonus requires minimum 100,000 points to qualify.</small>
            </div>
        </div>
        @elseif(!$hasBasicSalary)
        <div class="info-box" style="background: #e8f4fd; border-color: #3498db;">
            <div class="info-icon">ℹ️</div>
            <div class="info-text">
                <strong>NO BASIC SALARY DATA</strong><br>
                No hosts have basic salary data for this period.<br>
                All calculations are based on available data only.
            </div>
        </div>
        @endif

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-title">
                <h2>📋 Host Salary Calculation Details</h2>
                <span>{{ $summary['totalHosts'] ?? count($data) }} Records</span>
            </div>

            <div class="table-responsive">
                <table id="salaryTable">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>Name</th>
                            <th>ID</th>
                            <th>Type / Day / Time</th>
                            <th>Total Coin</th>
                            <th>Basic Point</th>
                            <th>Extra Point</th>
                            
                            <!-- Extra Bonus Column - Hidden if no bonus -->
                            <th class="{{ $hasExtraBonus ? '' : 'hidden-column' }}">Extra Bonus (600/100k)</th>
                            
                            <!-- Basic Salary Column -->
                            <th>Basic Salary (TK)</th>
                            
                            <!-- Final Salary Column -->
                            <th>Final Salary (TK)</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $host)
                        @php
                            $extra_bonus = $host['extra_bonus'];
                            $final_salary = $host['final_salary'];
                        @endphp
                        
                        <tr class="{{ $host['basic_salary'] == 0 ? 'zero-basic-row' : '' }}">
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $host['name'] }}</strong></td>
                            <td>{{ $host['id'] }}</td>
                            <td>
                                <div class="day-time-container">
                                    @if($host['hosting_type'] == 'Audio')
                                        <span class="host-type-audio">🎙️ Audio</span>
                                    @else
                                        <span class="host-type-video">🎥 Video</span>
                                    @endif
                                    <span class="day-badge">📅 Day: {{ $host['day'] }}</span>
                                    <span class="time-badge">⏱️ Time: {{ $host['time'] }}</span>
                                </div>
                            </td>
                            <td>{{ number_format($host['gift']) }}</td>
                            <td>{{ number_format($host['basic_point']) }}</td>
                            <td>{{ number_format($host['extra_point']) }}</td>
                            
                            <!-- Extra Bonus Column Data - Hidden if no bonus -->
                            <td class="{{ $hasExtraBonus ? 'bonus-column' : 'hidden-column' }}">
                                {{ $hasExtraBonus ? number_format($extra_bonus) : '0' }}
                            </td>
                            
                            <td>{{ number_format($host['basic_salary']) }}</td>
                            <td style="color: #ff1493; font-weight: 700; background: #f0f0f0;">
                                {{ number_format($final_salary) }}
                            </td>
                        </tr>
                    @endforeach
                    
                    <!-- Grand Total Row -->
                    <tr class="total-row">
                        <td colspan="4"><strong>GRAND TOTAL</strong></td>
                        <td><strong>{{ number_format($totalGift) }}</strong></td>
                        <td><strong>{{ number_format($totalBasicPoint) }}</strong></td>
                        <td><strong>{{ number_format($totalExtraPoint) }}</strong></td>
                        
                        <!-- Extra Bonus Total - Hidden if no bonus -->
                        @if($hasExtraBonus)
                            <td><strong>{{ number_format($totalExtraBonus) }}</strong></td>
                        @else
                            <td class="hidden-column"><strong>0</strong></td>
                        @endif
                        
                        <td><strong>{{ number_format($totalBasicSalary) }}</strong></td>
                        <td><strong>BDT {{ number_format($totalFinalSalary) }}</strong></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Bonus Calculation Note - Show only if there is bonus -->
            @if($hasExtraBonus)
            <div style="margin-top: 20px; padding: 15px; background: #b0c7d2; border-radius: 12px; border: 1px solid #8aa7b3;">
                <p style="color: #1e2f3a; font-size: 14px; margin: 0;">
                    <strong>📌 Bonus Calculation:</strong> Extra Point Bonus = floor(Extra Point ÷ 100,000) × 600 TK 
                    (e.g., 100,000-199,999 = 600 TK, 200,000-299,999 = 1,200 TK, etc.)
                </p>
                <p style="color: #1e2f3a; font-size: 13px; margin: 5px 0 0 0;">
                    <strong>📊 Day/Time Format:</strong> Day = Running days count | Time = Total duration (HH:MM:SS)
                </p>
                <p style="color: #1e2f3a; font-size: 13px; margin: 5px 0 0 0;">
                    <strong>⚠️ Note:</strong> Extra bonus is only calculated for hosts with Basic Salary > 0.
                </p>
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <button class="btn btn-primary" onclick="exportAsExcel()">
                <span>📊</span> Export as Excel
            </button>
            <button class="btn btn-disabled" disabled>
                <span>⏳</span> Finalize Salary (Preparing)
            </button>
        </div>

        <!-- Footer -->
        <div class="salary-footer">
            <div class="footer-note">
                ✅ Salary calculation for previous month • 
                @if($hasExtraBonus)
                    Extra bonus: 600 TK per complete 100,000 points • 
                @else
                    <span style="color: #ff9999;">No extra bonus applicable • </span>
                @endif
                Not finalized
            </div>
            <div class="footer-version">
                ⚡ Thomas ⚡ Salary System v2.0 • {{$agency->code}}
            </div>
        </div>
    </div>

    <script>
        // Export to Excel function
        function exportAsExcel() {
            const table = document.getElementById("salaryTable");
            
            // Before exporting, temporarily show hidden columns if needed for Excel
            @if(!$hasExtraBonus)
                // For Excel, we want to include all columns even if hidden in display
                // So we'll temporarily remove the hidden class
                const hiddenColumns = document.querySelectorAll('.hidden-column');
                hiddenColumns.forEach(col => {
                    col.classList.remove('hidden-column');
                });
            @endif
            
            const workbook = XLSX.utils.table_to_book(table, { sheet: "Salary" });
            XLSX.writeFile(workbook, "salary_{{str_replace(' ', '_', $agency->name)}}_{{$start_date}}_to_{{$end_date}}.xlsx");
            
            @if(!$hasExtraBonus)
                // Re-hide the columns after export
                hiddenColumns.forEach(col => {
                    col.classList.add('hidden-column');
                });
            @endif
            
            // Show alert
            alert("✅ Excel file downloaded successfully!\nBonus: 600 TK per complete 100,000 extra points\n(Only calculated for hosts with Basic Salary)");
        }
        
        // Optional: Print function
        function printSalary() {
            window.print();
        }
    </script>
</body>
</html>