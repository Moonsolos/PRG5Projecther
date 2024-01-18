@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="mb-4">Create a New Card Trick</h1>
        </div>
        <!-- Form -->
        <form action="{{ route('decks.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Trick Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="colors">Colors:</label>
                <select name="colors[]" id="colors" class="form-control" multiple>
                    <option value="green">Green</option>
                    <option value="red">Red</option>
                    <option value="black">Black</option>
                    <option value="blue">Blue</option>
                    <option value="yellow">Yellow</option>
                    <option value="purple">Purple</option>
                </select>
            </div>
            <div class="form-group">
                <label for="thumbnail">Thumbnail Image:</label>
                <input type="file" class="form-control-file" id="thumbnail" name="thumbnail" required>
            </div>
            <button type="submit" class="btn btn-primary">Create Trick</button>
        </form>
    </div>
@endsection
