<template>
  <div class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed" :class="{ 'c-sidebar-lg-show': !$page.url.startsWith('/apps/transactions') }" id="sidebar">
      <div class="c-sidebar-brand d-lg-down-none" style="background: #894b9d;">
        <img src="/images/cash-machine.png" class="bg-light rounded shadow-sm p-1" width="35"> <span class="ml-2 font-weight-bold">APLIKASI KASIR</span>
      </div>

      <!-- sidebar -->
      <Sidebar />
      <!-- end sidebar -->

    </div>
    <div class="c-wrapper c-fixed-components">
      
      <!-- header -->
      <Header />
      <!-- end header -->

      <div class="c-body">

        <!-- content -->
        <slot />
        <!-- end content -->

        <footer class="c-footer">
          <div><strong>APLIKASI KASIR</strong> &copy; 2022 - SantriKoding.com.</div>
        </footer>
      </div>
    </div>
  </div>
</template>

<script>

  import Header from '../Components/Header.vue'
  import Sidebar from '../Components/Sidebar.vue'

  export default {

    //register components
    components: {
      Header,
      Sidebar
    }

  }
</script>

<style>
</style>