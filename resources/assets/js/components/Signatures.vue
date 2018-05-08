<template>
    <div>
        <div class="panel panel-default" v-for="signature in signatures">
            <div class="panel-heading">
                <!--<div class="col-md-1">-->
                    <!--<div class="thumbnail">-->
                        <img id="image" :src="signature.avatar" :alt="signature.name">
                    <!--</div>-->
                <!--</div>-->
                <span class="glyphicon glyphicon-user" id="start"></span>
                <label id="started"></label> {{ signature.name }}：
            </div>
            <div class="panel-body">
                <p id="content">{{ signature.body }}</p>
            </div>
            <div class="panel-footer">
                <span class="glyphicon glyphicon-calendar" id="visit"></span> {{ signature.date }} |
                <span class="glyphicon glyphicon-flag" id="comment"></span>
                <a href="#" id="comments" @click="report(signature.id)">举报</a>
            </div>
        </div>
        <paginate
                :page-count="pageCount"
                :click-handler="fetch"
                :prev-text="'Prev'"
                :next-text="'Next'"
                :container-class="'pagination'">
        </paginate>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                signatures: [],
                pageCount: 1,
                endpoint: 'api/signatures?page='
            };
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page = 1) {
                axios.get(this.endpoint + page)
                    .then(({data}) => {
                        this.signatures = data.data;
                        this.pageCount = data.meta.last_page;
                    });
            },

            report(id) {
                if (confirm('Are you sure you want to report this signature?')) {
                    axios.put('api/signatures/' + id + '/report')
                        .then(response => this.removeSignature(id));
                }
            },

            removeSignature(id) {
                this.signatures = _.remove(this.signatures, function (signature) {
                    return signature.id !== id;
                });
            }
        }
    }
</script>


<style scoped>
    .panel-default {
        border: 1px solid #2ab27b;
        margin-top: 20px;
        padding: 5px;
        background-color: #c8cbcf;
    }
    #image {
        width: 40px;
        height: 40px;
    }
    #content {
        margin-top: 20px;
    }
</style>