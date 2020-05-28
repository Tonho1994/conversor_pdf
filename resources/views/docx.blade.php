<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1 shrink-to-fit=no">
        <title>{{ env('APP_NAME') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('img/icono-pdf.png') }}" />
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}">
        <script src="{{ asset('js/dropzone.js') }}"></script>
    </head>
    <body>
        <div class="row">
            <div class="col-md-10 mx-auto">
                <h1 class="display-4 text-center">Conversor pdf</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('conversor.vista') }}">Imágen</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Documento</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body" id ="">
                        <h5 class="card-title">Puedes Subir hasta 6 Documentos</h5>
                        {!! Form::open([ 'route' => [ 'conversordoc.save' ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'my-awesome-dropzone' ]) !!}
                        {!! Form::close() !!}
                            <div class="pt-2 mx-auto">
                                <a href="{{ route('conversordoc.dwnld') }}" class="btn btn-primary">Descargar</a>
                            </div>
                    </div>
                    <div class="card-footer text-muted">
                        6 Archivos de Máximo 2MB. Los formatos permitidos son: .doc .docx. odt .ppt .pptx .odp
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            Dropzone.options.myAwesomeDropzone = {
                maxFilesize: 2,
                maxFiles: 6,
                acceptedFiles: ".docx,.doc,.odt,.pptx,.ppt,.odp",
                filesizeBase: 1024,
                dictDefaultMessage:"Suelta los archivos para cargarlos automáticamente o da clíck",
                dictFileTooBig:"El archivo es muy grande",
                dictInvalidFileType:"Tipo de Archivo Invalido",
                dictRemoveFile:"Borrar",
                dictMaxFilesExceeded:"Máximo de archivos superado",
                addRemoveLinks: true,
                removedfile: function(file){
                    var name = file.name;
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "conversordoc/delete",
                        type: "POST",
                        data: {
                            "name" : name
                        },
                        sucess: function(data){
                            console.log('success: ' + data);
                        }
                    });
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                }
            };
        </script>
        <script src="{{ asset('js/jquery-3.5-1.js') }}"></script>
        <script src="{{ asset('js/bootstrap.bundle.js') }}"></script>
    </body>
</html>
