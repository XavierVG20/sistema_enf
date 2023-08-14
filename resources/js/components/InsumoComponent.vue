<template>
    <main class="main">
       
       
        <section class="content">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header with-border">
                    <h3 class="card-title">Listado Insumos</h3>
                </div>

                <div class="card-body">
                        <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" data-coreui-toggle="dropdown" aria-expanded="false">
                                Accion
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item " href="#" @click="abrirModal('insumo', 'registrar')">Nuevo</a></li>
                                <li><a class="dropdown-item " href="#" @click="abrirModal('insumo', 'importar')" >Importar datos </a></li>
                                <li class="divider"></li>
                                <li><a class="dropdown-item "  href="#" @click="exportarInsumos()">Exportar  .XMl</a></li>
                           </ul>
                        </div>
                     <br><br>
                    <div class="row">
                        <div class=" col-md-3">
                            <select class="form-control " v-model="criterio">
                                <option value="nombre">Nombre</option>
                                <option value="descripcion">Descripción</option>
                                                                <option value="num_documento">CI</option>

                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="text" v-model="buscar" @keyup.enter="listarInsumo(1, buscar, criterio)"
                                class="form-control" placeholder="Texto a buscar">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" @click="listarInsumo(1, buscar, criterio)" class="btn btn-primary"><i
                                    class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>

                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped ">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                   
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Unidad</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="insumo in arrayInsumo" :key="insumo.id">
                                    <td>
                                        <button type="button" @click="abrirModal('insumo', 'actualizar', insumo)"
                                            class="btn btn-primary btn-sm" title="Editar">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                        <template v-if="insumo.condicion">
                                            <button type="button" class="btn btn-danger btn-sm"
                                                @click="desactivarInsumo(insumo.id)" title="Desactivar">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm"
                                                @click="activarInsumo(insumo.id)" title="Activar">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </template>
                                        <!-- &nbsp;<button type="button" class="btn btn-danger btn-sm"
                                            @click="eliminarArticulo(articulo.id)" title="Eliminar">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        -->
                                    </td>
                                    <td v-text="insumo.nombre"></td>
                                    <td v-text="insumo.descripcion"></td>
                                    <td v-text="insumo.unidad"></td>

                                    <td>
                                        <div v-if="insumo.condicion">
                                            <span class="badge text-bg-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge text-bg-danger">Desactivado</span>
                                        </div>

                                    </td>
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
                <div class="box-footer">

                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
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
                        <form enctype="multipart/form-data" v-if="(tipoAccion == 1) || (tipoAccion == 2)">
                            <div class="row">
                                

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Insumo</label>
                                        <input type="text" v-model="nombre" class="form-control"
                                            placeholder="Insumo">
                                        <label v-if="errors.nombre" class="text-danger">* {{ errors.nombre[0] }}</label>
                                    </div>
                                </div>

                            </div>
                            <div class="row">

                              

                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Unidad</label>
                                        <input type="number" v-model="unidad" class="form-control" placeholder="">
                                        <label v-if="errors.unidad" class="text-danger">* {{ errors.unidad[0] }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-16">
                                <div class="form-group">
                                    <label class="control-label">Descripción</label>
                                    <textarea name="" v-model="descripcion" class="form-control"
                                        placeholder="Ingrese descripción" cols="40" rows="3"></textarea>

                                    <label v-if="errors.descripcion" class="text-danger">*
                                        {{ errors.descripcion[0] }}</label>
                                </div>
                            </div>

                         
                        </form>

                        <form enctype="multipart/form-data" action="" v-if="(tipoAccion == 3)">
                          
                            <div class="container">
                                <div class="upload">
                                    <label>File
                                        <input type="file" id="file" name="file" ref="file"
                                            v-on:change="handleFileUpload()" />
                                    </label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline pull-left btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion == 1" class="btn btn-outline btn-primary"
                            @click="registrarInsumo()">Guardar</button>
                        <button type="button" v-if="tipoAccion == 2" class="btn btn-outline btn-primary"
                            @click="actualizarInsumo()">Actualizar</button>
                        <button type="button" class="btn btn-outline" v-if="tipoAccion == 3"
                            v-on:click="importFile()">Importar</button>

                    </div>
                </div>
            </div>
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>

export default {
    data() {
        return {
            insumo_id: 0,
            nombre: '',
            descripcion: '',
            unidad: '',
           file:'',
            arrayInsumo: [],
            modal: 0,
            tituloModal: '',
            tipoAccion: 0,
            errorInsumo: 0,
            errorMostrarMsjInsumo: [],
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
            criterio: 'nombre',
            buscar: '',
         
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
       
        async listarInsumo(page, buscar, criterio) {
            let me = this;
            var url = '/insumo?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
            await axios.get(url).then(function (response) {
                var respuesta = response.data;
                console.log(response)
                me.arrayInsumo = respuesta.insumos.data;
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
            me.listarInsumo(page, buscar, criterio);
        },
        cargarPdf() {
            window.open('/articulo/listarPdf', '_blank');
        },

         handleFileUpload() {
            this.file = this.$refs.file.files[0];
            console.log(this.file);           /* we set the local file variable to the first File object in the FileList
            on the input[type="file"].  The this.$refs.file refers to the ref
            attribute on the input[type="file"]. This makes it easily accesible within our component */
        },
        async exportarInsumos() {
            window.open('insumo/exportarInsumos', '_blank');

        },

        async registrarInsumo() {
            let me = this;
            try {
                var data = new FormData();
                //Añadimos la imagen seleccionada
                
                data.append('nombre', this.nombre);
                data.append('descripcion', this.descripcion);
                data.append('unidad', this.unidad);
                await axios.post('/insumo/registrar', data).then(function (response) {
                    me.cerrarModal();
        
                    Swal.fire(
                        'Guardado!',
                        'El registro ha sido guardado con éxito.',
                        'success'
                    );
                    me.listarEstudiante(1, '', 'nombre');

                    me.errors = {};

                })

            } catch (error) {
                console.log(error.response.data);
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
        async importFile() {
            /* Initialize the form data */
            let me = this;
            let formData = new FormData();

            formData.append('file', this.file);
            try {
                axios.post('/insumo/importarEstudiantes', formData)
                    .then(function (res) {
                        //  console.log(res);
                        me.cerrarModal();
                        Swal.fire(
                            'Guardado!',
                            'Los registros han sido guardados con éxito.',
                            'success'
                        );
                        me.errors = {};
                    });
            } catch (error) {
                console.log(error.response.data);
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
            me.listarEstudiante(1, '', 'nombre');


        },

        async actualizarInsumo() {
            let me = this;
            try {
                var data = new FormData();
                //Añadimos la imagen seleccionada
                data.append('nombre', this.nombre);
                data.append('descripcion', this.descripcion);
                data.append('unidad', this.unidad);
                data.append('id', this.insumo_id);

                data.append('_method', 'PUT');



                await axios.post('/insumo/actualizar',data)
                    .then((response) => {
                        console.log(response)
                        me.cerrarModal();
                        Swal.fire(
                            'Actualizado!',
                            'El registro ha sido actualizado con éxito.',
                            'success'
                        );
                        me.errors = {};
                        me.listarInsumo(1, '', 'nombre');
                    })
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
       async desactivarInsumo(id) {
            Swal.fire({
                title: "Esta seguro de desactivar esta categoría?",
                text: "No podra utilizar esta informacion",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Aceptar",
            }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/insumo/desactivar', {
                        'id': id
                    }).then(function (response) {
                        me.listarInsumo(1, '', 'nombre');

                        Swal.fire(
                            "Desactivado!",
                            "El registro ha sido desactivado con éxito.",
                            "success"
                        );
                    }).catch(function (error) {
                        console.log(error);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Algo salio mas!",
                            footer: error.response.data.message,
                        });
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                }
            })
        },
        activarInsumo(id) {
            Swal.fire({
                title: "Esta seguro de activar esta categoría?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Cancelar",
                confirmButtonText: "Aceptar",
            }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/insumo/activar', {
                        'id': id
                    }).then(function (response) {
                        me.listarInsumo(1, '', 'nombre');
                        Swal.fire(
                            "Activado!",
                            "El registro ha sido activado con éxito.",
                            "success"
                        );
                    }).catch(function (error) {
                        console.log(error);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Algo salio mas!",
                            footer: error.response.data.message,
                        });
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                }
            })
        },

        cerrarModal() {
            this.modal = 0;
            this.nombre = '';
            this.descripcion = '';
            this.unidad = '';

            this.errors = {};
        },
        abrirModal(modelo, accion, data = []) {
            switch (modelo) {
                case "insumo":
                    {
                        switch (accion) {
                            case 'registrar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Registrar Insumo';
                                    this.nombre = '';
                                    this.descripcion = '';
                                    this.unidad = '';
                                    this.tipoAccion = 1;
                         

                                    break;
                                }
                            case 'actualizar':
                                {
                                    //console.log(data);
                                    this.modal = 1;
                                    this.tituloModal = 'Actualizar Insumo';
                                    this.tipoAccion = 2;
                                    this.insumo_id = data['id'];
                                   
                                    this.nombre = data['nombre'];
                                    
                                    this.descripcion = data['descripcion'];
                                    this.unidad = data['unidad'];
                                    
                                    break;
                                }
                            case 'importar':
                                {
                                    //console.log(data);
                                    this.modal = 3;
                                    this.tituloModal = 'Importar Insumo';
                                    this.tipoAccion = 3;

                                    break;
                                }
                        }
                    }
            }
        }
    },
    mounted() {
        this.listarInsumo(1, this.buscar, this.criterio);
    }
}
</script>
<style>
.mostrar {
    display: list-item !important;
}

.modal-body {
    max-height: calc(100vh - 210px);
    overflow-y: auto;
}
</style>