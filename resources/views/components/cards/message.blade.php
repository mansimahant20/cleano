<div class="message-card {{ user()->id == $user->id ? 'message-right-side' : 'message-left-side' }}" id="message-{{ $message->id }}">
    <div class="d-flex">
        @if ($user->id == user()->id || in_array('admin', user_roles()))
            <div class="dropdown message-actions">
                <button class="btn btn-lg f-14 p-0 text-lightest text-capitalize rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-ellipsis-h"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0" aria-labelledby="dropdownMenuLink" tabindex="0">
                    <a class="dropdown-item delete-message" data-row-id="{{ $message->id }}" data-user-id="{{ $user->id }}" href="javascript:;">@lang('app.delete')</a>
                </div>
            </div>
        @endif
    </div>
    @if ($message->message != '')
        <div class="message-text text-dark-grey text-justify text-break f-14">
            <span>{!! nl2br($message->message) !!}</span>
        </div>
    @endif
    {{ $slot }}
    <div class="message-files">
        @foreach ($message->files as $file)
            <div class="file-card">
                @if ($file->icon == 'images')
                    <img src="{{ $file->file_url }}">
                @else
                    <i class="fa {{ $file->icon }} text-lightest"></i>
                @endif
                <div class="dropdown file-action ml-auto">
                    <button class="btn btn-lg f-14 p-0 text-lightest text-capitalize rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0" aria-labelledby="dropdownMenuLink" tabindex="0">
                        <a class="dropdown-item" target="_blank" href="{{ $file->file_url }}">@lang('app.view')</a>
                        <a class="dropdown-item" href="{{ route('message_file.download', md5($file->id)) }}">@lang('app.download')</a>
                        @if (user()->id == $user->id)
                            <a class="dropdown-item delete-file" data-row-id="{{ $file->id }}" href="javascript:;">@lang('app.delete')</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
