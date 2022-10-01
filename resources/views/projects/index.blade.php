<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<ul>
    @foreach($projects as $project)
    <li>
        <a href="{{route('projects.show', $project->id)}}">
            {{$project->title}}-{{$project->description}}
        </a>
    </li>
    @endforeach
</ul>
</body>
</html>
