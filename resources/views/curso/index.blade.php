<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- //bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    {{-- //font-awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    
    {{-- //csrf-token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
</head>
<body>
    <br><br>
    <div class="container">
        <div class="card">
            <div class="card-header" style="background-color: dimgrey">

                <div class="d-grid gap-2 d-md-flex justify-content-md-end" style="background-color: dimgrey">
                    <button class="btn btn-outline-info btn-agregar" data-bs-toggle="modal" data-bs-target="#curso_modal" type="button">Agregar</button>
                  </div>

            </div>
            <div class="card-body" style="background-color: #343a40">
                <div id="contenido-tabla">
                   
                </div>

            </div>
        </div>
        <div>
            {{--MODALES--}}

            <!-- Modal -->
            <div class="modal fade" id="curso_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="title_curso">Registrar curso</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form id="formulario-curso">
                                    @csrf
                                    <input type="hidden" name="tipo_formulario" id="tipo_formulario" value="">
                                    <input type="hidden" name="id_curso_editar" id="id_curso_editar" value="">
                                    <div class="mb-3">
                                      <label for="nombre_curso" class="form-label">Nombre curso</label>
                                      <input type="text" class="form-control" name="nombre_curso" id="nombre_curso" required>                                      
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripcion</label>                                         
                                        <textarea class="form-control" name="descripcion" id="descripcion" cols="30" rows="5" required></textarea>                                   
                                      </div>
                                    
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Registrar</button>
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>                                        
                                    </div>
                                </form>
                            </div>
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    {{-- Ajax --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- Sweet Alert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- jquery validate --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.js"></script>

    <script>
        //csrf token --- https://laravel.com/docs/11.x/csrf
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function(){
            mostrar_lista_cursos();
            // codigo ascii alt 96  ``
            // Si yo creo una variable y entre esas comillas pongo codigo html, un formulario o lo que sea, lo puedo agregar con la foma que esta
            //agregando el contenido mas abajo
            // let variable=`
            //                  formulario completo
            //              `

            //$("#contenido-tabla").html('<h1>Contenido</h1>'); //    ---- con html agrega y pisa contenido que este anterior
            //$("#contenido-tabla").append(variable);          //     ---- con append lo agrega a lo que este
            $('.btn-agregar').click(function(){
                console.log("agregar")
                $("#title_curso").html('<h1 class="modal-title fs-5" id="title_curso">Nuevo curso</h1>');
                $("#tipo_formulario").val(1);
                $("#id_curso_editar").val("");
            });

            //Validaciones: van dirigidas al formulario con id del form
            $("#formulario-curso").validate({
            submitHandler: function(form) {
                console.log('registrar');
                registrar_curso();
                }
            });
        });

        // Funciones
        function mostrar_lista_cursos(){
            //console.log("Hola")
            $.ajax({
                type: 'POST',
                url: '{{ route('curso.lista')}}',
                dataType: 'json',
                beforeSend: function(){
                    $("#contenido-tabla").html('<div class="cargando"><i class="fa-solid fa-spinner fa-spin"></i></div>');
                },
                error: function(data){
                    let errorJson= JSON.parse(data.responseText);
                   Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: errorJson.message,
                    footer: '<a href="#">Why do I have this issue?</a>'
                    });
                },
                success: function(data){
                    $("#contenido-tabla").html(data.html);
                    btn_editar_curso();
                    btn_eliminar_curso();
                }
            });
        };

        function registrar_curso(){
            //console.log("Prueba");
            Swal.fire({
                title: "Desea guardar los cambios?",
                icon: "warning",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Guardar",
                denyButtonText: `No guardar`,
                showLoaderOnConfirm: true,
                preConfirm: ()=>{
            
                    let token= $('meta[name="csrf-token"]').attr('content');
                    let formElement=document.getElementById("formulario-curso");
                    let formData = new FormData(formElement);
                    return fetch('{{route('curso.registrar')}}', {
                        method: "POST",
                        body: formData,
                        headers:{
                            'X-Requested-With':'XMLHttpRequest',
                            'X-CSRF-TOKEN': token
                        }
                    }).then(response=> {
                        if(!response.ok){
                            return response.text().then(text=> {
                                throw new Error(text)
                            })
                        }else{
                            return response.json()
                        };
                    }).catch(error  =>{
                        let texto = JSON.parse(response.toString().substring(7));
                        let mensaje = texto.message;
                        Swal.showValidationMessage(
                            // `Error:${mensaje}`
                            `Error: ${error.message}`
                        );
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Swal.fire({
                title: "Atencion",
                icon: "success",
                text: "Se registro correctamente",
                confirmButtonText: 'OK',
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                        //const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                        //timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((confirmar)=>{
                if(confirmar.isConfirmed || confirmar.dismiss === Swal.DismissReason.timer){
                    $("#formulario-curso")[0].reset();
                    $("#curso_modal").modal('hide');
                    mostrar_lista_cursos();
                }
            })
                } else if (result.isDenied) {
                    Swal.fire("Los datos no fueron guardados", "", "info");
            }
            });
        };

        //EDITAR
        function btn_editar_curso(){
            $("#tabla_cursos tbody").on('click', '.btn_editar_curso', function(){
                let id_curso = $ (this).attr('data-id-curso');
                $("#tipo_formulario").val(2);
                $("#id_curso_editar").val(id_curso);
                console.log('ID_CURSO');
                console.log(id_curso);
                $.ajax({
                type: 'POST',
                url: '{{ route('curso.obtener_curso')}}',
                data:{id_curso:id_curso},
                dataType: 'json',
                beforeSend: function(){
                    // $("#contenido-tabla").html('<div class="cargando"><i class="fa-solid fa-spinner fa-spin"></i></div>');
                },
                error: function(data){
                    let errorJson= JSON.parse(data.responseText);
                   Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: errorJson.message,
                    footer: '<a href="#">Why do I have this issue?</a>'
                    });
                },
                success: function(data){
                    let curso = data.curso;
                    $("#title_curso").html('<h1 class="modal-title fs-5" id="title_curso">Editar curso</h1>');
                    $("#nombre_curso").val(curso.nombre_curso);
                    $("#descripcion").val(curso.descripcion);
                    $("#curso_modal").modal('show');
                    
                }
            });
            })
        };

        //ELIMINAR
        function btn_eliminar_curso(){
            $("#tabla_cursos tbody").on('click', '.btn_eliminar_curso', function(){
                let id_curso = $ (this).attr('data-id-curso');
                console.log('ID_CURSO_ELIMINAR');
                console.log(id_curso);

            Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás deshacer esto!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'DELETE',
                    url: '{{ route('curso.eliminar')}}',
                    // url: '{{ route('curso.eliminar', ['id' => '']) }}/' + id_curso,
                    data:{
                        // _token: '{{ csrf_token() }}',  // no lo necesito porque lo estoy pasando por otro lado
                        id_curso:id_curso                        
                    },
                    dataType: 'json',
                    beforeSend: function(){
                        // Opcional: Mostrar un indicador de carga
                    },
                    success: function(response){
                        if(response.success){
                            Swal.fire({
                                title: "Eliminado!",
                                icon: "success",
                                text: "El curso ha sido eliminado.",
                                confirmButtonText: 'OK',
                                timer: 1000,
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                        //const timer = Swal.getPopup().querySelector("b");
                                        timerInterval = setInterval(() => {
                                        //timer.textContent = `${Swal.getTimerLeft()}`;
                                    }, 100);
                                },
                                willClose: () => {
                                    clearInterval(timerInterval);
                                }
                            }
                                // 'Eliminado!',
                                // 'El curso ha sido eliminado.',
                                // 'success'
                            ).then(() => {
                                // Opcional: Actualizar la tabla o la vista
                                location.reload(); // O actualiza la tabla manualmente
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'No se pudo eliminar el curso.',
                                'error'
                                
                            );
                        }
                    },
                    error: function(xhr, status, error){
                        Swal.fire(
                            'Error!',
                            'Ocurrió un error al eliminar el curso.',
                            'error'
                        );
                    }
                });
            }
        });
            })
        };
    </script>
</body>
</html>