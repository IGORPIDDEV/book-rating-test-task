@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-2 mb-3 mb-md-0">
            <select id="sortSelect" class="form-control">
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating</option>
                <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Title</option>
            </select>
        </div>
        <div class="col-md-7">
            <form action="{{ route('books.index') }}" method="GET" id="searchForm">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Search by title or author" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-1 col-2 text-left">
            <button id="refreshButton" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>
        <div class="col-md-2 col-10 text-right">
            <a href="{{ route('books.create') }}" class="btn btn-primary">Create</a>
        </div>
    </div>
    <div class="row mt-3 mt-md-0">
        @foreach ($books as $book)
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="{{ $book['cover_image'] }}" class="card-img-top" alt="{{ $book['title'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $book['title'] }}</h5>
                        <p class="card-text">{{ $book['author'] }}</p>
                        <a href="{{ route('books.show', $book['id']) }}" class="btn btn-primary">View Book</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('refreshButton').addEventListener('click', function() {
        location.reload();
    });

    setInterval(function() {
        location.reload();
    }, 60000);

    document.getElementById('sortSelect').addEventListener('change', function() {
        const sortValue = this.value;
        const searchParams = new URLSearchParams(window.location.search);
        searchParams.set('sort', sortValue);
        window.location.search = searchParams.toString();
    });

    const sortSelect = document.getElementById('sortSelect');
    sortSelect.addEventListener('change', function() {
        const sortValue = this.value;
        const searchForm = document.getElementById('searchForm');
        const searchInput = searchForm.querySelector('input[name="search"]');
        const searchQuery = searchInput.value;

        const url = new URL(window.location.href);
        url.searchParams.set('sort', sortValue);
        url.searchParams.set('search', searchQuery);

        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.querySelector('.container .row').innerHTML;
                document.querySelector('.container .row').innerHTML = newContent;
            });
    });
</script>
@endpush
