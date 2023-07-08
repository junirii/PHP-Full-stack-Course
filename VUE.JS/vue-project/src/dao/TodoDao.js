import axios from 'axios';

export default {
    getList: function(fn) {
        axios.get('/todo/index')
        .then(res => {
            if(res.status === 200) {            
                console.log(res.data);
                fn(res.data);
            }
        });
    },
}