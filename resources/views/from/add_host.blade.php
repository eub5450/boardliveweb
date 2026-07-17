<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Broad Live · host request (ash)</title>
    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap 5 (grid & utilities) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <!-- toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css">
    <style>
        /* ----- ASH PALETTE (neutral, sophisticated) ----- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f2f4f8;  /* soft ash base */
            font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 0.75rem;
            margin: 0;
        }

        /* main card – ash glassmorphism */
        .ash-card {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border-radius: 36px;
            box-shadow: 0 20px 40px -15px rgba(100, 116, 139, 0.3), 0 2px 8px rgba(255,255,255,0.8) inset;
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 1.8rem 1.2rem;
            max-width: 720px;   /* narrower = super mobile friendly */
            margin: 0 auto;
            width: 100%;
        }

        /* header – ash minimalist */
        .header-ash {
            text-align: center;
            margin-bottom: 1.8rem;
            position: relative;
        }

        .header-ash h2 {
            font-weight: 600;
            color: #2c3e4f;    /* deep ash */
            font-size: clamp(1.7rem, 7vw, 2.3rem);
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-bottom: 0.2rem;
        }

        .header-ash h2 i {
            color: #7f8c8d;     /* muted ash */
            font-size: 2rem;
        }

        .header-ash .sub {
            color: #5d6d7e;
            font-weight: 400;
            font-size: 0.9rem;
            background: rgba(255, 255, 255, 0.6);
            display: inline-block;
            padding: 0.3rem 1.2rem;
            border-radius: 40px;
            backdrop-filter: blur(2px);
            border: 1px solid #d0d9e2;
        }

        /* section titles – ash variant */
        .section-title {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 600;
            font-size: 1.2rem;
            color: #3a4b5c;        /* deep ash */
            margin: 2rem 0 1.2rem 0;
            padding-left: 0.5rem;
            border-left: 5px solid #9aa9b9;
        }

        .section-title i {
            background: #cad2db;    /* ash circle */
            padding: 0.5rem;
            border-radius: 50%;
            color: #2c3e4f;
            font-size: 1rem;
            width: 2.2rem;
            text-align: center;
            box-shadow: 0 4px 8px #bac8d6;
        }

        /* modern input groups – ash version */
        .input-group-modern {
            display: flex;
            flex-direction: column;
            margin-bottom: 1.3rem;
        }

        .input-group-modern label {
            font-weight: 500;
            font-size: 0.85rem;
            color: #4a5b6b;
            margin-bottom: 0.25rem;
            letter-spacing: -0.01em;
        }

        .required-star {
            color: #b03a4e;    /* subtle red-ash */
            margin-left: 2px;
        }

        .input-icon-wrapper {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 28px;
            border: 1.5px solid #d7e0e8;
            transition: all 0.15s;
            padding: 0.1rem 0.1rem 0.1rem 1rem;
            box-shadow: 0 2px 6px rgba(133, 146, 163, 0.1);
        }

        .input-icon-wrapper:focus-within {
            border-color: #8599af;      /* ash focus */
            box-shadow: 0 6px 14px #bac8d9;
        }

        .input-icon-wrapper i {
            color: #6f7e91;              /* ash icon */
            font-size: 1rem;
            min-width: 1.8rem;
            text-align: center;
        }

        .input-icon-wrapper .form-control,
        .input-icon-wrapper .form-select {
            border: none;
            background: transparent;
            padding: 0.8rem 1rem 0.8rem 0.2rem;
            font-size: 1rem;
            border-radius: 28px;
            box-shadow: none !important;
            outline: none;
        }

        .input-icon-wrapper .form-control:focus,
        .input-icon-wrapper .form-select:focus {
            background: transparent;
        }

        /* file inputs – ash, clean */
        .file-ash {
            background: white;
            border-radius: 30px;
            padding: 0.65rem 1rem;
            border: 1.5px dashed #b1c0cf;
            display: flex;
            align-items: center;
            gap: 0.7rem;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s;
            margin-bottom: 0.5rem;
        }

        .file-ash:hover {
            background: #f0f4fa;
            border-color: #7f8fa3;
        }

        .file-ash i {
            font-size: 1.5rem;
            color: #6f839a;
            width: 2rem;
        }

        .file-ash .file-text {
            font-size: 0.9rem;
            color: #3e5364;
            font-weight: 500;
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .file-ash input[type=file] {
            display: none;
        }

        .preview-image {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 20px;
            border: 3px solid white;
            box-shadow: 0 5px 15px #b9c5d4;
            display: none;
            background: #ecf0f3;
            margin-top: 0.3rem;
        }

        /* bank area (optional) */
        .bank-area textarea {
            background: white;
            border-radius: 30px;
            border: 1.5px solid #d0ddee;
            padding: 0.9rem 1.4rem;
            width: 100%;
            resize: vertical;
            font-size: 0.95rem;
            color: #1e2a36;
        }

        .bank-area textarea:focus {
            border-color: #7f8fa3;
            outline: none;
            box-shadow: 0 6px 16px #ccd9e8;
        }

        /* submit button – ash gradient (no pink) */
        .btn-submit-ash {
            background: linear-gradient(145deg, #556b7f, #2e4155);
            border: none;
            border-radius: 44px;
            padding: 1rem 1.8rem;
            font-weight: 600;
            font-size: 1.2rem;
            letter-spacing: 0.5px;
            color: white;
            width: 100%;
            max-width: 280px;
            margin: 1.8rem auto 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 14px 26px #95a9bd;
            transition: all 0.2s ease;
            border: 1px solid #ffffffb0;
        }

        .btn-submit-ash:hover {
            background: linear-gradient(145deg, #3e566b, #1d2e3d);
            box-shadow: 0 18px 32px #7b8da3;
            transform: scale(1.01);
        }

        .btn-submit-ash i {
            font-size: 1.3rem;
        }

        /* validation */
        .is-invalid {
            border-color: #ba4a5a !important;
            background: #fef6f7;
        }

        .file-selected {
            color: #274256;
            font-weight: 600;
        }

        ::placeholder {
            color: #abb9c9;
            opacity: 0.8;
        }

        /* mobile first tiny adjustments */
        @media (max-width: 480px) {
            .ash-card {
                padding: 1.4rem 1rem;
                border-radius: 28px;
            }
            .section-title {
                font-size: 1.1rem;
                margin: 1.5rem 0 1rem;
            }
            .preview-image {
                width: 60px;
                height: 60px;
            }
            .input-icon-wrapper {
                padding-left: 0.7rem;
            }
        }

        /* extra smooth */
        .row {
            --bs-gutter-x: 1rem;
        }

        /* remove bootstrap override annoyances */
        .form-control,
        .form-select {
            background: transparent !important;
        }
    </style>
</head>
<body>
    <div class="container-fluid px-0">
        <div class="row justify-content-center g-0">
            <div class="col-12 col-sm-11 col-md-10 col-lg-8">
                <!-- ash card -->
                <div class="ash-card">
                    <!-- header -->
                    <div class="header-ash">
                        <h2>
                            <i class="fa-regular fa-building"></i> 
                            Broad Live
                        </h2>
                        <div class="sub">
                            <i class="fa-regular fa-pen-to-square me-1"></i> host request · ash edition
                        </div>
                    </div>

                    <!-- FORM (with ash theme) -->
                    <form action="{{URL::to('add_host_from_submit')}}" enctype="multipart/form-data" method="post" id="ashForm">
                        @csrf

                        <!-- 1. PERSONAL INFO (ASH) -->
                        <div class="section-title">
                            <i class="fa-regular fa-id-card"></i> 
                            <span>personal</span>
                        </div>
                        <div class="row g-2">
                            <div class="col-12 col-sm-6">
                                <div class="input-group-modern">
                                    <label>Agency Code <span class="required-star">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa-regular fa-building"></i>
                                        <input type="number" name="agency_code" class="form-control" placeholder="e.g. 101" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="input-group-modern">
                                    <label>Host ID <span class="required-star">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa-regular fa-id-badge"></i>
                                        <input type="number" name="host_id" class="form-control" placeholder="your host ID" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="input-group-modern">
                                    <label>Phone <span class="required-star">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa-regular fa-phone"></i>
                                        <input type="tel" name="phone_number" class="form-control" placeholder="+8801XXXXXXXXX" required>
                                    </div>
                                </div>
                            </div>
                          
                        </div>

                        <!-- 2. HOSTING DETAILS (ASH) -->
                        <div class="section-title">
                            <i class="fa-regular fa-microphone-lines"></i>
                            <span>hosting & region</span>
                        </div>
                        <div class="row g-2">
                            <div class="col-12 col-sm-6">
                                <div class="input-group-modern">
                                    <label>Hosting type <span class="required-star">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa-regular fa-circle-play"></i>
                                        <select name="hosting_type" class="form-select" required>
                                            <option value="" selected disabled>– select –</option>
                                            <option value="2">Video</option>
                                            <option value="1">Audio</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="input-group-modern">
                                    <label>Country <span class="required-star">*</span></label>
                                    <div class="input-icon-wrapper">
                                        <i class="fa-regular fa-flag"></i>
                                        <select name="country_id" class="form-select" required>
                                            <option value="" selected disabled>– select country –</option>
                                            @foreach($contry as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                     
                        <!-- submit button ash -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn-submit-ash">
                                <i class="fa-regular fa-paper-plane"></i> SUBMIT REQUEST
                            </button>
                        </div>
                        <p class="text-center mt-3 mb-0" style="color:#5f7489; font-size:0.75rem;">
                            <i class="fa-regular fa-shield"></i> ash gray · secure & neutral
                        </p>
                    </form>
                </div> <!-- ash-card -->
            </div> <!-- col -->
        </div> <!-- row -->
    </div> <!-- container -->

    <!-- scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js"></script>

    <script>
        // universal file handler + preview (ash)
        function handleFileSelect(input, fileNameSpanId, previewId) {
            const fileNameSpan = document.getElementById(fileNameSpanId);
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                let name = input.files[0].name;
                fileNameSpan.innerText = name.length > 28 ? name.substring(0, 25) + '…' : name;
                fileNameSpan.classList.add('file-selected');
                
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);

                $(input).removeClass('is-invalid');
            } else {
                fileNameSpan.innerText = 'choose file';
                preview.style.display = 'none';
            }
        }

        $(document).ready(function() {
            $('#ashForm').on('submit', function(e) {
                let allValid = true;
                $(this).find('input[required], select[required]').each(function() {
                    if (!$(this).val()) {
                        allValid = false;
                        $(this).addClass('is-invalid');
                        // visual hint for file parent
                        if ($(this).attr('type') === 'file') {
                            $(this).prev('.file-ash').css('border-color', '#ba4a5a');
                        }
                    } else {
                        $(this).removeClass('is-invalid');
                        if ($(this).attr('type') === 'file') {
                            $(this).prev('.file-ash').css('border-color', '#b1c0cf');
                        }
                    }
                });

                if (!allValid) {
                    e.preventDefault();
                    toastr.error('Please fill all required fields (ash edition ◇)');
                }
            });

            // remove invalid on input/change
            $('input, select').on('input change', function() {
                if ($(this).val()) {
                    $(this).removeClass('is-invalid');
                    if ($(this).attr('type') === 'file') {
                        $(this).prev('.file-ash').css('border-color', '#b1c0cf');
                    }
                }
            });

            // laravel session toasts
            @if(Session::has('messege'))
                var type = "{{Session::get('alert-type','info')}}";
                var msg = "{{ Session::get('messege') }}";
                switch(type) {
                    case 'info': toastr.info(msg); break;
                    case 'success': toastr.success(msg); break;
                    case 'warning': toastr.warning(msg); break;
                    case 'error': toastr.error(msg); break;
                    default: toastr.info(msg);
                }
            @endif
        });

        // legacy readURL function (safe)
        window.readURL = function(input, previewId) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#' + previewId).attr('src', e.target.result).show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    <!-- extra ash polish -->
    <style>
        .is-invalid {
            border-color: #ba4a5a !important;
        }
        .file-ash {
            transition: border 0.2s, background 0.2s;
        }
        .fa-regular, .fa-solid {
            pointer-events: none;
        }
        /* full mobile love */
        @media (max-width: 480px) {
            .preview-image { width: 55px; height: 55px; }
        }
    </style>
</body>
</html>