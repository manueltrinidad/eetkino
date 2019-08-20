@foreach ($films as $film)
    <h5>{{$film->title_english}}</h5>
@endforeach
@foreach ($names as $name)
    <h5>{{$name->name}}</h5>
@endforeach