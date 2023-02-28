<template>
    <nav>
        <ul :class="`pagination justify-content-${align} mb-0`">
            <li :class="[
                    'page-item', 
                    link.url == null ? 'disabled' : '',
                    link.active ? 'active' : '',
                ]" 
                v-for="(link, index) in links" :key="index">
                <Link 
                    class="page-link" 
                    :href="link.url === null ? '#' : link.url" 
                    v-html="link.label">
                </Link>
            </li>
        </ul>
    </nav>
</template>

<script>

    //import Link
    import { Link } from '@inertiajs/inertia-vue3';

    export default {
        props: {
            links: Array,
            align: String
        },

        components: {
            Link,
        },
    }
</script>

<style>

</style>