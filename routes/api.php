<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V4\SliderController as PublicV4SliderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['namespace' => 'Api'], function () {

Route::post('/login','AuthController@login');
Route::post('/register','AuthController@UserRegister');
Route::post('/google_auth','AuthController@GoogleLogin');
Route::get('/setting_info','AuthController@VarsionInfo')->middleware('broadlive.redis_first:home_settings,15,60');
Route::post('/forget_password','AuthController@ForgetPassword');
Route::get('Noti','AudioBrdController@send_push_notification');
Route::get('pre_user_live_home','UserLiveController@Index');


});

Route::get('v4/slider', [PublicV4SliderController::class, 'Index']);

Route::group(['namespace' => 'Api\V3','middleware' => ['auth:sanctum']], function () {
Route::get('Notification','VideoBrdController@Notification');
Route::get('v3/logout','AuthController@Logout');
Route::get('v3/login_user','AuthController@UserData');
Route::get('v3/change_password','AuthController@ChangePassword');
//Product
Route::get('v3/rank','RankingController@RankList');
Route::get('v3/top_list','RankingController@TopList');
Route::get('v3/generate_live_token','AgoraController@generateToken');
Route::get('v3/comment_skip_word_list','CommentSkipController@WordList');

Route::get('v3/user_live_store','UserLiveController@Store');

Route::get('v3/user_live_home','UserLiveController@Index')->middleware('throttle:home_data_limit');
Route::get('v3/party_index','UserLiveController@PartyIndex');
Route::get('v3/user_friend_live','UserLiveController@FriendsLive');
  
Route::get('v3/user_live_remove','UserLiveController@Delete');
Route::get('v3/comments_socket_io_store','CommentController@Store');
Route::get('v3/entry_realtime','CommentController@CheckEntry');
Route::get('v3/join_socket_io_store','CommentController@JoinStore');
Route::get('v3/gift_socket_io_store','CommentController@GiftPush');
Route::get('v3/audio_gift_socket_io_store','CommentController@AudioGiftPush');
Route::get('v3/audience_leave','CommentController@AudienceLeave');
Route::get('v3/audience_list','CommentController@AudienceList');
Route::get('v3/fly_comment','CommentController@FlyComment');
Route::get('v3/comment_mute_add','CommentController@CommentMute');
Route::get('v3/comment_mute_removed','CommentController@CommentMuteRemove');


Route::get('v3/check_balance_monthly','GiftController@HostBalanceChack');
Route::get('v3/gift_file_data','GiftController@GiftData');
//profile
Route::get('v3/profile/live_data','ProfileController@ProfileLiveData');
Route::post('v3/profile/update','ProfileController@ProfileUpdate');

Route::get('v3/co_host_request','LiveCoHostController@JoinCall');
Route::get('v3/co_host_request_list','LiveCoHostController@CallList');
Route::get('v3/co_host_request_accept','LiveCoHostController@CallAccept');
Route::get('v3/co_host_call_remove','LiveCoHostController@CallRemoved');
Route::get('v3/co_host_call_accept_list','LiveCoHostController@CallAcceptList');
Route::get('v3/co_host_call_mute','LiveCoHostController@CallMute');
Route::get('v3/co_host_call_mute_audio_brd_firebase','LiveCoHostController@AudioCallMuteFirebase');

//Audio BRD
Route::get('v3/audio_co_host_request','AudioBrdController@CallRequest');
Route::get('v3/audio_brd_host_list','AudioBrdController@HostList');
Route::get('v3/audio_user_live_store','AudioBrdController@Store');
Route::get('v3/audio_brd_call_request_list','AudioBrdController@CallList');
Route::get('v3/audio_call_accept','AudioBrdController@AudioCallAccept');
Route::get('v3/audio_call_mute','AudioBrdController@CallMute');
Route::get('v3/audio_call_remove','AudioBrdController@CallRemoved');
Route::get('v3/audio_brd_user_data','AudioBrdController@UserData');
Route::get('v3/audio_brd_host_mute','AudioBrdController@HostMue');
Route::get('v3/audio_gift_push','AudioBrdController@AudioGiftPush');
Route::get('v3/audio_kick','AudioBrdController@Kick');
Route::get('v3/audio_host_call_remove','AudioBrdController@HostCallRemove');
Route::get('v3/audio_brd_lock_unlock','AudioBrdController@LockUnlock');
Route::get('v3/audio_brd_pending_call_remove','AudioBrdController@PendingCallRemoved');
Route::get('v3/audio_check_co_host_active_or_inactive_call','AudioBrdController@CohostisActive');
Route::get('v3/audio_sand_emoji','AudioBrdController@SandEmoji');


//Video Brd
Route::get('v3/agora_video_setting','VideoBrdController@AgoraSetting');
Route::get('v3/video_co_host_request','VideoBrdController@CallRequest');
Route::get('v3/video_call_accept','VideoBrdController@VideoCallAccept');
Route::get('v3/video_call_mute','VideoBrdController@CallMute');
Route::get('v3/video_host_call_mute','VideoBrdController@HostMue');
Route::get('v3/video_user_live_store','VideoBrdController@Store');
Route::get('v3/video_call_remove_by_host ','VideoBrdController@HostCallRemove');
Route::get('v3/video_call_remove','VideoBrdController@CallRemoved');
Route::get('v3/video_gift_push','VideoBrdController@VideoGiftPush');
Route::get('v3/video_brd_user_data','VideoBrdController@UserData');
Route::get('v3/video_brd_pending_call_removed','VideoBrdController@PendingCallRemoved');
Route::get('v3/video_day_time_request','VideoBrdController@VideoBrdDayTimeRequest');
Route::get('v3/video_kick','VideoBrdController@Kick');

Route::get('v3/check_co_host_active_or_inactive_call','VideoBrdController@CohostisActive');

  
//friend request
Route::get('v3/follow','FollowerController@Follow');
Route::get('v3/un_follow','FollowerController@UnFollow');
Route::get('v3/follow_request_sand','FollowerController@Store');
Route::get('v3/follower_list','FollowerController@FollowerIndex');
Route::get('v3/friend_list','FollowerController@FriendIndex');
Route::get('v3/following_list','FollowerController@FollowingIndex');
  
//search 
  Route::get('v3/search','SearchController@Search');
  //chat
  Route::get('v3/chat_gift','ChatController@Gift');
  Route::get('v3/chat_store','ChatController@Store');
  Route::get('v3/lucky_gift','LuckyGiftController@Store');
//blocked 
Route::get('v3/block','BlockController@Store');
Route::get('v3/block_list','BlockController@Index');
Route::get('v3/unblock','BlockController@UnBlock');
  //user Profile
  Route::get('v3/user_data','UserDataController@Index');
  Route::get('v3/host_type','UserDataController@HostType');
  //Agency/HostControll
Route::get('v3/my-host-list','AgencyController@MyHost');
Route::get('v3/my-host-data','AgencyController@MyHostData');
Route::get('v3/my-host-profile','AgencyController@MyHostProfile');
Route::get('v3/add-host','AgencyController@AddHost');
Route::get('v3/host_verify','AgencyController@HostVerify');
//
Route::get('v3/active_coinbeg','CoinBegController@ActiveCoinBeg');
Route::get('v3/clim_coin_beg','CoinBegController@Claim');
  
//Help
Route::get('v3/help-store','HelpController@Store');
//slider
Route::get('v3/slider','SliderController@Index');
//Transfer
Route::get('v3/protal_data','PortalController@Index');
Route::get('v3/protal_balance_transfer','PortalController@Transfer');
Route::get('v3/protal_to_protal_transfer','PortalController@ProtalTransfer');
  
Route::get('v3/invisibal_active_inactive','SettingController@ActiveInvisible');
Route::get('v3/offical_brd_off_action','SettingController@LiveOff');
  
Route::get('v3/global_live','GlobalController@Index');
Route::get('v3/global_live_country_wise','GlobalController@CountryWiseData');

Route::get('v3/my_vip','VipController@Index');
Route::get('v3/vip_active','VipController@Active');
Route::get('v3/vip_active_inactive','VipController@VIPActive');
Route::get('v3/notification','VipController@Notification');
Route::get('v3/buy_entry','VipController@BuyEntry');
Route::get('v3/store_items','VipController@EntryFrame');
Route::get('v3/store_items_active_inactive','VipController@EntryFrameActiveInactive');
Route::get('v3/lavel_list','LavelController@Index');

//Invite
Route::get('v3/invite_deshbord','InviteController@Index');
Route::get('v3/invite_reward_withdraw','InviteController@Withdaw');
Route::get('v3/invite_confirm','InviteController@Invite');
Route::get('v3/invite_cancel','InviteController@InviteCancel');

Route::get('v3/host_request_call_audience','HostCallController@CallRequest');
Route::get('v3/host_request_call_accept_audience','HostCallController@CallAccept');
Route::get('v3/audio_host_request_call_audience','HostCallController@AudioCallRequest');
Route::get('v3/audio_host_request_call_accept_audience','HostCallController@AudioCallAccept');

Route::get('v3/host_withdraw_page','WithdrawController@Index');
Route::get('v3/host_withdraw_request','WithdrawController@SuperAgencyWithdraw');
Route::get('v3/agency_withdraw_wallet','WithdrawController@AgencyWallet');
Route::get('v3/agency_withdraw_convart','WithdrawController@Convart');
Route::get('v3/agency_withdraw_approved','WithdrawController@Approved');

Route::get('v3/brd_image_list','BrdImageController@Index');
Route::get('v3/brd_image_user_remove','BrdImageController@Delete');
Route::get('v3/brd_image_upload','BrdImageController@Store');


Route::get('v3/add_brd_admin','BrdAdminController@Store');
Route::get('v3/removed_brd_admin','BrdAdminController@Remove');
});

Route::group(['namespace' => 'Api\V2','middleware' => ['auth:sanctum']], function () {
Route::get('Notification','VideoBrdController@Notification');
Route::get('v2/logout','AuthController@Logout');
Route::get('v2/login_user','AuthController@UserData');
Route::get('v2/change_password','AuthController@ChangePassword');
//Product
Route::get('v2/rank','RankingController@RankList');
Route::get('v2/top_list','RankingController@TopList');
Route::get('v2/generate_live_token','AgoraController@generateToken');
Route::get('v2/comment_skip_word_list','CommentSkipController@WordList');

Route::get('v2/user_live_store','UserLiveController@Store');
Route::get('v2/user_live_home','UserLiveController@Index')->middleware('throttle:home_data_limit');
Route::get('v2/party_index','UserLiveController@PartyIndex');
Route::get('v2/user_friend_live','UserLiveController@FriendsLive');
  
Route::get('v2/user_live_remove','UserLiveController@Delete');
Route::get('v2/comments_socket_io_store','CommentController@Store');
Route::get('v2/entry_realtime','CommentController@CheckEntry');
Route::get('v2/join_socket_io_store','CommentController@JoinStore');
Route::get('v2/gift_socket_io_store','CommentController@GiftPush');
Route::get('v2/audio_gift_socket_io_store','CommentController@AudioGiftPush');
Route::get('v2/audience_leave','CommentController@AudienceLeave');
Route::get('v2/audience_list','CommentController@AudienceList');


Route::get('v2/check_balance_monthly','GiftController@HostBalanceChack');
//profile
Route::get('v2/profile/live_data','ProfileController@ProfileLiveData');
Route::get('v2/profile/update','ProfileController@ProfileUpdate');

Route::get('v2/co_host_request','LiveCoHostController@JoinCall');
Route::get('v2/co_host_request_list','LiveCoHostController@CallList');
Route::get('v2/co_host_request_accept','LiveCoHostController@CallAccept');
Route::get('v2/co_host_call_remove','LiveCoHostController@CallRemoved');
Route::get('v2/co_host_call_accept_list','LiveCoHostController@CallAcceptList');
Route::get('v2/co_host_call_mute','LiveCoHostController@CallMute');
Route::get('v2/co_host_call_mute_audio_brd_firebase','LiveCoHostController@AudioCallMuteFirebase');

//Audio BRD
Route::get('v2/audio_co_host_request','AudioBrdController@CallRequest');
Route::get('v2/audio_brd_host_list','AudioBrdController@HostList');
Route::get('v2/audio_user_live_store','AudioBrdController@Store');
Route::get('v2/audio_brd_call_request_list','AudioBrdController@CallList');
Route::get('v2/audio_call_accept','AudioBrdController@AudioCallAccept');
Route::get('v2/audio_call_mute','AudioBrdController@CallMute');
Route::get('v2/audio_call_remove','AudioBrdController@CallRemoved');
Route::get('v2/audio_brd_user_data','AudioBrdController@UserData');
Route::get('v2/audio_brd_host_mute','AudioBrdController@HostMue');
Route::get('v2/audio_gift_push','AudioBrdController@AudioGiftPush');
Route::get('v2/audio_kick','AudioBrdController@Kick');
Route::get('v2/audio_host_call_remove','AudioBrdController@HostCallRemove');
Route::get('v2/audio_brd_lock_unlock','AudioBrdController@LockUnlock');
Route::get('v2/audio_brd_pending_call_remove','AudioBrdController@PendingCallRemoved');
Route::get('v2/audio_check_co_host_active_or_inactive_call','AudioBrdController@CohostisActive');
Route::get('v2/audio_sand_emoji','AudioBrdController@SandEmoji');


//Video Brd
Route::get('v2/video_co_host_request','VideoBrdController@CallRequest');
Route::get('v2/video_call_accept','VideoBrdController@VideoCallAccept');
Route::get('v2/video_call_mute','VideoBrdController@CallMute');
Route::get('v2/video_host_call_mute','VideoBrdController@HostMue');
Route::get('v2/video_user_live_store','VideoBrdController@Store');
Route::get('v2/video_call_remove_by_host ','VideoBrdController@HostCallRemove');
Route::get('v2/video_call_remove','VideoBrdController@CallRemoved');
Route::get('v2/video_gift_push','VideoBrdController@VideoGiftPush');
Route::get('v2/video_brd_user_data','VideoBrdController@UserData');
Route::get('v2/video_brd_pending_call_removed','VideoBrdController@PendingCallRemoved');
Route::get('v2/video_day_time_request','VideoBrdController@VideoBrdDayTimeRequest');
Route::get('v2/video_kick','VideoBrdController@Kick');

Route::get('v2/check_co_host_active_or_inactive_call','VideoBrdController@CohostisActive');

  
//friend request
Route::get('v2/follow','FollowerController@Follow');
Route::get('v2/un_follow','FollowerController@UnFollow');
Route::get('v2/follow_request_sand','FollowerController@Store');
Route::get('v2/follower_list','FollowerController@FollowerIndex');
Route::get('v2/friend_list','FollowerController@FriendIndex');
Route::get('v2/following_list','FollowerController@FollowingIndex');
  
//search 
  Route::get('v2/search','SearchController@Search');
  //chat
  Route::get('v2/chat_gift','ChatController@Gift');
  Route::get('v2/chat_store','ChatController@Store');
  Route::get('v2/lucky_gift','LuckyGiftController@Store');
//blocked 
Route::get('v2/block','BlockController@Store');
Route::get('v2/block_list','BlockController@Index');
Route::get('v2/unblock','BlockController@UnBlock');
  //user Profile
  Route::get('v2/user_data','UserDataController@Index');
  //Agency/HostControll
Route::get('v2/my-host-list','AgencyController@MyHost');
Route::get('v2/my-host-data','AgencyController@MyHostData');
Route::get('v2/my-host-profile','AgencyController@MyHostProfile');
Route::get('v2/add-host','AgencyController@AddHost');
Route::get('v2/host_verify','AgencyController@HostVerify');

//Help
Route::get('v2/help-store','HelpController@Store');
//slider
Route::get('v2/slider','SliderController@Index');
//Transfer
Route::get('v2/protal_data','PortalController@Index');
Route::get('v2/protal_balance_transfer','PortalController@Transfer');
Route::get('v2/protal_to_protal_transfer','PortalController@ProtalTransfer');
  
Route::get('v2/invisibal_active_inactive','SettingController@ActiveInvisible');
Route::get('v2/offical_brd_off_action','SettingController@LiveOff');
  
Route::get('v2/global_live','GlobalController@Index');
Route::get('v2/global_live_country_wise','GlobalController@CountryWiseData');

Route::get('v2/my_vip','VipController@Index');
Route::get('v2/vip_active','VipController@Active');
Route::get('v2/vip_active_inactive','VipController@VIPActive');
Route::get('v2/notification','VipController@Notification');
Route::get('v2/buy_entry','VipController@BuyEntry');
Route::get('v2/store_items','VipController@EntryFrame');
Route::get('v2/store_items_active_inactive','VipController@EntryFrameActiveInactive');
Route::get('v2/lavel_list','LavelController@Index');

//Invite
Route::get('v2/invite_deshbord','InviteController@Index');
Route::get('v2/invite_reward_withdraw','InviteController@Withdaw');
Route::get('v2/invite_confirm','InviteController@Invite');
Route::get('v2/invite_cancel','InviteController@InviteCancel');

Route::get('v2/host_request_call_audience','HostCallController@CallRequest');
Route::get('v2/host_request_call_accept_audience','HostCallController@CallAccept');
Route::get('v2/audio_host_request_call_audience','HostCallController@AudioCallRequest');
Route::get('v2/audio_host_request_call_accept_audience','HostCallController@AudioCallAccept');

Route::get('v2/host_withdraw_page','WithdrawController@Index');
Route::get('v2/host_withdraw_request','WithdrawController@SuperAgencyWithdraw');
Route::get('v2/agency_withdraw_wallet','WithdrawController@AgencyWallet');
Route::get('v2/agency_withdraw_convart','WithdrawController@Convart');
Route::get('v2/agency_withdraw_approved','WithdrawController@Approved');

});
Route::group(['namespace' => 'Api','middleware' => ['auth:sanctum']], function () {
Route::get('logout','AuthController@Logout');
Route::get('login_user','AuthController@UserData');
Route::get('change_password','AuthController@ChangePassword');
//Product
Route::get('rank','RankingController@RankList')->middleware('broadlive.redis_first:ranking,30,120');
Route::get('generate_live_token','AgoraController@generateToken');
Route::match(['get','post'],'play_generate_live_token','AgoraController@generateToken');Route::match(['get','post'],'startStream','AgoraController@startStream');
Route::get('comment_skip_word_list','CommentSkipController@WordList');
Route::get('vip_setup_config','VipSetupController@Index');

Route::get('user_live_store','UserLiveController@Store');
Route::get('user_live_home','UserLiveController@Index')->middleware('throttle:home_data_limit')->middleware('broadlive.redis_first:room_list,3,10');
Route::get('party_index','UserLiveController@PartyIndex');
Route::get('user_friend_live','UserLiveController@FriendsLive');
  
Route::get('user_live_remove','UserLiveController@Delete');
Route::get('comments_socket_io_store','CommentController@Store');
Route::get('join_socket_io_store','CommentController@JoinStore');
Route::get('gift_socket_io_store','CommentController@GiftPush');
Route::get('audio_gift_socket_io_store','CommentController@AudioGiftPush');
Route::get('audience_leave','CommentController@AudienceLeave');
Route::get('audience_list','CommentController@AudienceList');


Route::get('check_balance_monthly','GiftController@HostBalanceChack');
Route::get('live_data_monthly_earn','LiveDataController@monthlyEarnSummary');
//profile
Route::get('profile/live_data','ProfileController@ProfileLiveData')->middleware('broadlive.redis_first:public_profile,30,60');
Route::get('profile/update','ProfileController@ProfileUpdate');

Route::get('co_host_request','LiveCoHostController@JoinCall');
Route::get('co_host_request_list','LiveCoHostController@CallList')->middleware('broadlive.redis_first:audio_room_state,1,3');
// broadlive main domain compatibility aliases
Route::get('ranking','RankingController@RankList')->middleware('broadlive.redis_first:ranking,30,120');
Route::get('room/list','UserLiveController@Index')->middleware('throttle:home_data_limit')->middleware('broadlive.redis_first:room_list,3,10');
Route::get('gift/list','GiftController@GiftData')->middleware('broadlive.redis_first:gift_list,30,120');
Route::get('profile','ProfileController@ProfileLiveData')->middleware('broadlive.redis_first:public_profile,30,60');
Route::get('cohost/list','LiveCoHostController@CallList')->middleware('broadlive.redis_first:audio_room_state,1,3');
Route::get('co_host_request_accept','LiveCoHostController@CallAccept');
Route::get('co_host_call_remove','LiveCoHostController@CallRemoved');
Route::get('co_host_call_accept_list','LiveCoHostController@CallAcceptList');
Route::get('co_host_call_mute','LiveCoHostController@CallMute');
Route::get('co_host_call_mute_audio_brd_firebase','LiveCoHostController@AudioCallMuteFirebase');

//Audio BRD
Route::get('audio_co_host_request','AudioBrdController@CallRequest');
Route::get('audio_brd_host_list','AudioBrdController@HostList');
Route::get('audio_user_live_store','AudioBrdController@Store');
Route::get('audio_brd_call_request_list','AudioBrdController@CallList');
Route::get('audio_call_accept','AudioBrdController@AudioCallAccept');
Route::get('audio_call_mute','AudioBrdController@CallMute');
Route::get('audio_call_remove','AudioBrdController@CallRemoved');
Route::get('audio_brd_user_data','AudioBrdController@UserData');
Route::get('audio_brd_host_mute','AudioBrdController@HostMue');
Route::get('audio_gift_push','AudioBrdController@AudioGiftPush');
Route::get('audio_kick','AudioBrdController@Kick');
Route::get('audio_host_call_remove','AudioBrdController@HostCallRemove');
Route::get('audio_brd_lock_unlock','AudioBrdController@LockUnlock');
Route::get('audio_brd_pending_call_remove','AudioBrdController@PendingCallRemoved');
Route::get('audio_check_co_host_active_or_inactive_call','AudioBrdController@CohostisActive');
Route::get('audio_sand_emoji','AudioBrdController@SandEmoji');


//Video Brd
Route::get('video_co_host_request','VideoBrdController@CallRequest');
Route::get('video_call_accept','VideoBrdController@VideoCallAccept');
Route::get('video_call_mute','VideoBrdController@CallMute');
Route::get('video_host_call_mute','VideoBrdController@HostMue');
Route::get('video_user_live_store','VideoBrdController@Store');
Route::get('video_call_remove_by_host ','VideoBrdController@HostCallRemove');
Route::get('video_call_remove','VideoBrdController@CallRemoved');
Route::get('video_gift_push','VideoBrdController@VideoGiftPush');
Route::get('video_brd_user_data','VideoBrdController@UserData');
Route::get('video_brd_pending_call_removed','VideoBrdController@PendingCallRemoved');
Route::get('video_day_time_request','VideoBrdController@VideoBrdDayTimeRequest');
Route::get('video_kick','VideoBrdController@Kick');

Route::get('check_co_host_active_or_inactive_call','VideoBrdController@CohostisActive');

  
//friend request
Route::get('follow','FollowerController@Follow');
Route::get('un_follow','FollowerController@UnFollow');
Route::get('follow_request_sand','FollowerController@Store');
Route::get('follower_list','FollowerController@FollowerIndex');
Route::get('friend_list','FollowerController@FriendIndex');
Route::get('following_list','FollowerController@FollowingIndex');
  
//search 
  Route::get('search','SearchController@Search');
  //chat
  Route::get('chat_gift','ChatController@Gift');
  Route::get('chat_store','ChatController@Store');
  Route::get('lucky_gift','LuckyGiftController@Store');
//blocked 
Route::get('block','BlockController@Store');
Route::get('block_list','BlockController@Index');
Route::get('unblock','BlockController@UnBlock');
  //user Profile
  Route::get('user_data','UserDataController@Index');
  //Agency/HostControll
Route::get('my-host-list','AgencyController@MyHost');
Route::get('my-host-profile','AgencyController@MyHostProfile');
Route::get('add-host','AgencyController@AddHost');
Route::get('host_verify','AgencyController@HostVerify');

//Help
Route::get('help-store','HelpController@Store');
//slider
Route::get('slider','SliderController@Index');
//Transfer
Route::get('protal_data','PortalController@Index');
Route::get('protal_balance_transfer','PortalController@Transfer');
Route::get('protal_to_protal_transfer','PortalController@ProtalTransfer');
  
Route::get('invisibal_active_inactive','SettingController@ActiveInvisible');
Route::get('offical_brd_off_action','SettingController@LiveOff');
  
Route::get('global_live','GlobalController@Index');
Route::get('global_live_country_wise','GlobalController@CountryWiseData');

Route::get('my_vip','VipController@Index');
Route::get('vip_active','VipController@Active');
Route::get('notification','VipController@Notification');
Route::get('lavel_list','LavelController@Index');

//Invite
Route::get('invite_deshbord','InviteController@Index');
Route::get('invite_reward_withdraw','InviteController@Withdaw');
Route::get('invite_confirm','InviteController@Invite');
Route::get('invite_cancel','InviteController@InviteCancel');

Route::get('host_request_call_audience','HostCallController@CallRequest');
Route::get('host_request_call_accept_audience','HostCallController@CallAccept');
Route::get('audio_host_request_call_audience','HostCallController@AudioCallRequest');
Route::get('audio_host_request_call_accept_audience','HostCallController@AudioCallAccept');

Route::get('host_withdraw_page','WithdrawController@Index');
Route::get('host_withdraw_request','WithdrawController@SuperAgencyWithdraw');
Route::get('agency_withdraw_wallet','WithdrawController@AgencyWallet');
Route::get('agency_withdraw_convart','WithdrawController@Convart');
Route::get('agency_withdraw_approved','WithdrawController@Approved');


});


Route::group(['namespace' => 'Api\V4','middleware' => ['auth:sanctum']], function () {
Route::get('v4/Notification','VipController@Notification');
Route::get('v4/logout','AuthController@Logout');
Route::get('v4/login_user','AuthController@UserData');
Route::get('v4/change_password','AuthController@ChangePassword');
//Product
Route::get('v4/rank','RankingController@RankList');
Route::get('v4/top_list','RankingController@TopList');
Route::get('v4/generate_live_token','AgoraController@generateToken');
Route::get('v4/comment_skip_word_list','CommentSkipController@WordList');

Route::get('v4/user_live_store','UserLiveController@Store');
Route::get('v4/user_live_home','UserLiveController@Index')->middleware('throttle:home_data_limit');
Route::get('v4/party_index','UserLiveController@PartyIndex');
Route::get('v4/user_friend_live','UserLiveController@FriendsLive');

Route::get('v4/user_live_remove','UserLiveController@Delete');
Route::get('v4/comments_socket_io_store','CommentController@Store');
Route::get('v4/room_bootstrap','CommentController@RoomBootstrap');
Route::get('v4/cache_clear','CommentController@ClearRoomCache');
Route::get('v4/entry_realtime','CommentController@CheckEntry');
Route::get('v4/join_socket_io_store','CommentController@JoinStore');
Route::get('v4/gift_socket_io_store','CommentController@GiftPush');
Route::get('v4/audio_gift_socket_io_store','CommentController@AudioGiftPush');
Route::get('v4/audience_leave','CommentController@AudienceLeave');
Route::get('v4/audience_list','CommentController@AudienceList');
Route::get('v4/fly_comment','CommentController@FlyComment');
Route::get('v4/comment_mute_add','CommentController@CommentMute');
Route::get('v4/comment_mute_removed','CommentController@CommentMuteRemove');

Route::get('v4/check_balance_monthly','GiftController@HostBalanceChack');
Route::get('v4/gift_file_data','GiftController@GiftData');
//profile
Route::get('v4/profile/live_data','ProfileController@ProfileLiveData');
Route::get('v4/live_data','ProfileController@ProfileLiveData');
Route::get('v4/profile/visit','UserDataController@ProfileVisit');
Route::post('v4/profile/update','ProfileController@ProfileUpdate');

Route::get('v4/co_host_request','LiveCoHostController@JoinCall');
Route::get('v4/co_host_request_list','LiveCoHostController@CallList');
Route::get('v4/co_host_request_accept','LiveCoHostController@CallAccept');
Route::get('v4/co_host_call_remove','LiveCoHostController@CallRemoved');
Route::get('v4/co_host_call_accept_list','LiveCoHostController@CallAcceptList');
Route::get('v4/co_host_call_mute','LiveCoHostController@CallMute');
Route::get('v4/co_host_call_mute_audio_brd_firebase','LiveCoHostController@AudioCallMuteFirebase');

//Audio BRD
Route::get('v4/audio_co_host_request','AudioBrdController@CallRequest');
Route::get('v4/audio_brd_host_list','AudioBrdController@HostList');
Route::get('v4/audio_user_live_store','AudioBrdController@Store');
Route::get('v4/audio_brd_call_request_list','AudioBrdController@CallList');
Route::get('v4/audio_call_accept','AudioBrdController@AudioCallAccept');
Route::get('v4/audio_call_mute','AudioBrdController@CallMute');
Route::get('v4/audio_call_remove','AudioBrdController@CallRemoved');
Route::get('v4/audio_brd_user_data','AudioBrdController@UserData');
Route::get('v4/audio_brd_host_mute','AudioBrdController@HostMue');
Route::get('v4/audio_gift_push','AudioBrdController@AudioGiftPush');
Route::get('v4/audio_kick','AudioBrdController@Kick');
Route::get('v4/audio_host_call_remove','AudioBrdController@HostCallRemove');
Route::get('v4/audio_brd_lock_unlock','AudioBrdController@LockUnlock');
Route::get('v4/audio_brd_pending_call_remove','AudioBrdController@PendingCallRemoved');
Route::get('v4/audio_check_co_host_active_or_inactive_call','AudioBrdController@CohostisActive');
Route::get('v4/audio_sand_emoji','AudioBrdController@SandEmoji');

//Video Brd
Route::get('v4/agora_video_setting','VideoBrdController@AgoraSetting');
Route::get('v4/video_co_host_request','VideoBrdController@CallRequest');
Route::get('v4/video_call_accept','VideoBrdController@VideoCallAccept');
Route::get('v4/video_call_mute','VideoBrdController@CallMute');
Route::get('v4/video_host_call_mute','VideoBrdController@HostMue');
Route::get('v4/video_user_live_store','VideoBrdController@Store');
Route::get('v4/video_call_remove_by_host','VideoBrdController@HostCallRemove');
Route::get('v4/video_call_remove','VideoBrdController@CallRemoved');
Route::get('v4/video_gift_push','VideoBrdController@VideoGiftPush');
Route::get('v4/video_brd_user_data','VideoBrdController@UserData');
Route::get('v4/video_brd_pending_call_removed','VideoBrdController@PendingCallRemoved');
Route::get('v4/video_day_time_request','VideoBrdController@VideoBrdDayTimeRequest');
Route::get('v4/video_kick','VideoBrdController@Kick');
Route::get('v4/check_co_host_active_or_inactive_call','VideoBrdController@CohostisActive');

//friend request
Route::get('v4/follow','FollowerController@Follow');
Route::get('v4/un_follow','FollowerController@UnFollow');
Route::get('v4/follow_request_sand','FollowerController@Store');
Route::get('v4/follower_list','FollowerController@FollowerIndex');
Route::get('v4/friend_list','FollowerController@FriendIndex');
Route::get('v4/following_list','FollowerController@FollowingIndex');

//search
Route::get('v4/search','SearchController@Search');
//chat
Route::get('v4/chat_gift','ChatController@Gift');
Route::get('v4/chat_store','ChatController@Store');
Route::get('v4/lucky_gift','LuckyGiftController@Store');
//blocked
Route::get('v4/block','BlockController@Store');
Route::get('v4/block_list','BlockController@Index');
Route::get('v4/unblock','BlockController@UnBlock');
Route::get('v4/unblock_user','BlockController@UnBlock');
//user Profile
Route::get('v4/user_data','UserDataController@Index');
Route::get('v4/host_type','UserDataController@HostType');
//Agency/HostControll
Route::get('v4/my-host-list','AgencyController@MyHost');
Route::get('v4/my-host-data','AgencyController@MyHostData');
Route::get('v4/my-host-profile','AgencyController@MyHostProfile');
Route::get('v4/add-host','AgencyController@AddHost');
Route::get('v4/host_verify','AgencyController@HostVerify');

Route::get('v4/active_coinbeg','CoinBegController@ActiveCoinBeg');
Route::get('v4/clim_coin_beg','CoinBegController@Claim');

//Help
Route::get('v4/help-store','HelpController@Store');
//slider is registered before the Sanctum group so app banner reads can use the legacy access_token check.
//Transfer
Route::get('v4/protal_data','PortalController@Index');
Route::get('v4/protal_balance_transfer','PortalController@Transfer');
Route::get('v4/protal_to_protal_transfer','PortalController@ProtalTransfer');

Route::get('v4/invisibal_active_inactive','SettingController@ActiveInvisible');
Route::get('v4/offical_brd_off_action','SettingController@LiveOff');

Route::get('v4/global_live','GlobalController@Index');
Route::get('v4/global_live_country_wise','GlobalController@CountryWiseData');

Route::get('v4/my_vip','VipController@Index');
Route::get('v4/vip_active','VipController@Active');
Route::get('v4/vip_active_inactive','VipController@VIPActive');
Route::get('v4/notification','VipController@Notification');
Route::get('v4/buy_entry','VipController@BuyEntry');
Route::get('v4/store_items','VipController@EntryFrame');
Route::get('v4/store_items_active_inactive','VipController@EntryFrameActiveInactive');
Route::get('v4/my_decorations','VipController@MyDecorations');
Route::post('v4/activate_decoration','VipController@ActivateDecoration');
Route::get('v4/lavel_list','LavelController@Index');

//Invite
Route::get('v4/invite_deshbord','InviteController@Index');
Route::get('v4/invite_reward_withdraw','InviteController@Withdaw');
Route::get('v4/invite_confirm','InviteController@Invite');
Route::get('v4/invite_cancel','InviteController@InviteCancel');

Route::get('v4/host_request_call_audience','HostCallController@CallRequest');
Route::get('v4/host_request_call_accept_audience','HostCallController@CallAccept');
Route::get('v4/audio_host_request_call_audience','HostCallController@AudioCallRequest');
Route::get('v4/audio_host_request_call_accept_audience','HostCallController@AudioCallAccept');

Route::get('v4/host_withdraw_page','WithdrawController@Index');
Route::get('v4/host_withdraw_request','WithdrawController@SuperAgencyWithdraw');
Route::get('v4/agency_withdraw_wallet','WithdrawController@AgencyWallet');
Route::get('v4/agency_withdraw_convart','WithdrawController@Convart');
Route::get('v4/agency_withdraw_approved','WithdrawController@Approved');
Route::get('v4/recharge_history','PortalController@RechargeHistory');

Route::get('v4/brd_image_list','BrdImageController@Index');
Route::get('v4/brd_image_user_remove','BrdImageController@Delete');
Route::get('v4/brd_image_upload','BrdImageController@Store');

Route::get('v4/add_brd_admin','BrdAdminController@Store');
Route::get('v4/removed_brd_admin','BrdAdminController@Remove');
Route::post('v4/room_comment_ws','RoomCommentController@Send');
});
