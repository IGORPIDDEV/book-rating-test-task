@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <img src="{{ $book['cover_image'] }}" class="card-img-top" alt="{{ $book['title'] }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $book['title'] }}</h5>
                    <p class="card-text">{{ $book['author'] }}</p>
                    <p>Published at: {{ $book['published_at'] }}</p>
                    <p>Rating: {{ round($averageRating * 2) / 2 ?? 'N/A' }}</p>
                    @auth
                    <form action="{{ route('rating.create', $book['id']) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="rating">Rate this book:</label>
                            <input type="number" class="form-control" id="rating" name="rating" min="1" max="5" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Leave a comment:</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Rating</button>
                    </form>
                    @else
                    <p>Please <a href="{{ route('login') }}">login</a> to leave a rating.</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mt-4 mb-4">
            <h2>Other books:</h2>
        </div>
    </div>
    <div class="row">
        @foreach ($otherBooks as $otherBook)
            <div class="col-md-4">
                <div class="card">
                    <img src="{{ $otherBook['cover_image'] }}" class="card-img-top" alt="{{ $otherBook['title'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $otherBook['title'] }}</h5>
                        <p class="card-text">{{ $otherBook['author'] }}</p>
                        <a href="{{ route('books.show', $otherBook['id']) }}" class="btn btn-primary">View Book</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    setInterval(function() {
        fetch('{{ route('books.index') }}')
            .then(response => response.json())
            .then(data => {
                const otherBooks = document.getElementById('otherBooks');
                otherBooks.innerHTML = '';
                data.forEach(book => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.innerHTML = `<a href="{{ url('books') }}/${book.id}">${book.title}</a>`;
                    otherBooks.appendChild(li);
                });
            });
    }, 10000);
</script>
@endpush
