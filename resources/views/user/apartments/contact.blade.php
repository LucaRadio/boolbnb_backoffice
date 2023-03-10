@extends('layouts.app')

@section('content')
    <div id="contact"></div>
@endsection

<script type=''>
import createApp from 'vue'

createApp({
    methods: {
        async ciao(axios){
            console.log('ciao');
            await axios.post('api/apartments')
            .then(resp=>{
                console.log(resp.data);
            })
        }
    },
    mounted() {
        this.ciao()
    },

}).mount('#contact')

</script>
