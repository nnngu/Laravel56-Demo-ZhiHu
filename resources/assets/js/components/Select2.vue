<template>
    <div>
        <select class="js-example-basic-multiple" name="states[]" multiple="multiple">
            <option value="AL" name="AL">Alabama</option>
            <option value="WY" name="WY">Wyoming</option>
        </select>
    </div>
</template>

<script>
    export default {

        created() {
            $(".js-example-basic-multiple").select2();
        },

        methods: {
            // fetch(page = 1) {
            //     axios.get(this.endpoint + page)
            //         .then(({data}) => {
            //             this.signatures = data.data;
            //             this.pageCount = data.meta.last_page;
            //         });
            // },
        }
    }
</script>

<style scoped>

</style>