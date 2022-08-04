<template>
  <div id="app">
    <TodoHeader />
    <TodoInput @childAddTodo="addTodo" @noInputValue="showModal" />
    <TodoList :propsItems="todoItems" @childRemoveTodo="removeTodo" />
    <TodoFooter @childClearTodo="clearTodo" />
  </div>
  <AlertModal :show="modalShow" header="알림창" body="내용을 입력해 주세요." @close="hiddenModal" />
</template>

<script>
import TodoHeader from './components/todo/TodoHeader.vue';
import TodoInput from './components/todo/TodoInput.vue';
import TodoList from './components/todo/TodoList.vue';
import TodoFooter from './components/todo/TodoFooter.vue';
import AlertModal from './components/common/AlertModal.vue';
import axios from 'axios';
import DateUtils from './utils/DateUtils';

export default {
  name: 'App',
  data(){
    return{
      todoItems: [],
      cnt: 0,
      modalShow: false
    }
  },
  methods: {
    addTodo(todoItem){
      const param = {
        'todo': todoItem
      };
      axios.post('/todo/index', param)
      .then(res => {
        if(res.status === 200 && res.data){
          console.log(res);
          const item = {
            'itodo': res.data.result,
            'todo': todoItem,
            'created_at': DateUtils.getTimestamp(new Date())
          }
          this.todoItems.push(item);
        }
      });
        
      // this.todoItems.push({
      //   key: this.cnt++,
      //   value: todoItem
      //   });
    },
    removeTodo(key){
      // this.todoItems.splice(idx, 1);
      this.todoItems.forEach((item, idx) => {
        if(item.itodo === key){
          this.todoItems.splice(idx, 1);
          axios.delete(`/todo/index/${item.itodo}`)
          .then(res => {
            console.log(res);
          });
        }
      })
    },
    clearTodo(){
      this.todoItems.splice(0);
      this.cnt = 0;
      axios.delete('/todo/index')
      .then(res => {
        console.log(res);
      })
    },
    changeValue(){
      const json = JSON.stringify(this.todoItems);
      localStorage.setItem('todoItems', json);
      localStorage.setItem('cnt', this.cnt);
    },
    showModal(){
      this.modalShow = true;
    },
    hiddenModal(){
      this.modalShow = false;
    }
  },
  components: {
    TodoHeader, 
    TodoInput, 
    TodoList, 
    TodoFooter,
    AlertModal
  },
  // watch: {
  //   todoItems: {
  //     deep: true,
  //     handler(){
  //       this.changeValue();
  //     }
  //   }
  // },
  created(){
    axios.get('/todo/index')
    .then(res => {
      if(res.status === 200 && res.data.length > 0){
        res.data.forEach(item => {
          this.todoItems.push(item);
        });
      }
      console.log(res);
    });

    // const json = localStorage.getItem('todoItems');
    // if(json){
    //   const todoItems = JSON.parse(json);
    //   todoItems.forEach(item => { 
    //     this.todoItems.push(item);
    //   });
    //   const cnt = localStorage.getItem('cnt');
    //   this.cnt = cnt;
    // }

    // if(localStorage.length > 0){
    //     for(let i=0; i<localStorage.length; i++){
    //         this.todoItems.push(localStorage.key(i));
    //     }
    // }
  }
}
</script>

<style>
body{text-align: center; background-color: #F6F6F8;}
input{border-style: groove; width: 200px;}
button{border-style: groove;}
.shadow{box-shadow: 5px 10px 10px rgba(0, 0, 0, 0.03);}
</style>
