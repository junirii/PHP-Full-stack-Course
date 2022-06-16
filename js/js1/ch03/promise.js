var num = 11;
//resolve, reject = 함수(여러 인자 못 받음)
var p1 = new Promise(function(resolve, reject){
  if(num >= 10){
    resolve(1);
  }else{
    reject(2);
  }
});

//대기상태(function으로 값 받음)
p1.then(function(result){
  console.log('then : ' + result);
}).catch(function(result){
  console.log('catch : ' + result);
});

/* try, catch문
try{

}catch(e){

}finally{

}
*/