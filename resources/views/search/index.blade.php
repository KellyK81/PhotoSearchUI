@extends('master')
@section('body')
<div id="main" class="search_page">
    <form id="form_search" action="{{ route('search') }}" method="get">
        <div class="wrapper">
            <input name="search_text" type="text" class="search_text" 
                value="{{ app('request')->input('search_text') }}"
                placeholder="Search for photos" required>
            <div id="search_icon" class="searchBtn">
                <i class="fas fa-search"></i>
            </div>
        </div>
    </form>

    <div id="divSearch_table">
        <table id="search_table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Image ID</th>
                    <th>Width</th>
                    <th>Height</th>
                    <th>Image Type (MIME)</th>
                    <th>Photographer</th>
                    <th>Photo</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['photos'] as $photo)
                    <tr>
                        <td>{{ $photo['id'] }}</td>
                        <td>{{ $photo['width'] }}</td>
                        <td>{{ $photo['height'] }}</td>
                        <td>{{ image_type_to_mime_type(exif_imagetype($photo['src']['medium'])) }}
                        <td>{{ ucwords(strtolower($photo['photographer'])) }}</td>
                        <td><img src="{{ $photo['src']['medium'] }}" alt="By {{ $photo['photographer'] }}" width="350" height="300"></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <th>Image ID</th>
                <th>Width</th>
                <th>Height</th>
                <th>Image Type (MIME)</th>
                <th>Photographer</th>
                <th>Photo</th>
                <th></th>
            </tfoot>
        </table>
    </div>
</div>
@endsection