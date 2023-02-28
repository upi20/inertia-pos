<template>

    <Head>
        <title>Add New Role - Aplikasi Kasir</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-shield-alt"></i> ADD ROLE</span>
                            </div>
                            <div class="card-body">

                                <form @submit.prevent="submit">
                                    
                                    <div class="mb-3">
                                        <label class="fw-bold">Role Name</label>
                                        <input class="form-control" v-model="form.name" :class="{ 'is-invalid': errors.name }" type="text" placeholder="Role Name">
                                        
                                        <div v-if="errors.name" class="alert alert-danger">
                                            {{ errors.name }}
                                        </div>
                                    </div>
                                    
                                    <hr>
                                    <div class="mb-3">
                                        <label class="fw-bold">Permissions</label>
                                        <br>
                                        <div class="form-check form-check-inline" v-for="(permission, index) in permissions" :key="index">
                                            <input class="form-check-input" type="checkbox" v-model="form.permissions" :value="permission.name" :id="`check-${permission.id}`">
                                            <label class="form-check-label" :for="`check-${permission.id}`">{{ permission.name }}</label>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-primary shadow-sm rounded-sm" type="submit">SAVE</button>
                                            <button class="btn btn-warning shadow-sm rounded-sm ms-3" type="reset">RESET</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import LayoutApp from '../../../Layouts/App.vue';

    //import Heade and useForm from Inertia
    import { Head, Link } from '@inertiajs/inertia-vue3';
    
    //import reactive from vue
    import { reactive } from 'vue';

    //import inerita adapter
    import { Inertia } from '@inertiajs/inertia';

    //import sweet alert2
    import Swal from 'sweetalert2';

    export default {
        //layout
        layout: LayoutApp,

        //register component
        components: {
            Head,
            Link
        },

        //props
        props: {
            errors: Object,
            permissions: Array,
        },

        //composition API
        setup() {

            //define form with reactive
            const form = reactive({
                name: '',
                permissions: [],
            });

            //method "submit"
            const submit = () => {

                //send data to server
                Inertia.post('/apps/roles', {
                    //data
                    name: form.name,
                    permissions: form.permissions,
                }, {
                    onSuccess: () => {
                        //show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Role saved successfully.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    },
                });

            }

            return {
                form,
                submit,
            };

        }
    }
</script>

<style>

</style>