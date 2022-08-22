<template>

  <Head>
    <title>Permissions - Aplikasi Kasir</title>
  </Head>
  <main class="c-main">
    <div class="container-fluid">
      <div class="fade-in">
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 rounded-3 shadow border-top-purple">
              <div class="card-header">
                <span class="font-weight-bold"><i class="fa fa-key"></i> PERMISSIONS</span>
              </div>
              <div class="card-body">
                <form @submit.prevent="handleSearch">
                  <div class="input-group mb-3">
                    <input
                           type="text"
                           class="form-control"
                           v-model="search"
                           placeholder="search by permission name..." />
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
                          v-html="order.title('name', 'Permission Name')"></th>
                      <th
                          scope="col"
                          @click="handleOrder('created_at')"
                          v-html="order.title('created_at', 'Guard Name')"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(permission, index) in permissions.data" :key="index">
                      <td>{{ permission.name }}</td>
                      <td>{{ permission.created_at }}</td>
                    </tr>
                  </tbody>
                </table>
                <Pagination :links="permissions.links" align="end" />
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
    permissions: Object,
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
      Inertia.get("/apps/permissions", {
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

    //return
    return {
      search,
      handleSearch,
      handleOrder,
      order,
    };
  },
};
</script>

<style>
</style>
