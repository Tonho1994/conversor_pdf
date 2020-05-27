<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 shrink-to-fit=no">
    <title>Conversor</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo e(asset('dropzone-5.7.0/dist/dropzone.css')); ?>">
    <script src="<?php echo e(asset('dropzone-5.7.0/dist/dropzone.js')); ?>"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h1 class="display-4 text-center">Conversor PDF</h1>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card text-center">
                    <div class="card-header">
                        <ul class="nav nav-pills card-header-pills">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Imagen</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">docx</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Ambos</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Sube hasta 3 imágenes aquí</h5>
                        <?php echo Form::open([ 'route' => [ 'conversorimg.store' ], 'files' => true, 'enctype' => 'multipart/form-data', 'class' => 'dropzone', 'id' => 'my-awesome-dropzone' ]); ?>

                        <?php echo Form::close(); ?>

                        <div class="row pt-2">
                            <a href="<?php echo e(route('conversorimg.download')); ?>" class="btn btn-primary mx-auto">Descargar</a>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        Máximo 3 MB. Los formatos soportados son: .jpeg.jpg.png
                    </div>
                    </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        Dropzone.options.myAwesomeDropzone = {
            maxFilesize:3,
            maxFiles:3,
            addRemoveLinks:true,
            dictFileTooBig:"El archivo es muy grande",
            dictInvalidFileType:"El tipo de archivo es incorrecto",
            dictMaxFilesExceeded:"El máximo de 3 archivos fue alcanzado",
            dictRemoveFile:"Borrar",
            acceptedFiles: ".jpeg,.jpg,.png"
        };
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>
<?php /**PATH /var/www/e-revocacion/e_revocacion/resources/views/conversor.blade.php ENDPATH**/ ?>