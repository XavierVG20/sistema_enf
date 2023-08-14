<template>
    <main class="main">
     
        <section class="content">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Listado Usuarios</h3>

                   
                </div>

                <div class="card-body">
                        <button type="button" @click="abrirModal('persona', 'registrar')" class="btn btn-primary
                          ">
                            <i class="fa fa-plus"></i>&nbsp;Nuevo
                        </button>

                     <br><br>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div>
                                <th>
                                    <select class="form-control" v-model="criterio">
                                        <option value="name">Nombre</option>
                                        <option value="num_documento">CI</option>
                                        <option value="email">Email</option>
                                        <option value="telefono">Teléfono</option>
                                    </select>

                                </th>
                                <th>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1, buscar, criterio)"
                                        class="form-control" placeholder="Texto a buscar">

                                </th>
                                <th>
                                    <button type="submit" @click="listarPersona(1, buscar, criterio)"
                                        class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>

                                </th>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>CI</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td>
                                        <button type="button" @click="abrirModal('persona', 'actualizar', persona)"
                                            class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="persona.condicion">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                @click="desactivarUsuario(persona.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm"
                                                @click="activarUsuario(persona.id)">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="persona.name"></td>
                                    <td v-text="persona.num_documento"></td>
                                    <td v-text="persona.direccion"></td>
                                    <td v-text="persona.telefono"></td>
                                    <td v-text="persona.email"></td>
                                    <td v-text="persona.rol"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#"
                                    @click.prevent="cambiarPagina(pagination.current_page - 1, buscar, criterio)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page"
                                :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)"
                                    v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#"
                                    @click.prevent="cambiarPagina(pagination.current_page + 1, buscar, criterio)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </section>
      
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal modal-primary" style="overflow: hidden;" tabindex="-1" :class="{ 'mostrar': modal }" role="dialog"
            aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                       
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Nombre(*)</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="name" class="form-control" placeholder="Nombre del usuario">
                                    <label v-if="errors.name" class="text-danger">* {{ errors.name[0] }}</label>

                                </div>
                            </div>
                           
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">CI</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="num_documento" class="form-control"
                                        placeholder="Número de documento">
                                    <label v-if="errors.num_documento" class="text-danger">*
                                        {{ errors.num_documento[0] }}</label>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="direccion" class="form-control" placeholder="Dirección">
                                    <label v-if="errors.direccion" class="text-danger">* {{ errors.direccion[0] }}</label>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Teléfono</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="telefono" class="form-control" placeholder="Teléfono">
                                    <label v-if="errors.telefono" class="text-danger">* {{ errors.telefono[0] }}</label>

                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                <div class="col-md-9">
                                    <input type="email" v-model="email" class="form-control" placeholder="Email">
                                    <label v-if="errors.email" class="text-danger">* {{ errors.email[0] }}</label>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Rol</label>
                                <div class="col-md-9">
                                    <select v-model="idrol" class="form-control">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="role in arrayRol" :key="role.id" :value="role.id"
                                            v-text="role.nombre"></option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Password</label>
                                <div class="col-md-9">
                                    <input type="password" v-model="password" class="form-control"
                                        placeholder="Password del usuario">
                                    <label v-if="errors.password" class="text-danger">* {{ errors.password[0] }}</label>

                                </div>
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-outline btn-primary"
                            @click="registrarPersona()">Guardar</button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-outline btn-primary"
                            @click="actualizarPersona()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Fin del modal-->

   

       
    </main>
</template>

<script>
import { Quagga } from 'quagga';

export default {
    
    data() {
        return {
            resultado: '',
            stream: null,
            persona_id: 0,
            name: '',
            tipo_documento: 'CI',
            num_documento: '',
            direccion: '',
            telefono: '',
            email: '',
            password: '',
            idrol: '',
            arrayPersona: [],
            arrayRol: [],
            modal: 0,
            tituloModal: '',
            tipoAccion: 0,
            errorPersona: 0,
            errorMostrarMsjPersona: [],
            pagination: {
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0,
            },
            errors: {},
            offset: 3,
            criterio: 'name',
            buscar: ''
        }
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        //Calcula los elementos de la paginación
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }

            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }

            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;

        }
    },
    methods: {
        iniciarCamara() {
            const constraints = {
                video: { facingMode: 'environment' } // Acceder a la cámara trasera del dispositivo
            };

            navigator.mediaDevices.getUserMedia(constraints)
                .then((stream) => {
                    this.$refs.video.srcObject = stream;
                })
                .catch((error) => {
                    console.error('Error al acceder a la cámara:', error);
                });
        },

        detenerCamara() {
            const stream = this.$refs.video.srcObject;
            const tracks = stream.getTracks();

            tracks.forEach((track) => track.stop());
        },

        leerCodigoBarras() {
            const canvas = document.createElement('canvas');
            canvas.width = this.$refs.video.videoWidth;
            canvas.height = this.$refs.video.videoHeight;

            const context = canvas.getContext('2d');
            context.drawImage(this.$refs.video, 0, 0, canvas.width, canvas.height);

            Quagga.decodeSingle({
                src: canvas.toDataURL(),
                numOfWorkers: 0,
                locate: true,
                decoder: {
                    readers : ["code_128_reader"]
                }
            }, (resultado) => {
                if (resultado && resultado.codeResult) {
                    this.resultado = 'Código de barras: ' + resultado.codeResult.code;
                } else {
                    this.resultado = 'No se encontró ningún código de barras.';
                }
            });
        },
    

        listarPersona(page, buscar, criterio) {
            let me = this;
            var url = '/user?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            axios.get(url).then(response => {
                var respuesta = response.data;
                me.arrayPersona = respuesta.personas.data;
                me.pagination = respuesta.pagination;
            })
                .catch(error => {
                    console.log(error);
                });
        },
        selectRol() {
            let me = this;
            var url = '/rol/selectRol';
            axios.get(url).then(response => {
                //console.log(response);
                var respuesta = response.data;
                me.arrayRol = respuesta.roles;
            })
                .catch(error => {
                    console.log(error);
                });
        },

        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listarPersona(page, buscar, criterio);
        },
        async registrarPersona() {


            let me = this;

            await axios.post('/user/registrar', {
                'name': this.name,
                'tipo_documento': this.tipo_documento,
                'num_documento': this.num_documento,
                'direccion': this.direccion,
                'telefono': this.telefono,
                'email': this.email,
                'idrol': this.idrol,
                'password': this.password

            }).then(response => {
                Swal.fire(
                    "Guardado!",
                    "El registro ha sido guardado con éxito.",
                    "success"
                );
                me.cerrarModal();
                me.listarPersona(1, '', 'nombre');
            }).catch(error => {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Algo salio mas!",
                    footer: error.response.data.message,
                });
                if (error.response.data) {

                    this.errors = error.response.data.errors;

                }
            });
        },
        actualizarPersona() {


            let me = this;

            axios.put('/user/actualizar', {
                'name': this.name,
                'tipo_documento': this.tipo_documento,
                'num_documento': this.num_documento,
                'direccion': this.direccion,
                'telefono': this.telefono,
                'email': this.email,
                'idrol': this.idrol,
                'password': this.password,
                'id': this.persona_id
            }).then(function (response) {
                Swal.fire(
                    "Actualizado!",
                    "El registro ha sido actualizado con éxito.",
                    "success"
                );
                me.cerrarModal();
                me.listarPersona(1, '', 'nombre');
            }).catch(error => {
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Algo salio mas!",
                    footer: error.response.data.message,
                });
                if (error.response.data) {

                    this.errors = error.response.data.errors;

                }
            });
        },

        cerrarModal() {
            this.modal = 0;
            this.tituloModal = '';
            this.name = '';
            this.tipo_documento = 'CI';
            this.num_documento = '';
            this.direccion = '';
            this.telefono = '';
            this.email = '';
            this.password = '';
            this.idrol = 0;
            this.errorPersona = 0;
            this.errors = {};
        },
        abrirModal(modelo, accion, data = []) {
            this.selectRol();
            switch (modelo) {
                case "persona":
                    {
                        switch (accion) {
                            case 'registrar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Registrar Usuario';
                                    this.name = '';
                                    this.tipo_documento = 'CI';
                                    this.num_documento = '';
                                    this.direccion = '';
                                    this.telefono = '';
                                    this.email = '';
                                    this.password = '';
                                    this.idrol = 0;
                                    this.tipoAccion = 1;
                                    break;
                                }
                            case 'actualizar':
                                {
                                    //console.log(data);
                                    this.modal = 1;
                                    this.tituloModal = 'Actualizar Usuario';
                                    this.tipoAccion = 2;
                                    this.persona_id = data['id'];
                                    this.name = data['name'];
                                    this.tipo_documento = data['tipo_documento'];
                                    this.num_documento = data['num_documento'];
                                    this.direccion = data['direccion'];
                                    this.telefono = data['telefono'];
                                    this.email = data['email'];
                                    this.password = data['password'];
                                    this.idrol = data['idrol'];
                                    break;
                                }
                        }
                    }
            }
        },
        desactivarUsuario(id) {

            Swal.fire({
                title: 'Esta seguro de desactivar este usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/user/desactivar', {
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(1, '', 'nombre');
                        Swal.fire(
                            'Desactivado!',
                            'El registro ha sido desactivado con éxito.',
                            'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {

                }
            })
        },
        activarUsuario(id) {
            Swal.fire({
                title: 'Esta seguro de activar este usuario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/user/activar', {
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(1, '', 'nombre');
                        Swal.fire(
                            'Activado!',
                            'El registro ha sido activado con éxito.',
                            'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {

                }
            })
        },
    },
    mounted() {
        this.listarPersona(1, this.buscar, this.criterio);
    }
}
</script>
<style>    .modal-content {
        width: 100% !important;
        position: absolute !important;
    }

    .mostrar {
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }

    .div-error {
        display: flex;
        justify-content: center;
    }

    .text-error {
        color: red !important;
        font-weight: bold;
    }</style>
