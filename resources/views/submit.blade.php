@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card auth-card">
                <div class="card-header">{{ __('Submit Clip') }}</div>

                <div class="card-body">
                    <form action="{{ route('submit-clip') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <label for="url">Clip URL</label>
                            <p class="text-muted">Paste the full URL to a Twitch Clip.</p>
                            <input class="form-control" id="url" name="url" type="url" required>
                            @if ($errors->has('url'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="title">Clip Title</label>
                            <p class="text-muted">Optionally give the clip a custom title. If left blank, the Twitch clip title will be used.</p>
                            <input class="form-control" id="title" name="title" type="text">
                            @if ($errors->has('title'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="tags">Video Tags</label>
                            <p class="text-muted">Tag the clip with up to 3 appropriate tags separated by comma.</p>
                            <input class="form-control" id="tags" name="tags" type="text">
                            @if ($errors->has('tags'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('tags') }}</strong>
                                </span>
                            @endif
                        </div>

                        <input class="btn btn-primary" type="submit" value="Submit">

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
