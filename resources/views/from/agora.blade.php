<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Broad Live Agora System</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Lobster&display=swap" rel="stylesheet">
    <style type="text/css">
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            --card-bg: rgba(255, 255, 255, 0.95);
            --text-dark: #2d3748;
            --text-light: #4a5568;
            --success: #48bb78;
            --warning: #ed8936;
            --danger: #f56565;
            --info: #4299e1;
            --shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            --radius: 12px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--primary-gradient);
            color: var(--text-dark);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding-top: 20px;
        }

        .header h1 {
            font-family: 'Lobster', cursive;
            font-size: 3.5rem;
            color: white;
            text-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            margin-bottom: 15px;
        }

        .header-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Form Card */
        .form-card {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 30px;
            margin-bottom: 40px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(10px);
        }

        .form-title {
            text-align: center;
            color: var(--text-dark);
            font-size: 2rem;
            margin-bottom: 25px;
            font-weight: 700;
            position: relative;
            padding-bottom: 15px;
        }

        .form-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--secondary-gradient);
            border-radius: 2px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .form-group {
            flex: 0 0 100%;
            padding: 0 15px;
            margin-bottom: 20px;
        }

        @media (min-width: 768px) {
            .form-group {
                flex: 0 0 50%;
            }
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 1rem;
            transition: var(--transition);
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
        }

        .form-input::placeholder {
            color: #a0aec0;
        }

        .btn-submit {
            background: var(--secondary-gradient);
            color: white;
            border: none;
            padding: 16px 40px;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            display: block;
            margin: 30px auto 0;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        /* Table Container */
        .table-container {
            background: var(--card-bg);
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .table-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-dark);
        }

        .export-buttons {
            display: flex;
            gap: 10px;
        }

        .export-btn {
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .export-pdf {
            background: #f56565;
            color: white;
        }

        .export-excel {
            background: #48bb78;
            color: white;
        }

        .export-btn:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        /* Table Styles */
        .responsive-table {
            width: 100%;
            border-collapse: collapse;
            overflow: hidden;
        }

        .responsive-table thead {
            background: var(--secondary-gradient);
        }

        .responsive-table th {
            padding: 18px 15px;
            text-align: left;
            color: white;
            font-weight: 600;
            font-size: 1rem;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .responsive-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: var(--transition);
        }

        .responsive-table tbody tr:hover {
            background-color: #f7fafc;
        }

        .responsive-table td {
            padding: 16px 15px;
            color: var(--text-light);
        }

        /* Text truncation for long content */
        .truncate-text {
            display: inline-block;
            max-width: 200px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Copy Button Styles */
        .copy-container {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .copy-btn {
            background: transparent;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 6px 12px;
            cursor: pointer;
            color: var(--text-light);
            font-size: 0.85rem;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .copy-btn:hover {
            background: var(--secondary-gradient);
            color: white;
            border-color: transparent;
        }

        .copy-btn i {
            font-size: 0.9rem;
        }

        .copy-success {
            background: var(--success);
            color: white;
            border-color: transparent;
        }

        .copy-success i {
            color: white;
        }

        .password-masked {
            font-family: monospace;
            letter-spacing: 2px;
            background: #f7fafc;
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px dashed #e2e8f0;
        }

        /* Status Badges */
        .status-badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-running {
            background: rgba(72, 187, 120, 0.2);
            color: var(--success);
        }

        .status-new {
            background: rgba(66, 153, 225, 0.2);
            color: var(--info);
        }

        .status-expired {
            background: rgba(245, 101, 101, 0.2);
            color: var(--danger);
        }

        /* Action Buttons */
        .action-btn {
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            border: none;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-size: 0.9rem;
        }

        .btn-active {
            background: var(--success);
            color: white;
        }

        .btn-active:hover {
            background: #38a169;
        }

        .btn-disabled {
            background: #e2e8f0;
            color: #a0aec0;
            cursor: not-allowed;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--success);
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
            z-index: 9999;
            display: none;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        /* Mobile Responsive Table */
        @media (max-width: 768px) {
            .header h1 {
                font-size: 2.5rem;
            }
            
            .form-card, .table-container {
                padding: 20px;
            }
            
            .responsive-table {
                display: block;
                overflow-x: auto;
            }
            
            .table-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .export-buttons {
                width: 100%;
                justify-content: space-between;
            }
            
            .export-btn {
                flex: 1;
                justify-content: center;
            }
            
            .truncate-text {
                max-width: 150px;
            }
        }

        /* Mobile card view for table rows */
        @media (max-width: 576px) {
            .responsive-table thead {
                display: none;
            }
            
            .responsive-table tbody tr {
                display: block;
                margin-bottom: 20px;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 15px;
                background: white;
                box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
            }
            
            .responsive-table td {
                display: flex;
                justify-content: space-between;
                padding: 12px 10px;
                border-bottom: 1px solid #f1f1f1;
            }
            
            .responsive-table td:last-child {
                border-bottom: none;
            }
            
            .responsive-table td:before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--text-dark);
                flex: 0 0 40%;
            }
            
            .responsive-table td .mobile-value {
                flex: 0 0 60%;
                text-align: right;
            }
            
            .truncate-text {
                max-width: 100%;
                white-space: normal;
                text-overflow: clip;
            }
            
            .copy-container {
                justify-content: flex-end;
            }
            
            .form-group {
                flex: 0 0 100%;
            }
            
            .btn-submit {
                width: 100%;
            }
        }

        /* Additional mobile optimizations */
        @media (max-width: 480px) {
            body {
                padding: 15px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
            
            .header-subtitle {
                font-size: 0.95rem;
            }
            
            .form-title {
                font-size: 1.5rem;
            }
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 20px;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }

        /* Loading animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* No data message */
        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--text-light);
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Toast Notification -->
    <div id="toast" class="toast">
        <i class="fas fa-check-circle"></i> <span id="toastMessage"></span>
    </div>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Broad Live Agora System</h1>
            <p class="header-subtitle">Manage your Agora video communication accounts, certificates, and credentials in one secure dashboard</p>
        </div>

        <!-- New Account Form -->
        <div class="form-card">
            <h2 class="form-title">New Agora Account</h2>
            <form action="{{URL::to('fontend-agora_account_store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label for="appId" class="form-label">Agora AppId *</label>
                        <input type="text" name="appId" class="form-input" placeholder="Enter AppId" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="appCertificate" class="form-label">Agora AppCertificate *</label>
                        <input type="text" name="appCertificate" class="form-input" placeholder="Enter Agora AppCertificate" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="AgoraEmail" class="form-label">Agora Account Email *</label>
                        <input type="email" name="AgoraEmail" class="form-input" placeholder="Enter Agora Account Email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="AgoraEmailPassword" class="form-label">Agora Account Email Password *</label>
                        <input type="text" name="AgoraEmailPassword" class="form-input" placeholder="Enter Agora Account Email Password" required>
                    </div>
                </div>
                
                <button type="submit" class="btn-submit" id="submitBtn">
                    <i class="fas fa-plus-circle"></i> Create Account
                </button>
            </form>
        </div>

        <!-- Accounts Table -->
        <div class="table-container">
            <div class="table-header">
                <h2 class="table-title">Agora Account List</h2>
            </div>
            
            <div class="table-responsive">
                <table class="responsive-table" id="salaryTable">
                    <thead>
                        <tr>
                            <th>Sl</th>
                            <th>AppId & AppCertificate</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach($data as $row)
                        <tr>
                            <td data-label="Sl">{{ ++$i }}</td>
                            <td data-label="AppId">
                                <div class="mobile-value">
                                    <span class="truncate-text" title="{{$row->appId}}">{{$row->appId}}</span>
                                    <br>
                                    <span class="truncate-text" title="{{$row->appCertificate}}">{{$row->appCertificate}}</span>
                                </div>
                            </td>
                           
                            <td data-label="Email">
                                <div class="mobile-value copy-container">
                                    <span class="truncate-text" title="{{$row->AgoraEmail}}">{{$row->AgoraEmail}}</span>
                                    <button class="copy-btn" onclick="copyToClipboard('{{$row->AgoraEmail}}', this, 'email')">
                                        <i class="far fa-copy"></i> Copy
                                    </button>
                                </div>
                            </td>
                            
                            <td data-label="Password">
                                <div class="mobile-value copy-container">
                                    <span class="password-masked" title="{{$row->AgoraEmailPassword}}">••••••••</span>
                                    <button class="copy-btn" onclick="copyToClipboard('{{$row->AgoraEmailPassword}}', this, 'password')">
                                        <i class="far fa-copy"></i> Copy
                                    </button>
                                </div>
                            </td>
                           
                            <td data-label="Status">
                                <div class="mobile-value">
                                    @if($row->Status == 1)
                                        <span class="status-badge status-running">
                                            <i class="fas fa-check-circle"></i> Running
                                        </span>
                                    @elseif($row->Status == 0)
                                        <span class="status-badge status-new">
                                            <i class="fas fa-clock"></i> New
                                        </span>
                                    @else
                                        <span class="status-badge status-expired">
                                            <i class="fas fa-times-circle"></i> Expired
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td data-label="Actions">
                                <div class="mobile-value">
                                    @if($row->Status==1)
                                        <span class="action-btn btn-disabled">Running</span>
                                    @elseif($row->Status==0)
                                        <a href="{{URL::to('fontend-agora_account_active/'.$row->id)}}" class="action-btn btn-active">
                                            <i class="fas fa-play"></i> Activate
                                        </a>
                                    @else
                                        <span class="action-btn btn-disabled">Expired</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if(count($data) === 0)
            <div class="no-data">
                <i class="fas fa-inbox"></i>
                <h3>No Agora Accounts Found</h3>
                <p>Create your first Agora account using the form above</p>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Broad Live Agora System • Secure Agora Account Management</p>
            <p>© {{ date('Y') }} All rights reserved</p>
        </div>
    </div>

    <!-- Include jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.23/jspdf.plugin.autotable.min.js"></script>
    <!-- Include SheetJS -->
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>

    <script>
        // Form submission loading indicator
        document.querySelector('form').addEventListener('submit', function() {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.innerHTML = '<span class="loading"></span> Creating...';
            submitBtn.disabled = true;
        });

        // Toast notification function
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            
            toast.style.backgroundColor = type === 'success' ? '#48bb78' : '#f56565';
            toastMessage.textContent = message;
            toast.style.display = 'block';
            
            setTimeout(() => {
                toast.style.display = 'none';
            }, 2000);
        }

        // Copy to clipboard function
        function copyToClipboard(text, button, type) {
            // Create temporary textarea
            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            
            // Select and copy
            textarea.select();
            textarea.setSelectionRange(0, 99999); // For mobile
            
            try {
                document.execCommand('copy');
                
                // Visual feedback
                const originalText = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check"></i> Copied!';
                button.classList.add('copy-success');
                
                // Show toast
                const fieldName = type === 'email' ? 'Email' : 'Password';
                showToast(`${fieldName} copied to clipboard!`);
                
                setTimeout(() => {
                    button.innerHTML = originalText;
                    button.classList.remove('copy-success');
                }, 2000);
            } catch (err) {
                showToast('Failed to copy', 'error');
            }
            
            // Remove temporary textarea
            document.body.removeChild(textarea);
        }

        // Export as PDF
        function exportAsPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('l', 'mm', 'a4');
            
            doc.setFontSize(18);
            doc.text('BP Live Agora Accounts', 14, 20);
            doc.setFontSize(11);
            doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 14, 28);
            
            doc.autoTable({
                html: '#salaryTable',
                startY: 35,
                styles: { fontSize: 9 },
                headStyles: { fillColor: [102, 126, 234] }
            });
            
            doc.save('agora-accounts.pdf');
        }

        // Export as Excel
        function exportAsExcel() {
            const table = document.getElementById("salaryTable");
            const workbook = XLSX.utils.table_to_book(table, { sheet: "Agora Accounts" });
            XLSX.writeFile(workbook, "agora-accounts.xlsx");
        }

        // Initialize mobile view on load
        document.addEventListener('DOMContentLoaded', function() {
            // Add data-label attributes for mobile view
            if (window.innerWidth <= 576) {
                const table = document.querySelector('.responsive-table');
                if (table) {
                    const headers = table.querySelectorAll('th');
                    headers.forEach((header, index) => {
                        const cells = table.querySelectorAll(`td:nth-child(${index + 1})`);
                        cells.forEach(cell => {
                            cell.setAttribute('data-label', header.textContent);
                        });
                    });
                }
            }
            
            // Add tooltips for truncated text
            const truncatedElements = document.querySelectorAll('.truncate-text');
            truncatedElements.forEach(element => {
                if (element.scrollWidth > element.clientWidth) {
                    element.setAttribute('title', element.textContent);
                }
            });
        });

        // Update on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth <= 576) {
                const table = document.querySelector('.responsive-table');
                if (table) {
                    const headers = table.querySelectorAll('th');
                    headers.forEach((header, index) => {
                        const cells = table.querySelectorAll(`td:nth-child(${index + 1})`);
                        cells.forEach(cell => {
                            cell.setAttribute('data-label', header.textContent);
                        });
                    });
                }
            }
        });
    </script>
</body>
</html>