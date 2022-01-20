@foreach($data as $el)
    <div class="alert alert-info">
        <h3>{{$el->name}}</h3>
        <p>{{$el->email}}</p>
        <p>{{$el->created_at}}</p>
    </div>
@endforeach
