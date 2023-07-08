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
  },
  'map' : function(cb){
    var tempArr = [];
    for(var i=0; i<this.length; i++)
    {
      tempArr.push(cb(this[i], i));
    }
    return tempArr;
  }
}
var result2Arr = arr.map(function(item, idx){
  if(item < 10){
    item = item * 2;
  }
  return item;
});
console.log(result2Arr);