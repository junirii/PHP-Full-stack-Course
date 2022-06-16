var arr = [2, 6, 10, 11, 22, 1, 7];
var sum = 0;
for(var i=0; i<arr.length; i++){
  sum += arr[i];
}
console.log(`sum : ${sum}`);

var evenSum = 0;
arr.forEach(function(item){
  if(item % 2 === 0){
    evenSum += item;
  }
});
console.log(`evenSum : ${evenSum}`);