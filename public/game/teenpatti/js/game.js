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

   //input_online_or_oflline();
});
// sound 
var audio_bg = document.getElementById('background_audio');

// Mute the audio initially
audio_bg.volume = 0;

// Add a click event listener to the document
document.addEventListener('click', function() {
 // Play the media element
 audio_bg.play();
});
/*
|---------------------
| All Animation Start
|---------------------
*/
// btn animation




$('#saven_winner .container .footer .footer_bottom .footer_bottom_right .images').click(function(){
   click_audio.play();
   // active st
   $('#saven_winner .container .footer .footer_bottom .footer_bottom_right .images').removeClass('active');
   $(this).addClass('active');
   // annimation
   $('#saven_winner .container .footer .footer_bottom .footer_bottom_right .images #btn_animation_wrapper').html('');
   $(this).children('#btn_animation_wrapper').html('<div class="animation">' +
   '    <span style="--i:1"><i class="fa-solid fa-play"></i></span>' +
   '    <span style="--i:2"><i class="fa-solid fa-play"></i></span>' +
   '    <span style="--i:3"><i class="fa-solid fa-play"></i></span>' +
   '    <span style="--i:4"><i class="fa-solid fa-play"></i></span>' +
   '    <span style="--i:5"><i class="fa-solid fa-play"></i></span>' +
   '</div>' +
   '');
});

// responsive design
/*
|---------------------
| All Animation End
|---------------------
*/
$('input.music_1_checkbox').click(function(){
   if($('input.music_1_checkbox').is(':checked')){
       audio_bg.play();
       audio_bg.volume=1;
   }else{
       audio_bg.volume=0;
   }
   
});
$('input.sound_checkbox').click(function(){
   
   if($('input.sound_checkbox').is(':checked')){
       click_audio.volume=1;
       coins_audio.volume=1;
   }else{
       click_audio.volume=0;
       coins_audio.volume=0;
   }
   
});
/*
|---------------------
| Click & Run Event
|---------------------
*/
// $('.icons_header_right_click').click(function(){
//     $('.header_right_icons_ul').toggleClass('d-none');
// });

$('.icons_header_right_click_1').click(function(){
   // settings 
   $('.Settings_Here').removeClass('d-none');
});
$('.icons_header_right_click_2').click(function(){
   // settings 
   $('.reward_here').removeClass('d-none');
  
});

$('.icons_header_right_click_3').click(function(){
   // settings 
   $('.Rules_here').removeClass('d-none');
});

$('.icons_header_right_click_4').click(function(){
   // settings 
   $('.users_here').removeClass('d-none');
   input_online_or_oflline_get_users();
});

// close 
$('#hidden_info_here.Settings_Here .container .close_bar').click(function(){
   // settings 
   $('#hidden_info_here.Settings_Here').addClass('d-none');
});

$('#hidden_info_here.reward_here .container .close_bar').click(function(){
   // settings 
   $('#hidden_info_here.reward_here').addClass('d-none');
});

$('#hidden_info_here.Rules_here .container .close_bar').click(function(){
   // settings 
   $('#hidden_info_here.Rules_here').addClass('d-none');
});

$('#hidden_info_here.users_here .container .close_bar').click(function(){
   // settings 
   $('#hidden_info_here.users_here').addClass('d-none');
});
/*
|---------------------
| Click & Run Event
|---------------------
*/

/*
|---------------------
| tseting here  st
|---------------------
*/
$('#saven_winner .container .footer .footer_bottom .footer_bottom_right .images').click(function(){

   $('#saven_winner .container .footer .footer_top .box_wrapper .box_wrapper_body img.coin_box3').css('animation', 'coin_box_2_anime 1s ease forwards');
   setTimeout(() => {
       var random_number = 1;
       $('#saven_winner .container .footer .footer_top .box_wrapper .box_wrapper_body img.coin_box3').css({'animation' : 'none', 'top' : ''+random_number+'%', 'left' : ''+random_number+'%'});
   }, 1000);

});

// settimeout_here
const settimeout_here = () => {
    let nowTime = Number(new Date().getTime()/1000);
    console.log('now Time' +nowTime)
   //ajax
   $.ajax({
       "method" : "get",
       "url" : "https://lindaapp.in/betel/tray_id",
       "data" : {
           'tray_id' : $('#tray_id').val(),
           'authkey': $('#authkey').val(),
           'authtoken': $('#authtoken').val(),
       },crossDomain: true,
           headers: {
             'Access-Control-Allow-Origin': '*'
           },

       success:function(res){
          let st=res.st;
           let data=res.data;
           if(st === true){
               $('.Server_Issue').hide();
               var x = setInterval(() => {
                  
                   // start
                   let nowTime = Number(new Date().getTime()/1000);
                  // console.log(data)
                   let time = Number(data - nowTime).toFixed(0);
                   console.log(time);
                   // some css before st
                   $('#saven_winner .container .body .body_bottom .images').css('display', 'none');
                   $('#saven_winner .container .footer .footer_top .box_wrapper').attr('disabled', true);
                   $('#tray_id').val(data);

                   // time bottom 
                   if(time > 10 && time < 26){
                       $('#saven_winner .container .body .body_bottom .images').css('display', 'block');
                       $('#saven_winner .container .footer .footer_top .box_wrapper').attr('disabled', false);
                       $('.clock_time_count_down').html(time-10);
                   }
                   // if(time == 35){
                   //      //get_winner_info();
                   //     //win_or_loss_calculation();

                   // }
                   if(time > 30){
                       win_or_loss_calculation();
                   }
                   if(time == 30){
                       get_winner_info();
                       $('.Winner_Here').removeClass('d-none');
                       get_fruits_results();
                       setTimeout(() => {
                           $('.Winner_Here').addClass('d-none');
                       }, 4000);
                       get_users_amount();
                   }
                   if(time == 26){
                       $('.This_is_notification').removeClass('d-none');
                       $('.This_is_notification .body .title').html('Start Batting');
                       setTimeout(() => {
                           $('.This_is_notification').addClass('d-none');
                       }, 1500);
                   }
                   if(time == 10){

                       $('#saven_winner .container .footer .footer_top .box_wrapper').attr('disabled', true);
                       if($('#saven_winner .container .footer .footer_top .box_wrapper:nth-child(1) .box_wrapper_footer .header').html() != "00"){
                           insert_betting(Number($('#saven_winner .container .footer .footer_top .box_wrapper:nth-child(1) .box_wrapper_footer .header').html()), 'apple');
                       }
                       if($('#saven_winner .container .footer .footer_top .box_wrapper:nth-child(2) .box_wrapper_footer .header').html() != "00"){
                           insert_betting(Number($('#saven_winner .container .footer .footer_top .box_wrapper:nth-child(2) .box_wrapper_footer .header').html()), 'saven_win');
                       }
                       if($('#saven_winner .container .footer .footer_top .box_wrapper:nth-child(3) .box_wrapper_footer .header').html() != "00"){
                           insert_betting(Number($('#saven_winner .container .footer .footer_top .box_wrapper:nth-child(3) .box_wrapper_footer .header').html()), 'watermelon');
                       }
                       
                   }
                   if(time == 10){
                       //win_pred();
                       $('#saven_winner .container .footer .footer_top .box_wrapper').attr('disabled', true);
                       $('.This_is_notification').removeClass('d-none');
                       $('.This_is_notification .body .title').html('Stop Batting');
                       $('#saven_winner .container .footer .footer_top .box_wrapper').removeClass('active');

                   }
                   if (time == 8) {
                      win_pred();
                   }if (time==5) {
                    result_final();
                   }
                   if (time ==3) {

                       setTimeout(() => {
                           saven_win_get_winner();
                           get_users_amount();
                           $('.This_is_notification').addClass('d-none');
                       }, 1000);
                   }
                   if(time < 0){
                       clearInterval(x);
                   }
               }, 1000);
           }else{
               settimeout_here();
               $('.Server_Issue').show();
           }
        },
        error: function() {
           $('.Server_Issue').show();
        }
    })



}

// saven_win_get_winner_in
const saven_win_get_winner = () => {
   // ajax
   $.ajax({
       "method" : "get",
       "url" : "https://lindaapp.in/betel/winner_saven_win",
       "data" : {
           'tray_id' : $('#tray_id').val(),
           'authkey': $('#authkey').val(),
           'authtoken': $('#authtoken').val(),
       },
       success:function(res){
           
           if(res.st === true){
               $('.Server_Issue').hide();
               setTimeout(() => {
                   // start Again
                   settimeout_here();

                   // st
                   $('#saven_winner .container .body').css('transform', 'translateY(0px)');
                   /*
                   |--------------
                   |spniner
                   |--------------
                   */
                   if(res.data == "apple"){
                       var span_num = 1;

                       var anim_while = "rotet_while_2 7s ease forwards";
                       var anim_while_f = "rotet_while_2_fruits 7s ease forwards";

                       var spn_img = 5;
                   }else if(res.data == "saven_win"){
                       var span_num = 2;

                       var anim_while = "saven_winner 7s ease forwards";
                       var anim_while_f = "saven_winner_fruits 7s ease forwards";

                       var spn_img = 3;
                   }else{
                       var span_num = 3;

                       var anim_while = "rotet_while_3 7s ease forwards";
                       var anim_while_f = "rotet_while_3_fruits 7s ease forwards";

                       var spn_img = 1;
                   }

                   $('#saven_winner .container .body .body_middle .images img.spinner_while').css('animation', anim_while);
                   $('#saven_winner .container .body .body_middle .images #all_animation_foots').css('animation', anim_while_f);

                   // winner
                   setTimeout(() => {
                       $('#saven_winner .container .footer .footer_top .box_wrapper').css('filter', 'grayscale(100%)');
                       $('#saven_winner .container .body .body_middle .images #all_animation_foots span img').css('filter', 'grayscale(100%)');
                       $('#saven_winner .container .body .body_middle .images img.spinner_while').css('filter', 'grayscale(100%)');
                       $('#saven_winner .container .body .body_middle .images #all_animation_foots span:nth-child('+span_num+')').css('filter', 'grayscale(0%)');
                       $('#saven_winner .container .body .body_middle .images #all_animation_foots span:nth-child('+spn_img+') img').css({'animation' : 'box_animation_apple 4s ease forwards', 'filter' : 'grayscale(0%)'});
                       $('#saven_winner .container .footer .footer_top .box_wrapper:nth-child('+span_num+')').css({'animation' : 'box_animation_apple 4s ease forwards', 'filter' : 'grayscale(0%)'});
                       setTimeout(() => {
                           // css 
                           $('#saven_winner .container .body .body_middle .images img.spinner_while').css('animation', 'none');
                           $('#saven_winner .container .body .body_middle .images #all_animation_foots').css('animation', 'none');
                           $('#saven_winner .container .body .body_middle .images #all_animation_foots span img').css('filter', 'grayscale(0%)');
                           $('#saven_winner .container .body .body_middle .images img.spinner_while').css('filter', 'grayscale(0%)');
                           $('#saven_winner .container .body .body_middle .images #all_animation_foots span:nth-child('+spn_img+') img').css({'animation' : 'none'});
                           $('#saven_winner .container .footer .footer_top .box_wrapper:nth-child('+span_num+')').css({'animation' : 'none'});
                           $('#saven_winner .container .body').css('transform', 'translateY(-50px)');
                           $('#saven_winner .container .footer .footer_top .box_wrapper').css('filter', 'grayscale(0%)');
                           // all amount 
                           $('#saven_winner .container .footer .footer_top .box_wrapper .box_wrapper_header .header, #saven_winner .container .footer .footer_top .box_wrapper .box_wrapper_footer .header').html('00');
                           $('.all_batting_img_here').html('');
                       }, 4000);
                   }, 7000);
               }, 500);
           }else{

               saven_win_get_winner();
               $('.Server_Issue').show();
           }
       },
        error: function() {
           $('.Server_Issue').show();
        }
   });
}
// insert_betting
const insert_betting = (Amount, betting_to) => {
   console.log(Amount + 'insert_betting' + betting_to);
   // ajax
   $.ajax({
       "method" : "get",
       "url" : "https://lindaapp.in/betel/fortune_insert",
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

// get user amount
const get_users_amount = () => {
  // win_or_loss_calculation();
   // ajax
   $.ajax({
       "method" : "get",
       "url" : "https://lindaapp.in/betel/user?authkey=" + $('#authkey').val() + "&authtoken=" + $('#authtoken').val(),
       success:function(res){
           $('.Server_Issue').hide();
           if(res.st == true){
               $('#total_amount').val(res.balance);
           }else{
               $('.Server_Issue').show();
           }
           
       },
       error: function() {
           // Show error message
           //console.log('error');
           $('.Server_Issue').show();
       }
   });
}

// const get_win_predict = () => {
//     // win_or_loss_calculation();
//      // ajax
//      $.ajax({
//          "method" : "get",
//          "url" : "https://lindaapp.in/betel/win_predict/",
//          "data" : {},
//          success:function(res){
//          }
//      });
//  }

// win_or_loss_calculation
const win_or_loss_calculation = () => {
   // ajax
   //console.log($('#userID').val()+"win_or_loss_calculation");
   $.ajax({
       "method" : "get",
       "url" : "https://lindaapp.in/betel/win_or_loss_calculation/",
       "data" : {
           'tray_id' : $('#tray_id').val(),
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

const result_final = () => {
   // ajax
   //console.log($('#userID').val()+"win_or_loss_calculation");
   $.ajax({
       "method" : "get",
       "url" : "https://lindaapp.in/betel/result_final/",
       "data" : {
           'tray_id' : $('#tray_id').val(),
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
const win_pred = () => {
   // ajax
   //console.log($('#userID').val()+"win_or_loss_calculation");
   $.ajax({
       "method" : "get",
       "url" : "https://lindaapp.in/betel/win_pred/",
       "data" : {
           'tray_id' : $('#tray_id').val(),
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


// get_winner_info
const get_winner_info = () => {
   // ajax
   $.ajax({
       "method" : "get",
       "url" : "https://lindaapp.in/betel/get_winner_info/",
       "data" : {
           'authkey': $('#authkey').val(),
           'authtoken': $('#authtoken').val(),
       },
       success:function(res){ 
           $('.Server_Issue').hide();
           if(res.users_1st_amount != ""){
               $('.Winner_Here .box_wrapper .box_r .img1').attr('src', "https://lindaapp.in/public/game/new/image/user.png");
               $('.Winner_Here .box_wrapper .box_r .username1').html(res.users_1st_name);
               $('.Winner_Here .box_wrapper .box_r .bet1').html(res.users_1st_amount);
               $('.Winner_Here .box_wrapper .box_r .betresult1').html(res.users_1st_amount_bet);
           }else{
               $('.Winner_Here .box_wrapper .box_r .img1').attr('src',"https://lindaapp.in/public/game/new/image/user.png");
               $('.Winner_Here .box_wrapper .box_r .username1').html('');
               $('.Winner_Here .box_wrapper .box_r .bet1').html('00');
               $('.Winner_Here .box_wrapper .box_r .betresult1').html('00');
           }

           if(res.users_2nd_amount != ""){
               $('.Winner_Here .box_wrapper .box_r .img2').attr('src',"https://lindaapp.in/public/game/new/image/user.png");
               $('.Winner_Here .box_wrapper .box_r .username2').html(res.users_2nd_name);
               $('.Winner_Here .box_wrapper .box_r .bet2').html(res.users_2nd_amount);
               $('.Winner_Here .box_wrapper .box_r .betresult2').html(res.users_2nd_amount_bet);

           }else{
               $('.Winner_Here .box_wrapper .box_r .img2').attr('src',"https://lindaapp.in/public/game/new/image/user.png");
               $('.Winner_Here .box_wrapper .box_r .username2').html('');
               $('.Winner_Here .box_wrapper .box_r .bet2').html('00');
               $('.Winner_Here .box_wrapper .box_r .betresult2').html('00');
           }

           if(res.users_3rd_amount != ""){
               $('.Winner_Here .box_wrapper .box_r .img3').attr('src',"https://lindaapp.in/public/game/new/image/user.png");
               $('.Winner_Here .box_wrapper .box_r .username3').html(res.users_3rd_name);
               $('.Winner_Here .box_wrapper .box_r .bet3').html(res.users_3rd_amount);
               $('.Winner_Here .box_wrapper .box_r .betresult3').html(res.users_3rd_amount_bet);
           }else{
               $('.Winner_Here .box_wrapper .box_r .img3').attr('src',"https://lindaapp.in/public/game/new/image/user.png");
               $('.Winner_Here .box_wrapper .box_r .username3').html('');
               $('.Winner_Here .box_wrapper .box_r .bet3').html('00');
               $('.Winner_Here .box_wrapper .box_r .betresult3').html('00');
           }

           // my 
           $('.Winner_Here .my_wining_info .myBet').html(res.my_tota_bet);
           $('.Winner_Here .my_wining_info .myBetWin').html(res.my_tota_bet_winning);
       },
        error: function() {
           $('.Server_Issue').show();
        }
   });
}
/*
|---------------------
| tseting here  End
|---------------------
*/


// active or ofline 

// input_online_or_oflline
// const input_online_or_oflline = () => {
//     // ajax
//     $.ajax({
//         "method" : "get",
//         "url" : "/",
//         "data" : {},
//         success:function(res){}
//     });
// }
// input_online_or_oflline_get_users
// const input_online_or_oflline_get_users = () => {
//     $('.users_here .users_box').html('<h2 class="title">Loadding...</h2>');
//     // ajax
//     $.ajax({
//         "method" : "get",
//         "url" : "https://game.vudoolive.com/api/games/saven_win/all_active_users",
//         "data" : {},
//         success:function(res){
//             $('#hidden_info_here.users_here .users_box')
//             const data = res.data.map((curE) => {
//                 return '' + 
//                 '<div class="box_r">' + 
//                 '    <img src="https://game.vudoolive.com/storage/"'+curE.img+'" alt="">' + 
//                 '    <p class="title">'+curE.name+'</p>' + 
//                 '</div>' + 
//                 '';
//             });
//             $('.users_here .users_box').html(data);
//         }
//     });
// }

// gets fruits results 
const get_fruits_results = () => {
    // ajax
   $.ajax({
       "method" : "get",
       "url" : "https://lindaapp.in/betel/wining_fruits",
       "data" : {
           'authkey': $('#authkey').val(),
           'authtoken': $('#authtoken').val(),
       },
       success:function(res){
           
           const rewards = res.data.map((curE) => {
               if(curE.winner == "watermelon"){
                   return '<div class="row col-12" style="margin-left:  -2px;background:#ffffff5e;border-radius: 6px;"> <div class="col-4 text-center text-white" style="">-</div> <div class="col-4 text-center text-white" style="">-</div> <div class="col-4 text-center text-white" style=""><img src="https://lindaapp.in/public/game/new/image/watermelon.png" alt="Saven Winner"></div> </div>';
0               }else if(curE.winner == "saven_win"){
                   return '<div class="row col-12" style="margin-left: -2px;background:#ffffff5e;border-radius: 6px;"> <div class="col-4 text-center text-white" style="">-</div> <div class="col-4 text-center text-white" style=""><img src="https://lindaapp.in/public/game/new/image/lemon.png" alt="Saven Winner"></div> <div class="col-4 text-center text-white" style="">-</div> </div>';
               }else{
                   return '<div class="row col-12" style="margin-left: -2px;background:#ffffff5e;border-radius: 6px;"> <div class="col-4 text-center text-white" style=""><img src="https://lindaapp.in/public/game/new/image/apple.png" alt="Saven Winner"></div> <div class="col-4 text-center text-white" style="">-</div> <div class="col-4 text-center text-white" style="">-</div> </div>';
               }
           });
           $('.reward_here .body').html(rewards);
           $('.apple_percentage').html(res.apple_parcentage+"%");
           $('.77win_percentage').html(res.lamon_parcentage+"%");
           $('.watermelon_percentage').html(res.watermellon_parcentage+"%");
           // $('.apple_percentage').html(res.apple_per+"%");
           // $('.77win_percentage').html(res.savensaven_per+"%");
           // $('.watermelon_percentage').html(res.watermelon_per+"%");
       }
   });
}

// input_online_or_oflline_get_users();

// setInterval(() => {
//     input_online_or_oflline();
// }, 5000);