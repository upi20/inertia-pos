<template>
  <nav>
    <ul :class="`pagination justify-content-${align} mb-0`">
      <li
          :class="[
            'page-item',
            link.url == null ? 'disabled' : '',
            link.active ? 'active' : '',
          ]"
          v-for="(link, index) in datas.links"
          :key="index">
        <Link
              class="page-link"
              :href="link.url === null ? '#' : `${link.url}${params}`"
              v-html="link.label">
        </Link>
      </li>
    </ul>
  </nav>
</template>

<script>
//import Link
import { Link } from "@inertiajs/inertia-vue3";

export default {
  props: {
    align: String,
    datas: Object,
  },

  components: {
    Link,
  },

  setup(props) {
    const search_params = props.datas.search ? `&q=${props.datas.search}` : "";
    const order_params = props.datas.order.sort ? `&sort=${props.datas.order.sort}` : "";
    const order_dir_params = props.datas.order.sortDir
      ? `&dir=${props.datas.order.sortDir}`
      : "";

    return {
      params: search_params + order_params + order_dir_params,
    };
  },
};
</script>

<style>
</style>
