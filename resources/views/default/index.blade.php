@extends('master')
@section('body')
<div id="main">
    <form id="form_search" action="{{ route('search') }}">
        <div class = "wrapper">
        <input name="search_text" type="text" class="search_text" placeholder="Search for photos" required>
            <div id="search_icon" class="searchBtn">
                <i class = "fas fa-search"></i>
            </div>
        </div>
    </form>
</div>
@endsection