var arr = {
  '0' : 2,
  '1' : 6,
  '2' : 10,
  '3' : 11,
  '4' : 22,
  '5' : 1,
  '6' : 7,
  'length' : 7,
  'forEach' : function(cb){
    for(var i=0; i<this.length; i++)
    {
      cb(this[i]);
    }
  },
  'filter' : function(cb){
    var tempArr = [];
    for(var i=0; i<this.length; i++){
      if(cb(this[i]) === true){
        tempArr.push(this[i]);
      }
    }
    return tempArr;
  }
}

var resultArr = arr.filter(function(item){
  if(item <= 11){
    return true;
  }
});
console.log(resultArr);

//배열의 map, reduce, 콜백 함수에 대한 이해, 비동기에 대한 이해, 콜백 지옥, promise, async/await