<style>
  .gf-premium-clock-host{
    position:relative;
    display:grid;
    place-items:center;
    pointer-events:none;
    isolation:isolate;
    margin-inline:auto;
  }

  .gf-premium-clock{
    --p:1;
    --timer-angle:-90deg;
    --timer-color:var(--gf-a);
    --gf-size:118px;
    --gf-width:var(--gf-size);
    --gf-height:var(--gf-size);
    --gf-radius:50%;
    --gf-text-size:2.9rem;
    --gf-label-size:.58rem;
    --gf-a:#00f5ff;
    --gf-b:#ff2df4;
    --gf-c:#ffd76b;
    --gf-num:#ffffff;
    --gf-scene:radial-gradient(circle,#09142d,#040711 72%);
    position:relative;
    width:var(--gf-width);
    height:var(--gf-height);
    border-radius:var(--gf-radius);
    display:grid;
    place-items:center;
    isolation:isolate;
    filter:drop-shadow(0 18px 32px rgba(0,0,0,.34));
    transition:transform .22s ease, opacity .22s ease, filter .22s ease;
  }

  .gf-premium-clock::before{
    content:"";
    position:absolute;
    inset:-14px;
    border-radius:inherit;
    background:radial-gradient(circle, rgba(255,255,255,.10), transparent 62%);
    opacity:.55;
    z-index:-3;
  }

  .gf-premium-scene,
  .gf-premium-progress,
  .gf-premium-core,
  .gf-premium-overlay,
  .gf-premium-rim,
  .gf-premium-badge,
  .gf-premium-dot,
  .gf-premium-shard,
  .gf-premium-hand,
  .gf-premium-pivot,
  .gf-premium-number,
  .gf-premium-sub{
    position:absolute;
  }

  .gf-premium-scene{
    inset:0;
    border-radius:inherit;
    background:var(--gf-scene);
    border:1px solid rgba(255,255,255,.18);
    box-shadow:inset 0 1px 0 rgba(255,255,255,.14), inset 0 -24px 52px rgba(0,0,0,.38);
    z-index:-2;
    overflow:hidden;
  }

  .gf-premium-scene::before{
    content:"";
    position:absolute;
    inset:0;
    border-radius:inherit;
    background:linear-gradient(140deg, rgba(255,255,255,.18), rgba(255,255,255,0) 26%, rgba(255,255,255,.08) 52%, rgba(255,255,255,0) 70%);
    opacity:.72;
    mix-blend-mode:screen;
  }

  .gf-premium-scene::after{
    content:"";
    position:absolute;
    inset:8% 12%;
    border-radius:inherit;
    background:radial-gradient(circle at 50% 18%, rgba(255,255,255,.16), transparent 34%);
    filter:blur(10px);
    opacity:.55;
  }

  .gf-premium-rim{
    border-radius:inherit;
    pointer-events:none;
  }

  .gf-premium-rim-1{
    inset:8px;
    border:1px solid rgba(255,255,255,.20);
    animation:gfClockSpin 18s linear infinite;
  }

  .gf-premium-rim-2{
    inset:-7px;
    border:2px dashed rgba(255,255,255,.16);
    animation:gfClockSpinReverse 12s linear infinite;
    opacity:.75;
  }

  .gf-premium-rim-3{
    inset:27px;
    border:1px dotted rgba(255,255,255,.14);
    animation:gfClockSpin 8s linear infinite;
    opacity:.72;
  }

  .gf-premium-progress{
    inset:0;
    border-radius:inherit;
    background:conic-gradient(var(--timer-color, var(--gf-a)) calc(var(--p, 1) * 360deg), rgba(255,255,255,.08) 0);
    -webkit-mask:radial-gradient(circle, transparent 57%, #000 60%);
    mask:radial-gradient(circle, transparent 57%, #000 60%);
    box-shadow:0 0 26px rgba(255,255,255,.08);
  }

  .gf-premium-core{
    inset:14px;
    border-radius:inherit;
    background:radial-gradient(circle at 34% 18%, rgba(255,255,255,.22), rgba(255,255,255,.05) 28%, rgba(7,11,24,.94) 72%);
    border:1px solid rgba(255,255,255,.12);
    box-shadow:inset 0 0 24px rgba(0,0,0,.48);
  }

  .gf-premium-overlay{
    inset:20px;
    border-radius:inherit;
    background:linear-gradient(180deg, rgba(255,255,255,.14), rgba(255,255,255,0) 36%);
    mix-blend-mode:screen;
    opacity:.32;
  }

  .gf-premium-hand{
    left:50%;
    top:50%;
    width:4px;
    height:27%;
    transform:translate(-50%, -92%) rotate(var(--timer-angle, -90deg));
    transform-origin:50% 92%;
    border-radius:999px;
    background:linear-gradient(180deg, #ffffff, var(--timer-color, var(--gf-a)));
    box-shadow:0 0 14px var(--timer-color, var(--gf-a));
    z-index:5;
  }

  .gf-premium-pivot{
    left:50%;
    top:50%;
    width:10px;
    height:10px;
    transform:translate(-50%, -50%);
    border-radius:50%;
    background:#ffffff;
    box-shadow:0 0 12px var(--timer-color, var(--gf-a));
    z-index:6;
  }

  .gf-premium-number{
    left:50%;
    top:50%;
    transform:translate(-50%, -58%);
    z-index:7;
    font-size:var(--gf-text-size);
    line-height:.82;
    font-weight:1000;
    letter-spacing:-.08em;
    color:var(--gf-num);
    text-shadow:0 0 18px rgba(255,255,255,.08), 0 8px 20px rgba(0,0,0,.48);
    transition:transform .18s ease, font-size .18s ease, letter-spacing .18s ease;
  }

  .gf-premium-number::before{
    content:attr(data-value);
    position:absolute;
    inset:0;
    z-index:-1;
    color:var(--timer-color, var(--gf-a));
    opacity:.42;
    filter:blur(10px);
  }

  .gf-premium-number.small,
  .gf-premium-number.phase-text{
    font-size:calc(var(--gf-text-size) * .42);
    letter-spacing:.18em;
    text-transform:uppercase;
    transform:translate(-50%, -60%);
  }

  .gf-premium-number.phase-soft{
    font-size:calc(var(--gf-text-size) * .62);
    letter-spacing:.26em;
    text-transform:uppercase;
  }

  .gf-premium-sub{
    left:50%;
    top:72%;
    transform:translateX(-50%);
    z-index:7;
    font-size:var(--gf-label-size);
    line-height:1;
    font-weight:800;
    letter-spacing:.18em;
    text-transform:uppercase;
    color:rgba(255,255,255,.72);
    white-space:nowrap;
  }

  .gf-premium-badge{
    z-index:1;
    opacity:.78;
    filter:blur(.2px);
  }

  .gf-premium-badge-top,
  .gf-premium-badge-bottom{
    left:50%;
    transform:translateX(-50%);
    width:64px;
    height:16px;
    border-radius:999px;
    background:linear-gradient(180deg, var(--gf-c), transparent);
  }

  .gf-premium-badge-top{top:10px;}
  .gf-premium-badge-bottom{bottom:10px; transform:translateX(-50%) rotate(180deg);}

  .gf-premium-badge-left,
  .gf-premium-badge-right{
    top:50%;
    width:16px;
    height:64px;
    transform:translateY(-50%);
    border-radius:999px;
    background:linear-gradient(90deg, var(--gf-c), transparent);
  }

  .gf-premium-badge-left{left:10px;}
  .gf-premium-badge-right{right:10px; transform:translateY(-50%) rotate(180deg);}

  .gf-premium-dot{
    width:7px;
    height:7px;
    border-radius:50%;
    background:#ffffff;
    box-shadow:0 0 14px var(--timer-color, var(--gf-a));
    animation:gfClockTwinkle 2.2s ease-in-out infinite;
    z-index:1;
  }

  .gf-premium-dot-1{left:18%;top:14%;animation-delay:.1s;}
  .gf-premium-dot-2{right:17%;top:18%;animation-delay:.5s;}
  .gf-premium-dot-3{left:20%;bottom:18%;animation-delay:.9s;}
  .gf-premium-dot-4{right:19%;bottom:14%;animation-delay:1.3s;}

  .gf-premium-shard{
    width:28px;
    height:28px;
    opacity:.34;
    z-index:1;
    clip-path:polygon(50% 0, 100% 50%, 50% 100%, 0 50%);
    background:linear-gradient(135deg, var(--gf-a), transparent 72%);
    filter:drop-shadow(0 0 10px var(--gf-a));
    animation:gfClockFloat 4.2s ease-in-out infinite;
  }

  .gf-premium-shard-1{left:7%;top:14%;}
  .gf-premium-shard-2{right:7%;top:14%;animation-delay:.7s;}
  .gf-premium-shard-3{left:9%;bottom:14%;animation-delay:1.4s;}
  .gf-premium-shard-4{right:9%;bottom:14%;animation-delay:2.1s;}

  .gf-premium-clock.hidden-phase{
    opacity:0;
    transform:scale(.84);
  }

  .gf-premium-clock.disabled{
    opacity:.84;
  }

  .gf-premium-clock.gf-alert,
  .gf-premium-clock-host.round-live .gf-premium-clock{
    filter:drop-shadow(0 0 18px rgba(255,255,255,.14)) drop-shadow(0 18px 32px rgba(0,0,0,.34));
  }

  .gf-premium-clock.gf-ended{
    opacity:.9;
  }

  .gf-premium-clock-host.round-go .gf-premium-clock{
    transform:translateY(-2px) scale(1.02);
  }

  .gf-premium-clock-host.timer-hidden,
  .gf-premium-clock-host.is-hidden{
    display:none !important;
    visibility:hidden;
  }

  .gf-teen-clock .gf-premium-clock{
    --gf-size:118px;
    --gf-text-size:2.85rem;
    --gf-label-size:.52rem;
  }

  .gf-lucky-wheel-clock .gf-premium-clock{
    --gf-size:126px;
    --gf-text-size:3rem;
    --gf-label-size:.52rem;
  }

  .gf-fruit-hero-clock .gf-premium-clock,
  .gf-fruit-arcade-clock .gf-premium-clock{
    --gf-size:114px;
    --gf-text-size:2.7rem;
    --gf-label-size:.54rem;
  }

  .gf-live-strip-clock .gf-premium-clock{
    --gf-size:92px;
    --gf-text-size:2.15rem;
    --gf-label-size:.44rem;
  }

  .gf-theme-neon{--gf-a:#00f5ff;--gf-b:#ff2df4;--gf-c:#6e49ff;--gf-num:#eaffff;--gf-scene:radial-gradient(circle,#07152f,#030611 72%);}
  .gf-theme-minimal{--gf-a:#ffd05a;--gf-b:#ffffff;--gf-c:#d9b45b;--gf-num:#ffeab0;--gf-scene:linear-gradient(145deg,#080808,#151515);--gf-radius:36px;}
  .gf-theme-minimal .gf-premium-dot,
  .gf-theme-minimal .gf-premium-shard,
  .gf-theme-minimal .gf-premium-badge-left,
  .gf-theme-minimal .gf-premium-badge-right,
  .gf-theme-minimal .gf-premium-hand{display:none;}

  .gf-theme-samurai{--gf-a:#dc2020;--gf-b:#f1c784;--gf-c:#c59a55;--gf-num:#f9dfb0;--gf-scene:radial-gradient(circle,#4b0808,#090505 72%);--gf-radius:20px;}
  .gf-theme-samurai .gf-premium-clock,
  .gf-theme-samurai .gf-premium-scene,
  .gf-theme-samurai .gf-premium-progress,
  .gf-theme-samurai .gf-premium-core{
    clip-path:polygon(18% 0, 82% 0, 100% 18%, 100% 82%, 82% 100%, 18% 100%, 0 82%, 0 18%);
  }

  .gf-theme-steampunk{--gf-a:#ffaf3f;--gf-b:#7a461c;--gf-c:#c48b43;--gf-num:#ffbd59;--gf-scene:radial-gradient(circle,#2a1808,#080604 78%);}
  .gf-theme-steampunk .gf-premium-rim-2{border-style:dashed;opacity:.95;}
  .gf-theme-steampunk .gf-premium-shard{background:linear-gradient(135deg,#c48b43,transparent 72%);filter:drop-shadow(0 0 10px #c48b43);}

  .gf-theme-casino{--gf-a:#df001f;--gf-b:#ffd35b;--gf-c:#d3a73d;--gf-num:#ffd35b;--gf-scene:radial-gradient(circle,#260507,#050303 76%);}
  .gf-theme-casino .gf-premium-rim-2{border-color:rgba(255,207,95,.42);}
  .gf-theme-casino .gf-premium-badge-top,
  .gf-theme-casino .gf-premium-badge-bottom{background:linear-gradient(180deg,#ffd35b,transparent);}

  .gf-theme-fire{--gf-a:#ff5a00;--gf-b:#ffe000;--gf-c:#ff9d00;--gf-num:#ffe98e;--gf-scene:radial-gradient(circle,#330600,#070100 74%);}
  .gf-theme-fire .gf-premium-core{background:radial-gradient(circle at 34% 18%, rgba(255,255,255,.18), rgba(255,210,120,.10) 26%, rgba(36,4,0,.94) 72%);}

  .gf-theme-liquid{--gf-a:#22f4df;--gf-b:#0e72e9;--gf-c:#6ff9ff;--gf-num:#f3ffff;--gf-scene:linear-gradient(145deg,#063f83,#03112a);}
  .gf-theme-liquid .gf-premium-core{background:radial-gradient(circle at 40% 20%, rgba(255,255,255,.38), rgba(37,237,221,.34) 38%, rgba(4,54,109,.94) 72%);}

  .gf-theme-flip{--gf-a:#ff3030;--gf-b:#e7edf5;--gf-c:#8e949b;--gf-num:#f3f3f3;--gf-scene:linear-gradient(145deg,#030303,#141414);--gf-radius:22px;--gf-width:calc(var(--gf-size) * 1.16);--gf-height:calc(var(--gf-size) * .82);}
  .gf-theme-flip .gf-premium-hand,
  .gf-theme-flip .gf-premium-pivot,
  .gf-theme-flip .gf-premium-dot{display:none;}
  .gf-theme-flip .gf-premium-number{font-family:ui-monospace, Menlo, Consolas, monospace;letter-spacing:-.12em;transform:translate(-50%, -55%);}

  .gf-theme-cyber{--gf-a:#1affea;--gf-b:#0bb0ff;--gf-c:#1affea;--gf-num:#9ffff8;--gf-scene:radial-gradient(circle,#052227,#020606 76%);}
  .gf-theme-cyber .gf-premium-scene::after{background:linear-gradient(rgba(26,255,234,.10) 1px, transparent 1px), linear-gradient(90deg, rgba(26,255,234,.08) 1px, transparent 1px);background-size:20px 20px;filter:none;opacity:.44;inset:0;}

  .gf-theme-frost{--gf-a:#bff6ff;--gf-b:#eaffff;--gf-c:#93dfff;--gf-num:#ecfbff;--gf-scene:radial-gradient(circle,#0c2a45,#020814 78%);}
  .gf-theme-frost .gf-premium-shard{background:linear-gradient(135deg,#ffffff,#88e9ff);filter:drop-shadow(0 0 10px #88e9ff);}

  .gf-theme-royal{--gf-a:#e6002f;--gf-b:#005dff;--gf-c:#e0ae42;--gf-num:#ffd76b;--gf-scene:radial-gradient(circle,#071128,#080407 75%);}
  .gf-theme-royal .gf-premium-badge-top{
    width:86px;
    height:24px;
    top:-2px;
    clip-path:polygon(0 100%, 10% 40%, 20% 78%, 32% 12%, 50% 78%, 68% 12%, 80% 78%, 90% 40%, 100% 100%);
    background:linear-gradient(180deg,#ffe88c,#bc7514);
  }
  .gf-theme-royal .gf-premium-badge-bottom{background:linear-gradient(180deg,#b11e34,transparent);}

  .gf-theme-arcade{--gf-a:#12dfff;--gf-b:#ff35cd;--gf-c:#ffd22a;--gf-num:#ffd22a;--gf-scene:linear-gradient(145deg,#060720,#11133b);--gf-radius:22px;}
  .gf-theme-arcade .gf-premium-clock{--gf-width:calc(var(--gf-size) * 1.08);--gf-height:calc(var(--gf-size) * .9);}
  .gf-theme-arcade .gf-premium-number{font-family:ui-monospace, Menlo, Consolas, monospace;text-shadow:3px 3px 0 #ff6b00, 0 0 14px #ffd22a;}
  .gf-theme-arcade .gf-premium-dot{display:none;}

  .gf-theme-forest{--gf-a:#65ff58;--gf-b:#164d17;--gf-c:#5b3f1e;--gf-num:#d7ffd0;--gf-scene:radial-gradient(circle,#12200d,#051006 78%);}
  .gf-theme-forest .gf-premium-badge-left,
  .gf-theme-forest .gf-premium-badge-right{background:linear-gradient(90deg,#5b3f1e,transparent);}

  .gf-theme-crystal{--gf-a:#c8f7ff;--gf-b:#d042ff;--gf-c:#8e73ff;--gf-num:#f8fcff;--gf-scene:radial-gradient(circle,#101858,#040611 76%);}
  .gf-theme-crystal .gf-premium-clock,
  .gf-theme-crystal .gf-premium-scene,
  .gf-theme-crystal .gf-premium-progress,
  .gf-theme-crystal .gf-premium-core{
    clip-path:polygon(50% 0, 86% 14%, 100% 50%, 86% 86%, 50% 100%, 14% 86%, 0 50%, 14% 14%);
  }
  .gf-theme-crystal .gf-premium-shard{background:linear-gradient(135deg,#ffffff,#5deaff,#f563ff);filter:drop-shadow(0 0 10px #5deaff);}

  .gf-theme-cosmic{--gf-a:#5ba6ff;--gf-b:#b63cff;--gf-c:#7c5cff;--gf-num:#edf5ff;--gf-scene:radial-gradient(circle,#0b1030,#030515 78%);}
  .gf-theme-cosmic .gf-premium-rim-2{border-color:rgba(182,60,255,.34);}

  .gf-theme-origami{--gf-a:#f9c431;--gf-b:#63ce4b;--gf-c:#1389aa;--gf-num:#ef352f;--gf-scene:linear-gradient(145deg,#1680a1,#0c5571);--gf-radius:18px;}
  .gf-theme-origami .gf-premium-shard{opacity:.56;clip-path:polygon(50% 0, 100% 100%, 0 100%);background:linear-gradient(180deg,#f9c431,#63ce4b);}

  .gf-theme-holo{--gf-a:#16efff;--gf-b:#ff50f8;--gf-c:#7a4dff;--gf-num:#eafcff;--gf-scene:radial-gradient(circle,#08132a,#03050c 78%);}
  .gf-theme-holo .gf-premium-core{background:linear-gradient(135deg, rgba(255,255,255,.08), rgba(26,255,255,.14), rgba(255,66,236,.12)), radial-gradient(circle at 34% 18%, rgba(255,255,255,.18), rgba(6,10,23,.94) 70%);}

  .gf-theme-carnival{--gf-a:#ffd15b;--gf-b:#c41422;--gf-c:#f2b642;--gf-num:#ffe2a2;--gf-scene:radial-gradient(circle,#851219,#190205 76%);}
  .gf-theme-carnival .gf-premium-rim-2{border-color:rgba(255,209,91,.34);}

  .gf-theme-candy{--gf-a:#ff4da6;--gf-b:#31dfff;--gf-c:#ffd35a;--gf-num:#ff207f;--gf-scene:linear-gradient(145deg,#ff78bd,#5edcff);}
  .gf-theme-candy .gf-premium-core{background:radial-gradient(circle,#fff7de,#ffd4ec 66%);}
  .gf-theme-candy .gf-premium-number{text-shadow:0 4px 0 #b81562, 0 0 18px #ffffff;}

  .gf-theme-deco{--gf-a:#d9b65b;--gf-b:#0d4d42;--gf-c:#d9b65b;--gf-num:#ead07a;--gf-scene:linear-gradient(145deg,#04100e,#060707);}
  .gf-theme-deco .gf-premium-rim-1,
  .gf-theme-deco .gf-premium-rim-2{border-color:rgba(217,182,91,.28);}

  .gf-theme-stained{--gf-a:#ffb31d;--gf-b:#20da8a;--gf-c:#8a5b20;--gf-num:#ffd25c;--gf-scene:conic-gradient(from 20deg, rgba(255,55,45,.24), rgba(255,179,29,.24), rgba(32,218,138,.24), rgba(55,95,255,.18), rgba(180,40,255,.20), rgba(255,55,45,.24));}
  .gf-theme-stained .gf-premium-core{background:radial-gradient(circle,#15125a,#070719 70%);}

  @keyframes gfClockSpin{to{transform:rotate(360deg);}}
  @keyframes gfClockSpinReverse{to{transform:rotate(-360deg);}}
  @keyframes gfClockTwinkle{0%,100%{opacity:.24;transform:scale(.58);}50%{opacity:1;transform:scale(1.3);}}
  @keyframes gfClockFloat{0%,100%{transform:translateY(0) rotate(0deg);}50%{transform:translateY(-8px) rotate(12deg);}}

  @media (max-width: 520px){
    .gf-teen-clock .gf-premium-clock{--gf-size:92px;--gf-text-size:2.18rem;--gf-label-size:.44rem;}
    .gf-lucky-wheel-clock .gf-premium-clock{--gf-size:102px;--gf-text-size:2.3rem;--gf-label-size:.44rem;}
    .gf-fruit-hero-clock .gf-premium-clock,
    .gf-fruit-arcade-clock .gf-premium-clock{--gf-size:96px;--gf-text-size:2.2rem;--gf-label-size:.46rem;}
    .gf-live-strip-clock .gf-premium-clock{--gf-size:80px;--gf-text-size:1.86rem;--gf-label-size:.4rem;}
  }
</style>