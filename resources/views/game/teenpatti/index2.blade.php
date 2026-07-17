<!DOCTYPE html>
<html lang="en">
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: Thu, 01 Jan 1970 00:00:00 GMT");
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My script</title>

    <link rel="stylesheet" href="{{asset('public/game/teenpatti/')}}/css/new/day.css">
    <link rel="stylesheet" href="{{asset('public/game/teenpatti/')}}/css/new/night.css">
    <link rel="stylesheet" href="{{asset('public/game/teenpatti/')}}/css/new/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.0/css/bootstrap.min.css"
        integrity="sha512-NZ19NrT58XPK5sXqXnnvtf9T5kLXSzGQlVZL9taZWeTBtXoN3xIfTdxbkQh6QSoJfJgpojRqMfhyqBAAEeiXcA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{asset('public/game/teenpatti/')}}/js/app.63f5c45e.js"></script> 

    <style>
        /* ===== RESPONSIVE FIXES - ADDED WITHOUT CHANGING EXISTING STYLES ===== */
        
        :root {
            --card-height: 140px;
            --card-width: 95px;
            --chair-height: 110px;
        }

        /* Responsive Cards Container */
        .newtoppart {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin-bottom: -30px;
            width: 100%;
        }

        .cardback {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        /* Responsive Chair */
        .chair {
            width: auto;
            height: clamp(80px, 16vh, 120px);
            max-width: 132px;
            margin-bottom: -50px;
            z-index: 2;
            object-fit: contain;
        }

        /* Responsive Card Wrapper */
        .cardshow {
            position: relative;
            display: flex;
            justify-content: center;
            margin-top: -35px;
            margin-bottom: 35px;
            z-index: 3;
            width: 100%;
            perspective: 1000px;
        }

        /* 3D Card Container */
        .card-3d {
            position: relative;
            width: clamp(60px, 14vw, 95px);
            height: clamp(85px, 18vh, 140px);
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            transform-style: preserve-3d;
            cursor: pointer;
        }

        .card-3d.flipped {
            transform: rotateY(180deg) scale(1.05);
        }

        .card-3d .card-front,
        .card-3d .card-back {
            position: absolute;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 8px;
            box-shadow: 0 10px 15px rgba(0,0,0,0.5);
        }

        .card-3d .card-front {
            transform: rotateY(180deg);
            background: white;
            border: 2px solid gold;
            overflow: hidden;
        }

        .card-3d .card-front img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .card-3d .card-back {
            transform: rotateY(0deg);
            background: linear-gradient(145deg, #2a1a3a, #1a0f2a);
            border: 2px solid gold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Aggressive Flip Animation */
        @keyframes aggressiveFlip {
            0% { transform: rotateY(0) scale(1); }
            30% { transform: rotateY(90deg) scale(1.3); filter: brightness(1.5); }
            60% { transform: rotateY(180deg) scale(1.2); filter: brightness(1.3); }
            100% { transform: rotateY(180deg) scale(1.1); }
        }

        @keyframes aggressiveFlipBack {
            0% { transform: rotateY(180deg) scale(1.1); }
            30% { transform: rotateY(90deg) scale(1.3); filter: brightness(1.5); }
            60% { transform: rotateY(0deg) scale(1.2); filter: brightness(1.3); }
            100% { transform: rotateY(0deg) scale(1); }
        }

        .aggressive-flip {
            animation: aggressiveFlip 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }

        .aggressive-flip-back {
            animation: aggressiveFlipBack 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards;
        }

        /* Winner Highlight */
        .winner-highlight {
            animation: winnerPulse 1s ease infinite;
            position: relative;
            z-index: 10;
        }

        @keyframes winnerPulse {
            0%, 100% { 
                transform: scale(1.1) rotateY(180deg); 
                filter: drop-shadow(0 0 15px gold);
            }
            50% { 
                transform: scale(1.2) rotateY(180deg); 
                filter: drop-shadow(0 0 30px gold);
            }
        }

        /* Tablet Data */
        .tabletdata {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            color: white;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            border: 2px solid gold;
            z-index: 4;
            white-space: nowrap;
        }

        /* Boards Container - Responsive */
        .footer_top {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.5rem;
            margin: 10px 0;
        }

        .box_wrapper {
            min-height: 110px;
            padding: 8px 4px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .box_wrapper_body img {
            width: clamp(22px, 4vw, 30px);
            height: clamp(22px, 4vw, 30px);
        }

        /* Header Icons - Responsive */
        .header_right .icons_header_right ul li {
            margin: 0 2px;
        }

        .setng {
            width: clamp(40px, 8vw, 55px) !important;
            height: auto;
        }

        /* Timer Display */
        .body_bottom .images {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .clock {
            width: clamp(40px, 10vw, 60px);
            height: auto;
        }

        .clock_time_count_down {
            position: absolute;
            font-size: clamp(18px, 5vw, 24px);
            color: gold;
            text-shadow: 0 0 10px rgba(255,215,0,0.5);
        }

        /* Bottom Bar - Responsive */
        .footer_bottom {
            display: flex;
            align-items: center;
            justify-content: space-around;
            margin-top: 10px;
            padding: 6px;
            background-size: 100% 100%;
        }

        .footer_bottom_right {
            display: flex;
            align-items: center;
            gap: 5px;
            flex-wrap: wrap;
        }

        .images {
            position: relative;
            cursor: pointer;
        }

        .images img {
            width: clamp(45px, 8vw, 60px);
            height: clamp(45px, 8vw, 60px);
        }

        .animation {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
        }

        /* HEIGHT BREAKPOINTS */
        @media (max-height: 325px) {
            :root {
                --card-height: 80px;
                --card-width: 55px;
            }
            
            .newtoppart {
                margin-bottom: -20px;
            }
            
            .chair {
                height: 60px;
                margin-bottom: -30px;
                max-width: 80px;
            }
            
            .card-3d {
                width: 50px;
                height: 75px;
            }
            
            .cardshow {
                margin-top: -20px;
                margin-bottom: 20px;
            }
            
            .footer_top {
                margin: 5px 0;
            }
            
            .box_wrapper {
                min-height: 80px;
                padding: 4px 2px;
            }
            
            .box_wrapper_header h2,
            .box_wrapper_footer h2 {
                font-size: 12px !important;
                margin: 2px 0 !important;
            }
            
            .footer_bottom {
                padding: 3px;
            }
            
            .images img {
                width: 35px;
                height: 35px;
            }
            
            .setng {
                width: 30px !important;
            }
            
            .topplayer {
                padding: 2px 5px;
                font-size: 9px;
            }
            
            .topplayer img {
                width: 18px;
                height: 18px;
            }
        }

        @media (min-height: 326px) and (max-height: 375px) {
            .chair {
                height: 75px;
                margin-bottom: -40px;
                max-width: 100px;
            }
            
            .card-3d {
                width: 60px;
                height: 90px;
            }
            
            .box_wrapper {
                min-height: 95px;
            }
        }

        @media (min-height: 376px) and (max-height: 450px) {
            .chair {
                height: 90px;
                max-width: 115px;
            }
            
            .card-3d {
                width: 70px;
                height: 105px;
            }
        }

        @media (min-height: 451px) and (max-height: 550px) {
            .chair {
                height: 105px;
            }
            
            .card-3d {
                width: 85px;
                height: 125px;
            }
        }

        /* WIDTH BREAKPOINTS */
        @media (max-width: 340px) {
            .chair {
                height: 70px;
                max-width: 85px;
                margin-bottom: -35px;
            }
            
            .card-3d {
                width: 52px;
                height: 78px;
            }
            
            .images img {
                width: 38px;
                height: 38px;
            }
            
            .setng {
                width: 28px !important;
            }
            
            .footer_bottom_right {
                gap: 3px;
            }
        }

        @media (min-width: 341px) and (max-width: 375px) {
            .card-3d {
                width: 65px;
                height: 98px;
            }
        }

        /* Existing class overrides */
        .w-100 {
            width: 100% !important;
        }

        .d-flex {
            display: flex !important;
        }

        .text-center {
            text-align: center !important;
        }

        .d-none {
            display: none !important;
        }

        /* Fix for top players */
        .topplayer {
            width: fit-content;
            padding: 3px 7px;
            text-align: center;
            border-radius: 10px;
            margin-bottom: 2px;
            background-image: url(https://broadlive.xyz/public/game/teenpatti/image/profile.png);
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
        }

        .topplayer p {
            margin: 0px;
            font-size: clamp(9px, 1.8vh, 12px) !important;
        }

        .topplayer img {
            width: clamp(20px, 4vh, 28px);
            height: clamp(20px, 4vh, 28px);
            border-radius: 50%;
        }
    </style>
</head>
<body>

    <link rel="stylesheet" href="{{asset('public/game/teenpatti/')}}/css\saven_win.css">
    <style>
        .text-danger {
            color: #EB00CC!important;
        }
        .text-success {
            color: #0BB568!important;
        }
        .zoomeffectleft {
            font-weight: 700;
            position: absolute;
            margin-left: -1px;
            margin-top: 0px;
            font-size: 15px;
        }
        .zoomeffectright {
            font-weight: 700;
            position: absolute;
            margin-left: -81px;
            margin-top: 0px;
            font-size: 15px;
        }
        .flipped {
            transform: rotateY(90deg);
        }
    </style>

    <input value="{{ $authkey }}" name="email" id="authkey" hidden>
    <input value="{{$authtoken }}" name="authtoken" id="authtoken" hidden>

    <audio id="background_audio" src="#"></audio>
    <audio id="click_audio" src="#"></audio>
    <audio id="coins_audio" src="#"></audio>

    <section id="saven_winner" class="gameconatiner">
        <div class="container gamemain">
            <div class="header_r">
                <div class="header_left"></div>
                <div id="logs-container"></div>
                <div class="header_right">
                    <div style="position: relative" class="icons icons_header_right">
                        <ul class="header_right_icons_ul d-flex" style="right: 0;z-index: 99; flex-direction: row-reverse;">
                            <li class="icons_header_right_click_4">
                                <img class="setng" src="{{URL::to('/')}}/public/game/teenpatti/image/users.png" style="width: 55px;" alt="">
                            </li>
                            <li class="icons_header_right_click_1">
                                <img class="setng" src="{{URL::to('/')}}/public/game/teenpatti/image/setting.png" style="width: 55px;" alt="">
                            </li>
                            <li class="icons_header_right_click_3">
                                <img class="setng" src="{{URL::to('/')}}/public/game/teenpatti/image/help.png" style="width: 55px;" alt="">
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="body">
                <div class="body_bottom">
                    <div style="display: none;" class="images">
                        <img class="clock" src="{{asset('public/game/teenpatti/image')}}/clock.png" alt="Saven Winner">
                        <h2 class="header clock_time_count_down"></h2>
                    </div>
                </div>
            </div>

            <div class="footer">
                <!-- CARDS SECTION - UPDATED WITH 3D CONTAINERS -->
                <div class="newtoppart">
                    <!-- Player 1 - Red Chair -->
                    <div class="cardback text-center">
                        <div>
                            <img class="w-100 chair" style="max-width:132px;position: relative; margin-bottom: -80px;" src="{{asset('public/game/teenpatti/image')}}/ChairRed.png" alt="">
                        </div>
                        <div class="d-flex cardshow" style="justify-content: center; align-items: center; margin-top: -45px; margin-bottom: 45px;">
                            <div class="card-3d" id="card1">
                                <div class="card-front">
                                    <img style="z-index: 0; width: 100%; height: 100%; object-fit: contain;" class="backcard" id="a1" src="{{asset('public/game/teenpatti/image')}}/backcardnew.png" alt="">
                                </div>
                                <div class="card-back"></div>
                            </div>
                            <p id="adata" class="tabletdata d-none"></p>
                        </div>
                    </div>

                    <!-- Player 2 - Blue Chair -->
                    <div class="cardback text-center">
                        <div>
                            <img class="w-100 chair" style="max-width:132px;position: relative; margin-bottom: -80px;" src="{{asset('public/game/teenpatti/image')}}/ChairBlue.png" alt="">
                        </div>
                        <div class="d-flex cardshow" style="justify-content: center; align-items: center; margin-top: -45px; margin-bottom: 45px;">
                            <div class="card-3d" id="card2">
                                <div class="card-front">
                                    <img style="z-index: 0; width: 100%; height: 100%; object-fit: contain;" class="backcard" id="s1" src="{{asset('public/game/teenpatti/image')}}/backcardnew.png" alt="">
                                </div>
                                <div class="card-back"></div>
                            </div>
                            <p id="sdata" class="tabletdata d-none"></p>
                        </div>
                    </div>

                    <!-- Player 3 - Green Chair -->
                    <div class="cardback text-center">
                        <div>
                            <img class="w-100 chair" style="max-width:132px;position: relative; margin-bottom: -80px;" src="{{asset('public/game/teenpatti/image')}}/ChairGreen.png" alt="">
                        </div>
                        <div class="d-flex cardshow" style="justify-content: center; align-items: center; margin-top: -45px; margin-bottom: 45px;">
                            <div class="card-3d" id="card3">
                                <div class="card-front">
                                    <img style="z-index: 0; width: 100%; height: 100%; object-fit: contain;" class="backcard" id="w1" src="{{asset('public/game/teenpatti/image')}}/backcardnew.png" alt="">
                                </div>
                                <div class="card-back"></div>
                            </div>
                            <p id="wdata" class="tabletdata d-none"></p>
                        </div>
                    </div>
                </div>

                <!-- Betting Boards - YOUR EXISTING CODE -->
                <div class="footer_top">
                    <button class="box_wrapper" disabled style="background-image:url(https://broadlive.xyz/public/game/teenpatti/image/appleboard.png);">
                        <input type="hidden" value="apple">
                        <div class="box_wrapper_header">
                            <h2 class="header">0</h2>
                        </div>
                        <div class="box_wrapper_body" id="box_wrapper_bet_1">
                            <span class="all_batting_img_here"></span>
                        </div>
                        <div class="box_wrapper_footer">
                            <h2 class="header" id="won_bet_apple">0</h2>
                        </div>
                    </button>

                    <button class="box_wrapper" disabled style="background-image:url(https://broadlive.xyz/public/game/teenpatti/image/lemonboard.png);">
                        <input type="hidden" value="saven_win">
                        <div class="box_wrapper_header">
                            <h2 class="header">0</h2>
                        </div>
                        <div class="box_wrapper_body" id="box_wrapper_bet_2">
                            <span class="all_batting_img_here"></span>
                        </div>
                        <div class="box_wrapper_footer">
                            <h2 class="header" id="won_bet_saven_win">0</h2>
                        </div>
                    </button>

                    <button class="box_wrapper" disabled style="background-image:url(https://broadlive.xyz/public/game/teenpatti/image/board-01.png);">
                        <input type="hidden" value="watermelon">
                        <div class="box_wrapper_header">
                            <h2 class="header">0</h2>
                        </div>
                        <div class="box_wrapper_body" id="box_wrapper_bet_3">
                            <span class="all_batting_img_here"></span>
                        </div>
                        <div class="box_wrapper_footer">
                            <h2 class="header" id="won_bet_watermelon">0</h2>
                        </div>
                    </button>
                </div>

                <!-- Bottom Bar - YOUR EXISTING CODE -->
                <div class="footer_bottom">
                    <div class="footer_bottom_left">
                        <div class="footer_bottom_left_right">
                            <div class="footer_bottom_left_right_top">
                                <input type="text" name="" id="speed" value="" readonly placeholder="{{Auth::user()->name}}">
                            </div>
                            <div class="footer_bottom_left_right_bottom">
                                <img src="{{asset('public/game/teenpatti/image')}}/bt.png" alt="Saven Winner">
                                <input style="color: white" type="text" id="total_amount" value="..." disabled>
                            </div>
                        </div>
                    </div>

                    <div class="footer_bottom_right">
                        <div class="images active">
                            <input type="hidden" value="500" />
                            <img src="{{asset('public/game/teenpatti/image')}}/500.png" alt="Saven Winner">
                            <span id="btn_animation_wrapper">
                                <div class="animation">
                                    <span style="--i:1"><i class="fa-solid fa-play"></i></span>
                                    <span style="--i:2"><i class="fa-solid fa-play"></i></span>
                                    <span style="--i:3"><i class="fa-solid fa-play"></i></span>
                                    <span style="--i:4"><i class="fa-solid fa-play"></i></span>
                                    <span style="--i:5"><i class="fa-solid fa-play"></i></span>
                                </div>
                            </span>
                        </div>
                        <div class="images">
                            <input type="hidden" value="1000" />
                            <img src="{{asset('public/game/teenpatti/image')}}/1000.png" alt="Saven Winner">
                            <div id="btn_animation_wrapper"></div>
                        </div>
                        <div class="images">
                            <input type="hidden" value="10000" />
                            <img src="{{asset('public/game/teenpatti/image')}}/10k.png" alt="Saven Winner">
                            <div id="btn_animation_wrapper"></div>
                        </div>
                        <div class="images">
                            <input type="hidden" value="50000" />
                            <img src="{{asset('public/game/teenpatti/image')}}/50k.png" alt="Saven Winner">
                            <div id="btn_animation_wrapper"></div>
                        </div>
                        <div class="images">
                            <input type="hidden" value="100000" />
                            <img src="{{asset('public/game/teenpatti/image')}}/100k.png" alt="Saven Winner">
                            <div id="btn_animation_wrapper"></div>
                        </div>
                        <div class="icons_header_right_click_2">
                            <img src="{{asset('public/game/teenpatti/image')}}/ranking.png" class="rankingsdf" alt="Saven Winner">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ALL YOUR EXISTING MODALS - EXACTLY AS THEY WERE -->
    <div class="gameconatiner">
        <div id="hidden_info_here" class="Reminder_Here d-none" style="width: 60%;">
            <div style="height: 20vh" class="container">
                <div class="body">
                    <p class="title text-dark">Insuffisant coins!</p>
                </div>
            </div>
        </div>
        
        <div id="hidden_info_here" class="Server_Issue" style="display:none;width: 60%;">
            <div style="height: 20vh" class="container">
                <div class="body">
                    <p class="title text-dark">Connecting Server....</p>
                </div>
            </div>
        </div>

        <div id="hidden_info_here" class="Winner_Here d-none" style="width: 80%;">
            <div class="container" style="background:#000000a6;border:none;box-shadow:none;">
                <div class="body">
                    <div class="box_wrapper">
                        <div class="box_r"></div>
                        <div class="box_r">
                            <div class="ima">
                                <img class="img w-100 last_winner_image" id="last_winner_image" src="" alt="">
                            </div>
                            <div class="d-flex" style="">
                                <img style="max-height: 50px; width: auto;" class="w-100" id="winner1" src="{{asset('public/game/teenpatti/image')}}/backcardnew.png" alt="">
                            </div>
                            <div>
                                <img class="img w-100" style="margin-top: -40px;" src="{{asset('public/game/teenpatti/image')}}/win.png" alt="">
                            </div>
                        </div>
                        <div class="box_r"></div>
                    </div>
                    <div class="my_wining_info">
                        <div class="right">
                            <div class="images">
                                <img src="{{URL::to('/')}}/public/user.png" alt="">
                            </div>
                            <p style="color: white" class="title username4">{{Auth::user()->name}}</p>
                        </div>
                        <div class="left">
                            <li>
                                <span class="info">Bet : </span>
                                <span class="info_r myBet">...</span>
                            </li>
                            <li>
                                <span class="info">Win : </span>
                                <span class="info_r myBetWin">...</span>
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="hidden_info_here" class="Settings_Here d-none" style="width: 60%;">
            <div class="container">
                <img src="{{URL::to('/')}}/public/game/teenpatti/image/close.png" class="close_bar" style="width: 30px;" alt="">
                <div style="width: 100%" class="body">
                    <div class="music">
                        <p class="header">Music : </p>
                        <input type="checkbox" class="music_checkbox music_1_checkbox">
                    </div>
                    <div style="margin-top: 2.5rem" class="music">
                        <p class="header">Sound : </p>
                        <input type="checkbox" class="music_checkbox sound_checkbox">
                    </div>
                </div>
            </div>
        </div>

        <div id="hidden_info_here" class="Rules_here d-none" style="width: 60%;height: 80%;">
            <div class="container" style="height: 80%;">
                <img src="{{URL::to('/')}}/public/game/teenpatti/image/close.png" class="close_bar" style="width: 30px;" alt="">
                <div style="width: 100%;align-items:start;overflow-y: scroll;height: 90%;justify-content: flex-start !important;" class="body"></div>
            </div>
        </div>

        <div id="hidden_info_here" class="reward_here d-none" style="width: 55%;">
            <div style="flex-direction: unset;flex-wrap: wrap;" class="container">
                <img src="{{URL::to('/')}}/public/game/teenpatti/image/close.png" class="close_bar" style="width: 30px;" alt="">
                <div class="topbodybar" style="width: 100%; align-items: start; padding: 2px;">
                    <div class="row col-12" style="margin-left: -2px;background:#ffffff5e;border-radius: 6px;"> 
                        <div class="col-4 text-center text-white"><img src="https://broadlive.xyz/public/game/teenpatti/image/apple.png" alt="Saven Winner"></div> 
                        <div class="col-4 text-center text-white"><img src="https://broadlive.xyz/public/game/teenpatti/image/lemon.png" alt="Saven Winner"></div> 
                        <div class="col-4 text-center text-white"><img src="https://broadlive.xyz/public/game/teenpatti/image/watermelon.png" alt="Saven Winner"></div> 
                    </div>
                </div>
                <div style="width: 100%;align-items:start;overflow-y: scroll; height: 90%;" class="body"></div>
            </div>
        </div>

        <div id="hidden_info_here" class="users_here d-none" style="width: 60%;">
            <div class="container">
                <img src="{{URL::to('/')}}/public/game/teenpatti/image/close.png" class="close_bar" style="width: 30px;" alt="">
                <div style="width: 100%;align-items:start;overflow-y: scroll; height: 100%;" class="body">
                    <div class="users_box" id=""></div>
                </div>
            </div>
        </div>

        <div id="hidden_info_here" class="Reminder_Here This_is_notification d-none" style="width: 60%;">
            <div class="container">
                <div class="body">
                    <p class="title text-white"></p>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="tray_id" value="{{ time() }}">

    <!-- ADD THIS SMALL SCRIPT FOR 3D CARD ANIMATIONS - DOES NOT AFFECT EXISTING FUNCTIONS -->
    <script>
        // Helper function for aggressive flip animations
        function aggressiveFlipCard(cardElement, showFront = true) {
            if (!cardElement) return;
            
            if (showFront) {
                cardElement.classList.add('aggressive-flip');
                setTimeout(() => {
                    cardElement.classList.add('flipped');
                    cardElement.classList.remove('aggressive-flip');
                }, 400);
            } else {
                cardElement.classList.add('aggressive-flip-back');
                setTimeout(() => {
                    cardElement.classList.remove('flipped');
                    cardElement.classList.remove('aggressive-flip-back');
                }, 400);
            }
        }

        // Responsive layout handler
        function handleResponsiveLayout() {
            const height = window.innerHeight;
            const width = window.innerWidth;
            
            // Adjust card sizes based on screen height
            if (height <= 325) {
                document.querySelectorAll('.chair').forEach(chair => {
                    chair.style.maxWidth = '90px';
                    chair.style.marginBottom = '-50px';
                });
            } else if (height <= 375) {
                document.querySelectorAll('.chair').forEach(chair => {
                    chair.style.maxWidth = '110px';
                });
            } else {
                document.querySelectorAll('.chair').forEach(chair => {
                    chair.style.maxWidth = '132px';
                });
            }
            
            // Adjust for very narrow screens
            if (width <= 320) {
                document.querySelectorAll('.images img').forEach(img => {
                    if (img.closest('.footer_bottom_right')) {
                        img.style.width = '38px';
                        img.style.height = '38px';
                    }
                });
            }
        }

        // Call on load and resize
        window.addEventListener('load', handleResponsiveLayout);
        window.addEventListener('resize', handleResponsiveLayout);

        // Hook into your existing revealCards function (if needed)
        // This doesn't modify your existing functions, just adds a helper
        console.log('Responsive layout handler loaded');
    </script>

    <!-- YOUR EXISTING JAVASCRIPT - EXACTLY AS IT WAS -->
    <script>
    $(document).ready(function() {
        checkMobileScreen();
    });
    
    $(document).ready(function() {
        function checkMobileScreen() {
            var width = $(window).width();
            var noticewidth = width -100;
            var height = $(window).height();
            if ($(window).height() > 345 && $(window).width() <= 450) {
                $('.gameconatiner').css('transform', 'rotate(90deg)');
                $('.gamemain').css('min-height', width);
                $('.gamemain').css('width', height);
                $('body').css('overflow', 'visible');
                $('.topheadplayer').css('top', '10%');
                $('.topplayer').css('zoom', '120%');
                $('.cardback').css('padding', '0 20px');
                $('#s1').css('padding', '10px 20px');
                $('#a1').css('padding', '10px 20px');
                $('#w1').css('padding', '10px 20px');
                if(width < 339){
                    $('.cardback').css('padding', '0 20px');
                }
                if(width < 310){
                    $('.cardback').css('padding', '0 20px');
                }
                $('#saven_winner .container .footer .footer_bottom .footer_bottom_right').css('gap', '40px');
                $('.topplayer').css('margin-bottom', '2px');
                $('.topplayer img').css('width', '20px');
                $('.topplayer img').css('height', '20px');
                $('.topheadplayer').css('width', height);
                $('.header_r').css('width', height);
                $('#saven_winner .container .header_r .icons_header_right .header_right_icons_ul').css('flex-direction', 'row-reverse');
                $('.topplayer p').css('font-size', '10px');
                $('#hidden_info_here.reward_here .container').css('height', noticewidth);
                $('#hidden_info_here.users_here .container').css('height', noticewidth);
                $('#hidden_info_here.Rules_here .container').css('height', noticewidth);
                $('#hidden_info_here.reward_here .container .body').css('height', '80%');
                if(width < 310){
                    $('#saven_winner .container .footer .footer_top').css('zoom', '80%');
                    $('.newtoppart').css('zoom', '80%');
                    $('.chair').css('max-width', '100px');
                    $('.chair').css('margin-bottom', '-60px');
                }
            }
            else if ($(window).height() <= 345 && $(window).width() <= 1024) {
                $('.gameconatiner').css('transform', 'none');
                $('.chair').css('max-width', '100px');
                $('.chair').css('margin-bottom', '-60px');
                $('#saven_winner .container .footer .footer_top').css('margin-top', '-25px');
                $('#saven_winner .container .footer .footer_bottom .footer_bottom_right').css('gap', '10px');
                $('#saven_winner .container .footer .footer_top').css('zoom', '90%');
                $('.newtoppart').css('zoom', '80%');
                $('.topheadplayer').css('top', '5%');
                $('.topplayer').css('margin-bottom', '2px');
                $('.topplayer img').css('width', '20px');
                $('.topplayer img').css('height', '20px');
                $('.topplayer p').css('font-size', '10px');
                $('#s1').css('padding', '10px 4px');
                $('#a1').css('padding', '10px 4px');
                $('#w1').css('padding', '10px 4px');
                $('#hidden_info_here.reward_here .container .body').css('height', '80%');
            } else {
                $('.gameconatiner').css('transform', 'none');
                $('.topheadplayer').css('top', '5%');
                $('.topplayer').css('margin-bottom', '10px');
                $('.topplayer img').css('width', '40px');
                $('.topplayer img').css('height', '40px');
                $('.topplayer p').css('font-size', '14px');
                $('#saven_winner .container .body .body_bottom .images h2.header').css('top', '250%');
            }
        }

        // Initial check
        checkMobileScreen();

        // Check on window resize
        $(window).resize(function() {
            checkMobileScreen();
        });
    });
    </script>

    <script>
    // Clear all cookies
    var cookies = document.cookie.split("; ");
    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    }
    
    $(document).ready(function(){
        css_tricks();
        $(document).click(function(event) {
            var target = $(event.target);
            var targetClass = target.attr('class');
            var rewardDiv = $('.reward_here');
            if (targetClass === "rankingsdf") {
                if($(".reward_here").css('display') == 'none') {
                    $('.reward_here').show();
                } else {
                    $('.reward_here').hide();
                }
            } else {
                $('.reward_here').hide();
            }
        });
    });
    
    $(window).resize(function(){
        css_tricks();
    });
    
    const css_tricks = () => {
        let height  = window.innerHeight;
        if(height < 400){
        } else {
        }
    }
    </script>

    <script type="text/javascript">
    var click_audio = document.getElementById('click_audio');
    var coins_audio = document.getElementById('coins_audio');
    var audio_bg = document.getElementById('background_audio');

    coins_audio.volume=0;
    click_audio.volume=0;
    audio_bg.volume=0;
    
    $(document).ready(function(){
        settimeout_here();
        get_users_amount();
        win_or_loss_calculation();
        input_online_or_oflline();
        get_fruits_results();
    });
    
    var audio_bg = document.getElementById('background_audio');
    audio_bg.volume = 0;
    
    document.addEventListener('click', function() {
        // Play the media element
    });

    $('#saven_winner .container .footer .footer_bottom .footer_bottom_right .images').click(function(){
        click_audio.play();
        $('#saven_winner .container .footer .footer_bottom .footer_bottom_right .images').removeClass('active');
        $(this).addClass('active');
        $('#saven_winner .container .footer .footer_bottom .footer_bottom_right .images #btn_animation_wrapper').html('');
        $(this).children('#btn_animation_wrapper').html('<div class="animation">' +
            '<span style="--i:1"><i class="fa-solid fa-play"></i></span>' +
            '<span style="--i:2"><i class="fa-solid fa-play"></i></span>' +
            '<span style="--i:3"><i class="fa-solid fa-play"></i></span>' +
            '<span style="--i:4"><i class="fa-solid fa-play"></i></span>' +
            '<span style="--i:5"><i class="fa-solid fa-play"></i></span>' +
        '</div>');
    });

    $('input.music_1_checkbox').click(function(){
        if($('input.music_1_checkbox').is(':checked')){
            audio_bg.play();
            audio_bg.volume=1;
        } else {
            audio_bg.volume=0;
        }
    });
    
    $('input.sound_checkbox').click(function(){
        if($('input.sound_checkbox').is(':checked')){
            click_audio.volume=1;
            coins_audio.volume=1;
        } else {
            click_audio.volume=0;
            coins_audio.volume=0;
        }
    });

    $('.icons_header_right_click_1').click(function(){
        $('.Settings_Here').removeClass('d-none');
    });
    
    $('.icons_header_right_click_2').click(function(){
        $('.reward_here').removeClass('d-none');
    });

    $('.icons_header_right_click_3').click(function(){
        $('.Rules_here').removeClass('d-none');
        get_last_my_result();
    });

    $('.icons_header_right_click_4').click(function(){
        $('.users_here').removeClass('d-none');
        input_online_or_oflline_get_users();
    });

    $('#hidden_info_here.Settings_Here .container .close_bar').click(function(){
        $('#hidden_info_here.Settings_Here').addClass('d-none');
    });

    $('#hidden_info_here.reward_here .container .close_bar').click(function(){
        $('#hidden_info_here.reward_here').addClass('d-none');
    });

    $('#hidden_info_here.Rules_here .container .close_bar').click(function(){
        $('#hidden_info_here.Rules_here').addClass('d-none');
    });

    $('#hidden_info_here.users_here .container .close_bar').click(function(){
        $('#hidden_info_here.users_here').addClass('d-none');
    });

    $('#saven_winner .container .footer .footer_bottom .footer_bottom_right .images').click(function(){
        $('#saven_winner .container .footer .footer_top .box_wrapper .box_wrapper_body img.coin_box3').css('animation', 'coin_box_2_anime 1s ease forwards');
        setTimeout(() => {
            var random_number = 1;
            $('#saven_winner .container .footer .footer_top .box_wrapper .box_wrapper_body img.coin_box3').css({'animation' : 'none', 'top' : ''+random_number+'%', 'left' : ''+random_number+'%'});
        }, 1000);
    });

    const settimeout_here = () => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/tray_id",
            "data" : {
                'tray_id' : $('#tray_id').val(),
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            }, crossDomain: true,
            headers: {
                'Access-Control-Allow-Origin': '*'
            },
            success:function(res){
                let st=res.st;
                let user_id={{ Auth::id() }};
                let data=res.data;
                let nowTime = res.currentTimeInSeconds;
                if(st === true){
                    $('.Server_Issue').hide();
                    var x = setInterval(() => {
                        nowTime++; 
                        let time = Number(data - nowTime).toFixed(0);
                        $('#saven_winner .container .body .body_bottom .images').css('display', 'none');
                        $('#saven_winner .container .footer .footer_top .box_wrapper').attr('disabled', true);
                        $('#tray_id').val(data);

                        if(time > 6 && time < 22){
                            $('#saven_winner .container .body .body_bottom .images').css('display', 'block');
                            $('#saven_winner .container .footer .footer_top .box_wrapper').attr('disabled', false);
                            $('.clock_time_count_down').html(time-6);
                        }
                  
                        if(time == 26){
                            get_winner_info();
                            $('.Winner_Here').removeClass('d-none');
                            get_fruits_results();
                            setTimeout(() => {
                                $('.Winner_Here').addClass('d-none');
                            }, 4000);
                        }
                        
                        if(time == 22){
                            win_or_loss_calculation();
                            input_online_or_oflline();
                            $('.This_is_notification').removeClass('d-none');
                            $('.This_is_notification .body .title').html('Start Batting');
                            setTimeout(() => {
                                $('.This_is_notification').addClass('d-none');
                            }, 1500);
                        }
                  
                        if(time == 6){
                            $('#saven_winner .container .footer .footer_top .box_wrapper').attr('disabled', true);
                            $('.This_is_notification').removeClass('d-none');
                            $('.This_is_notification .body .title').html('Stop Batting');
                            $('#saven_winner .container .footer .footer_top .box_wrapper').removeClass('active');
                            win_pred();
                        }
                        
                        if (time ==3) {
                            result_final();
                        }
                   
                        if (time ==2) {
                            setTimeout(() => {
                                saven_win_get_winner();
                                $('.cardshow').addClass('rotate-image');
                                $('.This_is_notification').addClass('d-none');
                            }, 1000);
                        }
                        
                        if(time < 0){
                            clearInterval(x);
                        }
                    }, 1000);
                } else {
                    settimeout_here();
                    $('.Server_Issue').show();
                }
            },
            error: function() {
                // $('.Server_Issue').show();
            }
        });
    }

    const saven_win_get_winner = () => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/winner_saven_win",
            "data" : {
                'tray_id' : $('#tray_id').val(),
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            },
            success:function(res){
                if(res.st === true){
                    $('.Server_Issue').hide();
                    setTimeout(() => {
                        settimeout_here();
                        $('#saven_winner .container .body').css('transform', 'translateY(0px)');
                        
                        let span_num, spn_img;
                        if(res.data[0].Table == 1){
                            span_num = 1;
                            spn_img = 5;
                        } else if(res.data[0].Table == 2){
                            span_num = 2;
                            spn_img = 3;
                        } else {
                            span_num = 3;
                            spn_img = 1;
                        }
                        
                        let oldimage = '{{asset('public/game/teenpatti/image')}}/backcardnew.png';
                        $('#last_winner_image').attr('src', "");

                        setTimeout(() => {
                            $('.cardshow').removeClass('rotate-image');

                            // Rotate cards one by one with delay
                            $('#a1').addClass('flipped');
                            setTimeout(() => {
                                $('#a1').attr('src', '{{ asset('public/game/teenpatti/image/cardset') }}/' + res.data[0].FirstPairCards + '.png').fadeIn(700);
                                $('#a1').removeClass('flipped');

                                $('#s1').addClass('flipped');
                                setTimeout(() => {
                                    $('#adata').html(res.data[0].FirstPair);
                                    $('#adata').removeClass('d-none').fadeIn(700);
                                }, 700);
                                setTimeout(() => {
                                    $('#s1').attr('src', '{{ asset('public/game/teenpatti/image/cardset') }}/' + res.data[0].SecondPairCards + '.png').fadeIn(700);
                                    $('#s1').removeClass('flipped');

                                    $('#w1').addClass('flipped');
                                    setTimeout(() => {
                                        $('#sdata').html(res.data[0].SecondPair);
                                        $('#sdata').removeClass('d-none').fadeIn(700);
                                    }, 700);
                                    setTimeout(() => {
                                        $('#w1').attr('src', '{{ asset('public/game/teenpatti/image/cardset') }}/' + res.data[0].ThirdPairCards + '.png').fadeIn(700);
                                        $('#w1').removeClass('flipped');
                                        setTimeout(() => {
                                            $('#wdata').html(res.data[0].ThirdPair);
                                            $('#wdata').removeClass('d-none').fadeIn(700);
                                        }, 700);
                                    }, 1000);
                                }, 1000);
                            }, 1000);
                        }, 2000);

                        setTimeout(() => {
                            $('.backcard').css('filter', 'grayscale(100%)');
                            $('#saven_winner .container .footer .footer_top .box_wrapper').css('filter', 'grayscale(100%)');

                            if(span_num == 1){
                                $('#a1').css({'animation': 'box_animation_apple 4s ease forwards', 'filter': 'grayscale(0%)'});
                            } else if(span_num == 2){
                                $('#s1').css({'animation': 'box_animation_apple 4s ease forwards', 'filter': 'grayscale(0%)'});
                            } else {
                                $('#w1').css({'animation': 'box_animation_apple 4s ease forwards', 'filter': 'grayscale(0%)'});
                            }

                            $('#saven_winner .container .footer .footer_top .box_wrapper:nth-child('+span_num+')').css({'animation': 'box_animation_apple 4s ease forwards', 'filter': 'grayscale(0%)'});

                            setTimeout(() => {
                                $('#saven_winner .container .footer .footer_top .box_wrapper:nth-child('+span_num+')').css({'animation': 'none'});
                                let width = $(window).width();
                                let height = $(window).height(); 
                                $('#saven_winner .container .footer .footer_top .box_wrapper').css('filter', 'grayscale(0%)');

                                $('#saven_winner .container .footer .footer_top .box_wrapper .box_wrapper_header .header, #saven_winner .container .footer .footer_top .box_wrapper .box_wrapper_footer .header').html('00');
                                $('.all_batting_img_here').html('');
                                $('.tabletdata').addClass('d-none');
                                $('#adata').html('');
                                $('#sdata').html('');
                                $('#wdata').html('');
                                $('.backcard').attr('src', oldimage);
                                $('.backcard').css('filter', 'grayscale(0%)');

                                $('#a1').css({'animation': '', 'filter': 'grayscale(0%)'});
                                $('#s1').css({'animation': '', 'filter': 'grayscale(0%)'});
                                $('#w1').css({'animation': '', 'filter': 'grayscale(0%)'});
                            }, 4000);
                        }, 7000);
                    }, 500);
                } else {
                    saven_win_get_winner();
                }
            },
            error: function() {
                // $('.Server_Issue').show();
            }
        });
    }

    const insert_bettingapple = (Amount, betting_to) => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/fortune_insert",
            "data" : {
                'tray_id' : $('#tray_id').val(),
                'amount' : Amount,
                'pot_no' : betting_to,
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            },
            success:function(res){
                $('.Server_Issue').hide();
            },
            error: function() {
                $('.Server_Issue').show();
            }
        });
    }

    const robot = () => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/robot/",
            "data" : {
                'tray_id' : $('#tray_id').val(),
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            },
            success:function(res){
                $('.Server_Issue').hide();
                if(res.st == true){
                    // $('#total_amount').val(res.balance);
                }
            },
            error: function() {
                // $('.Server_Issue').show();
            }
        });
    }

    const insert_bettingsaven_winner = (Amount, betting_to) => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/fortune_insert",
            "data" : {
                'tray_id' : $('#tray_id').val(),
                'amount' : Amount,
                'pot_no' : betting_to,
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            },
            success:function(res){
                $('.Server_Issue').hide();
            },
            error: function() {
                $('.Server_Issue').show();
            }
        });
    }

    const get_users_amount = () => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/user?authkey=" + $('#authkey').val() + "&authtoken=" + $('#authtoken').val(),
            success:function(res){
                $('.Server_Issue').hide();
                if(res.st == true){
                    $('#total_amount').val(res.balance);
                } else {
                    $('.Server_Issue').show();
                }
            },
            error: function() {
                $('.Server_Issue').show();
            }
        });
    }

    const win_or_loss_calculation = () => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/win_or_loss_calculation/",
            "data" : {
                'tray_id' : $('#tray_id').val(),
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            },
            success:function(res){
                $('.Server_Issue').hide();
                $('#total_amount').val(res.balance);
            },
            error: function() {
                // $('.Server_Issue').show();
            }
        });
    }

    const result_final = () => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/result_final/",
            "data" : {
                'tray_id' : $('#tray_id').val(),
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            },
            success:function(res){
                $('.Server_Issue').hide();
            },
            error: function() {
                // $('.Server_Issue').show();
            }
        });
    }

    const win_pred = () => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/win_pred/",
            "data" : {
                'tray_id' : $('#tray_id').val(),
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            },
            success:function(res){
                $('.Server_Issue').hide();
            },
            error: function() {
                // $('.Server_Issue').show();
            }
        });
    }

    const get_winner_info = () => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/get_winner_info/",
            "data" : {
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            },
            success:function(res){ 
                $('.Server_Issue').hide();
                if(res.last_winner_image == "apple"){
                    $('#last_winner_image').attr('src',"{{asset('public/game/teenpatti/')}}/image/ChairRed.png");
                } else if(res.last_winner_image == "watermelon"){
                    $('#last_winner_image').attr('src',"{{asset('public/game/teenpatti/')}}/image/ChairGreen.png");
                } else if(res.last_winner_image == "saven_win"){
                    $('#last_winner_image').attr('src',"{{asset('public/game/teenpatti/')}}/image/ChairBlue.png");
                }
                $('.Winner_Here .my_wining_info .myBet').html(res.my_tota_bet);
                $('.Winner_Here .my_wining_info .myBetWin').html(res.my_tota_bet_winning);
            },
            error: function() {
                $('.Server_Issue').show();
            }
        });
    }

    const get_fruits_results = () => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/wining_fruits",
            "data" : {
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            },
            success:function(res){
                const rewards = res.data.map((curE) => {
                    if(curE.winner == "watermelon"){
                        return '<div class="row col-12" style="margin-left:  -2px;background:#ffffff5e;border-radius: 6px;"> <div class="col-4 text-center text-white" style="">-</div> <div class="col-4 text-center text-white" style="">-</div> <div class="col-4 text-center " style="color: red !important; font-size: 13px; font-family: cursive; font-weight: bold;">Win</div> </div>';
                    } else if(curE.winner == "saven_win"){
                        return '<div class="row col-12" style="margin-left: -2px;background:#ffffff5e;border-radius: 6px;"> <div class="col-4 text-center text-white" style="">-</div> <div class="col-4 text-center " style="color: red !important; font-size: 13px; font-family: cursive; font-weight: bold;">Win</div> <div class="col-4 text-center text-white" style="">-</div> </div>';
                    } else {
                        return '<div class="row col-12" style="margin-left: -2px;background:#ffffff5e;border-radius: 6px;"> <div class="col-4 text-center" style="color: red !important; font-size: 13px; font-family: cursive; font-weight: bold;">Win</div> <div class="col-4 text-center text-white" style="">-</div> <div class="col-4 text-center text-white" style="">-</div> </div>';
                    }
                });
                $('.reward_here .body').html(rewards);
                $('.apple_percentage').html(res.apple_parcentage+"%");
                $('.77win_percentage').html(res.lamon_parcentage+"%");
                $('.watermelon_percentage').html(res.watermellon_parcentage+"%");
            }
        });
    }

    $(document).ready(function() {
        $("#saven_winner .container .footer .footer_top .box_wrapper").click(function() {
            if (isNaN(Number($("#total_amount").val()))) {
                return $(".This_is_notification").removeClass("d-none"), $(".This_is_notification .body .title").html("Please Refrash Your Game!"), setTimeout(() => {
                    $(".This_is_notification").addClass("d-none")
                }, 500), !1;
            }

            if (Number($("#total_amount").val()) - Number($("#saven_winner .container .footer .footer_bottom .footer_bottom_right .images.active").children("input").val()) < 0 || Number($("#total_amount").val()) < 1) return $(".This_is_notification").removeClass("d-none"), $(".This_is_notification .body .title").html("Insuffisant coins!"), setTimeout(() => {
                $(".This_is_notification").addClass("d-none")
            }, 500), !1;
            
            $(this).children("input").val() == "apple" ? $("#saven_winner .container .footer .footer_top .box_wrapper:nth-child(1) .box_wrapper_footer .header").html(Number($("#saven_winner .container .footer .footer_top .box_wrapper:nth-child(1) .box_wrapper_footer .header").html()) + Number($("#saven_winner .container .footer .footer_bottom .footer_bottom_right .images.active").children("input").val())) : $(this).children("input").val() == "saven_win" ? $("#saven_winner .container .footer .footer_top .box_wrapper:nth-child(2) .box_wrapper_footer .header").html(Number($("#saven_winner .container .footer .footer_top .box_wrapper:nth-child(2) .box_wrapper_footer .header").html()) + Number($("#saven_winner .container .footer .footer_bottom .footer_bottom_right .images.active").children("input").val())) : $("#saven_winner .container .footer .footer_top .box_wrapper:nth-child(3) .box_wrapper_footer .header").html(Number($("#saven_winner .container .footer .footer_top .box_wrapper:nth-child(3) .box_wrapper_footer .header").html()) + Number($("#saven_winner .container .footer .footer_bottom .footer_bottom_right .images.active").children("input").val())), $("#total_amount").val(Number($("#total_amount").val()) - Number($("#saven_winner .container .footer .footer_bottom .footer_bottom_right .images.active").children("input").val())), $.ajax({
                method: "get",
                url: "https://broadlive.xyz/teenpatti/fortune_insert",
                data: {
                    'authkey': $('#authkey').val(),
                    'authtoken': $('#authtoken').val(),
                    tray_id: $('#tray_id').val(),
                    bord_name: $(this).children("input").val(),
                    amount: $("#saven_winner .container .footer .footer_bottom .footer_bottom_right .images.active").children("input").val()
                },
                success: function(i) {
                    // $("#total_amount").val(i.balance);
                    // $("#won_bet_apple").val(i.apple);
                    // $("#won_bet_watermelon").val(i.watermelon);
                    // $("#won_bet_saven_win").val(i.lemon);
                }
            })
        });
    });

    const input_online_or_oflline = () => {
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/fortune_user_activity",
            "data" : {
                tray_id: $('#tray_id').val(),
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            },
            success:function(res){
                if (res.data[0]) {
                    $('#top_one').attr('src','https://broadlive.xyz/'+res.data[0].profile);
                    $('#top_one_id').val(res.data[0].id);
                }
                if (res.data[1]) {
                    $('#top_two_id').val(res.data[1].id);
                    $('#top_two').attr('src', 'https://broadlive.xyz/'+res.data[1].profile);
                }
                if (res.data[2]) {
                    $('#top_three_id').val(res.data[2].id);
                    $('#top_three').attr('src','https://broadlive.xyz/'+res.data[2].profile );
                }
                if (res.data[3]) {
                    $('#top_four_id').val(res.data[3].id);
                    $('#top_four').attr('src','https://broadlive.xyz/'+res.data[3].profile);
                }
            }
        });
    }

    const input_online_or_oflline_get_users = () => {
        $('.users_here .users_box').html('<h2 class="title">Loadding...</h2>');
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/fortune_all_active_users",
            "data" : {},
            success:function(res){
                $('#hidden_info_here.users_here .users_box')
                const data = res.data.map((curE) => {
                    return '<div class="box_r"><img style="width: 7rem; height: 5rem; position: absolute;" src="https://broadlive.xyz/public/game/teenpatti/image/profile.png"><img src="https://broadlive.xyz/'+  curE.profile +'" alt=""><p class="title">'+curE.name+'</p></div>';;
                });
                $('.users_here .users_box').html(data);
            }
        });
    }

    const get_last_my_result = () => {
        $('.users_here .users_box').html('<h2 class="title">Loadding...</h2>');
        $.ajax({
            "method" : "get",
            "url" : "https://broadlive.xyz/teenpatti/last_user_result",
            "data" : {
                'authkey': $('#authkey').val(),
                'authtoken': $('#authtoken').val(),
            },
            success:function(res){
                const rewards = res.data.map((curE) => {
                    let result;
                    if (curE.status == 1) {
                        result = "win";
                    } else if (curE.status == 10) {
                        result = "Loss";
                    } else {
                        result = "Hold";
                    }

                    if (curE.pot_no === "watermelon") {
                        return `
                            <div class="row col-12" style="margin-left: -2px; background: #ffffff5e; border-radius: 4px; border-radius: 5px; margin-bottom: 5px;">
                                <div class="col-4 text-center text-dark">${curE.tray_id}</div> 
                                <div class="col-3 text-center text-dark">
                                    <img src="https://broadlive.xyz/public/game/teenpatti/image/watermelon.png" alt="Saven Winner" style="width: 21px;">
                                </div> 
                                <div class="col-2 text-center text-dark">${result}</div>
                                <div class="col-3 text-center text-dark">${curE.amount}</div>
                            </div>
                        `;
                    } else if (curE.pot_no === "saven_win") {
                        return `
                            <div class="row col-12" style="margin-left: -2px; background: #ffffff5e; border-radius: 4px; border-radius: 5px; margin-bottom: 5px;">
                                <div class="col-4 text-center text-dark">${curE.tray_id}</div> 
                                <div class="col-3 text-center text-dark">
                                    <img src="https://broadlive.xyz/public/game/teenpatti/image/lemon.png" alt="Saven Winner" style="width: 21px;">
                                </div>
                                <div class="col-2 text-center text-dark">${result}</div> 
                                <div class="col-3 text-center text-dark">${curE.amount}</div>
                            </div>
                        `;
                    } else {
                        return `
                            <div class="row col-12" style="margin-left: -2px; background: #ffffff5e; border-radius: 4px; border-radius: 5px; margin-bottom: 5px;">
                                <div class="col-4 text-center text-dark">${curE.tray_id}</div> 
                                <div class="col-3 text-center text-dark">
                                    <img src="https://broadlive.xyz/public/game/teenpatti/image/apple.png" alt="Saven Winner" style="width: 21px;">
                                </div> 
                                <div class="col-2 text-center text-dark">${result}</div>
                                <div class="col-3 text-center text-dark">${curE.amount}</div>
                            </div>
                        `;
                    }
                });
                $('.Rules_here .body').html(rewards);
            }
        });
    }

    // Remove all cache from localStorage
   // localStorage.clear();
    // Remove all cache from sessionStorage
    //sessionStorage.clear();
    </script>
</body>
</html>