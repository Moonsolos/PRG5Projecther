@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="mb-4">One Piece Decks</h1>
            <p class="lead">This website was made to showcase the leaders of the One Piece TCG</p>
        </div>
        <!-- Search Bar -->
        <form class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Search for a trick...">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="searchBtn">Search</button>
                </div>
            </div>
        </form>

        <form class="mb-4">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="blackCheckbox" value="black">
                <label class="form-check-label" for="blackCheckbox">Black</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="yellowCheckbox" value="yellow">
                <label class="form-check-label" for="yellowCheckbox">Yellow</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="greenCheckbox" value="green">
                <label class="form-check-label" for="greenCheckbox">Green</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="blueCheckbox" value="blue">
                <label class="form-check-label" for="blueCheckbox">Blue</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="redCheckbox" value="red">
                <label class="form-check-label" for="redCheckbox">Red</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" id="purpleCheckbox" value="purple">
                <label class="form-check-label" for="purpleCheckbox">Purple</label>
            </div>
        </form>

        <div class="form-box">
            <div class="form-group row" id="deckList">
                @foreach($decks as $deck)
                    <div class="col-md-4 deck-item" data-colors="{{ $deck->colors }}">
                        @can('edit-deck', $deck)
                            <a href="{{ route('decks.edit', ['deck' => $deck->id]) }}">
                                <img class="img-fluid h-75" src="{{ asset('storage/' . $deck->thumbnail) }}" alt="Deck Image">
                                <h1>{{ $deck->name }}</h1>
                            </a>
                            <p>{{ $deck->colors }}</p>
                            <form method="POST" action="{{ route('decks.delete', ['deck' => $deck->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="alert alert-danger">Verwijder</button>
                            </form>
                        @else
                            <img class="img-fluid h-75" src="{{ asset('storage/' . $deck->thumbnail) }}" alt="Deck Image">
                            <h1>{{ $deck->name }}</h1>
                            <p>{{ $deck->colors }}</p>
                        @endcan
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            function handleSearch() {
                let searchTerm = $('#searchInput').val().toLowerCase();
                filterList(searchTerm);
            }

            // Function to handle color filtering
            function handleColorFilter() {
                let selectedColors = [];
                $('input[type=checkbox]:checked').each(function () {
                    selectedColors.push($(this).val());
                });

                if (selectedColors.length > 0) {
                    $('.deck-item').hide();
                    selectedColors.forEach(function (color) {
                        $('.deck-item[data-colors*=' + color + ']').show();
                    });
                } else {
                    $('.deck-item').show();
                }
            }

            // Event listener for search button
            $('#searchBtn').on('click', function () {
                handleSearch();
            });

            // Event listener for Enter key in search input
            $('#searchInput').on('keyup', function (e) {
                if (e.key === 'Enter') {
                    handleSearch();
                }
            });

            // Event listener for color checkboxes
            $('input[type=checkbox]').on('change', function () {
                handleColorFilter();
            });

            // Initial filtering on page load
            handleColorFilter();
        });

        // Function to filter list based on search term
        function filterList(searchTerm) {
            $('.deck-item').each(function () {
                let deckName = $(this).find('h1').text().toLowerCase();
                if (deckName.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    </script>
@endsection
