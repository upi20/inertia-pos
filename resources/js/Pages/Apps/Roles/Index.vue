<template>

    <Head>
        <title>Roles - Aplikasi Kasir</title>
    </Head>
    <main class="c-main">
        <div class="container-fluid">
            <div class="fade-in">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 rounded-3 shadow border-top-purple">
                            <div class="card-header">
                                <span class="font-weight-bold"><i class="fa fa-shield-alt"></i> ROLES</span>
                            </div>
                            <div class="card-body">
                                <form @submit.prevent="handleSearch">
                                    <div class="input-group mb-3">
                                        <Link href="/apps/roles/create" v-if="hasAnyPermission(['roles.create'])"
                                              class="btn btn-primary input-group-text"> <i
                                           class="fa fa-plus-circle me-2"></i> NEW</Link>
                                        <input type="text" class="form-control" placeholder="search by role name..."
                                               v-model="search">

                                        <button class="btn btn-primary input-group-text" type="submit"> <i
                                               class="fa fa-search me-2"></i>
                                            SEARCH</button>

                                    </div>
                                </form>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th
                                                scope="col"
                                                @click="handleOrder('name')"
                                                v-html="order.title('name', 'Role Name')"></th>
                                            <th style="width:50%"
                                                scope="col"
                                                v-html="order.title('permission', 'Permissions')"></th>
                                            <th style="width:20%"
                                                scope="col"
                                                v-html="order.title('action', 'Actions')"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(role, index) in roles.data" :key="index">
                                            <td>{{ role.name }}</td>
                                            <td>
                                                <span v-for="(permission, index) in role.permissions" :key="index"
                                                      class="badge badge-primary shadow border-0 ms-2 mb-2">
                                                    {{ permission.name }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <Link :href="`/apps/roles/${role.id}/edit`"
                                                      v-if="hasAnyPermission(['roles.edit'])"
                                                      class="btn btn-success btn-sm me-2"><i
                                                   class="fa fa-pencil-alt me-1"></i> EDIT</Link>
                                                <button @click.prevent="destroy(role.id)"
                                                        v-if="hasAnyPermission(['roles.delete'])"
                                                        class="btn btn-danger btn-sm"><i
                                                       class="fa fa-trash"></i> DELETE</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Pagination :links="roles.links" align="end" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
//import layout
import LayoutApp from '../../../Layouts/App.vue';

//import component pagination
import Pagination from '../../../Components/Pagination.vue';

//import Heade and Link from Inertia
import { Head, Link } from '@inertiajs/inertia-vue3';

//import inertia adapter
import { Inertia } from "@inertiajs/inertia";
import { reactive, ref } from "vue";

//import sweet alert2
import Swal from 'sweetalert2';

export default {
    //layout
    layout: LayoutApp,

    //register component
    components: {
        Head,
        Link,
        Pagination
    },

    props: {
        roles: Object,
    },
    setup(props) {
        const order = reactive({
            sort: null,
            sortDir: "asc",
            change(sort, dir = null) {
                if (dir == null) {
                    // diganti
                    if (this.sort == sort) {
                        this.sortDir = this.sortDir == "asc" ? "desc" : "asc";
                    } else {
                        this.sortDir = "asc";
                    }
                } else {
                    this.sortDir = dir;
                }
                this.sort = sort;
            },
            r() {
                return {
                    sort: this.sort,
                    sortDir: this.sortDir,
                };
            },
            title(name, title) {
                return title + this.icon(name);
            },
            icon(name) {
                if (name != this.sort) return "";
                return OrderIcon.dir(this.sortDir);
            },
        });

        const params = new URL(document.location).searchParams;
        const search = ref("" || params.get("q"));
        const page_number = ref("" || params.get("page"));
        const order_by = ref("" || params.get("sort"));
        const order_dir = ref("" || params.get("dir"));

        // initial order
        order.change(order_by, order_dir);

        //define method search
        const handleSearch = (order = { sort, sortDir, page }) => {
            Inertia.get("/apps/roles", {
                //send params "q" with value from state "search"
                page: order.page,
                q: search.value,
                sort: order.sort,
                dir: order.sortDir,
            });
        };

        // handel order
        const handleOrder = (name) => {
            order.change(name);
            handleSearch({ ...order.r(), page: page_number.value });
        };

        //define method destroy
        const destroy = (id) => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
                .then((result) => {
                    if (result.isConfirmed) {

                        Inertia.delete(`/apps/roles/${id}`);

                        Swal.fire({
                            title: 'Deleted!',
                            text: 'Role deleted successfully.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false,
                        });
                    }
                })
        }

        //return
        return {
            search,
            handleSearch,
            handleOrder,
            order,
            destroy
        };
    },
}
</script>

<style>
</style>
