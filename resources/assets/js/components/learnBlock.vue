<template>
    <div>
        <div class="panel-body">
            <div class="alert-danger" v-if="showend">
                Слов больше нет
            </div>
        </div>
        <div class="panel-body">
            <div class="words-list" v-if="words.length > 0 && !showend">
                <h1>Word: {{words[index].word}}</h1>
                <h3 v-if="showword">Help: {{words[index].translation}}</h3>
                Translation: <input type="text"
                                    class="input-group input-lg"
                                    v-on:keyup.enter="more()"
                                    v-model="words[index].mytranslation">
                <div class="result">
                    <div v-if="isEqual()">
                        Yeah, correct
                        <button v-on:click="more()" class="btn-default btn">
                            Next
                        </button>
                    </div>
                    <div v-else>
                        <button v-on:click="skip()" class="btn-danger btn">Skip</button>
                        <button v-on:click="show()" class="btn btn-success">Show word</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            let that = this;
            $.get({
                url: '/words/get'
            }).done(function(data){
                for(let i = 0; i< data.length; i++) {
                    data[i].mytranslation = '';
                }
                that.words = data;
            })
        },
        data: function () {
            return {
                words: [],
                index: 0,
                showend: false,
                showword: false,
                ignore_answer: false
            }
        },
        methods: {
            more() {
                let that = this;
                console.log('more');
                let word = this.words[this.index];
                if (!this.isEqual()) {
                    this.show();
                    console.log(word.translation + ' nq ' + word.mytranslation);
                    return false;
                }
                if (this.ignore_answer === false) {
                  $.ajax({
                    url: '/words/post',
                    method: 'post',
                    data: {
                      _token: $('input[name=_token]').val(),
                      word_id: word.id
                    }
                  });
                }
                that.skip();

            },
            skip() {
                this.ignore_answer = false;
                if (this.words.length > (this.index+1)) {
                    this.index++
                } else {
                    this.showend = true;
                }
            },
            isEqual() {
                let word = this.words[this.index];
                return word.translation.toLowerCase() == word.mytranslation.toLowerCase();
            },
            show() {
                this.showword = true;
                this.ignore_answer = true;
                let that = this;
                setTimeout(function(){
                    that.showword = false;
                }, 1000)
            }
        }
    }
</script>
<style>
    .result {
        margin-top: 10px
    }
</style>