@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('You are logged in!') }}
                    </div>


                </div>
                
                <div class="row mt-4">
                    
                @foreach ($news as $item)
                
                    <div class="card col">
                        <div class="card-header">
                            <h2>{{ $item->title }}</h2>
                        </div>
                        <div class="card-body">
                            <img src="{{ $item->thumbnail }}" alt="News Image" class="img-fluid mb-3">
                            <p>{{ $item->content }}</p>
                        </div>
                        <a href="{{ route('share-facebook', ['id' => $item->id]) }}" target="_blank">
                            <button>Chia sẻ Facebook</button>
                        </a>
                    </div>

                @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection