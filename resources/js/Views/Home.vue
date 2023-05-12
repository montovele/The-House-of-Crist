<template>
  <div class="max-w-screen-lg mx-auto text-gray-900">
    <div class="flex justify-center">
        <div class="flex-1">
            <div class="border w-auto">
                <div  class="border p-4 font-semibold  tipograpi"> <h2>MAPA</h2></div>

                <div class="p-4 bg-white">
                        <div>
                        <Map/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

 

<script>
import Map from "../components/MapExample5.vue"
export default {
    
    components: {
        Map
        },
    data() {
        return {
        }
    }
}
</script>