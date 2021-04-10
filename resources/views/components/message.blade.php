@if ($errors->any())
    <div class="">
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                {{ $error }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endforeach
    </div>
@endif
@if ($msg = Session::get('message'))
    @php $msg = Session::get('message'); @endphp
    <div class="">
        <div class="alert alert-{{ $msg['type'] }}" role="alert">
            {{ $msg['text'] }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>
@endif