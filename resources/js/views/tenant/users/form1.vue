<template>
    <el-dialog :title="titleDialog" :visible="showDialog" @close="close" @open="create">
        <form autocomplete="off" @submit.prevent="submit">
            <div class="form-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.name}">
                            <label class="control-label">Nombre</label>
                            <el-input v-model="form.name"></el-input>
                            <small class="form-control-feedback" v-if="errors.name" v-text="errors.name[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.username}">
                            <label class="control-label">Login</label>
                            <el-input v-model="form.username"></el-input>
                            <small class="form-control-feedback" v-if="errors.username" v-text="errors.username[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.email}">
                            <label class="control-label">Correo Electrónico</label>
                            <el-input v-model="form.email" :disabled="form.id!=null"></el-input>
                            <small class="form-control-feedback" v-if="errors.email" v-text="errors.email[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group" :class="{'has-danger': errors.establishment_id}">
                            <label class="control-label">Establecimiento</label>
                            <el-select v-model="form.establishment_id" filterable>
                                <el-option v-for="option in establishments" :key="option.id" :value="option.id" :label="option.description"></el-option>
                            </el-select>
                            <small class="form-control-feedback" v-if="errors.establishment_id" v-text="errors.establishment_id[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-12" v-show="form.id">
                        <div class="form-group" :class="{'has-danger': errors.api_token}">
                            <label class="control-label">Api Tokentttt</label>
                            <el-input v-model="form.api_token" :readonly="form.id!=null"></el-input>
                            <small class="form-control-feedback" v-if="errors.api_token" v-text="errors.api_token[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.password}">
                            <label class="control-label">Contraseña</label>
                            <el-input v-model="form.password"></el-input>
                            <small class="form-control-feedback" v-if="errors.password" v-text="errors.password[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group" :class="{'has-danger': errors.password_confirmation}">
                            <label class="control-label">Confirmar Contraseña</label>
                            <el-input v-model="form.password_confirmation"></el-input>
                            <small class="form-control-feedback" v-if="errors.password_confirmation" v-text="errors.password_confirmation[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group" :class="{'has-danger': errors.admin}">
                            <label class="control-label d-block text-success">Rol Administrador</label>
                            <el-checkbox v-model="form.admin" class="d-block text-success"></el-checkbox>
                            <small class="form-control-feedback d-block" v-if="errors.admin" v-text="errors.admin[0]"></small>
                        </div>
                    </div>
                    <div class="col-md-12" v-show="form.admin == false">
                        <div class="form-group ">
                            <label class="control-label">Módulos</label>
                            <div class="row">
                                <div class="col-4" v-for="module in form.modules">
                                    <el-checkbox v-model="module.checked">{{ module.description }}</el-checkbox> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-actions text-right mt-4">
                <el-button @click.prevent="close()">Cancelar</el-button>
                <el-button type="primary" native-type="submit" :loading="loading_submit">Guardar</el-button>
            </div>
        </form>
    </el-dialog>

</template>

<script>

    import {EventBus} from '../../../helpers/bus'

    export default {
        props: ['showDialog', 'recordId'],
        data() {
            return {
                loading_submit: false,
                titleDialog: null,
                resource: 'users',
                errors: {},
                form: {},
                modules: [],
                establishments: []
            }
        },
        async created() {
            await this.$http.get(`/${this.resource}/tables`)
                .then(response => {
                    this.modules = response.data.modules
                    this.establishments = response.data.establishments
                })
            await this.initForm()
        },
        methods: {
            initForm() {
                this.errors = {}
                this.form = {
                    id: null,
                    name: null,
                    username: null,
                    email: null,
                    api_token: null,
                    establishment_id: null,
                    password: null,
                    admin: false,
                    password_confirmation: null,
                    modules: []
                }

                this.modules.forEach(module => {
                    this.form.modules.push({
                        id: module.id,
                        description: module.description,
                        checked: false
                    })
                })
            },
            create() {
                this.titleDialog = (this.recordId)? 'Editar Usuario':'Nuevo Usuario'
                if (this.recordId) {
                    this.$http.get(`/${this.resource}/record/${this.recordId}`)
                        .then(response => {
                            this.form = response.data.data
                            this.form.admin = response.data.data.admin == 1 ? true : false
                        })
                }
            },
            submit() {
                this.loading_submit = true
                this.$http.post(`/${this.resource}`, this.form)
                    .then(response => {
                        if (response.data.success) {
                            this.form.password = null
                            this.form.password_confirmation = null
                            this.$message.success(response.data.message)
                            this.$eventHub.$emit('reloadData')
                            this.close()
                        } else {
                            this.$message.error(response.data.message)
                        }
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data
                        } else {
                            console.log(error)
                        }
                    })
                    .then(() => {
                        this.loading_submit = false
                    })
            },
            close() {
                this.$emit('update:showDialog', false)
                this.initForm()
            },
        }
    }
</script>
