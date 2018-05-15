<template>
    <button class="btn btn-primary"
            v-text="text"
            @click="vote"
            :class="{'btn-success': voted}"
    ></button>
</template>

<script>
    export default {
        name:'user-vote-button',
        props: ['answer', 'count'],
        mounted() {
            axios.post('/api/answer/' + this.answer + '/votes/users').then(response => {
                this.voted = response.data.voted
            })
        },
        data() {
            return {
                voted: false
            }
        },
        computed: {
            text() {
                return this.count
            }
        },
        methods: {
            vote() {
                axios.post('/api/answer/vote', {'answer':this.answer}).then(response => {
                    this.voted = response.data.voted
                    response.data.voted ? this.count++ : this.count--
                })
            }
        }
    }
</script>

<style scoped>

</style>