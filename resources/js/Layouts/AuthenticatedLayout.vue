<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import Navbar from '@/Layouts/Parts/Navbar.vue';
import Sidebar from '@/Layouts/Parts/Sidebar.vue';
import Footer from '@/Layouts/Parts/Footer.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div class="main">
        <!-- NAVBAR - START-->
        <Navbar></Navbar>
        <!-- NAVBAR - END-->

        <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">


            <!-- SIDERBAR START-->
             <Sidebar></Sidebar>
            <!-- SIDEBAR END-->
        
            <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
                <main>
                    <slot />
                </main>

                <!-- FOOTER START-->
                <!-- <Footer></Footer> -->
  
                <!-- FOOTER END-->
            </div>
        </div>
        
    </div>
</template>
