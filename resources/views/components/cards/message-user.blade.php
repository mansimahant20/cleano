@php
$user = $message->from != user()->id ? $message->fromUser : $message->toUser;
@endphp
@if ($message->toUser->unread_messages_count > 0)
    @php
        $unreadMessageCount = $message->toUser->unread_messages_count;
    @endphp
@else
    @php
        $unreadMessageCount = $message->fromUser->unread_messages_count;
    @endphp
@endif


<div class="card rounded-0 border-top-0 border-left-0 border-right-0 user_list_box message-list-color" id="user-no-{{ $user->id }}">
    <a @class([
        'tablinks',
        'show-user-messages',
        'unread-message' => $unreadMessageCount > 0,
    ]) href="javascript:;" data-name="{{ $user->name }}"
        data-user-id="{{ $user->id }}"
        data-unread-message-count="{{ $unreadMessageCount }}">
        <div class="card-horizontal user-message">
            <div class="message-card-img">
                <img class="" src="{{ $user->image_url }}" alt="{{ $user->name }}">
            </div>
            <div class="card-body border-0 pl-0">
                <div class="d-flex justify-content-between">
                    <h4 class="card-title f-14 message-title text-dark-grey">{{ $user->name }}</h4>
                    <!-- <p class="card-date f-11 text-dark-grey mb-0">
                        {{ \Carbon\Carbon::parse($message->created_at)->diffForHumans() }}</p> -->
                </div>
                <div @class([
                    'card-text',
                    'f-12',
                    'text-lightest',
                    'd-flex',
                    'justify-content-between',
                    'message-mention',
                    'text-dark' => $unreadMessageCount > 0,
                    'font-weight-bold' => $unreadMessageCount > 0,
                ])>
                <div>
                    @if (strlen(strip_tags($message->message)) > 40)
                        <p>{{ substr(strip_tags($message->message), 0, 40) }}...</p>
                    @else
                        <p>{{ strip_tags($message->message) }}</p>
                    @endif
                </div>
                    @if ($unreadMessageCount > 0)
                        <div>
                            <span class="badge badge-primary ml-1 unread-count">{{ $unreadMessageCount }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>

