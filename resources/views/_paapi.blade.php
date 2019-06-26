<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    @if($itches)
        <p>{{ count($itches) }} itches to update </p>
        @php
        $itch = $itches[0];
        @endphp
        <form action="/_/paapi/{{ $itch->id }}" method="POST">
             @csrf
            <a href="{{ $itch->url }}">{{ $itch->url }}</a><br>
            <input type="text" name="url" placeholder="url"><br>
            <input type="text" name="pic" placeholder="pic"><br>
            <input type="text" name="price" placeholder="price"><br>
            <input type="text" name="description" placeholder="description"><br>
            <input type="submit" value="go">
        </form>
    @else
        <p>All done</p>
    @endif

</body>
</html>