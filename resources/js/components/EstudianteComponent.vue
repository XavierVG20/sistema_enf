<template>
    <main class="main">
        
        <!-- Main content -->
        <section class="content">
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Listado estudiantes</h3>

                    
                </div>
                <div class="card-body">
                    <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                Accion
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item " href="#" @click="abrirModal('estudiante', 'registrar')">Nuevo</a></li>
                                <li><a class="dropdown-item " href="#" @click="abrirModal('estudiante', 'importar')" >Importar datos </a></li>
                                <li class="divider"></li>
                                <li><a class="dropdown-item "  href="#" @click="exportarEstudiantes()">Exportar  datos</a></li>
                            </ul>
                        </div>
                
                        
                  
                    <br /><br />
                    <div class="row">
                        <div class="col-md-3">
                            <select class="form-control" v-model="criterio">
                                <option value="nombre">Nombre</option>
                                <option value="num_documento">CI</option>
                                <option value="curso">Curso</option>
                                <option value="telefono">Teléfono</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" v-model="buscar" @keyup.enter="listarEstudiante(1, buscar, criterio)"
                                class="form-control" placeholder="Texto a buscar" />
                        </div>
                        <div class="col-md-3">
                            <button type="submit" @click="listarEstudiante(1, buscar, criterio)" class="btn btn-primary">
                                <i class="fa fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>

                    <br>

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Curso</th>
                                    <th>CI</th>
                                    <th>Dirección</th>
                                    <th>Representante</th>
                                    <th>Representante CI</th>
                                    <th>Telefono</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="estudiante in arrayEstudiante" :key="estudiante.id">
                                    <td>
                                        <button type="button" @click="abrirModal('estudiante', 'actualizar', estudiante)"
                                            class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                    <td v-text="estudiante.nombre"></td>
                                    <td v-text="estudiante.curso"></td>
                                    <td v-text="estudiante.num_documento"></td>
                                    <td v-text="estudiante.direccion"></td>
                                    <td v-text="estudiante.rep_nombre"></td>
                                    <td v-text="estudiante.rep_documento"></td>
                                    <td v-text="estudiante.telefono"></td>
                                    <td v-text="estudiante.estado"></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="
                                    cambiarPagina(pagination.current_page - 1, buscar, criterio)
                                ">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page"
                                :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page, buscar, criterio)"
                                    v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="
                                    cambiarPagina(pagination.current_page + 1, buscar, criterio)
                                ">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- /.box-body -->
                <div class="box-footer"></div>
                <!-- /.box-footer-->
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </section>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal modal-primary" style="overflow: hidden" tabindex="-1" :class="{ mostrar: modal }" role="dialog"
            aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                       
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                    </div>
                    <div class="modal-body">
         
                        <form action="" v-if="(tipoAccion == 1) || (tipoAccion == 2)" method="post">
                            <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Nombre</label>
                                    <input type="text" v-model="nombre" class="form-control"
                                        placeholder="Nombre del estudiante" />
                                    <label v-if="errors.nombre" class="text-danger">* {{ errors.nombre[0] }}</label>


                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="email-input">Dirección</label>
                                    <input type="text" v-model="direccion" class="form-control" placeholder="Dirección" />
                                    <label v-if="errors.direccion" class="text-danger">* {{ errors.direccion[0] }}</label>



                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="text-input">Curso</label>
                                    <input type="text" v-model="curso" class="form-control" placeholder="Curso" />
                                    <label v-if="errors.curso" class="text-danger">* {{ errors.curso[0] }}</label>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="text-input">CI</label>
                                    <input type="text" v-model="num_documento" class="form-control"
                                        placeholder="Número de CI" />
                                    <label v-if="errors.num_documento" class="text-danger">*
                                        {{ errors.num_documento[0] }}</label>


                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Representante</label>
                                    <input type="rep_nombre" v-model="rep_nombre" class="form-control" placeholder="Nombre del representante" />
                                    <label v-if="errors.rep_nombre" class="text-danger">* {{ errors.rep_nombre[0] }}</label>


                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Representante CI</label>
                                    <input type="text" v-model="rep_documento" class="form-control" placeholder="Numero de CI del representante" />
                                    <label v-if="errors.rep_documento" class="text-danger">* {{ errors.rep_documento[0] }}</label>



                                </div>
                            </div>
                        </div>
                        <div class="row">
                           
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="control-label">Teléfono del Representante</label>
                                    <input type="text" v-model="telefono" class="form-control"
                                        placeholder="Teléfono del Representante">
                                    <label v-if="errors.telefono" class="text-danger">*
                                        {{ errors.telefono[0] }}</label>
                                </div>
                            </div>
                        </div>
                        </form>
                        <form action="" method="post" enctype="multipart/form-data" v-if="(tipoAccion == 3)">
                            <label>File
                                <input type="file" id="file" name="file" ref="file" v-on:change="handleFileUpload()" />
                            </label>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline btn-secondary pull-left" @click="cerrarModal()">
                            Cerrar
                        </button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-outline btn-primary" @click="registrarEstudiante()">
                            Guardar
                        </button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-outline btn-primary" @click="actualizarEstudiante()">
                            Actualizar
                        </button>
                        <button type="button" class="btn btn-outline" v-if="tipoAccion == 3"
                            v-on:click="importFile()">Importar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
export default {

    data() {

        return {
            estudiante_id: 0,
            nombre: '',
            curso: '',
            num_documento: '',
            direccion: '',
            rep_nombre: '',
            rep_documento: '',
            estado: '',
            telefono: '',
            file: null ,
            arrayEstudiante: [],
            modal: 0,
            tituloModal: "",
            tipoAccion: 0,
            errorEstudiantes: 0,
            errorMostrarMsjEstudiante: [],
            pagination: {
                total: 0,
                current_page: 0,
                per_page: 0,
                last_page: 0,
                from: 0,
                to: 0,
            },
            errors: {},
            offset: 3,
            criterio: "nombre",
            buscar: "",
        };
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

            var to = from + this.offset * 2;
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }

            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
    },
    methods: {
        async listarEstudiante(page, buscar, criterio) {
            let me = this;
            var url =
                '/estudiante?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            await axios
                .get(url)
                .then(function (response) {
                    var respuesta = response.data;
                    me.arrayEstudiante = respuesta.estudiantes.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cambiarPagina(page, buscar, criterio) {
            let me = this;
            //Actualiza la página actual
            me.pagination.current_page = page;
            //Envia la petición para visualizar la data de esa página
            me.listarEstudiante(page, buscar, criterio);
        },
        async registrarEstudiante() {

            let me = this;


            await axios.post("/estudiante/registrar", {
                'nombre': this.nombre,
                'curso': this.curso,
                'num_documento': this.num_documento,
                'direccion': this.direccion,
                'rep_nombre': this.rep_nombre,
                'rep_documento': this.rep_documento,
                'telefono': this.telefono
            })
                .then(response => {
                    console.log(response)
                    me.cerrarModal();
                    Swal.fire(
                        "Guardado!",
                        "El registro ha sido guardado con éxito.",
                        "success"
                    );
                    me.listarEstudiante(1, "", "nombre");
                })
                .catch(error => {
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Algo salio mas!",
                        footer: error.response.data.message,
                    });
                    if (error.response.data) {
                        this.errors = error.response.data.errors;
                    }


                })



        },
        handleFileUpload() {
            this.file = this.$refs.file.files[0];
            console.log(this.file);           
        },
        async exportarEstudiantes() {
            window.open('/estudiante/exportarEstudiantes', '_blank');

        },
        async importFile() {
            /* Initialize the form data */
            let me = this;
            let formData = new FormData();

            formData.append('file', me.file);
            try {
                axios.post('/estudiante/importarEstudiantes', formData)
                    .then(function (res) {
                        console.log(res);
                        me.cerrarModal();
                        Swal.fire(
                            'Guardado!',
                            'Los registros han sido guardados con éxito.',
                            'success'
                        );
                        me.errors = {};

                        me.listarEstudiante(1, '', 'nombre');
                    });
            } catch (error) {
                console.log(error);

                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Algo salio mas!",
                    footer: error.response.data.message,
                });
                if (error.response.data) {
                    this.errors = error.response.data.errors;
                }
            }

        },
        async actualizarEstudiante() {

            let me = this;

            try {
                await axios.put("/estudiante/actualizar", {
                    'nombre': this.nombre,
                    'curso': this.curso,
                    'num_documento': this.num_documento,
                    'direccion': this.direccion,
                    'rep_nombre': this.rep_nombre,
                    'rep_documento': this.rep_documento,
                    'telefono': this.telefono,
                    'id': this.estudiante_id
                })
                    .then(function (response) {
                        me.cerrarModal();
                        Swal.fire(
                            "Actualizado!",
                            "El registro ha sido actualizado con éxito.",
                            "success"
                        );
                        me.listarEstudiante(1, "", "nombre");
                    })
            } catch (error) {
                console.log(error.response)
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Algo salio mas!",
                    footer: error.response.data.message,
                });
                if (error.response.data) {
                    this.errors = error.response.data.errors;
                }

            }

        },

        cerrarModal() {
            this.modal = 0;
            this.tituloModal = "";
            this.nombre = "";
            this.curso = "";
            this.num_documento = "";
            this.direccion = "";
            this.rep_nombre = "";
            this.rep_documento = "";
            this.telefono = "";
            this.errorPersona = 0;
            this.errors = {};
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "estudiante": {
                    switch (accion) {
                        case "registrar": {
                            this.modal = 1;
                            this.tituloModal = 'Registrar Estudiantes';
                            this.nombre = '';
                            this.curso = '';
                            this.num_documento = '';
                            this.direccion = '';
                            this.rep_nombre = '';
                            this.rep_documento = '';
                            this.telefono = '';
                            this.tipoAccion = 1;
                            break;
                        }
                        case "actualizar": {
                            //console.log(data);
                            this.modal = 1;
                            this.tituloModal = 'Actualizar Estudiante';
                            this.tipoAccion = 2;
                            this.estudiante_id = data['id'];
                            this.nombre = data['nombre'];
                            this.curso = data['curso'];
                            this.num_documento = data['num_documento'];
                            this.direccion = data['direccion'];
                            this.rep_nombre = data['rep_nombre'];
                            this.rep_documento = data['rep_documento'];
                            this.telefono = data['telefono'];

                            break;
                        }
                        case "importar": {
                            //console.log(data);
                            this.modal = 3;
                            this.tituloModal = 'Importar Estudiante';
                            this.tipoAccion = 3;
                            this.file = '';
                    
                            break;
                        }
                    }
                }
            }
        },
    },
    mounted() {
        this.listarEstudiante(1, this.buscar, this.criterio);
    },
};
</script>