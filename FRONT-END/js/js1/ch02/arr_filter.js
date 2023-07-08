var arr = [2, 6, 10, 11, 22, 1, 7];

var resultArr = arr.filter(function(item, idx){
  console.log(`${idx} : ${item}`);
  if(item <= 8){
    return true;
  }
});

var newArr = [];
newArr.push(10);
newArr.push(12);
console.log(newArr);
/*
newArr[0] = 10;
newArr[1] = 12;
newArr[5] = 14;
console.log(newArr);
*/