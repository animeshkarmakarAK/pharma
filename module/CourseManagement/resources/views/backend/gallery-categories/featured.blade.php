@extends('master::layouts.master')


@push('css')
    <style>
        .album-image {
            height: 20vh;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <form action="{{ route('course_management::admin.gallery-album.change-featured') }}">
            <div class="row">
                @foreach($albums as $key => $album)
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header row">
                                <div class="custom-control custom-checkbox">
                                    <input class="feature-checkbox custom-control-input" type="checkbox"
                                           id="{{ $album->id }}" name="{{ $album->id }}">
                                    <label for="{{ $album->id }}" class="custom-control-label">{{ $album->title_en }}
                                        <sup
                                            style="color: #eeeeee">{{ $album->featured ? "featured" : "not featuring" }}</sup></label>
                                </div>
                            </div>
                            <img class="album-image card-img-bottom" src="{{ asset("storage/". $album->image) }}"
                                 alt="{{ $album->title_en }}">
                        </div>
                    </div>
                @endforeach
            </div>
            <input type="submit" class="btn btn-primary float-right" value="change">
        </form>

    </div>
@endsection


@push('js')
    <script>
        const maxFeaturedGallery = 4;

        function checkMaxFeaturedGallery() {
            let nFeaturedGalleries = $('input[type="checkbox"]:checked').length;
            return nFeaturedGalleries <= maxFeaturedGallery;
        }

        $(document).ready(function () {
            $('.feature-checkbox').on('click', function (e) {
                if (!checkMaxFeaturedGallery() && $(this).is(':checked')) {
                    e.preventDefault();
                    return false;
                }
            })
        })

        $( "form" ).submit(function( event ) {

            // Stop form from submitting normally
            event.preventDefault();

            // Get some values from elements on the page:
            const $form = $( this ),
                url = $form.attr( "action" );

            let checkedAlbums = $('input[type=checkbox]:checked').map(function(_, el) {
                return $(el).attr('id');
            }).get();

            const data = $(this).serialize();
            let posting = $.post( url, { data: checkedAlbums } );

            // Put the results in a div
            posting.done(function( data ) {
               console.log('done');
            });
        });
    </script>
@endpush
