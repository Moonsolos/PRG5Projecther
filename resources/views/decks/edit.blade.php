@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <a href="{{ route('back') }}" class="btn btn-primary">Back to decks</a>
        <div class="text-center">
            <h1 class="mb-4">Update Deck</h1>
        </div>



        <form action="{{ route('decks.update', ['deck' => $deck->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-group">
                <label for="name">Deck Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $deck->name }}" required>
            </div>
            <div class="form-group">
                <label for="colors">Colors:</label>
                <select name="colors[]" id="colors" class="form-control" multiple>
                    <option value="green" {{ in_array('green', explode(',', $deck->colors)) ? 'selected' : '' }}>Green</option>
                    <option value="red" {{ in_array('red', explode(',', $deck->colors)) ? 'selected' : '' }}>Red</option>
                    <option value="black" {{ in_array('black', explode(',', $deck->colors)) ? 'selected' : '' }}>Black</option>
                    <option value="blue" {{ in_array('blue', explode(',', $deck->colors)) ? 'selected' : '' }}>Blue</option>
                    <option value="yellow" {{ in_array('yellow', explode(',', $deck->colors)) ? 'selected' : '' }}>Yellow</option>
                    <option value="purple" {{ in_array('purple', explode(',', $deck->colors)) ? 'selected' : '' }}>Purple</option>
                </select>
            </div>
            <div class="form-group">
                <label for="thumbnail">Current Thumbnail:</label>
                <img src="{{ asset('storage/' . $deck->thumbnail) }}" alt="Current Thumbnail" style="height: 100px;">
                <input type="file" class="form-control-file" id="thumbnail" name="thumbnail">
            </div>
            <button type="submit" class="btn btn-primary">Update Deck</button>
        </form>
    </div>
@endsection
