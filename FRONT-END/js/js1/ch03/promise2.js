var p1 = new Promise(function(resolve){
  resolve(1);
});

//리턴값 result가 promise로 감싸서 보내짐 => p2는 promise
var p2 = p1.then(function(result){
  return result;
});

p2.then(function(result){
  console.log('result : ' + result);
})