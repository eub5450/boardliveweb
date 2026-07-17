<style id="game-final-mobile-fit-v2">
  html,
  body,
  body *,
  .app,
  .game-container,
  #viewport,
  #stage,
  #stageWrap,
  .modal,
  .overlay,
  .history-modal,
  .appModal,
  .popup-backdrop,
  .audio-popup-overlay,
  .modal-card,
  .popup,
  .history-card,
  .modalCard,
  .audio-popup,
  .pro-phase-popup,
  .history-table-wrap,
  .modalTableWrap,
  .modal-table-wrap,
  .historyTableWrap,
  .history-stack,
  .modalBody,
  .utility-list,
  .winner-list,
  .active-user-grid,
  .profile-grid,
  .playerGrid,
  .playerRosterGrid,
  .playerListGrid,
  .users-card-grid,
  .settingsGrid,
  .modalGrid,
  .tile-grid,
  .trendBoardTable,
  .teen-trend-roadmap,
  .chip-scroll{
    scrollbar-width:none !important;
    -ms-overflow-style:none !important;
  }
  .route-coin,
  .coin-fly,
  .spark,
  .fruit-rain,
  .cinema-fruit,
  .fruitConfetti,
  .winnerCoin,
  .winner-spark,
  .flying-coin,
  .flyingChip,
  .payoutChipGhost,
  .payout-chip-ghost,
  .coin-rain,
  .coin-sand,
  .chipTrailSpark,
  .betImpact,
  .bridge-win-spark,
  .bridge-win-crown,
  .payoutFlyAmount,
  .payout-fly-amount{
    contain:layout paint !important;
    will-change:transform,opacity !important;
    pointer-events:none !important;
  }
  .modal.start-pop.show,
  .modal.stop-pop.show,
  .modal.winner-pop.show,
  .modal.loss-pop.show,
  .modal.loser-pop.show,
  .modal.no-bid-pop.show,
  #modalStart.show,
  #modalStop.show,
  #modalWin.show,
  #modalLoss.show,
  #modalNoBid.show{
    pointer-events:none !important;
  }
  .modal.start-pop.show .modal-card,
  .modal.stop-pop.show .modal-card,
  .modal.winner-pop.show .modal-card,
  .modal.loss-pop.show .modal-card,
  .modal.loser-pop.show .modal-card,
  .modal.no-bid-pop.show .modal-card,
  #modalStart.show .modal-card,
  #modalStop.show .modal-card,
  #modalWin.show .modal-card,
  #modalLoss.show .modal-card,
  #modalNoBid.show .modal-card{
    pointer-events:none !important;
  }
  @media (max-height:520px),(max-width:430px),(prefers-reduced-motion:reduce){
    .cinema-fruit:nth-child(n+7),
    .fruit-rain:nth-child(n+9),
    .fruitConfetti:nth-child(n+9),
    .winnerCoin:nth-child(n+7),
    .spark:nth-child(n+5),
    .chipTrailSpark:nth-child(n+5),
    .coin-rain:nth-child(n+9),
    .coin-sand:nth-child(n+9){
      display:none !important;
    }
  }
  html::-webkit-scrollbar,
  body::-webkit-scrollbar,
  body *::-webkit-scrollbar,
  .app::-webkit-scrollbar,
  .game-container::-webkit-scrollbar,
  #viewport::-webkit-scrollbar,
  #stage::-webkit-scrollbar,
  #stageWrap::-webkit-scrollbar,
  .modal::-webkit-scrollbar,
  .overlay::-webkit-scrollbar,
  .history-modal::-webkit-scrollbar,
  .appModal::-webkit-scrollbar,
  .popup-backdrop::-webkit-scrollbar,
  .audio-popup-overlay::-webkit-scrollbar,
  .modal-card::-webkit-scrollbar,
  .popup::-webkit-scrollbar,
  .history-card::-webkit-scrollbar,
  .modalCard::-webkit-scrollbar,
  .audio-popup::-webkit-scrollbar,
  .pro-phase-popup::-webkit-scrollbar,
  .history-table-wrap::-webkit-scrollbar,
  .modalTableWrap::-webkit-scrollbar,
  .modal-table-wrap::-webkit-scrollbar,
  .historyTableWrap::-webkit-scrollbar,
  .history-stack::-webkit-scrollbar,
  .modalBody::-webkit-scrollbar,
  .utility-list::-webkit-scrollbar,
  .winner-list::-webkit-scrollbar,
  .active-user-grid::-webkit-scrollbar,
  .profile-grid::-webkit-scrollbar,
  .playerGrid::-webkit-scrollbar,
  .playerRosterGrid::-webkit-scrollbar,
  .playerListGrid::-webkit-scrollbar,
  .users-card-grid::-webkit-scrollbar,
  .settingsGrid::-webkit-scrollbar,
  .modalGrid::-webkit-scrollbar,
  .tile-grid::-webkit-scrollbar,
  .trendBoardTable::-webkit-scrollbar,
  .teen-trend-roadmap::-webkit-scrollbar,
  .chip-scroll::-webkit-scrollbar{
    width:0 !important;
    height:0 !important;
    display:none !important;
    background:transparent !important;
  }
  @media (max-width:920px), (max-height:760px){
    html,
    body{
      width:100vw !important;
      height:100dvh !important;
      max-width:100vw !important;
      max-height:100dvh !important;
      overflow:hidden !important;
      overscroll-behavior:none !important;
      touch-action:manipulation;
    }
    body{
      margin:0 !important;
      min-height:100dvh !important;
    }
    img,
    svg,
    canvas,
    video{
      max-width:100%;
    }
    .app,
    .game-container,
    #viewport,
    #stageWrap{
      width:100vw !important;
      max-width:100vw !important;
      height:100dvh !important;
      max-height:100dvh !important;
      overflow:hidden !important;
    }
    .app,
    .game-container,
    #stage{
      contain:layout paint;
    }
    .modal,
    .overlay,
    .history-modal,
    .appModal,
    .popup-backdrop,
    .audio-popup-overlay{
      width:100vw !important;
      max-width:100vw !important;
      min-width:0 !important;
      overflow:hidden !important;
      overscroll-behavior:contain !important;
      max-height:100dvh !important;
    }
    .modal-card,
    .popup,
    .history-card,
    .modalCard,
    .audio-popup,
    .pro-phase-popup{
      box-sizing:border-box !important;
      min-width:0 !important;
      width:auto;
      max-width:calc(100vw - 20px) !important;
      max-height:calc(100dvh - 20px) !important;
      overflow-x:hidden !important;
      overflow-y:auto !important;
      overscroll-behavior-x:none !important;
      overscroll-behavior-y:contain !important;
      -webkit-overflow-scrolling:touch;
    }
    .modal-card *,
    .popup *,
    .history-card *,
    .modalCard *,
    .audio-popup *,
    .pro-phase-popup *{
      min-width:0;
      max-width:100%;
      box-sizing:border-box;
    }
    .history-table-wrap,
    .modalTableWrap,
    .modal-table-wrap,
    .historyTableWrap,
    .history-stack,
    .modalBody,
    .utility-list,
    .winner-list,
    .active-user-grid,
    .profile-grid,
    .playerGrid,
    .playerRosterGrid,
    .playerListGrid,
    .users-card-grid,
    .settingsGrid,
    .modalGrid,
    .tile-grid{
      min-width:0 !important;
      max-width:100% !important;
      overflow-x:hidden !important;
      overscroll-behavior-x:none !important;
    }
    .history-table,
    .modalTable,
    .modal-table,
    .historyTable,
    .history-card table,
    .modal-card table,
    .modalCard table{
      width:100% !important;
      max-width:100% !important;
      min-width:0 !important;
      table-layout:fixed !important;
    }
    .history-table th,
    .history-table td,
    .modalTable th,
    .modalTable td,
    .modal-table th,
    .modal-table td,
    .historyTable th,
    .historyTable td,
    .history-card th,
    .history-card td,
    .modalCard th,
    .modalCard td{
      white-space:normal !important;
      overflow-wrap:anywhere !important;
      word-break:break-word !important;
    }
  }

  @media (max-height:450px){
    html,
    body{
      height:100dvh !important;
      max-height:100dvh !important;
      overflow:hidden !important;
    }

    /* Teen Patti */
    .game-container .top-bar{min-height:42px !important;padding:5px 8px !important}
    .game-container .coin-section{min-width:88px !important;min-height:30px !important;padding:4px 8px !important}
    .game-container .coin-amount{font-size:.72rem !important}
    .game-container .icon-btn{width:30px !important;height:30px !important}
    .game-container .top-stack{top:40px !important;gap:1px !important}
    .game-container .status-strip{gap:3px !important}
    .game-container .status-pill{padding:3px 6px !important;font-size:.42rem !important;letter-spacing:0 !important}
    .game-container .timer-orb,
    .game-container .gf-premium-clock{width:48px !important;height:48px !important;min-width:48px !important;min-height:48px !important}
    .game-container .bottom-stack{bottom:calc(var(--chips-bar-h,46px) + env(safe-area-inset-bottom)) !important;gap:1px !important}
    .game-container .pot{min-height:66px !important;padding:2px 2px 0 !important}
    .game-container .chair{display:none !important}
    .game-container .cards{height:40px !important;min-height:40px !important}
    .game-container .board{min-height:44px !important;padding:4px 3px !important;border-radius:10px !important}
    .game-container .board-payout{display:none !important}
    .game-container .chips-bar{min-height:calc(var(--chips-bar-h,46px) + env(safe-area-inset-bottom)) !important;max-height:calc(var(--chips-bar-h,46px) + env(safe-area-inset-bottom)) !important;overflow:hidden !important}
    .game-container .chips-bar .chip,
    .game-container .chips-bar .tool-btn,
    .game-container .fast-bid-btn{width:30px !important;height:30px !important;flex-basis:30px !important}

    /* Lucky77 shared wheel rooms */
    .shell{gap:4px !important;padding:4px 6px calc(var(--safe-bottom,0px) + 4px) !important}
    .topbar{min-height:34px !important;gap:4px !important}
    .balance-card{min-height:32px !important;padding:5px 7px !important;border-radius:13px !important}
    .balance-value{font-size:14px !important;gap:5px !important}
    .balance-value .coin{width:18px !important;height:18px !important}
    .top-actions{display:none !important}
    .topbar-meta{display:none !important}
    .hero-zone{gap:3px !important}
    .hero-panel{padding:2px !important;border-radius:16px !important}
    .wheel-wrap{max-width:min(42vw,128px) !important;max-height:min(42vw,128px) !important}
    .recent-strip{display:none !important}
    .bets{min-height:44px !important;gap:4px !important}
    .bet-card{min-height:44px !important;padding:4px 3px !important;border-radius:10px !important}
    .bet-icon-wrap{width:24px !important;height:24px !important}
    .fruit-icon{width:20px !important;height:20px !important}
    .bet-slot{font-size:18px !important}
    .bet-amount{font-size:9px !important;padding:3px 5px !important}
    .bet-multi{font-size:10px !important}
    .chip-bar{min-height:36px !important;grid-template-columns:minmax(0,1fr) 40px !important;gap:3px !important}
    .chip-rail{padding:4px !important;border-radius:12px !important;overflow:hidden !important}
    .chip-scroll{gap:2px !important;overflow:hidden !important}
    .chip,
    .chip svg{width:26px !important;height:26px !important}
    .chip-label{display:none !important}
    .action-box{min-width:38px !important;padding:4px !important;border-radius:12px !important}
    .action-box b,
    .action-box span{font-size:0 !important}

    /* Lucky77 Max */
    .stage{top:calc(var(--safe-top,0px) + 34px) !important;bottom:calc(var(--bottom-h,40px) + var(--bets-h,52px) + var(--safe-bottom,0px) + 4px) !important;overflow:hidden !important}
    .wheel-wrap{width:var(--wheel-size,min(38vw,118px)) !important;height:var(--wheel-size,min(38vw,118px)) !important}
    .bottom-bar{height:calc(var(--bottom-h,40px) + var(--safe-bottom,0px)) !important}

    /* Lucky7 Pro */
    .machine{height:100dvh !important;max-height:100dvh !important;overflow:hidden !important}
    .title-wrap,
    .side-buttons,
    .stake-panel,
    .result-copy{display:none !important}
    .live-strip{height:24px !important}
    .room-actions{height:32px !important}
    .wheel-section{min-height:0 !important;padding:4px !important}
    .wheel-shell{width:min(48vw,132px) !important;min-width:116px !important}
    .selector-row{gap:4px !important}
    .selector-card{min-height:52px !important;padding:4px 2px !important;border-radius:10px !important}
    .selector-icon{width:20px !important;height:20px !important}
    .selector-name{font-size:8px !important}
    .selector-stats span{font-size:6px !important;padding:2px !important}
    .chips{height:44px !important;min-height:44px !important;overflow:hidden !important}
    .chip-asset,
    .casino-chip-face{width:34px !important;height:34px !important}

    /* Fruit Slot */
    .app > .topbar{height:calc(var(--topbar-h,46px) + var(--safe-top,0px)) !important}
    .app > .stage{inset:calc(var(--topbar-h,46px) + var(--safe-top,0px)) 0 calc(var(--chip-dock-h,50px) + var(--safe-bottom,0px)) 0 !important;overflow:hidden !important}
    .hero-head{display:none !important}
    .result-stage{display:none !important}
    .board-wrapper{padding:0 6px !important}
    .board-outer{padding:8px !important;border-radius:18px !important}
    .board-inner{padding:6px !important;border-radius:10px !important}
    .board-grid{gap:4px !important}
    .tile{padding:4px 2px !important;border-radius:8px !important}
    .token{font-size:18px !important}
    .multi{font-size:12px !important}
    .pool{font-size:8px !important;min-width:24px !important;padding:2px 4px !important}
    .chips{height:calc(var(--chip-dock-h,50px) + var(--safe-bottom,0px)) !important;overflow:hidden !important}

    /* Fruits Loop */
    #stage{height:100dvh !important;min-height:0 !important;max-height:100dvh !important}
    #stageWrap{height:100dvh !important;overflow:hidden !important}
    .topRow{top:max(env(safe-area-inset-top),3px) !important;height:50px !important;padding:0 6px !important}
    .dockRight{grid-template-columns:repeat(6,minmax(0,1fr)) !important;gap:3px !important}
    .menuBtn{height:26px !important;border-radius:9px !important}
    .menuBtn .menuText{display:none !important}
    .midTop{display:none !important}
    #wheelZone{top:42px !important;height:134px !important;--wheel-zone-w:min(96vw,260px);--wheel-shell-w:min(90vw,250px);--wheel-shell-h:132px;--wheel-window-w:min(62vw,184px);--wheel-window-h:92px;--wheel-face-size:min(46vw,170px)}
    #timer{top:137px !important;width:34px !important;height:34px !important;font-size:16px !important}
    #statusBar{display:none !important}
    #winnerBanner{top:138px !important;font-size:14px !important;min-width:132px !important;padding:6px 9px !important}
    #winnerHistory{display:none !important}
    #board{bottom:52px !important;width:calc(100% - 10px) !important;min-height:96px !important;padding:5px !important;grid-template-rows:20px 1fr !important;column-gap:4px !important;row-gap:3px !important}
    .betFruit{width:20px !important;height:20px !important;font-size:12px !important}
    .betBox{height:70px !important;border-radius:10px !important}
    .potText{left:5px !important;top:5px !important;font-size:8px !important}
    .potText span{font-size:9px !important}
    .combo{top:22px !important;gap:3px !important}
    .fruitBadge{width:24px !important;height:24px !important;font-size:14px !important}
    .youText{left:5px !important;bottom:5px !important;font-size:9px !important}
    .youText small{display:none !important}
    .multText{right:5px !important;bottom:5px !important;font-size:9px !important}
    #bottomBar{bottom:max(env(safe-area-inset-bottom),3px) !important;width:calc(100% - 8px) !important;padding:4px !important;grid-template-columns:62px minmax(0,1fr) !important}
    #balancePill{width:62px !important;height:28px !important}
    #balanceIcon{display:none !important}
    #balanceValue{font-size:9px !important}
    #chipDock{height:30px !important;gap:3px !important}
    .chipBtn{height:28px !important;font-size:0 !important}

    body::before,
    .bg-particles,
    .bg-lights,
    .spark,
    .orb{
      animation-duration:12s !important;
      filter:none !important;
    }
  }

  @media (max-height:325px){
    .game-container .top-bar{min-height:34px !important;padding:3px 6px !important}
    .game-container .user-section,
    .game-container .status-strip,
    .game-container .hand-label{display:none !important}
    .game-container .top-stack{top:32px !important}
    .game-container .timer-orb,
    .game-container .gf-premium-clock{width:38px !important;height:38px !important;min-width:38px !important;min-height:38px !important}
    .game-container .pot{min-height:46px !important}
    .game-container .cards{height:30px !important;min-height:30px !important}
    .game-container .board{min-height:34px !important;padding:3px 2px !important;border-radius:8px !important}
    .game-container .board-top,
    .game-container .board-bottom{min-height:18px !important;padding:2px 4px !important;border-radius:6px !important}
    .game-container .board-mini{display:none !important}
    .game-container .board-amount,
    .game-container .won-amount{font-size:.5rem !important}
    .game-container .chips-bar .chip,
    .game-container .chips-bar .tool-btn,
    .game-container .fast-bid-btn{width:24px !important;height:24px !important;flex-basis:24px !important}

    .shell{gap:2px !important;padding:3px 4px calc(var(--safe-bottom,0px) + 3px) !important}
    .topbar{min-height:28px !important}
    .balance-card{min-height:26px !important;padding:3px 5px !important}
    .balance-value{font-size:11px !important}
    .hero-panel{padding:1px !important}
    .wheel-wrap{max-width:min(34vw,82px) !important;max-height:min(34vw,82px) !important}
    .bets{min-height:34px !important;gap:2px !important}
    .bet-card{min-height:34px !important;padding:2px !important}
    .bet-amount{display:none !important}
    .bet-icon-wrap{width:18px !important;height:18px !important}
    .bet-multi{font-size:8px !important}
    .chip-bar{min-height:28px !important;grid-template-columns:minmax(0,1fr) 30px !important}
    .chip,
    .chip svg{width:20px !important;height:20px !important}
    .action-box{min-width:30px !important}

    .stage{top:calc(var(--safe-top,0px) + 28px) !important;bottom:calc(var(--bottom-h,32px) + var(--bets-h,36px) + var(--safe-bottom,0px) + 3px) !important}
    .bottom-bar{height:calc(var(--bottom-h,32px) + var(--safe-bottom,0px)) !important}

    .machine{padding:3px 4px calc(36px + var(--safe-bottom,0px)) !important;gap:2px !important}
    .live-strip,
    .room-actions,
    .recent-strip{display:none !important}
    .wheel-shell{width:min(38vw,90px) !important;min-width:82px !important}
    .selector-card{min-height:38px !important}
    .selector-stats{display:none !important}
    .chips{height:34px !important;min-height:34px !important}
    .chip-asset,
    .casino-chip-face{width:25px !important;height:25px !important}

    .app > .topbar{height:calc(34px + var(--safe-top,0px)) !important}
    .app > .stage{inset:calc(34px + var(--safe-top,0px)) 0 calc(38px + var(--safe-bottom,0px)) 0 !important;padding:3px !important;display:grid !important;grid-template-rows:auto minmax(0,1fr) !important;align-items:center !important}
    .brand span,
    .pill svg,
    .chip-coin{display:none !important}
    .pill{min-width:52px !important;height:23px !important;padding:0 5px !important}
    .pill strong{font-size:9px !important}
    .app > .stage > .hero{padding:2px 4px !important;border-radius:10px !important}
    .app > .stage .game-title{font-size:10px !important;padding:2px 8px !important}
    .board-wrapper{height:100% !important;min-height:0 !important;padding:0 5px !important;display:flex !important;align-items:center !important;justify-content:center !important}
    .board-outer{padding:5px !important;border-radius:12px !important}
    .board-inner{padding:4px !important;border-width:2px !important}
    .board-grid{gap:3px !important}
    .tile{aspect-ratio:auto !important;height:51px !important;min-height:0 !important;padding:2px 1px !important}
    .token{font-size:13px !important;line-height:1 !important}
    .board-grid .name{font-size:7px !important;line-height:1 !important}
    .multi{font-size:9px !important}
    .pool{display:none !important}
    .chips{height:calc(38px + var(--safe-bottom,0px)) !important}
    .chips .chip{height:25px !important;font-size:8px !important;border-radius:9px !important}

    #wheelZone{top:30px !important;height:104px !important;--wheel-shell-h:104px;--wheel-window-h:72px;--wheel-face-size:min(40vw,132px)}
    #timer{top:100px !important;width:28px !important;height:28px !important;font-size:13px !important}
    #board{bottom:40px !important;min-height:78px !important;grid-template-rows:0 1fr !important}
    .betFruit{display:none !important}
    .betBox{height:66px !important}
    #bottomBar{grid-template-columns:48px minmax(0,1fr) !important}
    #balancePill{width:48px !important;height:24px !important}
    #chipDock{height:24px !important}
    .chipBtn{height:23px !important}
  }
</style>
