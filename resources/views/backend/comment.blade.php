@forelse($comments as $comment)
@php
    $senderName = $comment->sender_name ?: 'Unknown User';
    $hostName = $comment->host_name ?: 'Unknown Host';
    $search = trim($senderName.' '.$comment->user_id.' '.$hostName.' '.$comment->reciever_id.' '.$comment->channelName.' '.$comment->message);
@endphp
<div class="chat-item" data-feed-item data-search="{{ e($search) }}">
    <div class="chat-avatar">
        <img src="{{ $comment->sender_profile ? URL::to($comment->sender_profile) : asset('public/backend/it-solutionsbd/assets/dist/img/user2-160x160.png') }}" alt="">
        <div class="online-badge online"></div>
    </div>
    <div class="chat-info">
        <h5>{{ \Illuminate\Support\Str::limit($senderName, 34) }} - ID: {{ $comment->user_id }}</h5>
        <p>{{ \Illuminate\Support\Str::limit($comment->message, 120) }}</p>
        <div class="feed-meta">
            Host: {{ \Illuminate\Support\Str::limit($hostName, 28) }} | Channel: {{ \Illuminate\Support\Str::limit($comment->channelName, 24) }} | {{ optional($comment->created_at)->format('Y-m-d H:i:s') }}
        </div>
        @if($comment->user_id && $comment->reciever_id)
            <a class="btn btn-danger btn-sm mt-2" href="{{ URL::to('id_device_banned', ['id' => $comment->user_id, 'host' => $comment->reciever_id]) }}">Device Ban</a>
        @endif
    </div>
</div>
@empty
<div class="feed-empty">No recent comments</div>
@endforelse
