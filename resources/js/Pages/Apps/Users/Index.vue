<template>

  <Head>
    <title>Users - Aplikasi Kasir</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"><i class="fa fa-users"></i> USERS</span>
              </div>
              <div class="card-body">
                <form @submit.prevent="handleSearch">
                  <div class="input-group mb-3">
                    <Link
                          href="/apps/users/create"
                          v-if="hasAnyPermission(['users.create'])"
                          class="btn btn-primary input-group-text">
                    <i class="fa fa-plus-circle me-2"></i> NEW</Link>
                    <input
                           type="text"
                           class="form-control"
                           placeholder="search by role name..."
                           v-model="search" />

                    <button class="btn btn-primary input-group-text" type="submit">
                      <i class="fa fa-search me-2"></i> SEARCH
                    </button>
                  </div>
                </form>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th
                          scope="col"
                          @click="handleOrder('name')"
                          v-html="order.title('name', 'Full Name')"></th>
                      <th
                          scope="col"
                          @click="handleOrder('email')"
                          v-html="order.title('email', 'Email Address')"></th>
                      <th scope="col">Roles</th>
                      <th scope="col" style="width: 20%">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(user, index) in users.data" :key="index">
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>
                        <span
                              v-for="(role, index) in user.roles"
                              :key="index"
                              class="badge badge-primary shadow border-0 ms-2 mb-2">
                          {{ role.name }}
                        </span>
                      </td>
                      <td class="text-center">
                        <Link
                              :href="`/apps/users/${user.id}/edit`"
                              v-if="hasAnyPermission(['users.edit'])"
                              class="btn btn-success btn-sm me-2"><i
                           class="fa fa-pencil-alt me-1"></i> EDIT</Link>
                        <button
                                @click.prevent="destroy(user.id)"
                                v-if="hasAnyPermission(['users.delete'])"
                                class="btn btn-danger btn-sm">
                          <i class="fa fa-trash"></i> DELETE
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <Pagination :links="users.links" align="end" />
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
import LayoutApp from "../../../Layouts/App.vue";

//import component pagination
import Pagination from "../../../Components/Pagination.vue";
import OrderIcon from "../../../Components/OrderIcon.vue";

//import Heade and Link from Inertia
import { Head, Link } from "@inertiajs/inertia-vue3";

//import inertia adapter
import { Inertia } from "@inertiajs/inertia";
import { reactive, ref } from "vue";

//import sweet alert2
import Swal from "sweetalert2";

export default {
  //layout
  layout: LayoutApp,

  //register component
  components: {
    Head,
    Link,
    Pagination,
  },

  //props
  props: {
    users: Object,
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
    const handleSearch = ({ sort, sortDir, page }) => {
      Inertia.get("/apps/users", {
        //send params "q" with value from state "search"
        page,
        q: search.value,
        sort,
        dir: sortDir,
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
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
      }).then((result) => {
        if (result.isConfirmed) {
          Inertia.delete(`/apps/users/${id}`);

          Swal.fire({
            title: "Deleted!",
            text: "Role deleted successfully.",
            icon: "success",
            timer: 2000,
            showConfirmButton: false,
          });
        }
      });
    };

    //return
    return {
      search,
      handleSearch,
      handleOrder,
      order,
      destroy,
    };
  },
};
</script>

<style>
</style>
