@forelse($chat_data_all as $chat)
@php
    $sender = ($chat->sender_name ?: 'Unknown Sender').' - ID: '.$chat->sander_id;
    $receiver = ($chat->receiver_name ?: 'Unknown Receiver').' - ID: '.$chat->receiver_id;
    $search = trim($sender.' '.$receiver.' '.$chat->text);
@endphp
<div class="chat-item" data-feed-item data-search="{{ e($search) }}">
    <div class="chat-avatar">
        <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(145deg,#4361ee,#06d6a0);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:900;">
            <i class="typcn typcn-message"></i>
        </div>
        <div class="online-badge online"></div>
    </div>
    <div class="chat-info">
        <h5>{{ \Illuminate\Support\Str::limit($sender, 42) }}</h5>
        <p>{{ \Illuminate\Support\Str::limit($chat->text, 120) }}</p>
        <div class="feed-meta">Receiver: {{ \Illuminate\Support\Str::limit($receiver, 42) }} | {{ optional($chat->created_at)->format('Y-m-d H:i:s') }}</div>
    </div>
</div>
@empty
<div class="feed-empty">No recent chats</div>
@endforelse
