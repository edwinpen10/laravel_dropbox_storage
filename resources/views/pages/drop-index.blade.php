<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
              <script src="http://malsup.github.com/jquery.form.js"></script>
    </head>
    <body>
        <div class="container">

            <form action="{{route('dropboxupload')}}" method="post" enctype="multipart/form-data">
                @csrf
                <label>file(S)</label>
                <input type="file" name="file[]" multiple="true">
                <button type="submit">upload</button>
            </form>
            <br />
                            <div class="progress">
                              <div class="progress-bar progress-bar-striped" role="progressbar" aria-valuenow=""
                              aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                0%
                              </div>
                            </div>
                            <br />
                            <div id="success">

                            </div>
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
                            {{-- @if ($file->file_type == "image/png" || $file->file_type == "image/jpeg")
                                    <img src="{{url('drop/'. $file->file_title)}}" alt="" width="150px" height="150px">
                                    @else
                                    <video width="320" height="240" controls>
                                        <source src="{{url('drop/'. $file->file_title)}}" type="video/mp4">
                                    </video>
                            @endif --}}
        
        
                        <a href="{{url('drop/'. $file->file_title)}}">{{$file->file_title}}</a>
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


        </div>
        <script>
            $(document).ready(function(){
            
                $('form').ajaxForm({
                  beforeSend:function(){
                    $('#success').empty();
                  },
                  uploadProgress:function(event, position, total, percentComplete)
                  {
                    $('.progress-bar').text(percentComplete + '%');
                    $('.progress-bar').css('width', percentComplete + '%');
                  },
                  success:function(data)
                  {
                    if(data.error)
                    {
                      $('.progress-bar').text('0%');
                      $('.progress-bar').css('width', '0%');
                      $('#success').html('<span class="text-danger"><b>'+data.error+'</b></span>');
                    }
                    if(data.success)
                    {  
                      $('.progress-bar').text('Uploaded');
                      $('.progress-bar').css('width', '100%');
                      $('#success').html('<span class="text-success"><b>'+data.success+'</b></span><br /><br />');
                      location.reload(); 
                    }
                  }
                });
            
            });
            </script>
    </body>
</html>
