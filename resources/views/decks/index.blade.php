@extends('layouts.app')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <div class="container mt-5">
        <div class="text-center">
            <h1 class="mb-4">One Piece Decks</h1>
            <p class="lead">This website was made to showcase the leaders of the One Piece TCG</p>
            <p class="lead">You can only create new leaders after you logged in 3 times</p>
            <p class="lead">You can only update and delete your own leaders</p>
        </div>
        <div class="text-center mb-4">
            <a href="{{ route('decks.create') }}" class="btn btn-primary">Create Leader</a>
        </div>
        <!-- Search Bar -->
        <form class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" id="searchInput" placeholder="Search for a leader..">
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
                            @if ($deck->status === 'active')

                                <a href="{{ route('decks.edit', ['deck' => $deck->id]) }}">
                                    <img class="img-fluid h-75" src="{{ asset('storage/' . $deck->thumbnail) }}" alt="Deck Image">
                                    <h1>{{ $deck->name }}</h1>
                                </a>
                                <p>{{ str_replace(',', ' ', $deck->colors) }}</p>
                                <form method="POST" action="{{ route('decks.toggleStatus', ['deck' => $deck->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Active</button>
                                </form>
                                <form method="POST" action="{{ route('decks.delete', ['deck' => $deck->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="alert alert-danger">Delete</button>
                                </form>
                            @else


                                <form method="POST" action="{{ route('decks.toggleStatus', ['deck' => $deck->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Inactive</button>
                                </form>
                            @endif
                        @else
                            <img class="img-fluid h-75" src="{{ asset('storage/' . $deck->thumbnail) }}" alt="Deck Image">
                            <h1>{{ $deck->name }}</h1>
                            <p>{{ str_replace(',', ' ', $deck->colors) }}</p>
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


            function handleColorFilter() {
                let selectedColors = $('input[type=checkbox]:checked').map(function () {
                    return $(this).val();
                }).get();

                if (selectedColors.length > 0) {
                    $('.deck-item').hide();
                    $('.deck-item').filter(function () {
                        let itemColors = $(this).data('colors').toLowerCase().split(','); // Change split here
                        return selectedColors.some(color => itemColors.includes(color));
                    }).show();
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
