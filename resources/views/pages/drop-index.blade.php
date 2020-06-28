<html>
    <head>

    </head>
    <body>
    <form action="{{route('dropboxupload')}}" method="post" enctype="multipart/form-data">
        @csrf
        <label>file(S)</label>
        <input type="file" name="file[]" multiple="true">
        <button type="submit">upload</button>
    </form>
    <table border="1">
        <thead>
            <tr>
                <th>Title</th>
                <th>mime/Type</th>
                <th>File Size</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)

            <tr>
                <td>
                    @if ($file->file_type == "image/png")
                            <img src="{{url('drop/'. $file->file_title)}}" alt="" height="100%">
                            @else
                            <video width="320" height="240" controls>
                                <source src="{{url('drop/'. $file->file_title)}}" type="video/mp4">
                            </video>
                    @endif


                {{-- <a href="{{url('drop/'. $file->file_title)}}">{{$file->file_title}}</a> --}}
                </td>
                <td>
                    {{$file->file_type}}
                </td>
                <td>
                    {{number_format($file->file_size / 1024,1)}} Kb
                </td>
                <td>
                    <a href="{{url('drop/'. $file->file_title.'/download')}}">Download</a> || <a href="{{url('delete/'.$file->id.'')}}">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </body>
</html>
